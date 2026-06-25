@extends('layouts.main')

@section('title', __('messages.admin_add_student_id_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<style>
    main { padding-top: 0 !important; }
    .panel { background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 12px 35px rgba(0,0,0,.06); border: 1px solid #edf2f7; max-width: 600px; margin: auto; margin-top: 2rem; }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="panel mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-id-card me-2"></i>{{ __('messages.admin_add_student_id_heading') }}</h3>
            <a href="{{ route('admin.subscribed_students') }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-arrow-right"></i> {{ __('messages.admin_back_btn') }}</a>
        </div>

        <form method="POST" action="{{ route('admin.store.student_id') }}">
            @csrf
            <input type="hidden" name="course_id" value="{{ $course->id }}">
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.admin_sub_student_name') }}</label>
                <input type="text" class="form-control bg-light" value="{{ $user->name }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.admin_sub_course_name') }}</label>
                <input type="text" class="form-control bg-light" value="{{ $course->title }}" readonly>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.admin_edit_course_code_label') }}</label>
                <input type="text" class="form-control bg-light" value="{{ $course->unique_course_id }}" readonly>
            </div>

            <div class="mb-4">
                <label class="form-label fw-bold">{{ __('messages.admin_add_student_id_input_label') }} <span class="text-danger">*</span></label>
                <input type="text" name="student_id" class="form-control @error('student_id') is-invalid @enderror" required placeholder="{{ __('messages.admin_add_student_id_placeholder') }}">
                @error('student_id')
                    <span class="invalid-feedback">{{ $message }}</span>
                @enderror
                <div class="form-text text-muted mt-2"><i class="fa-solid fa-circle-info me-1"></i>{{ __('messages.admin_add_student_id_hint') }}</div>
            </div>

            <button type="submit" class="btn btn-success w-100 fw-bold py-2"><i class="fa-solid fa-paper-plane me-2"></i>{{ __('messages.admin_add_student_id_submit') }}</button>
        </form>
    </div>
</div>
@endsection
