@extends('layouts.main')

@section('title', __('messages.free_courses_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('main_pages_style/freecourse.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="page-header text-center">
    <div class="container">
        <h1 class="fw-bold mb-3 display-4"><i class="fas fa-gift me-2"></i> {{ __('messages.free_courses_hero') }}</h1>
        <p class="lead mb-0 opacity-75">{{ __('messages.free_courses_hero_desc') }}</p>
    </div>
</section>

<div class="container mb-5">
    <div class="search-container">
        <form action="{{ route('freecourse') }}" method="GET">
            <input type="text" name="query" class="form-control search-input" placeholder="{{ __('messages.free_courses_search') }}" value="{{ request('query') }}">
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>

    @if(request('query'))
        <div class="text-center mb-4">
            <span class="badge bg-white text-dark shadow-sm px-3 py-2 rounded-pill">
                {{ __('messages.free_courses_results_for') }} <strong class="text-primary">{{ request('query') }}</strong>
                <a href="{{ route('freecourse') }}" class="text-danger ms-2 text-decoration-none"><i class="fas fa-times-circle"></i></a>
            </span>
        </div>
    @endif

    @if(isset($courses) && $courses->count() > 0)
        <div class="row g-4">
            @foreach($courses as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="course-card">
                        <div class="course-image-container" style="overflow: hidden;">
                            <span class="free-badge">{{ __('messages.free_courses_badge') }}</span>
                            @if($course->image_path)
                                <img src="{{ asset($course->image_path) }}" alt="{{ $course->title }}" class="course-card-img" style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <i class="fa-solid fa-laptop-code fa-5x opacity-25"></i>
                            @endif
                        </div>
                        <div class="course-body">
                            <h5 class="course-title">{{ $course->title }}</h5>
                            <p class="course-desc">{{ Str::limit($course->description, 100) }}</p>
                            
                            <div class="instructor-info">
                                <div class="instructor-avatar">
                                    @if($course->instructor->profile_photo)
                                        <img src="{{ asset($course->instructor->profile_photo) }}" alt="{{ $course->instructor->name }}">
                                    @else
                                        <i class="fas fa-user-tie"></i>
                                    @endif
                                </div>
                                <span class="small fw-bold text-secondary">{{ $course->instructor->name }}</span>
                                <span class="ms-auto small text-muted"><i class="fas fa-video me-1"></i> {{ __('messages.free_courses_lessons', ['count' => $course->lessons->count()]) }}</span>
                            </div>
                            
                            <a href="{{ route('courses.show', $course) }}" class="btn-start">{{ __('messages.free_courses_start') }} <i class="fas fa-arrow-left ms-2"></i></a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="fas fa-search fa-5x text-muted opacity-25"></i>
            </div>
            <h4 class="text-muted fw-bold">{{ __('messages.free_courses_no_results') }}</h4>
            <p class="text-muted">{{ __('messages.free_courses_no_hint') }}</p>
            <a href="{{ route('freecourse') }}" class="btn btn-primary px-4 mt-3 rounded-pill">{{ __('messages.free_courses_view_all') }}</a>
        </div>
    @endif
</div>
@endsection
