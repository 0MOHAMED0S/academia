@extends('layouts.main')

@section('title', __('messages.instructor_register_title'))

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

        <h2>{{ __('messages.instructor_register_heading') }}</h2>

        @if(session('success_register'))
            <div class="alert-success-box">{{ session('success_register') }}</div>
        @endif

        @if($errors->any())
            <div class="alert-error-box">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('instructor.register') }}">
            @csrf

            <div class="form-group">
                <label>{{ __('messages.full_name') }} <span class="required">*</span></label>
                <input type="text" name="name" placeholder="{{ __('messages.instructor_name_ph') }}" value="{{ old('name') }}" required>
                @error('name')<div class="error-text">{{ $message }}</div>@enderror
                <div class="helper"><i class="fas fa-user"></i> {{ __('messages.instructor_name_helper') }}</div>
            </div>

            <div class="form-group">
                <label>{{ __('messages.email_label') }} <span class="required">*</span></label>
                <input type="email" name="email" placeholder="{{ __('messages.email_ph') }}" value="{{ old('email') }}" required>
                @error('email')<div class="error-text">{{ $message }}</div>@enderror
                <div class="helper"><i class="fas fa-envelope"></i> {{ __('messages.instructor_email_helper') }}</div>
            </div>

            <div class="form-group">
                <label>{{ __('messages.instructor_job_title') }}</label>
                <input type="text" name="job_title" placeholder="{{ __('messages.instructor_job_ph') }}" value="{{ old('job_title') }}">
                <div class="helper"><i class="fas fa-briefcase"></i> {{ __('messages.instructor_job_helper') }}</div>
            </div>

            <div class="form-group">
                <label>{{ __('messages.password_label') }} <span class="required">*</span></label>
                <input type="password" name="password" placeholder="{{ __('messages.password_ph') }}" required>
                @error('password')<div class="error-text">{{ $message }}</div>@enderror
                <div class="helper"><i class="fas fa-lock"></i> {{ __('messages.instructor_password_helper') }}</div>
            </div>

            <div class="form-group">
                <label>{{ __('messages.password_confirm') }} <span class="required">*</span></label>
                <input type="password" name="password_confirmation" placeholder="{{ __('messages.password_confirm_ph') }}" required>
                <div class="helper"><i class="fas fa-check-circle"></i> {{ __('messages.password_confirm_helper') }}</div>
            </div>

            <button type="submit" class="btn-submit">{{ __('messages.btn_create_instructor') }}</button>

            <div class="form-footer">
                <p>
                    {{ __('messages.already_instructor') }}
                    <a href="{{ route('instructor_login_page') }}">{{ __('messages.instructor_login_link') }}</a>
                </p>
            </div>

        </form>
    </div>
</div>
@endsection
