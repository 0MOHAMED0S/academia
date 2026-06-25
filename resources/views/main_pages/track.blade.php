@extends('layouts.main')

@section('title', __('messages.track_page_title', ['name' => $track->name]))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<style>
    main { padding-top: 0 !important; }
    @media (max-width: 768px) {
        .bg-white.rounded-4 { border-radius: 12px !important; padding: 18px !important; }
        h1.fw-bold { font-size: 1.3rem; }
        h3.h4 { font-size: 1.1rem; }
    }
    @media (max-width: 480px) {
        .bg-white.rounded-4 { padding: 14px !important; }
        h1.fw-bold { font-size: 1.1rem; }
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="mb-4">
        <a href="{{ url('/') }}" class="btn btn-outline-primary">{{ __('messages.track_back_home') }}</a>
    </div>
    <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
        <h1 class="fw-bold">{{ $track->name }}</h1>
        <p class="text-muted mb-0">{{ $track->description }}</p>
    </div>

    @forelse($track->courses as $course)
        <div class="bg-white rounded-4 shadow-sm p-4 mb-4">
            <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                <div>
                    <h3 class="h4 fw-bold">{{ $course->title }}</h3>
                    <p class="text-muted">{{ $course->description }}</p>
                    <span class="badge {{ $course->type === 'paid' ? 'bg-warning text-dark' : 'bg-success' }}">{{ $course->type === 'paid' ? __('messages.track_paid') : __('messages.track_free') }}</span>
                </div>
                <a href="{{ route('courses.show', $course) }}" class="btn btn-primary">{{ __('messages.track_open_course') }}</a>
            </div>

            @if($course->roadmap)
                <h5 class="fw-bold mt-4">{{ __('messages.track_roadmap') }}</h5>
                <ol class="list-group list-group-numbered mb-4">
                    @foreach(preg_split('/\r\n|\r|\n/', $course->roadmap) as $step)
                        @if(trim($step) !== '')
                            <li class="list-group-item">{{ $step }}</li>
                        @endif
                    @endforeach
                </ol>
            @endif

            <h5 class="fw-bold">{{ __('messages.track_videos') }}</h5>
            @if($course->lessons->isEmpty())
                <div class="alert alert-light border mb-0">{{ __('messages.track_no_videos') }}</div>
            @else
                <div class="list-group">
                    @foreach($course->lessons as $lesson)
                        <a href="{{ route('lessons.show', $lesson) }}" class="list-group-item list-group-item-action">
                            {{ $lesson->title }}
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    @empty
        <div class="alert alert-warning text-center">{{ __('messages.track_courses_empty') }}</div>
    @endforelse
</div>
@endsection
