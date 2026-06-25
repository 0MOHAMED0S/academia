@extends('layouts.main')

@section('title', __('messages.admin_profile_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('admin_pages_style/admin_profile.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="profile-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">{{ __('messages.admin_profile_heading') }}</h2>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">{{ __('messages.admin_back_to_dashboard') }}</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="text-center mb-4">
            @if($admin->profile_photo)
                <img src="{{ asset($admin->profile_photo) }}" class="avatar" alt="{{ $admin->name }}">
            @else
                <div class="avatar">{{ strtoupper(substr($admin->name, 0, 1)) }}</div>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label class="form-label">{{ __('messages.admin_profile_name') }}</label>
            <input type="text" name="name" class="form-control mb-3" value="{{ old('name', $admin->name) }}" required>

            <label class="form-label">{{ __('messages.admin_profile_email') }}</label>
            <input type="email" name="email" class="form-control mb-3" value="{{ old('email', $admin->email) }}" required>

            <label class="form-label">{{ __('messages.admin_profile_photo') }}</label>
            <input type="file" name="profile_photo" class="form-control mb-3" accept="image/*">

            <label class="form-label">{{ __('messages.admin_profile_password') }}</label>
            <input type="password" name="password" class="form-control mb-3" placeholder="{{ __('messages.admin_profile_leave_blank') }}">

            <label class="form-label">{{ __('messages.admin_profile_confirm') }}</label>
            <input type="password" name="password_confirmation" class="form-control mb-4">

            <button class="btn btn-primary w-100">{{ __('messages.admin_profile_save') }}</button>
        </form>
    </div>
</div>
@endsection
