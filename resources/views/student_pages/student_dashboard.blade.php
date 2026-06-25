@extends('layouts.main')

@section('title', __('messages.student_dashboard_title'))

@section('footer')
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('student_pages_2/strudent_dashboard.css') }}">
<style>
    body { padding-top: 0 !important; }
    footer.academia-footer { display: none !important; }
    @if($currentDir === 'ltr')
    .student-sidebar {
        right: auto !important;
        left: 0 !important;
        border-left: none !important;
        border-right: 1px solid #eef2f6 !important;
    }
    .student-sidebar.closed {
        transform: translateX(-100%) !important;
    }
    .student-sidebar.open {
        transform: translateX(0) !important;
    }
    .main {
        margin-right: 0 !important;
        margin-left: 280px !important;
    }
    .main.expanded {
        margin-left: 0 !important;
    }
    #desktopToggle {
        right: auto !important;
        left: 290px !important;
    }
    @media (max-width: 768px) {
        .main { margin-left: 0 !important; }
        .student-sidebar { transform: translateX(-100%) !important; }
        .student-sidebar.open { transform: translateX(0) !important; }
    }
    @endif
</style>
@endsection

@section('content')

<button id="mobileToggle" class="d-md-none"><i class="fas fa-bars"></i></button>

<!-- SIDEBAR -->
<div class="student-sidebar" id="sidebar">

    <div class="mb-4 d-flex justify-content-between align-items-center d-md-none">
        <h5 style="color:var(--main)" class="m-0 fw-bold"><i class="fas fa-graduation-cap me-2"></i> Academia+</h5>
        <button id="closeSidebar" class="btn btn-sm btn-light rounded-circle"><i class="fas fa-times"></i></button>
    </div>

    <div class="sidebar-profile">
        @if(Auth::user()->profile_photo)
            <img src="{{ asset(Auth::user()->profile_photo) }}" class="sidebar-avatar" alt="{{ Auth::user()->name }}">
        @else
            <div class="sidebar-avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
        @endif
        <h6>{{ Auth::user()->name }}</h6>
        <span><i class="fas fa-user-graduate me-1"></i> {{ __('messages.student_active') }}</span>
    </div>

    <div class="student-nav-title">{{ __('messages.student_main_menu') }}</div>
    <a href="{{ url('/') }}" class="student-side-link"><i class="fas fa-home"></i><span>{{ __('messages.student_home') }}</span></a>
    <a href="{{ url('/payedcources') }}" class="student-side-link"><i class="fas fa-play-circle"></i><span>{{ __('messages.student_available') }}</span></a>
    <a href="{{ url('/instructors') }}" class="student-side-link"><i class="fas fa-user-tie"></i><span>{{ __('messages.student_instructors') }}</span></a>

    <div class="student-nav-title">{{ __('messages.student_learning_space') }}</div>
    <a class="student-side-link active"><i class="fas fa-bookmark"></i><span>{{ __('messages.student_my_saved') }}</span></a>
    <a href="{{ url('/articles') }}" class="student-side-link"><i class="fas fa-newspaper"></i><span>{{ __('messages.student_articles') }}</span></a>
    <a href="{{ url('/exams') }}" class="student-side-link"><i class="fas fa-file-alt"></i><span>{{ __('messages.student_exams') }}</span></a>
    <a href="{{ route('student.chat') }}" class="student-side-link"><i class="fas fa-comments"></i><span>{{ __('messages.student_chat') }}</span><span class="chat-badge ms-auto" id="studentChatBadge" style="display:none; background: #dc3545; color: #fff; font-size: 0.65rem; font-weight: 700; min-width: 18px; height: 18px; border-radius: 9px; align-items: center; justify-content: center; padding: 0 5px;"></span></a>

    <div class="student-nav-title">{{ __('messages.student_account_settings') }}</div>
    <a href="{{ route('student.profile') }}" class="student-side-link"><i class="fas fa-user-pen"></i><span>{{ __('messages.student_edit_profile') }}</span></a>

    <form id="logout-form" action="{{ route('student.logout') }}" method="POST" class="mt-4">
        @csrf
        <button type="submit" class="logout-btn w-100"><i class="fas fa-sign-out-alt me-2"></i> {{ __('messages.student_logout') }}</button>
    </form>

</div>

<div id="desktopToggle"><i class="fas fa-chevron-right"></i></div>

