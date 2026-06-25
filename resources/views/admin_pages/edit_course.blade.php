@extends('layouts.main')

@section('title', __('messages.admin_edit_course_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<style>
    main { padding-top: 0 !important; }
    .panel { background: #fff; border-radius: 16px; padding: 32px; box-shadow: 0 12px 35px rgba(0,0,0,.06); border: 1px solid #edf2f7; max-width: 800px; margin: auto; margin-top: 2rem; }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="panel mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold mb-0 text-primary"><i class="fa-solid fa-pen me-2"></i>{{ __('messages.admin_edit_course_heading') }}</h3>
            <a href="{{ route('admin.subscribed_students') }}" class="btn btn-sm btn-outline-secondary"><i class="fa-solid fa-arrow-right"></i> {{ __('messages.admin_back_btn') }}</a>
        </div>

        <form method="POST" action="{{ route('admin.update.subscribed_course', $course) }}">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.admin_course_name') }} <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" value="{{ old('title', $course->title) }}" required>
                @error('title') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.admin_course_desc') }}</label>
                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="4">{{ old('description', $course->description) }}</textarea>
                @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">{{ __('messages.admin_edit_course_code_label') }} <span class="text-danger">*</span></label>
                <input type="text" name="unique_course_id" class="form-control @error('unique_course_id') is-invalid @enderror" value="{{ old('unique_course_id', $course->unique_course_id) }}" required>
                @error('unique_course_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label class="form-label fw-bold">{{ __('messages.admin_edit_course_type_label') }} <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                        <option value="free" {{ old('type', $course->type) == 'free' ? 'selected' : '' }}>{{ __('messages.admin_free') }}</option>
                        <option value="paid" {{ old('type', $course->type) == 'paid' ? 'selected' : '' }}>{{ __('messages.admin_paid') }}</option>
                    </select>
                    @error('type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold">{{ __('messages.instructor_course_track') }}</label>
                    <select name="track_id" class="form-select @error('track_id') is-invalid @enderror">
                        <option value="">{{ __('messages.instructor_no_track') }}</option>
                        @foreach($tracks as $track)
                            <option value="{{ $track->id }}" {{ old('track_id', $course->track_id) == $track->id ? 'selected' : '' }}>{{ $track->name }}</option>
                        @endforeach
                    </select>
                    @error('track_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 fw-bold py-2"><i class="fa-solid fa-save me-2"></i>{{ __('messages.course_edit_save_btn') }}</button>
        </form>
    </div>
</div>
@endsection
