@extends('layouts.main')

@section('title', __('messages.admin_login_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('admin_pages_style/admin_login.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<div class="container">
    <div class="login-card">
        <div class="admin-icon"><i class="fa-solid fa-user-shield"></i></div>
        <h2 class="text-center fw-bold mb-2">{{ __('messages.admin_login_heading') }}</h2>
        <p class="text-center text-muted mb-4">{{ __('messages.admin_login_subtitle') }}</p>

        @if(session('success_logout'))
            <div class="alert alert-success">{{ session('success_logout') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <label class="form-label">{{ __('messages.email_label_admin') }}</label>
            <input type="email" name="email" class="form-control mb-3" value="{{ old('email') }}" required autofocus>

            <label class="form-label">{{ __('messages.password_label_admin') }}</label>
            <input type="password" name="password" class="form-control mb-3" required>

            <label class="d-flex align-items-center gap-2 mb-4">
                <input type="checkbox" name="remember" value="1">
                <span>{{ __('messages.remember_me') }}</span>
            </label>

            <button class="btn btn-primary w-100 py-2 fw-bold">{{ __('messages.btn_admin_login') }}</button>
        </form>
    </div>
</div>
@endsection
