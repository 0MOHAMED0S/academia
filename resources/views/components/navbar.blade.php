<meta name="csrf-token" content="{{ csrf_token() }}">
@once
<style>
    .academia-navbar {
        background: linear-gradient(90deg, #1f2c9c, #2f80ed);
        z-index: 1030;
    }

    .academia-navbar .navbar-brand,
    .academia-navbar .nav-link {
        color: #fff !important;
    }

    .academia-navbar .nav-link {
        font-weight: 700;
        border-radius: 8px;
        transition: background .2s ease;
    }

    .academia-navbar .nav-link:hover {
        background: rgba(255, 255, 255, .16);
    }

    .academia-navbar .btnn {
        background-color: #f1f0f3;
        color: #3712bd;
        border: 1px solid #4343f8;
        border-radius: 10px;
        padding: 8px 10px;
        margin: 5px;
        transition: .2s ease;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .academia-navbar .btnn:hover {
        background: #3f22e0;
        color: #fff;
    }

    .academia-navbar .dropdown {
        position: relative;
    }

    .academia-navbar .dropdown-menu {
        inset-inline-end: 0;
        inset-inline-start: auto;
        text-align: right;
        z-index: 1050;
    }

    .academia-navbar .dropdown-menu.show {
        display: block;
    }

    .notif-bell {
        width: 40px;
        height: 40px;
        border: 0;
        border-radius: 50%;
        background: rgba(255, 255, 255, .16);
        color: #fff;
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .notif-badge {
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 999px;
        background: #dc3545;
        color: #fff;
        font-size: 11px;
        position: absolute;
        top: -3px;
        inset-inline-end: -4px;
        display: none;
        align-items: center;
        justify-content: center;
    }

    .notif-dropdown {
        position: absolute;
        top: 48px;
        inset-inline-end: 0;
        width: 320px;
        max-width: calc(100vw - 24px);
        background: #fff;
        border: 1px solid #e8eef8;
        border-radius: 12px;
        box-shadow: 0 18px 45px rgba(15, 23, 42, .18);
        overflow: hidden;
        z-index: 1040;
        color: #15233f;
    }

    .notif-header,
    .notif-footer {
        padding: 10px 12px;
        background: #f8fbff;
        font-weight: 800;
    }

    .notif-list {
        max-height: 320px;
        overflow-y: auto;
    }

    .notif-item {
        padding: 10px 12px;
        border-bottom: 1px solid #eef2f7;
        cursor: pointer;
    }

    .notif-item.unread {
        background: #f0f5ff;
    }

    .notif-item p {
        margin-bottom: 2px;
    }

    .notif-time,
    .notif-empty {
        color: #64748b;
        font-size: 12px;
    }

    .notif-empty {
        padding: 16px 12px;
        text-align: center;
    }

    @media (max-width: 768px) {
        .academia-navbar { padding: 8px 12px !important; }
        .academia-navbar .navbar-brand { font-size: 1.2rem !important; }
        .academia-navbar .navbar-brand img { width: 38px !important; }
        .notif-dropdown { width: 280px; top: 44px; }
        .notif-bell { width: 36px; height: 36px; }
        .academia-navbar .btnn { padding: 6px 10px; font-size: 0.85rem; margin: 3px; }
    }
    @media (max-width: 480px) {
        .academia-navbar .navbar-brand { font-size: 1rem !important; }
        .academia-navbar .navbar-brand img { width: 32px !important; }
        .academia-navbar .brand-title { display: none; }
        .notif-dropdown { width: 260px; }
        .notif-header, .notif-footer { padding: 8px 10px; font-size: 0.85rem; }
        .notif-item { padding: 8px 10px; }
        .academia-navbar .btnn { padding: 5px 8px; font-size: 0.8rem; border-radius: 8px; }
    }
.academia-navbar .dropdown:hover .dropdown-menu { display: block; }
</style>
@endonce
<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-light border-bottom fixed-top academia-navbar" style="padding: 10px 25px; box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);">
    <div class="container-fluid px-lg-5">
        <a class="navbar-brand d-flex align-items-center" href="/" style="font-weight: 700; color: #ffffff !important; font-size: 1.6rem; letter-spacing: 1px;">
            <img src="{{ asset('main_images/images/Logo.jpg') }}" alt="logo" width="50" class="me-2" style="border-radius: 8px;">
            <span class="brand-title">Academia Plus</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu" style="background-color: white;">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navMenu">
            <ul class="navbar-nav align-items-lg-center ms-auto">
                <li class="nav-item mx-lg-2"><a class="nav-link" href="/">{{ __('messages.nav_home') }}</a></li>
                <li class="nav-item mx-lg-2"><a class="nav-link" href="{{ route('freecourse') }}">{{ __('messages.nav_free_courses') }}</a></li>
                <li class="nav-item mx-lg-2"><a class="nav-link" href="/payedcources">{{ __('messages.nav_paid_courses') }}</a></li>
                <li class="nav-item mx-lg-2"><a class="nav-link" href="/instructors">{{ __('messages.nav_instructors') }}</a></li>
                <li class="nav-item mx-lg-2"><a class="nav-link" href="/articles">{{ __('messages.nav_articles') }}</a></li>
                <li class="nav-item mx-lg-2"><a class="nav-link" href="/about">{{ __('messages.nav_about') }}</a></li>

                {{-- Language Dropdown --}}
                <x-language-dropdown />

                {{-- Notification bell --}}
                @auth('web')
                @elseauth('instructor')
                @elseauth('admin')
                    @php $showNotif = true; @endphp
                @endauth
                @if(!empty($showNotif) || Auth::guard('web')->check() || Auth::guard('instructor')->check() || Auth::guard('admin')->check())
                <li class="nav-item d-flex align-items-center mx-1" id="notifContainer" style="position:relative;">
                    <button class="notif-bell" id="notifBellBtn" onclick="toggleNotifDropdown(event)">
                        <i class="fa-solid fa-bell"></i>
                        <span class="notif-badge" id="notifBadge">0</span>
                    </button>
                    <div class="notif-dropdown" id="notifDropdown" style="display:none;">
                        <div class="notif-header">{{ __('messages.notifications') }}</div>
                        <div class="notif-list" id="notifList"></div>
                        <div class="notif-empty" id="notifEmpty">{{ __('messages.no_notifications') }}</div>
                        <div class="notif-footer" id="notifFooter" style="display:none;">
                            <button class="btn btn-sm btn-link" onclick="markAllNotifRead()">{{ __('messages.mark_all_read') }}</button>
                            <a href="{{ route('notifications.all') }}" class="btn btn-sm btn-outline-primary">{{ __('messages.view_all_notifications') }}</a>
                        </div>
                    </div>
                </li>
                @endif

                @auth('web')
                    <li class="nav-item ms-2"><a class="btnn" href="/student_dashboard">{{ __('messages.nav_dashboard') }}</a></li>
                    <li class="nav-item ms-2 d-flex align-items-center">
                        <form method="POST" action="{{ route('student.logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="btnn" style="color: #dc3545; border-color: #dc3545;">{{ __('messages.nav_logout') }}</button>
                        </form>
                    </li>
                @elseauth('instructor')
                    <li class="nav-item ms-2"><a class="btnn" href="/instructor_dashboard">{{ __('messages.nav_dashboard') }}</a></li>
                    <li class="nav-item ms-2 d-flex align-items-center">
                        <form method="POST" action="{{ route('instructor.logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="btnn" style="color: #dc3545; border-color: #dc3545;">{{ __('messages.nav_logout') }}</button>
                        </form>
                    </li>
                @elseauth('admin')
                    <li class="nav-item ms-2"><a class="btnn" href="/admin_dashboard">{{ __('messages.nav_dashboard') }}</a></li>
                    <li class="nav-item ms-2 d-flex align-items-center">
                        <form method="POST" action="{{ route('admin.logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" class="btnn" style="color: #dc3545; border-color: #dc3545;">{{ __('messages.nav_logout') }}</button>
                        </form>
                    </li>
                @else
                    <li class="nav-item dropdown ms-2 d-flex align-items-center">
                        <a class="btnn dropdown-toggle" href="javascript:void(0)" id="loginDropdown" role="button" data-bs-toggle="dropdown" data-academia-dropdown-toggle aria-expanded="false">
                            {{ __('messages.nav_login') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="loginDropdown">
                            <li><a class="dropdown-item" href="{{ route('student_login_page') }}">{{ __('messages.nav_as_student') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('instructor_login_page') }}">{{ __('messages.nav_as_instructor') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('admin.login_page') }}">{{ __('messages.nav_as_admin') }}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown ms-2 d-flex align-items-center">
                        <a class="btnn dropdown-toggle" href="javascript:void(0)" id="registerDropdown" role="button" data-bs-toggle="dropdown" data-academia-dropdown-toggle aria-expanded="false">
                            {{ __('messages.nav_register') }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="registerDropdown">
                            <li><a class="dropdown-item" href="{{ route('student_register_page') }}">{{ __('messages.nav_as_student') }}</a></li>
                            <li><a class="dropdown-item" href="{{ route('instructor_register_page') }}">{{ __('messages.nav_as_instructor') }}</a></li>
                        </ul>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>{{-- Include notification scripts --}}
<script src="{{ asset('main_pages_js/navbar.js') }}"></script>
@once
<script>
    document.addEventListener('click', function (event) {
        var toggle = event.target.closest('[data-academia-dropdown-toggle]');

        document.querySelectorAll('.academia-navbar .dropdown-menu.show').forEach(function (menu) {
            if (!toggle || !menu.parentElement.contains(toggle)) {
                menu.classList.remove('show');
                var button = menu.parentElement.querySelector('[data-academia-dropdown-toggle]');
                if (button) button.setAttribute('aria-expanded', 'false');
            }
        });

        if (!toggle) {
            return;
        }

        event.preventDefault();
        var parent = toggle.closest('.dropdown');
        var menu = parent ? parent.querySelector('.dropdown-menu') : null;
        if (!menu) {
            return;
        }

        var willOpen = !menu.classList.contains('show');
        menu.classList.toggle('show', willOpen);
        toggle.setAttribute('aria-expanded', willOpen ? 'true' : 'false');
    });
</script>
@endonce
