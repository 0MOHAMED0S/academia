<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use App\Http\Controllers\Concerns\InteractsWithGoogleAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Two\InvalidStateException;

class StudentAuthController extends Controller
{
    use InteractsWithGoogleAuth;

    public function register_page()
    {
        return view('student_pages.student_register');
    }

    public function login_page()
    {
        return view('student_pages.student_login');
    }

    public function get_dashboard()
    {
        $user = Auth::guard('web')->user();
        $savedCourses = $user->savedCourses()->with('instructor')->get();
        $courses = Course::with('instructor')->latest()->get();

        return view('student_pages.student_dashboard', compact('savedCourses', 'courses'));
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6', 'max:50', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::guard('web')->login($user);

        return redirect()->route('student.dashboard')->with('success_register', 'تم التسجيل بنجاح.');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        if (Auth::guard('web')->attempt($validated)) {
            $request->session()->regenerate();
            $student = Auth::guard('web')->user();
            return redirect()->route('student.dashboard')->with('success_login', 'مرحباً بك يا ' . $student->name . ' 👋');
        }

        return back()->withErrors([
            'email' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة.',
        ])->withInput();
    }

    public function redirectToGoogle()
    {
        if (! $this->googleOAuthConfigured()) {
            return redirect()->route('student_login_page')
                ->with('error', 'تسجيل الدخول عبر Google غير مُكوّن. راجع إعدادات GOOGLE_CLIENT_ID و GOOGLE_CLIENT_SECRET في ملف البيئة.');
        }

        return $this->googleOAuthRedirect('student.google.callback');
    }

    public function handleGoogleCallback(Request $request)
    {
        if (! $this->googleOAuthConfigured()) {
            return redirect()->route('student_login_page')
                ->with('error', 'تسجيل الدخول عبر Google غير مُكوّن.');
        }

        try {
            $googleUser = $this->googleOAuthUser('student.google.callback');
        } catch (InvalidStateException) {
            return redirect()->route('student_login_page')
                ->with('error', 'انتهت صلاحية جلسة التحقق مع Google. حاول تسجيل الدخول مرة أخرى.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Google Login Error (Student): ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->route('student_login_page')
                ->with('error', 'فشل تسجيل الدخول عبر Google: ' . $e->getMessage() . '. تأكد من أن عنوان الاسترجاع (Redirect URI) في Google Console يطابق: ' . config('services.google.redirect_student'));
        }

        if (! $googleUser->getEmail()) {
            return redirect()->route('student_login_page')
                ->with('error', 'تعذر الحصول على البريد الإلكتروني من حساب Google.');
        }

        $user = $this->findOrCreateFromGoogleUser(User::class, $googleUser, [
            // Plain string: User model uses 'password' => 'hashed' cast (single hash).
            'password' => Str::random(48),
            'email_verified_at' => now(),
        ]);

        Auth::guard('web')->login($user);
        $request->session()->regenerate();

        return redirect()->route('student.dashboard')
            ->with('success_login', 'مرحباً بك يا ' . $user->name . ' 👋');
    }

    public function logout(Request $request)
    {
        $name = Auth::guard('web')->user()->name;
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('student_login_page')->with('success_logout', 'إلى اللقاء يا ' . $name . ' 👋');
    }

    public function profile()
    {
        return view('student_pages.student_profile', ['student' => Auth::guard('web')->user()]);
    }

    public function updateProfile(Request $request)
    {
        $student = Auth::guard('web')->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $student->id],
            'password' => ['nullable', 'string', 'min:6', 'confirmed'],
            'profile_photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $student->name = $validated['name'];
        $student->email = $validated['email'];

        if (! empty($validated['password'])) {
            $student->password = Hash::make($validated['password']);
        }

        if ($request->hasFile('profile_photo')) {
            $student->profile_photo = $this->storePublicUpload($request->file('profile_photo'), 'students');
        }

        $student->save();

        return back()->with('success_profile', 'تم تحديث بياناتك بنجاح.');
    }

    private function storePublicUpload($file, string $folder): string
    {
        $name = uniqid() . '.' . $file->getClientOriginalExtension();
        $path = "uploads/{$folder}";
        $file->move(public_path($path), $name);

        return "{$path}/{$name}";
    }
}
