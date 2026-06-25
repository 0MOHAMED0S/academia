@extends('layouts.main')

@section('title', __('messages.instructor_login_title'))

@section('styles')
<style>
    body {
        background: linear-gradient(135deg, #0f2b4f 0%, #1a3f6e 100%);
        min-height: 100vh;
    }
    main { padding-top: 0 !important; }
    footer.academia-footer { display: none !important; }
    .academia-navbar { border-bottom: none !important; }

    .auth-wrapper {
        min-height: 100vh;
        padding: 120px 1.5rem 3rem;
        display: flex;
        justify-content: center;
    }

    .auth-card {
        background: #fff;
        width: 100%;
        max-width: 480px;
        padding: 2.5rem 2rem;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.15);
        align-self: flex-start;
        animation: fadeSlideUp 0.6s ease-out;
    }

    @keyframes fadeSlideUp {
        0% { opacity: 0; transform: translateY(35px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    .back-link {
        margin-bottom: 1.5rem;
    }

    .back-link a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: transparent;
        border: 1.5px solid #1e3c72;
        color: #1e3c72;
        font-weight: 700;
        font-size: 0.85rem;
        padding: 0.5rem 1.2rem;
        border-radius: 2.5rem;
        text-decoration: none;
        transition: all 0.25s;
    }

    .back-link a:hover {
        background: #1e3c72;
        color: #fff;
    }

    .auth-card h2 {
        text-align: center;
        font-weight: 800;
        font-size: 1.8rem;
        margin-bottom: 2rem;
        color: #1e3c72;
    }

    .form-group {
        margin-bottom: 1.2rem;
    }

    .form-group label {
        display: block;
        font-weight: 700;
        font-size: 0.9rem;
        color: #1e2a3e;
        margin-bottom: 0.4rem;
    }

    .form-group label .required {
        color: #dc3545;
    }

    .form-group input {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        font-size: 0.95rem;
        background: #fefefe;
        transition: all 0.25s ease;
        outline: none;
        color: #1e2a3e;
    }

    .form-group input:focus {
        border-color: #1e3c72;
        box-shadow: 0 0 0 4px rgba(30, 60, 114, 0.15);
        background: #fff;
    }

    .form-group input::placeholder {
        color: #a0b4c8;
        font-size: 0.85rem;
    }

    .helper {
        font-size: 0.7rem;
        color: #6c7f94;
        margin-top: 0.3rem;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    .error-text {
        color: #dc3545;
        font-size: 0.8rem;
        margin-top: 0.3rem;
    }

    .alert-success-box {
        background: #d4edda;
        color: #155724;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 1rem;
        text-align: center;
        font-weight: 500;
    }

    .alert-error-box {
        background: #f8d7da;
        color: #721c24;
        padding: 12px 16px;
        border-radius: 12px;
        margin-bottom: 1rem;
    }

    .alert-error-box div {
        margin-bottom: 0.25rem;
    }

    .alert-error-box div:last-child {
        margin-bottom: 0;
    }

    .btn-submit {
        width: 100%;
        padding: 14px;
        background: linear-gradient(95deg, #1e3c72, #2a5298);
        color: #fff;
        border: none;
        border-radius: 14px;
        font-weight: 700;
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.25s ease;
        margin-top: 0.5rem;
        box-shadow: 0 8px 18px rgba(30, 60, 114, 0.3);
    }

    .btn-submit:hover {
        background: linear-gradient(95deg, #153157, #1f4270);
        transform: translateY(-2px);
        box-shadow: 0 14px 26px rgba(30, 60, 114, 0.4);
    }

    .auth-divider {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin: 1.25rem 0 1rem;
    }

    .auth-divider__line {
        flex: 1;
        height: 1px;
        background: linear-gradient(90deg, transparent, #d0dae6, transparent);
    }

    .auth-divider__text {
        font-size: 0.8rem;
        font-weight: 600;
        color: #6c7f94;
        white-space: nowrap;
    }

    .google-login-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.65rem;
        width: 100%;
        padding: 13px 18px;
        background: #fff;
        color: #1e2a3e;
        border: 1.5px solid #e2e8f0;
        border-radius: 14px;
        font-weight: 700;
        font-size: 0.95rem;
        text-decoration: none;
        cursor: pointer;
        transition: all 0.25s ease;
        box-shadow: 0 4px 14px rgba(30, 60, 114, 0.08);
    }

    .google-login-btn:hover {
        border-color: #1e3c72;
        background: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 10px 22px rgba(30, 60, 114, 0.15);
    }

    .form-footer {
        margin-top: 1.8rem;
        text-align: center;
        font-size: 0.85rem;
        color: #4a5b6e;
        border-top: 1px solid #edf2f7;
        padding-top: 1.2rem;
    }

    .form-footer a {
        color: #1e3c72;
        text-decoration: none;
        font-weight: 700;
    }

    .form-footer a:hover {
        text-decoration: underline;
    }

    @media (max-width: 520px) {
        .auth-wrapper { padding: 110px 1rem 2rem; }
        .auth-card { padding: 1.5rem 1.2rem; }
        .auth-card h2 { font-size: 1.5rem; }
    }
</style>
@endsection

@section('content')
<div class="auth-wrapper">
    <div class="auth-card">

        <div class="back-link">
            <a href="{{ url('/') }}">
                <i class="fas fa-arrow-{{ $currentDir === 'rtl' ? 'right' : 'left' }}"></i>
                {{ __('messages.back_to_home') }}
            </a>
        </div>

        <h2>{{ __('messages.instructor_login_heading') }}</h2>

        @if(session('success_login'))
            <div class="alert-success-box">{{ session('success_login') }}</div>
        @endif
        @if(session('success_logout'))
            <div class="alert-success-box">{{ session('success_logout') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error-box">{{ session('error') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error-box">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('instructor.login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label>{{ __('messages.email_label') }} <span class="required">*</span></label>
                <input type="email" name="email" placeholder="{{ __('messages.email_ph') }}" required value="{{ old('email') }}">
                @error('email')<div class="error-text">{{ $message }}</div>@enderror
                <div class="helper"><i class="fas fa-envelope"></i> {{ __('messages.email_instructor_helper') }}</div>
            </div>

            <div class="form-group">
                <label>{{ __('messages.password_label') }} <span class="required">*</span></label>
                <input type="password" name="password" placeholder="{{ __('messages.password_ph') }}" required>
                @error('password')<div class="error-text">{{ $message }}</div>@enderror
                <div class="helper"><i class="fas fa-lock"></i> {{ __('messages.password_instructor_helper') }}</div>
            </div>

            <button type="submit" class="btn-submit">{{ __('messages.btn_instructor_login') }}</button>

            <div class="auth-divider" aria-hidden="true">
                <span class="auth-divider__line"></span>
                <span class="auth-divider__text">{{ __('messages.or') }}</span>
                <span class="auth-divider__line"></span>
            </div>

            <a href="{{ route('instructor.google.redirect') }}" class="google-login-btn" aria-label="{{ __('messages.google_instructor_login') }}">
                <span class="google-login-btn__icon" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22">
                        <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303c-1.649 4.657-6.08 8-11.303 8-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.955 4 4 12.955 4 24s8.955 20 20 20 20-8.955 20-20c0-1.341-.138-2.65-.389-3.917z"/>
                        <path fill="#FF3D00" d="m6.306 14.691 6.571 4.819C14.655 15.108 18.961 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 16.318 4 9.656 8.337 6.306 14.691z"/>
                        <path fill="#4CAF50" d="M24 44c5.166 0 9.86-1.977 13.409-5.192l-6.19-5.238A11.91 11.91 0 0 1 24 36c-5.202 0-9.619-3.317-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                        <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303a12.04 12.04 0 0 1-4.087 5.571l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.65-.389-3.917z"/>
                    </svg>
                </span>
                <span class="google-login-btn__text">{{ __('messages.google_instructor_login') }}</span>
            </a>

            <div class="form-footer">
                <p>
                    {{ __('messages.no_instructor_account') }}
                    <a href="{{ route('instructor_register_page') }}">{{ __('messages.create_instructor_account') }}</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection
