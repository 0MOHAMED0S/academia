<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\InstructorAuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StudentAuthController;
use App\Http\Controllers\MultipleLanguageController;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Locale-independent fallback for the 'login' named route
|--------------------------------------------------------------------------
| Laravel's auth middleware redirects unauthenticated users to the 'login'
| named route. We keep it outside the locale group pointing to the student
| login page so it always works regardless of URL prefix.
*/

Route::get('/login', fn() => redirect()->route('student_login_page'))->name('login');

Route::get('/language/{locale}', [App\Http\Controllers\LocalizationController::class, 'switch'])->name('language.switch');

/*
|--------------------------------------------------------------------------
| Language Switching Routes (Non-Localized)
|--------------------------------------------------------------------------
| These routes allow users to change language without locale prefix
*/
Route::get('/setlocale/{locale}', [MultipleLanguageController::class, 'setLocale'])->name('language.switch');

/*
|--------------------------------------------------------------------------
| Localized Route Group
|--------------------------------------------------------------------------
| Every route inside this group gets a locale prefix: /ar, /en, /de.
|
| Middleware stack:
|   localeSessionRedirect  – stores chosen locale in session & redirects
|                            if no locale prefix is present in the URL.
|   localizationRedirect   – redirects deprecated/wrong locale URLs.
|   localize               – registers the locale routes.
|   setLocale              – our custom middleware: sets App::setLocale(),
|                            shares $currentLocale + $currentDir in views.
*/
Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'setLocale']
    ],
    function () {

        // ── Public home (loads courses from DB) ──────────────────────────────
        Route::get('/', [CourseController::class, 'index'])->name('home');

        // ── Static contact POST ──────────────────────────────────────────────
        Route::post('/contact', [CourseController::class, 'contact'])->name('contact.store');

        // ── Admin auth (guest:admin guard) ───────────────────────────────────
        Route::middleware('guest:admin')->group(function () {
            Route::get('/admin_login',  [AdminController::class, 'loginPage'])->name('admin.login_page');
            Route::post('/admin_login', [AdminController::class, 'login'])->name('admin.login');
        });

        // ── Admin authenticated routes ────────────────────────────────────────
        Route::middleware('auth:admin')->group(function () {
            Route::get('/admin_dashboard',  [AdminController::class, 'dashboard'])->name('admin.dashboard');
            Route::post('/admin_logout',    [AdminController::class, 'logout'])->name('admin.logout');

            // Users management
            Route::delete('/admin/students/{user}',      [AdminController::class, 'deleteStudent'])->name('admin.delete.student');
            Route::delete('/admin/instructors/{instructor}', [AdminController::class, 'deleteInstructor'])->name('admin.delete.instructor');

            // Tracks management
            Route::post('/admin/tracks',           [AdminController::class, 'storeTrack'])->name('admin.store.track');
            Route::put('/admin/tracks/{track}',    [AdminController::class, 'updateTrack'])->name('admin.update.track');
            Route::delete('/admin/tracks/{track}', [AdminController::class, 'deleteTrack'])->name('admin.delete.track');

            // Video management
            Route::delete('/admin/lessons/{lesson}', [AdminController::class, 'deleteLesson'])->name('admin.delete.lesson');

            // Admin profile
            Route::get('/admin_profile',   [AdminController::class, 'profile'])->name('admin.profile');
            Route::put('/admin_profile',   [AdminController::class, 'updateProfile'])->name('admin.profile.update');
            Route::delete('/admin/courses/{course}',                          [AdminController::class, 'deleteCourse'])->name('admin.delete.course');
            Route::delete('/admin/courses/{course}/students/{user}',          [AdminController::class, 'removeStudentFromCourse'])->name('admin.courses.remove_student');

            // Subscription management
            Route::get('/admin/subscribed_students',                           [CourseController::class, 'adminSubscribedStudents'])->name('admin.subscribed_students');
            Route::get('/admin/courses/{course}/edit_subscribed',              [CourseController::class, 'adminEditCourse'])->name('admin.edit.subscribed_course');
            Route::put('/admin/courses/{course}/update_subscribed',            [CourseController::class, 'adminUpdateCourse'])->name('admin.update.subscribed_course');
            Route::delete('/admin/courses/{course}/delete_subscribed',         [CourseController::class, 'adminDeleteCourse'])->name('admin.delete.subscribed_course');
            Route::get('/admin/courses/{course}/students/{user}/add_id',       [CourseController::class, 'adminAddStudentIdView'])->name('admin.add.student_id_view');
            Route::post('/admin/store_student_id',                             [CourseController::class, 'adminStoreStudentId'])->name('admin.store.student_id');
            // ── Admin Chat ───────────────────────────────────────────────────
            Route::get('/admin/chat',                                          [ChatController::class, 'adminIndex'])->name('admin.chat');
            Route::post('/admin/chat/send',                                    [ChatController::class, 'sendMessage'])->name('admin.chat.send');
            Route::post('/admin/chat/send-audio',                              [ChatController::class, 'sendAudio'])->name('admin.chat.send_audio');
            Route::get('/admin/chat/messages',                                 [ChatController::class, 'fetchMessages'])->name('admin.chat.messages');
            Route::get('/admin/chat/conversations',                            [ChatController::class, 'getConversations'])->name('admin.chat.conversations');
            Route::post('/admin/chat/mark-read',                               [ChatController::class, 'markAsRead'])->name('admin.chat.mark_read');
            Route::get('/admin/chat/unread-count',                             [ChatController::class, 'unreadCount'])->name('admin.chat.unread');
            Route::put('/admin/chat/{message}/edit',                           [ChatController::class, 'editMessage'])->name('admin.chat.edit');
            Route::delete('/admin/chat/{message}',                             [ChatController::class, 'deleteMessage'])->name('admin.chat.delete');
        });

        // ── Static public pages ───────────────────────────────────────────────
        Route::get('/about',           fn() => view('main_pages.about'));
        Route::get('/aicources',       fn() => view('main_pages.aicources'));
        Route::get('/articles',        fn() => view('main_pages.articals'));
        Route::get('/c++cources',      fn() => view('main_pages.cpluspluscources'));
        Route::get('/devopscources',   fn() => view('main_pages.devopscources'));
        Route::get('/exams',           fn() => view('main_pages.exams'));
        Route::get('/flutter_cources', fn() => view('main_pages.fluttercources'));
        Route::get('/fullstackcources', fn() => view('main_pages.fullstackcources'));
        Route::get('/gamecources',     fn() => view('main_pages.gamecources'));
        Route::get('/htmlcources',     fn() => view('main_pages.htmlcources'));
        Route::get('/jscources',       fn() => view('main_pages.jscources'));
        Route::get('/mobilecources',   fn() => view('main_pages.mobilecources'));
        Route::get('/nodecources',     fn() => view('main_pages.nodecources'));
        Route::get('/payedcources',    [CourseController::class, 'payedCourses'])->name('payedcources');
        Route::get('/freecourse',      [CourseController::class, 'freeCourses'])->name('freecourse');
        Route::get('/pythoncources',   fn() => view('main_pages.pythoncources'));
        Route::get('/phpcources',      fn() => view('main_pages.phpcources'));
        Route::get('/reactcources',    fn() => view('main_pages.reactcources'));
        Route::get('/instructors',     fn() => view('main_pages.instructors', ['instructors' => \App\Models\Instructor::all()]));

        // ── Courses & Lessons — public ────────────────────────────────────────
        Route::get('/courses/{course}',    [CourseController::class, 'show'])->name('courses.show');
        Route::get('/lessons/{lesson}',    [CourseController::class, 'lesson'])->name('lessons.show');
        Route::get('/tracks/{track:slug}', [CourseController::class, 'track'])->name('tracks.show');

        // ── STUDENT ───────────────────────────────────────────────────────────

        // Guest-only student routes
        Route::middleware('guest:web')->group(function () {
            Route::get('/student_register',  [StudentAuthController::class, 'register_page'])->name('student_register_page');
            Route::get('/student_login',     [StudentAuthController::class, 'login_page'])->name('student_login_page');
            Route::post('/student_register', [StudentAuthController::class, 'register'])->name('student.register');
            Route::post('/student_login',    [StudentAuthController::class, 'login'])->name('student.login');
            Route::get('/auth/google/student', [StudentAuthController::class, 'redirectToGoogle'])->name('student.google.redirect');
        });

        Route::get('/auth/google/student/callback', [StudentAuthController::class, 'handleGoogleCallback'])
            ->name('student.google.callback');

        // Authenticated student routes
        Route::middleware('auth:web')->group(function () {
            Route::get('/student_dashboard',          [StudentAuthController::class, 'get_dashboard'])->name('student.dashboard');
            Route::get('/student_profile',            [StudentAuthController::class, 'profile'])->name('student.profile');
            Route::put('/student_profile',            [StudentAuthController::class, 'updateProfile'])->name('student.profile.update');
            Route::post('/student_logout',            [StudentAuthController::class, 'logout'])->name('student.logout');
            Route::post('/courses/{course}/save',     [CourseController::class, 'saveCourse'])->name('courses.save');
            Route::post('/courses/{course}/payment',  [CourseController::class, 'verifyPayment'])->name('courses.payment.verify');
            Route::post('/lessons/{lesson}/quiz',     [CourseController::class, 'submitLessonQuiz'])->name('lessons.quiz.submit');
            Route::get('/courses/{course}/certificate', [CourseController::class, 'certificate'])->name('courses.certificate');

            // ── Student Chat ───────────────────────────────────────────────────
            Route::get('/student/chat',                       [ChatController::class, 'studentIndex'])->name('student.chat');
            Route::post('/student/chat/send',                 [ChatController::class, 'studentSendMessage'])->name('student.chat.send');
            Route::post('/student/chat/send-audio',           [ChatController::class, 'studentSendAudio'])->name('student.chat.send_audio');
            Route::get('/student/chat/messages',              [ChatController::class, 'studentFetchMessages'])->name('student.chat.messages');
            Route::post('/student/chat/mark-read',            [ChatController::class, 'studentMarkAsRead'])->name('student.chat.mark_read');
            Route::get('/student/chat/unread-count',          [ChatController::class, 'studentUnreadCount'])->name('student.chat.unread');
            Route::put('/student/chat/{message}/edit',        [ChatController::class, 'studentEditMessage'])->name('student.chat.edit');
            Route::delete('/student/chat/{message}',          [ChatController::class, 'studentDeleteMessage'])->name('student.chat.delete');
        });

        // ── INSTRUCTOR ────────────────────────────────────────────────────────

        // Guest-only instructor routes
        Route::middleware('guest:instructor')->group(function () {
            Route::get('/instructor_register',  [InstructorAuthController::class, 'register_page'])->name('instructor_register_page');
            Route::get('/instructor_login',     [InstructorAuthController::class, 'login_page'])->name('instructor_login_page');
            Route::post('/instructor_register', [InstructorAuthController::class, 'register'])->name('instructor.register');
            Route::post('/instructor_login',    [InstructorAuthController::class, 'login'])->name('instructor.login');
            Route::get('/auth/google/instructor', [InstructorAuthController::class, 'redirectToGoogle'])->name('instructor.google.redirect');
        });

        Route::get('/auth/google/instructor/callback', [InstructorAuthController::class, 'handleGoogleCallback'])
            ->name('instructor.google.callback');

        // Authenticated instructor routes
        Route::middleware('auth:instructor')->group(function () {
            Route::get('/instructor_dashboard',                [InstructorAuthController::class, 'dashboard'])->name('instructor.dashboard');
            Route::get('/instructor_profile',                  [InstructorAuthController::class, 'profile'])->name('instructor.profile');
            Route::put('/instructor_profile',                  [InstructorAuthController::class, 'updateProfile'])->name('instructor.profile.update');
            Route::get('/instructor_courses/{course}/edit',    [InstructorAuthController::class, 'editCourse'])->name('instructor.course.edit');
            Route::put('/instructor_courses/{course}',         [InstructorAuthController::class, 'updateCourse'])->name('instructor.course.update');
            Route::post('/instructor_courses',                 [InstructorAuthController::class, 'storeCourse'])->name('instructor.course.store');
            Route::post('/instructor_lessons',                 [InstructorAuthController::class, 'storeLesson'])->name('instructor.lesson.store');
            Route::post('/instructor_lessons/chunk-upload',    [InstructorAuthController::class, 'storeLessonChunked'])->name('instructor.lesson.store.chunked');
            Route::get('/instructor_lessons/{lesson}/edit',    [InstructorAuthController::class, 'editLesson'])->name('instructor.lesson.edit');
            Route::put('/instructor_lessons/{lesson}',         [InstructorAuthController::class, 'updateLesson'])->name('instructor.lesson.update');
            Route::post('/instructor_lessons/{lesson}/chunk-update', [InstructorAuthController::class, 'updateLessonChunked'])->name('instructor.lesson.update.chunked');
            Route::post('/instructor_logout',                  [InstructorAuthController::class, 'logout'])->name('instructor.logout');
            // ── Instructor Chat ──────────────────────────────────────────────
            Route::get('/instructor/chat',                    [ChatController::class, 'instructorIndex'])->name('instructor.chat');
            Route::post('/instructor/chat/send',              [ChatController::class, 'sendMessage'])->name('instructor.chat.send');
            Route::post('/instructor/chat/send-audio',        [ChatController::class, 'sendAudio'])->name('instructor.chat.send_audio');
            Route::get('/instructor/chat/messages',           [ChatController::class, 'fetchMessages'])->name('instructor.chat.messages');
            Route::get('/instructor/chat/unread-count',       [ChatController::class, 'unreadCount'])->name('instructor.chat.unread');
            Route::put('/instructor/chat/{message}/edit',    [ChatController::class, 'editMessage'])->name('instructor.chat.edit');
            Route::delete('/instructor/chat/{message}',      [ChatController::class, 'deleteMessage'])->name('instructor.chat.delete');

            // ── Instructor Student Chat ──────────────────────────────────────
            Route::get('/instructor/student-chat',             [ChatController::class, 'instructorStudentIndex'])->name('instructor.student_chat');
            Route::post('/instructor/student-chat/send',       [ChatController::class, 'instructorStudentSendMessage'])->name('instructor.student_chat.send');
            Route::post('/instructor/student-chat/send-audio', [ChatController::class, 'instructorStudentSendAudio'])->name('instructor.student_chat.send_audio');
            Route::get('/instructor/student-chat/messages',    [ChatController::class, 'instructorStudentFetchMessages'])->name('instructor.student_chat.messages');
            Route::post('/instructor/student-chat/mark-read',  [ChatController::class, 'instructorStudentMarkAsRead'])->name('instructor.student_chat.mark_read');
            Route::get('/instructor/student-chat/unread-count',[ChatController::class, 'instructorStudentUnreadCount'])->name('instructor.student_chat.unread');
            Route::put('/instructor/student-chat/{message}/edit', [ChatController::class, 'instructorStudentEditMessage'])->name('instructor.student_chat.edit');
            Route::delete('/instructor/student-chat/{message}', [ChatController::class, 'instructorStudentDeleteMessage'])->name('instructor.student_chat.delete');
        });

        // ── Notifications API ─────────────────────────────────────────────────
        Route::get('/notifications/api',                       [NotificationController::class, 'index']);
        Route::post('/notifications/api/{notification}/read',  [NotificationController::class, 'markAsRead']);
        Route::post('/notifications/api/read-all',             [NotificationController::class, 'markAllAsRead']);
        Route::get('/notifications/api/unread-count',          [NotificationController::class, 'unreadCount']);
        Route::get('/notifications',                           [NotificationController::class, 'all'])->name('notifications.all');
    }
);



Route::get('/instructor/student-messages', function () {
    return redirect()->route('instructor.student_chat');
})->name('instructor.student.messages');
