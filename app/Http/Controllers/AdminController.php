<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\ContactMessage;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\Notification;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function loginPage()
    {
        return view('admin_pages.admin_login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            return redirect()->route('admin.dashboard')->with('success_login', 'مرحباً بك في لوحة الأدمن.');
        }

        return back()->withErrors([
            'email' => 'بيانات دخول الأدمن غير صحيحة.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login_page')->with('success_logout', 'تم تسجيل الخروج بنجاح.');
    }

    public function dashboard()
    {
        $admin = Auth::guard('admin')->user();
        $students = User::latest()->get();
        $instructors = Instructor::latest()->get();
        $courses = Course::with(['instructor', 'lessons', 'track'])->latest()->get();
        $tracks = Track::latest()->get();
        $messages = ContactMessage::latest()->get();
        $notifications = Notification::latest()->get();

        // Subscriptions logic
        $paidCourses = Course::where('type', 'paid')->with('savedBy')->get();

        return view('admin_pages.admin_dashboard', compact(
            'admin', 'students', 'instructors', 'courses', 'tracks', 'messages', 'notifications', 'paidCourses'
        ));
    }

    // ─── Users Management ─────────────────────────────────────────────────

    public function deleteStudent(User $user)
    {
        $user->delete();
        return back()->with('success', 'تم حذف الطالب بنجاح.');
    }

    public function deleteInstructor(Instructor $instructor)
    {
        $instructor->delete();
        return back()->with('success', 'تم حذف المدرب بنجاح.');
    }

    // ─── Tracks Management ─────────────────────────────────────────────────

    public function storeTrack(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        Track::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . uniqid(),
            'description' => $validated['description'] ?? '',
        ]);

        return back()->with('success', 'تم إضافة المسار بنجاح.');
    }

    public function updateTrack(Request $request, Track $track)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $track->update([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . $track->id,
            'description' => $validated['description'] ?? '',
        ]);

        return back()->with('success', 'تم تعديل المسار بنجاح.');
    }

    public function deleteTrack(Track $track)
    {
        $track->delete();
        return back()->with('success', 'تم حذف المسار بنجاح.');
    }

    // ─── Courses & Videos ──────────────────────────────────────────────────

    public function deleteLesson(Request $request, Lesson $lesson)
    {
        $validated = $request->validate([
            'delete_reason' => ['required', 'string', 'min:5', 'max:1000'],
        ]);

        $course = $lesson->course;
        $instructor = $course->instructor;
        $reason = $validated['delete_reason'];

        // Store the lesson info before deletion
        $lessonTitle = $lesson->title;
        $lessonId = $lesson->id;

        // Delete the lesson
        $lesson->delete();

        // Send notification to the instructor
        if ($instructor) {
            Notification::create([
                'type' => 'video_deleted',
                'notifiable_id' => $instructor->id,
                'notifiable_type' => Instructor::class,
                'data' => [
                    'lesson_id' => $lessonId,
                    'lesson_title' => $lessonTitle,
                    'course_title' => $course->title,
                    'course_id' => $course->id,
                    'reason' => $reason,
                    'deleted_by' => Auth::guard('admin')->user()->name,
                ],
                'message' => "تم حذف فيديو \"{$lessonTitle}\" من كورس \"{$course->title}\". السبب: {$reason}",
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'تم حذف الفيديو وإرسال إشعار للمدرب.');
    }

    // ─── Admin Profile ─────────────────────────────────────────────────────

    public function profile()
    {
        $admin = Auth::guard('admin')->user();
        return view('admin_pages.admin_profile', compact('admin'));
    }

    public function updateProfile(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];

        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_photo')) {
            $admin->profile_photo = $this->storePublicUpload($request->file('profile_photo'), 'admins');
        }

        $admin->save();

        return back()->with('success', 'تم تحديث بياناتك بنجاح.');
    }

    private function storePublicUpload($file, string $folder): string
    {
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "uploads/{$folder}";
        if (!is_dir(public_path($path))) {
            mkdir(public_path($path), 0775, true);
        }
        $file->move(public_path($path), $name);

        return "{$path}/{$name}";
    }

    public function removeStudentFromCourse(Course $course, User $user)
    {
        $course->savedBy()->detach($user->id);
        return back()->with('success', 'تم حذف الطالب من الكورس بنجاح.');
    }

    public function deleteCourse(Course $course)
    {
        $course->delete();
        return back()->with('success', 'تم حذف الكورس بنجاح.');
    }
}
