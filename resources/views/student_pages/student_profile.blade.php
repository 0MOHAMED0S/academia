@extends('layouts.main')

@section('title', __('messages.student_profile_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('student_pages_2/student_profile.css') }}">
<style>
    body { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="profile-card">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold mb-0">{{ __('messages.student_profile_heading') }}</h2>
            <a href="{{ route('student.dashboard') }}" class="btn btn-outline-secondary">{{ __('messages.student_back_to_dashboard') }}</a>
        </div>

        @if(session('success_profile'))
            <div class="alert alert-success">{{ session('success_profile') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="text-center mb-4">
            @if($student->profile_photo)
                <img src="{{ asset($student->profile_photo) }}" class="avatar" alt="{{ $student->name }}">
            @else
                <div class="avatar">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
            @endif
        </div>

        <form method="POST" action="{{ route('student.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <label class="form-label">{{ __('messages.student_name') }}</label>
            <input type="text" name="name" class="form-control mb-3" value="{{ old('name', $student->name) }}" required>

            <label class="form-label">{{ __('messages.student_email') }}</label>
            <input type="email" name="email" class="form-control mb-3" value="{{ old('email', $student->email) }}" required>

            <label class="form-label">{{ __('messages.student_photo') }}</label>
            <input type="file" name="profile_photo" class="form-control mb-3" accept="image/*">

            <label class="form-label">{{ __('messages.student_new_password') }}</label>
            <input type="password" name="password" class="form-control mb-3" placeholder="{{ __('messages.student_leave_blank') }}">

            <label class="form-label">{{ __('messages.student_confirm_password') }}</label>
            <input type="password" name="password_confirmation" class="form-control mb-4">

            <button class="btn btn-primary w-100">{{ __('messages.student_save_changes') }}</button>
        </form>
    </div>
</div>
@endsection