<!-- MAIN -->
<div class="main pt-4" id="mainContent">

    @if(session('success_login'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="fas fa-check-circle me-2"></i> {{ session('success_login') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-2" style="color: #1e293b;">{{ __('messages.student_dashboard_heading', ['name' => Auth::user()->name]) }}</h2>
            <p class="text-muted" style="font-size: 1.1rem;">{{ __('messages.student_dashboard_sub') }}</p>
        </div>
    </div>

    <!-- STATS -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="text-primary mb-2 opacity-50"><i class="fas fa-bookmark fa-2x"></i></div>
                <p>{{ __('messages.student_saved_courses') }}</p>
                <h3>{{ $savedCourses->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="text-success mb-2 opacity-50"><i class="fas fa-book-open fa-2x"></i></div>
                <p>{{ __('messages.student_available_courses') }}</p>
                <h3>{{ $courses->count() }}</h3>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <div class="text-warning mb-2 opacity-50"><i class="fas fa-trophy fa-2x"></i></div>
                <p>{{ __('messages.student_overall_progress') }}</p>
                <h3>{{ $savedCourses->count() > 0 ? '10%' : '0%' }}</h3>
            </div>
        </div>
    </div>

    <!-- SAVED COURSES -->
    <div class="glass mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0" style="color: #1e293b;"><i class="fas fa-bookmark text-primary me-2"></i>
                {{ __('messages.student_my_saved') }}</h4>
        </div>

        <div class="row g-4">
            @if($savedCourses->isEmpty())
                <div class="col-12">
                    <div class="alert alert-light border text-center p-5 rounded-4">
                        <i class="fas fa-folder-open fa-4x text-muted mb-3 opacity-25 d-block"></i>
                        <h5 class="fw-bold text-dark">{{ __('messages.student_no_saved_courses') }}</h5>
                        <p class="mb-0 text-muted">{{ __('messages.student_no_saved_hint') }}</p>
                        <a href="{{ url('/payedcources') }}" class="btn btn-primary rounded-pill px-4 mt-3">{{ __('messages.student_browse_courses') }}</a>
                    </div>
                </div>
            @else
                @foreach($savedCourses as $course)
                    <div class="col-md-6 col-lg-4">
                        <div class="course-card">
                            <div class="course-card-image-wrapper bg-light d-flex align-items-center justify-content-center"
                                style="height: 150px; background: linear-gradient(45deg, #eef2f6, #ffffff); overflow: hidden;">
                                @if($course->image_path)
                                    <img src="{{ asset($course->image_path) }}" alt="{{ $course->title }}" class="course-card-img" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <i class="fas fa-laptop-code fa-4x text-primary opacity-25"></i>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="fw-bold text-dark text-truncate mb-3" title="{{ $course->title }}">
                                    {{ $course->title }}
                                </h5>
                                <div class="d-flex align-items-center mb-4">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2 text-white"
                                        style="width: 30px; height: 30px;">
                                        <i class="fas fa-user-tie small"></i>
                                    </div>
                                    <p class="small text-muted mb-0 fw-semibold">{{ $course->instructor->name }}</p>
                                </div>
                                <a href="{{ route('courses.show', $course) }}"
                                    class="btn btn-primary w-100 btn-course">{{ __('messages.student_continue_learning') }} <i class="fas fa-arrow-left ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

    <!-- SUGGESTED COURSES -->
    <div class="glass">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0" style="color: #1e293b;"><i class="fas fa-compass text-primary me-2"></i> {{ __('messages.student_new_courses') }}</h4>
            <a href="{{ url('/payedcources') }}" class="btn btn-sm btn-outline-primary rounded-pill px-4">{{ __('messages.student_view_all') }}</a>
        </div>
        <div class="row g-4">
            @foreach($courses->take(3) as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="course-card">
                        <div class="course-card-image-wrapper bg-light d-flex align-items-center justify-content-center"
                            style="height: 150px; background: linear-gradient(45deg, #eef2f6, #ffffff); overflow: hidden;">
                            @if($course->image_path)
                                <img src="{{ asset($course->image_path) }}" alt="{{ $course->title }}" class="course-card-img" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fas fa-graduation-cap fa-4x text-primary opacity-25"></i>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column p-4">
                            <h6 class="fw-bold mb-2">{{ $course->title }}</h6>
                            <p class="small text-muted mb-4">{{ Str::limit($course->description, 60) }}</p>
                            <a href="{{ route('courses.show', $course) }}"
                                class="btn btn-outline-primary w-100 btn-course">{{ __('messages.student_details') }}</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    const sidebar = document.getElementById('sidebar');
    const mainContent = document.getElementById('mainContent');
    const desktopToggle = document.getElementById('desktopToggle');
    const mobileToggle = document.getElementById('mobileToggle');
    const closeSidebar = document.getElementById('closeSidebar');
    const isLtr = document.documentElement.dir === 'ltr';

    let sidebarVisible = true;

    desktopToggle.addEventListener('click', () => {
        const side = isLtr ? 'left' : 'right';
        if (sidebarVisible) {
            sidebar.classList.add('closed');
            mainContent.classList.add('expanded');
            desktopToggle.style[side] = '20px';
            desktopToggle.innerHTML = isLtr
                ? '<i class="fas fa-chevron-right"></i>'
                : '<i class="fas fa-chevron-left"></i>';
        } else {
            sidebar.classList.remove('closed');
            mainContent.classList.remove('expanded');
            desktopToggle.style[side] = '290px';
            desktopToggle.innerHTML = isLtr
                ? '<i class="fas fa-chevron-left"></i>'
                : '<i class="fas fa-chevron-right"></i>';
        }
        sidebarVisible = !sidebarVisible;
    });

    mobileToggle.addEventListener('click', () => {
        sidebar.classList.add('open');
    });

    if (closeSidebar) {
        closeSidebar.addEventListener('click', () => {
            sidebar.classList.remove('open');
        });
    }

    function updateStudentChatBadge() {
        fetch('{{ route("student.chat.unread") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
        })
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('studentChatBadge');
            if (badge) {
                if (data.count > 0) {
                    badge.style.display = 'inline-flex';
                    badge.textContent = data.count;
                } else {
                    badge.style.display = 'none';
                }
            }
        })
        .catch(() => {});
    }
    updateStudentChatBadge();
    setInterval(updateStudentChatBadge, 10000);
</script>
@endsection
