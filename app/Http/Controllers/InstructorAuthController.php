<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithGoogleAuth;
use App\Models\Course;
use App\Models\Instructor;
use App\Models\Lesson;
use App\Models\LessonQuestion;
use App\Models\Track;
use App\Rules\VideoDuration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\InvalidStateException;

class InstructorAuthController extends Controller
{
    use InteractsWithGoogleAuth;

    private const VIDEO_MIMETYPES = 'video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm';
    private const VIDEO_EXTENSIONS = ['mp4', 'mov', 'avi', 'wmv', 'webm'];

    public function register_page()
    {
        return view('instructor_pages.instructor_register');
    }

    public function login_page()
    {
        return view('instructor_pages.instructor_login');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:instructors,email'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'job_title' => ['nullable', 'string', 'max:255'],
        ]);

        $instructor = Instructor::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'job_title' => $validated['job_title'] ?? null,
        ]);

        Auth::guard('instructor')->login($instructor);

        return redirect()->route('instructor.dashboard')->with('success_register', 'تم إنشاء حساب المحاضر بنجاح.');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if (Auth::guard('instructor')->attempt($validated)) {
            $request->session()->regenerate();
            $instructor = Auth::guard('instructor')->user();
            return redirect()->route('instructor.dashboard')->with('success_login', 'مرحباً بك يا ' . $instructor->name . ' 👋');
        }

        return back()->withErrors([
            'email' => 'بيانات الدخول غير صحيحة.',
        ])->withInput();
    }

    public function redirectToGoogle()
    {
        if (! $this->googleOAuthConfigured()) {
            return redirect()->route('instructor_login_page')
                ->with('error', 'تسجيل الدخول عبر Google غير مُكوّن. راجع إعدادات GOOGLE_CLIENT_ID و GOOGLE_CLIENT_SECRET في ملف البيئة.');
        }

        return $this->googleOAuthRedirect('instructor.google.callback');
    }

    public function handleGoogleCallback(Request $request)
    {
        if (! $this->googleOAuthConfigured()) {
            return redirect()->route('instructor_login_page')
                ->with('error', 'تسجيل الدخول عبر Google غير مُكوّن.');
        }

        try {
            $googleUser = $this->googleOAuthUser('instructor.google.callback');
        } catch (InvalidStateException) {
            return redirect()->route('instructor_login_page')
                ->with('error', 'انتهت صلاحية جلسة التحقق مع Google. حاول تسجيل الدخول مرة أخرى.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Google Login Error (Instructor): ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('instructor_login_page')
                ->with('error', 'فشل تسجيل الدخول عبر Google: ' . $e->getMessage() . '. تأكد من أن عنوان الاسترجاع (Redirect URI) في Google Console يطابق: ' . config('services.google.redirect_instructor'));
        }

        if (! $googleUser->getEmail()) {
            return redirect()->route('instructor_login_page')
                ->with('error', 'تعذر الحصول على البريد الإلكتروني من حساب Google.');
        }

        try {
            $instructor = $this->findOrCreateFromGoogleUser(Instructor::class, $googleUser);
        } catch (\Throwable) {
            return redirect()->route('instructor_login_page')
                ->with('error', 'تعذر إنشاء أو ربط حساب المحاضر. حاول مرة أخرى أو سجّل حساباً يدوياً.');
        }

        Auth::guard('instructor')->login($instructor);
        $request->session()->regenerate();

        return redirect()->route('instructor.dashboard')
            ->with('success_login', 'مرحباً بك يا ' . $instructor->name . ' 👋');
    }

    public function logout(Request $request)
    {
        $name = Auth::guard('instructor')->user()->name;
        Auth::guard('instructor')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('instructor_login_page')->with('success_logout', 'إلى اللقاء يا ' . $name . ' 👋');
    }

    public function dashboard()
    {
        $instructor = Auth::guard('instructor')->user();

        $courses = Course::with('lessons')
            ->where('instructor_id', $instructor->id)
            ->get();
        $tracks = Track::orderBy('name')->get();

        return view('instructor_pages.instructor_dashboard', compact('instructor', 'courses', 'tracks'));
    }

    public function profile()
    {
        $instructor = Auth::guard('instructor')->user();
        return view('instructor_pages.instructor_profile', compact('instructor'));
    }

    public function updateProfile(Request $request)
    {
        $instructor = Auth::guard('instructor')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:instructors,email,' . $instructor->id],
            'job_title' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $instructor->name = $validated['name'];
        $instructor->email = $validated['email'];
        $instructor->job_title = $validated['job_title'] ?? null;

        if (!empty($validated['password'])) {
            $instructor->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_photo')) {
            $instructor->profile_photo = $this->storePublicUpload($request->file('profile_photo'), 'instructors');
        }

        $instructor->save();

        return back()->with('success_profile', 'تم تحديث بياناتك الشخصية بنجاح.');
    }

    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'track_id' => ['nullable', 'exists:tracks,id'],
            'type' => ['required', 'in:free,paid'],
            'unique_course_id' => ['required_if:type,paid', 'nullable', 'string', 'max:50'],
            'roadmap' => ['nullable', 'string'],
            'course_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = null;
        if ($request->hasFile('course_photo')) {
            $imagePath = $this->storePublicUpload($request->file('course_photo'), 'courses');
        }

        $course = Course::create([
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . uniqid(),
            'description' => $validated['description'] ?? '',
            'track_id' => $validated['track_id'] ?? null,
            'type' => $validated['type'],
            'unique_course_id' => ($validated['type'] === 'paid') ? $validated['unique_course_id'] : 'Free-' . Str::random(10),
            'roadmap' => $validated['roadmap'] ?? null,
            'instructor_id' => Auth::guard('instructor')->id(),
            'image_path' => $imagePath,
        ]);

        return back()->with('success_course', 'تم إنشاء الكورس بنجاح.');
    }

    public function editCourse(Course $course)
    {
        if ($course->instructor_id !== Auth::guard('instructor')->id()) {
            abort(403, 'غير مصرح لك بتعديل هذا الكورس.');
        }

        $tracks = Track::orderBy('name')->get();

        return view('instructor_pages.instructor_course_edit', compact('course', 'tracks'));
    }

    public function updateCourse(Request $request, Course $course)
    {
        if ($course->instructor_id !== Auth::guard('instructor')->id()) {
            abort(403, 'غير مصرح لك بتعديل هذا الكورس.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'track_id' => ['nullable', 'exists:tracks,id'],
            'type' => ['required', 'in:free,paid'],
            'unique_course_id' => ['required_if:type,paid', 'nullable', 'string', 'max:50'],
            'roadmap' => ['nullable', 'string'],
            'course_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $imagePath = $course->image_path;
        if ($request->hasFile('course_photo')) {
            if ($course->image_path && file_exists(public_path($course->image_path))) {
                @unlink(public_path($course->image_path));
            }
            $imagePath = $this->storePublicUpload($request->file('course_photo'), 'courses');
        }

        $course->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? '',
            'track_id' => $validated['track_id'] ?? null,
            'type' => $validated['type'],
            'unique_course_id' => ($validated['type'] === 'paid') ? $validated['unique_course_id'] : 'Free-' . Str::random(10),
            'roadmap' => $validated['roadmap'] ?? null,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('instructor.dashboard')->with('success_profile', 'تم تعديل الكورس بنجاح.');
    }




    public function storeLesson(Request $request)
    {
        try {
            $validated = $request->validate($this->lessonRules());

            $videoPath = $validated['video_path'] ?? null;

            if ($request->hasFile('video_file') && $request->file('video_file')->isValid()) {
                $file = $request->file('video_file');
                $videoPath = $this->storePublicUpload($file, 'videos');
            }

            if (!$videoPath) {
                return back()->withErrors(['video_file' => 'يجب رفع فيديو أو إدخال رابط.']);
            }

            return $this->saveLessonRecord($validated, $videoPath, $request);
        } catch (\Throwable $e) {
            return $this->lessonStoreResponse($request, false, 'حدث خطأ: ' . $e->getMessage());
        }
    }

    private function saveLessonRecord(array $validated, string $videoPath, Request $request)
    {
        $course = Course::where('id', $validated['course_id'])
            ->where('instructor_id', auth('instructor')->id())
            ->first();

        if (!$course) {
            abort(403, 'Unauthorized');
        }

        $questions = $this->completeLessonQuestions($request);

        if ($questions->count() < 5) {
            return $this->lessonStoreResponse($request, false, 'يجب إضافة 5 أسئلة على الأقل لكل فيديو.');
        }

        DB::transaction(function () use ($course, $validated, $videoPath, $questions) {
            $lesson = Lesson::create([
                'course_id' => $course->id,
                'title' => $validated['title'],
                'description' => $validated['description'] ?? '',
                'video_path' => $videoPath,
                'sort_order' => ($course->lessons()->max('sort_order') ?? 0) + 1,
            ]);

            foreach ($questions->take(5) as $q) {
                LessonQuestion::create([
                    'lesson_id' => $lesson->id,
                    'question' => $q['question'],
                    'option_a' => $q['option_a'],
                    'option_b' => $q['option_b'],
                    'option_c' => $q['option_c'],
                    'option_d' => $q['option_d'],
                    'correct_option' => $q['correct_option'],
                ]);
            }
        });

        return $this->lessonStoreResponse($request, true, 'تم حفظ الفيديو والبيانات بنجاح');
    }


    public function storeLessonChunked(Request $request)
    {
        $instructor = auth('instructor')->user();
        if (!$instructor) {
            return response()->json(['success' => false], 401);
        }

        // Validate basic chunk info
        $request->validate([
            'file' => ['required', 'file', 'max:512000'],
            'chunkIndex' => ['required', 'integer'],
            'totalChunks' => ['required', 'integer'],
            'identifier' => ['required', 'string'],
            'originalName' => ['required', 'string'],
            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'min:3', 'max:255'],
        ], [
            'file.file' => 'فشل رفع جزء من ملف الفيديو. يرجى التأكد من حجم الملف وإعدادات السيرفر.',
            'file.max' => 'حجم الجزء يتجاوز الحد المسموح به.',
            'course_id.required' => 'يجب اختيار كورس.',
            'title.required' => 'يجب إدخال عنوان الفيديو.',
        ]);

        $chunk = $request->file('file');
        $dir = storage_path("app/chunks/{$request->identifier}");

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $chunk->move($dir, "chunk_{$request->chunkIndex}");
        $received = count(glob($dir . '/chunk_*'));

        if ($received < $request->totalChunks) {
            return response()->json(['success' => true, 'complete' => false]);
        }

        // Only validate questions on the last chunk when assembly is complete
        $request->validate([
            'questions' => ['required', 'array', 'min:5'],
            'questions.*.question' => ['required', 'string', 'max:255'],
            'questions.*.option_a' => ['required', 'string', 'max:255'],
            'questions.*.option_b' => ['required', 'string', 'max:255'],
            'questions.*.option_c' => ['required', 'string', 'max:255'],
            'questions.*.option_d' => ['required', 'string', 'max:255'],
            'questions.*.correct_option' => ['required', 'in:a,b,c,d'],
        ], [
            'questions.required' => 'يجب إضافة 5 أسئلة على الأقل.',
            'questions.min' => 'يجب إضافة 5 أسئلة على الأقل.',
        ]);

        // Final assembly
        $extension = pathinfo($request->originalName, PATHINFO_EXTENSION);
        $finalName = \Illuminate\Support\Str::uuid() . '.' . $extension;
        $finalPath = storage_path("app/chunks/{$finalName}");

        $out = fopen($finalPath, 'wb');
        for ($i = 0; $i < $request->totalChunks; $i++) {
            $chunkPath = "{$dir}/chunk_{$i}";
            $in = fopen($chunkPath, 'rb');
            stream_copy_to_stream($in, $out);
            fclose($in);
            unlink($chunkPath);
        }
        fclose($out);
        rmdir($dir);

        // Validate duration
        $validator = new VideoDuration();
        $error = null;
        $validator->validate('video', $finalPath, function ($msg) use (&$error) {
            $error = $msg;
        });

        if ($error) {
            unlink($finalPath);
            return response()->json(['success' => false, 'message' => $error], 422);
        }

        // Move to public uploads
        $publicDir = public_path('uploads/videos');
        if (!is_dir($publicDir)) {
            mkdir($publicDir, 0775, true);
        }
        $publicPath = $publicDir . '/' . $finalName;
        rename($finalPath, $publicPath);

        // Now save the lesson with questions
        $videoPath = "uploads/videos/{$finalName}";

        $validated = $request->validate($this->lessonRules(false));
        $validated['video_path'] = $videoPath;

        return $this->saveLessonRecord($validated, $videoPath, $request);
    }

    public function editLesson(Lesson $lesson)
    {
        $instructor = Auth::guard('instructor')->user();

        if ($lesson->course->instructor_id !== $instructor->id) {
            abort(403, 'غير مصرح لك بتعديل هذا الفيديو.');
        }

        return view('instructor_pages.instructor_lesson_edit', compact('lesson'));
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $instructor = Auth::guard('instructor')->user();

        if ($lesson->course->instructor_id !== $instructor->id) {
            abort(403, 'غير مصرح لك بتعديل هذا الفيديو.');
        }

        $validated = $request->validate([
            'title'       => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'video_path'  => ['nullable', 'string', 'max:2000'],
            'video_file'  => ['nullable', 'file', 'max:512000', 'mimetypes:' . self::VIDEO_MIMETYPES, new VideoDuration()],
        ]);

        $lesson->title       = $validated['title'];
        $lesson->description = $validated['description'] ?? '';

        // Handle video replacement by file upload or URL
        if ($request->hasFile('video_file') && $request->file('video_file')->isValid()) {
            $file = $request->file('video_file');
            $newPath = $this->storePublicUpload($file, 'videos');

            $oldPath = public_path($lesson->video_path);
            if ($lesson->video_path && file_exists($oldPath) && !is_dir($oldPath)) {
                unlink($oldPath);
            }

            $lesson->video_path = $newPath;
        } elseif (!empty($validated['video_path'])) {
            $oldPath = public_path($lesson->video_path);
            if ($lesson->video_path && file_exists($oldPath) && !is_dir($oldPath)) {
                unlink($oldPath);
            }
            $lesson->video_path = $validated['video_path'];
        }

        $lesson->save();

        if ($request->expectsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => 'تم تعديل الفيديو بنجاح.',
                'redirect' => route('courses.show', $lesson->course_id),
            ]);
        }

        return redirect()->route('courses.show', $lesson->course_id)
            ->with('success', 'تم تعديل الفيديو بنجاح.');
    }

    public function updateLessonChunked(Request $request, Lesson $lesson)
    {
        $instructor = auth('instructor')->user();
        if (!$instructor || $lesson->course->instructor_id !== $instructor->id) {
            return response()->json(['success' => false, 'message' => 'غير مصرح.'], 403);
        }

        $request->validate([
            'file'        => ['required', 'file', 'max:512000'],
            'chunkIndex'  => ['required', 'integer'],
            'totalChunks' => ['required', 'integer'],
            'identifier'  => ['required', 'string'],
            'originalName' => ['required', 'string'],
        ]);

        $chunk = $request->file('file');
        $dir = storage_path("app/chunks/{$request->identifier}");

        if (!is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        $chunk->move($dir, "chunk_{$request->chunkIndex}");
        $received = count(glob($dir . '/chunk_*'));

        if ($received < $request->totalChunks) {
            return response()->json(['success' => true, 'complete' => false]);
        }

        // Final assembly
        $extension = pathinfo($request->originalName, PATHINFO_EXTENSION);
        $finalName = Str::uuid() . '.' . $extension;
        $finalPath = storage_path("app/chunks/{$finalName}");

        $out = fopen($finalPath, 'wb');
        for ($i = 0; $i < $request->totalChunks; $i++) {
            $chunkPath = "{$dir}/chunk_{$i}";
            $in = fopen($chunkPath, 'rb');
            stream_copy_to_stream($in, $out);
            fclose($in);
            unlink($chunkPath);
        }
        fclose($out);
        rmdir($dir);

        // Validate duration (3–15 minutes)
        $validator = new \App\Rules\VideoDuration();
        $error = null;
        $validator->validate('video', $finalPath, function ($msg) use (&$error) {
            $error = $msg;
        });

        if ($error) {
            unlink($finalPath);
            return response()->json(['success' => false, 'message' => $error], 422);
        }

        // Move to public uploads
        $publicDir = public_path('uploads/videos');
        if (!is_dir($publicDir)) {
            mkdir($publicDir, 0775, true);
        }
        rename($finalPath, $publicDir . '/' . $finalName);

        // Delete old video file
        $oldPath = public_path($lesson->video_path);
        if ($lesson->video_path && file_exists($oldPath) && !is_dir($oldPath)) {
            unlink($oldPath);
        }

        // Update lesson metadata
        $lesson->title       = $request->input('title', $lesson->title);
        $lesson->description = $request->input('description', $lesson->description);
        $lesson->video_path  = "uploads/videos/{$finalName}";
        $lesson->save();

        return response()->json([
            'success'  => true,
            'message'  => 'تم تعديل الفيديو بنجاح.',
            'redirect' => route('courses.show', $lesson->course_id),
        ]);
    }

    public function storePublicUpload(object $file, string $folder): string
    {
        $extension = $file->extension();

        $name = \Illuminate\Support\Str::uuid() . '.' . $extension;

        $path = public_path("uploads/{$folder}");

        if (!is_dir($path)) {
            mkdir($path, 0775, true);
        }

        $file->move($path, $name);

        $full = $path . '/' . $name;

        if (!file_exists($full)) {
            throw new \Exception("Upload failed");
        }

        return "uploads/{$folder}/{$name}";
    }


    private function completeLessonQuestions(Request $request)
    {
        return collect($request->input('questions', []))->filter(function ($question) {
            return filled($question['question'] ?? null)
                && filled($question['option_a'] ?? null)
                && filled($question['option_b'] ?? null)
                && filled($question['option_c'] ?? null)
                && filled($question['option_d'] ?? null)
                && in_array($question['correct_option'] ?? null, ['a', 'b', 'c', 'd'], true);
        });
    }



    public function lessonRules(bool $includeVideoFile = true): array
    {
        $rules = [

            'course_id' => ['required', 'exists:courses,id'],
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],

            'video_path' => ['nullable', 'string', 'max:2000'],

            'questions' => ['required', 'array', 'min:5'],

            'questions.*.question' => ['required', 'string', 'max:255'],
            'questions.*.option_a' => ['required', 'string', 'max:255'],
            'questions.*.option_b' => ['required', 'string', 'max:255'],
            'questions.*.option_c' => ['required', 'string', 'max:255'],
            'questions.*.option_d' => ['required', 'string', 'max:255'],
            'questions.*.correct_option' => ['required', 'in:a,b,c,d'],
        ];

        if ($includeVideoFile) {
            $rules['video_file'] = [
                'nullable',
                'file',
                'max:512000', // 500MB
                'mimetypes:' . self::VIDEO_MIMETYPES,
                new VideoDuration(),
            ];
        }

        return $rules;
    }
    private function lessonStoreResponse(
        Request $request,
        bool $success,
        string $message
    ) {

        // JSON response
        if ($request->expectsJson()) {

            return response()->json([

                'success' => $success,

                'message' => $message,

                'redirect' => route('instructor.dashboard') . '#add-video',

            ], $success ? 200 : 422);
        }
        // Success response
        if ($success) {
            return back()->with(
                'success_lesson',
                $message
            );
        }
        // Error response
        return back()
            ->withErrors([
                'video_file' => $message
            ])
            ->withInput();
    }
}
