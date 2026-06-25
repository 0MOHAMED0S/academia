@extends('layouts.main')

@section('title', __('messages.course_edit_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('instructor_pages_style/instructor_courses.css') }}">
<style>
    body { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">{{ __('messages.course_edit_heading') }}</h2>
                <a href="{{ route('instructor.dashboard') }}" class="btn btn-outline-secondary"><i class="fa-solid fa-arrow-right"></i> {{ __('messages.course_edit_back') }}</a>
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

            <div class="card card-modern p-4">
                <form method="POST" action="{{ route('instructor.course.update', $course) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label class="form-label">{{ __('messages.course_edit_title_label') }}</label>
                    <input type="text" name="title" class="form-control mb-3" value="{{ old('title', $course->title) }}" required>

                    <div class="mb-3">
                        <label class="form-label">{{ __('messages.course_edit_image_label') }}</label>
                        @if($course->image_path)
                            <div class="mb-2">
                                <img src="{{ asset($course->image_path) }}" alt="{{ $course->title }}" style="width: 150px; height: 100px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;">
                                <p class="small text-muted mb-0">{{ __('messages.course_edit_current_image') }}</p>
                            </div>
                        @endif
                        <input type="file" name="course_photo" class="form-control" accept="image/*">
                    </div>

                    <label class="form-label">{{ __('messages.course_edit_desc_label') }}</label>
                    <textarea name="description" class="form-control mb-3" rows="5">{{ old('description', $course->description) }}</textarea>

                    <label class="form-label">{{ __('messages.course_edit_track_label') }}</label>
                    <select name="track_id" class="form-select mb-3">
                        <option value="">{{ __('messages.instructor_no_track') }}</option>
                        @foreach($tracks as $track)
                            <option value="{{ $track->id }}" @selected(old('track_id', $course->track_id) == $track->id)>{{ $track->name }}</option>
                        @endforeach
                    </select>

                    <label class="form-label">{{ __('messages.course_edit_type_label') }}</label>
                    <select name="type" id="course_type" class="form-select mb-3" required onchange="toggleUniqueId(this.value)">
                        <option value="free" @selected(old('type', $course->type) === 'free')>{{ __('messages.instructor_free') }}</option>
                        <option value="paid" @selected(old('type', $course->type) === 'paid')>{{ __('messages.instructor_paid') }}</option>
                    </select>

                    <div id="unique_id_wrapper" style="{{ old('type', $course->type) === 'paid' ? 'display: block;' : 'display: none;' }}">
                        <label class="form-label">{{ __('messages.course_edit_unique_id_label') }}</label>
                        <input type="text" name="unique_course_id" class="form-control mb-3" value="{{ old('unique_course_id', $course->unique_course_id) }}" {{ old('type', $course->type) === 'paid' ? 'required' : '' }}>
                    </div>

                    <label class="form-label">{{ __('messages.course_edit_roadmap_label') }}</label>
                    <textarea name="roadmap" class="form-control mb-3" rows="5" placeholder="{{ __('messages.course_edit_roadmap_hint') }}">{{ old('roadmap', $course->roadmap) }}</textarea>

                    <button class="btn btn-primary w-100">{{ __('messages.course_edit_save_btn') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleUniqueId(type) {
        const wrapper = document.getElementById('unique_id_wrapper');
        const input = wrapper.querySelector('input');
        if (type === 'paid') {
            wrapper.style.display = 'block';
            input.setAttribute('required', 'required');
        } else {
            wrapper.style.display = 'none';
            input.removeAttribute('required');
        }
    }
</script>
@endsection
