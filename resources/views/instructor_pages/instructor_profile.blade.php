@extends('layouts.main')

@section('title', __('messages.instructor_profile_heading'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('instructor_pages_style/instructor_profile.css') }}">
<style>
    body { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">{{ __('messages.instructor_profile_heading') }}</h2>
                <a href="{{ route('instructor.dashboard') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-right"></i> {{ __('messages.instructor_back_to_dashboard') }}</a>
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

            <div class="card card-modern p-4">
                <form method="POST" action="{{ route('instructor.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label class="form-label">{{ __('messages.instructor_name') }}</label>
                    <input type="text" name="name" class="form-control mb-3" value="{{ $instructor->name }}">

                    <label class="form-label">{{ __('messages.instructor_email') }}</label>
                    <input type="email" name="email" class="form-control mb-3" value="{{ $instructor->email }}">

                    <label class="form-label">{{ __('messages.instructor_job_title') }}</label>
                    <input type="text" name="job_title" class="form-control mb-3" value="{{ old('job_title', $instructor->job_title) }}" placeholder="{{ __('messages.instructor_job_placeholder') }}">

                    <label class="form-label">{{ __('messages.instructor_photo') }}</label>
                    @if($instructor->profile_photo)
                        <div class="mb-2">
                            <img src="{{ asset($instructor->profile_photo) }}" alt="{{ $instructor->name }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;">
                        </div>
                    @endif
                    <input type="file" name="profile_photo" class="form-control mb-3" accept="image/*">

                    <label class="form-label">{{ __('messages.instructor_new_password_opt') }}</label>
                    <input type="password" name="password" class="form-control mb-3" placeholder="{{ __('messages.instructor_password_leave') }}">

                    <label class="form-label">{{ __('messages.instructor_confirm_password') }}</label>
                    <input type="password" name="password_confirmation" class="form-control mb-3">

                    <button class="btn btn-primary w-100">{{ __('messages.instructor_save') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
