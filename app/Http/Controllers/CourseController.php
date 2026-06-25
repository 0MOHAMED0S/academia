<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Lesson;
use App\Models\LessonAttempt;
use App\Models\Track;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CourseController extends Controller
{
    public function contact(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        \App\Models\ContactMessage::create($validated);

        return back()->with('success_contact', 'تم إرسال رسالتك بنجاح، شكراً لتواصلك معنا!');
    }

    public function index()
    {
        if (! Schema::hasTable('courses')) {
            $courses = collect();
            $tracks = collect();
            $instructors = collect();

            return view('main_pages.home', compact('courses', 'tracks', 'instructors'));
        }

        $courses = Course::with('instructor')->latest()->get();
        $tracks = Schema::hasTable('tracks') ? Track::with(['courses.lessons'])->get() : collect();
        $instructors = Schema::hasTable('instructors') ? \App\Models\Instructor::latest()->take(8)->get() : collect();

        return view('main_pages.home', compact('courses', 'tracks', 'instructors'));
    }

    public function payedCourses(Request $request)
    {
        $query = Course::with('instructor')->where('type', 'paid')->latest();

        if ($request->has('query') && $request->input('query') != '') {
            $searchTerm = $request->input('query');
            $query->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('instructor', function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%');
                });
        }

        $courses = $query->get();
        return view('main_pages.payedcources', compact('courses'));
    }

    public function freeCourses(Request $request)
    {
        $query = Course::with('instructor')->where('type', 'free')->latest();

        if ($request->has('query') && $request->input('query') != '') {
            $searchTerm = $request->input('query');
            $query->where('title', 'LIKE', '%' . $searchTerm . '%')
                ->orWhere('description', 'LIKE', '%' . $searchTerm . '%')
                ->orWhereHas('instructor', function ($q) use ($searchTerm) {
                    $q->where('name', 'LIKE', '%' . $searchTerm . '%');
                });
        }

        $courses = $query->get();
        return view('main_pages.freecourse', compact('courses'));
    }

    public function show(Course $course)
    {
        $course->load('lessons.questions', 'instructor', 'track');

        $saved = false;
        $hasAccess = ! $course->isPaid();
        $progress = null;

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            $savedCourse = $user->savedCourses()->where('course_id', $course->id)->first();
            $saved = (bool) $savedCourse;
            $hasAccess = ! $course->isPaid() || ($savedCourse && $savedCourse->pivot->payment_verified_at);
            $progress = $this->courseProgress($course, $user->id);
        }

        return view('courses.show', compact('course', 'saved', 'hasAccess', 'progress'));
    }

    public function lesson(Lesson $lesson)
    {
        $lesson->load('course.instructor', 'course.lessons', 'questions');
        $course = $lesson->course;

        $isStudent = Auth::guard('web')->check();
        $isInstructor = Auth::guard('instructor')->check();
        $isAdmin = Auth::guard('admin')->check();

        // 1. Check if anyone is logged in
        if (! $isStudent && ! $isInstructor && ! $isAdmin) {
            return redirect()->route('student_login_page')->with('error', 'يجب تسجيل الدخول لمشاهدة الدروس.');
        }

        // 2. If it's a student, check payment and progression
        if ($isStudent) {
            $user = Auth::guard('web')->user();

            // Check Payment for Paid Courses
            if ($course->isPaid()) {
                $savedCourse = $user->savedCourses()->where('course_id', $course->id)->first();
                if (! $savedCourse || ! $savedCourse->pivot->payment_verified_at) {
                    return redirect()->route('courses.show', $course)->with('error', 'يجب إتمام عملية الدفع أولاً لفتح هذا الكورس.');
                }
            }

            // Check Progression (Must pass previous lesson quiz)
            $previousLessons = $course->lessons->where('sort_order', '<', $lesson->sort_order);
            foreach ($previousLessons as $previousLesson) {
                $passed = LessonAttempt::where('lesson_id', $previousLesson->id)
                    ->where('user_id', $user->id)
                    ->where('passed', true)
                    ->exists();

                if (! $passed && $previousLesson->questions->count() > 0) {
                    return redirect()->route('lessons.show', $previousLesson)
                        ->with('error', 'يجب اجتياز أسئلة الفيديو السابق أولاً.');
                }
            }
        }

        $attempt = $isStudent
            ? LessonAttempt::where('lesson_id', $lesson->id)->where('user_id', Auth::guard('web')->id())->first()
            : null;

        return view('lessons.show', compact('lesson', 'attempt'));
    }

    public function saveCourse(Course $course)
    {
        $user = Auth::guard('web')->user();

        if (! $user) {
            return redirect()->route('student.login_page')->with('error', 'يجب تسجيل الدخول لحفظ الكورس.');
        }

        $user->savedCourses()->syncWithoutDetaching($course->id);

        return back()->with('success', 'تم حفظ الكورس بنجاح.');
    }

    public function verifyPayment(Request $request, Course $course)
    {
        $user = Auth::guard('web')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'unique_course_id' => ['required', 'string', 'exists:courses,unique_course_id'],
            'student_id' => ['required', 'string'],
        ]);

        if ($validated['unique_course_id'] !== $course->unique_course_id) {
            return back()->with('error', 'كود الكورس غير صحيح لهذا الكورس.');
        }

        // Check if this student_id is assigned to this user for this course in course_user table
        $subscription = DB::table('course_user')
            ->where('course_id', $course->id)
            ->where('user_id', $user->id)
            ->where('student_id', $validated['student_id'])
            ->first();

        if (!$subscription) {
            return back()->with('error', 'كود الطالب غير صحيح أو غير مسجل لهذا الكورس.');
        }

        $user->savedCourses()->updateExistingPivot($course->id, [
            'payment_cash_id' => $validated['unique_course_id'],
            'payment_verified_at' => now(),
        ]);

        return back()->with('success', 'تم تفعيل مشاهدة الكورس المدفوع بنجاح.');
    }

    public function submitLessonQuiz(Request $request, Lesson $lesson)
    {
        $user = Auth::guard('web')->user();
        $lesson->load('questions', 'course.lessons');

        $answers = $request->input('answers', []);
        $score = 0;

        foreach ($lesson->questions as $question) {
            if (($answers[$question->id] ?? null) === $question->correct_option) {
                $score++;
            }
        }

        $total = max($lesson->questions->count(), 1);
        $passed = $score >= 4;

        LessonAttempt::updateOrCreate(
            ['lesson_id' => $lesson->id, 'user_id' => $user->id],
            ['score' => $score, 'total' => $total, 'passed' => $passed]
        );

        $this->syncCourseCompletion($lesson->course, $user->id);

        return back()->with($passed ? 'success' : 'error', $passed
            ? "تم اجتياز الاختبار بدرجة {$score}/{$total}."
            : "درجتك {$score}/{$total}. يجب الإجابة على 4 أسئلة صحيحة على الأقل.");
    }

    public function track(Track $track)
    {
        $track->load('courses.lessons', 'courses.instructor');

        return view('main_pages.track', compact('track'));
    }

    public function certificate(Course $course)
    {
        $user = Auth::guard('web')->user();
        $savedCourse = $user->savedCourses()->where('course_id', $course->id)->firstOrFail();

        abort_unless($savedCourse->pivot->completed_at, 403);

        return view('courses.certificate', compact('course', 'user', 'savedCourse'));
    }

    private function courseProgress(Course $course, int $userId): array
    {
        $lessonIds = $course->lessons->pluck('id');
        $total = max($lessonIds->count(), 1);
        $passed = LessonAttempt::whereIn('lesson_id', $lessonIds)->where('user_id', $userId)->where('passed', true)->count();

        return [
            'passed' => $passed,
            'total' => $lessonIds->count(),
            'percent' => (int) round(($passed / $total) * 100),
        ];
    }

    private function syncCourseCompletion(Course $course, int $userId): void
    {
        $lessonIds = $course->lessons()->pluck('id');
        if ($lessonIds->isEmpty()) {
            return;
        }

        $passedCount = LessonAttempt::whereIn('lesson_id', $lessonIds)->where('user_id', $userId)->where('passed', true)->count();
        if ($passedCount !== $lessonIds->count()) {
            return;
        }

        DB::table('course_user')->updateOrInsert(
            ['course_id' => $course->id, 'user_id' => $userId],
            ['completed_at' => now(), 'grade' => 100, 'updated_at' => now(), 'created_at' => now()]
        );
    }

    // ─── Admin Subscription Management ─────────────────────────────────────

    public function adminSubscribedStudents()
    {
        $subscriptions = DB::table('course_user')
            ->join('users', 'course_user.user_id', '=', 'users.id')
            ->join('courses', 'course_user.course_id', '=', 'courses.id')
            ->select(
                'users.name as student_name',
                'courses.title as course_name',
                'courses.description as course_description',
                'courses.unique_course_id',
                'course_user.student_id as student_course_id',
                'course_user.id as subscription_id',
                'course_user.course_id',
                'course_user.user_id'
            )
            ->get();

        return view('admin_pages.subscribed_students', compact('subscriptions'));
    }

    public function adminEditCourse(Course $course)
    {
        $tracks = Track::all();
        return view('admin_pages.edit_course', compact('course', 'tracks'));
    }

    public function adminUpdateCourse(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'unique_course_id' => ['required_if:type,paid', 'nullable', 'string', 'unique:courses,unique_course_id,' . $course->id],
            'track_id' => ['nullable', 'exists:tracks,id'],
            'type' => ['required', 'in:free,paid'],
        ]);

        if ($validated['type'] === 'free' && (empty($validated['unique_course_id']) || !str_starts_with($validated['unique_course_id'], 'Free-'))) {
            $validated['unique_course_id'] = 'Free-' . \Illuminate\Support\Str::random(10);
        }

        $course->update($validated);

        return redirect()->route('admin.subscribed_students')->with('success', 'تم تحديث بيانات الكورس بنجاح.');
    }

    public function adminDeleteCourse(Course $course)
    {
        $course->delete();
        return back()->with('success', 'تم حذف الكورس بنجاح.');
    }

    public function adminAddStudentIdView($course_id, $user_id)
    {
        $course = Course::findOrFail($course_id);
        $user = \App\Models\User::findOrFail($user_id);

        return view('admin_pages.add_student_id', compact('course', 'user'));
    }

    public function adminStoreStudentId(Request $request)
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'user_id' => ['required', 'exists:users,id'],
            'student_id' => ['required', 'string'],
        ]);

        DB::table('course_user')
            ->updateOrInsert(
                ['course_id' => $validated['course_id'], 'user_id' => $validated['user_id']],
                ['student_id' => $validated['student_id'], 'updated_at' => now()]
            );

        $course = Course::find($validated['course_id']);
        $user = \App\Models\User::find($validated['user_id']);

        // Send Notification
        \App\Models\Notification::create([
            'type' => 'course_subscription',
            'notifiable_id' => $user->id,
            'notifiable_type' => \App\Models\User::class,
            'data' => [
                'course_id' => $course->unique_course_id,
                'student_id' => $validated['student_id'],
                'course_title' => $course->title,
            ],
            'message' => "تم تفعيل اشتراكك في كورس \"{$course->title}\". كود الكورس: {$course->unique_course_id}، كود الطالب: {$validated['student_id']}. يرجى استخدامهما في صفحة الدفع.",
            'is_read' => false,
        ]);

        return redirect()->route('admin.subscribed_students')->with('success', 'تم إضافة كود الطالب وإرسال إشعار بنجاح.');
    }
}
