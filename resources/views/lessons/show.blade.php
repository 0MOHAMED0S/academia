@extends('layouts.main')

@section('title', __('messages.lesson_page_title', ['title' => $lesson->title]))

@section('styles')
<link rel="stylesheet" href="{{ asset('instructor_pages_style/lessons.css') }}">
<style>
    main { padding-top: 0 !important; }
    .lesson-option-label:hover {
        background-color: #f0f4ff;
        border-color: #1f2c9c !important;
    }
    .form-check-input:checked + .lesson-option-label {
        background-color: #eef2ff;
        border-color: #1f2c9c !important;
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-4 d-flex justify-content-between align-items-center">
        <a href="{{ route('courses.show', $lesson->course) }}" class="btn btn-outline-primary btn-back">
            <i class="fa-solid fa-arrow-right me-2"></i> {{ __('messages.lesson_back_to_course') }}
        </a>
    </div>

    <div class="video-container-card">

        <h1 class="lesson-title h2"><i class="fa-solid fa-play-circle text-danger me-2"></i> {{ $lesson->title }}</h1>
        <hr class="mb-4 text-muted">

        <div class="video-player-wrapper">
            @if(\Illuminate\Support\Str::startsWith($lesson->video_path, ['http://', 'https://']))
                <div class="ratio ratio-16x9">
                    @php
                        $videoUrl = $lesson->video_path;
                        if (str_contains($videoUrl, 'youtube.com/watch?v=')) {
                            $videoUrl = str_replace('watch?v=', 'embed/', $videoUrl);
                        } elseif (str_contains($videoUrl, 'youtu.be/')) {
                            $videoUrl = str_replace('youtu.be/', 'youtube.com/embed/', $videoUrl);
                        }
                        if (str_contains($videoUrl, '&')) {
                            $videoUrl = explode('&', $videoUrl)[0];
                        }
                    @endphp
                    <iframe src="{{ $videoUrl }}" allowfullscreen class="border-0"></iframe>
                </div>
            @else
                <video controls class="w-100" preload="metadata" style="max-height: 600px;">
                    <source src="{{ asset($lesson->video_path) }}" type="video/mp4">
                    {{ __('messages.lesson_video_not_supported') }}
                </video>
            @endif
        </div>

        <p class="lesson-desc mb-5">{{ $lesson->description }}</p>

        <div class="instructor-info mt-4">
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; font-size: 24px;">
                <i class="fa-solid fa-chalkboard-user"></i>
            </div>
            <div>
                <h5 class="mb-1 fw-bold">{{ __('messages.lesson_course', ['name' => $lesson->course->title]) }}</h5>
                <p class="mb-0 text-muted">{{ __('messages.lesson_instructor', ['name' => $lesson->course->instructor->name]) }}</p>
            </div>
        </div>

        @if($lesson->questions->count())
            <div class="mt-5 p-4 bg-light rounded-4 border">
                <h4 class="fw-bold mb-3"><i class="fa-solid fa-question-circle text-primary me-2"></i> {{ __('messages.lesson_quiz_title') }}</h4>

                @auth('web')
                    @if($attempt)
                        <div class="alert {{ $attempt->passed ? 'alert-success' : 'alert-warning' }} border-0 shadow-sm">
                            <i class="fa-solid {{ $attempt->passed ? 'fa-circle-check' : 'fa-circle-exclamation' }} me-2"></i>
                            {{ __('messages.lesson_your_result', ['score' => $attempt->score, 'total' => $attempt->total, 'passed' => $attempt->passed ? __('messages.lesson_passed') : __('messages.lesson_failed')]) }}
                        </div>
                    @endif
                    <form method="POST" action="{{ route('lessons.quiz.submit', $lesson) }}">
                        @csrf
                        @foreach($lesson->questions as $question)
                            <div class="mb-4 p-3 bg-white rounded-3 border shadow-sm">
                                <h6 class="fw-bold mb-3">{{ $loop->iteration }}. {{ $question->question }}</h6>
                                <div class="row g-2">
                                    @foreach(['a' => $question->option_a, 'b' => $question->option_b, 'c' => $question->option_c, 'd' => $question->option_d] as $key => $option)
                                        <div class="col-md-6">
                                            <label class="d-block border rounded-3 p-3 mb-0 lesson-option-label" style="cursor: pointer;">
                                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $key }}" class="form-check-input me-2" required>
                                                <strong>{{ strtoupper($key) }}:</strong> {{ $option }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center mt-4">
                            <button class="btn btn-primary btn-lg px-5 shadow-sm rounded-pill">{{ __('messages.lesson_submit_answers') }} <i class="fa-solid fa-paper-plane ms-2"></i></button>
                        </div>
                    </form>
                @else
                    <div class="alert alert-info border-0 shadow-sm mb-4">
                        <i class="fa-solid fa-eye me-2"></i> {{ __('messages.lesson_preview_only') }}
                    </div>
                    @foreach($lesson->questions as $question)
                        <div class="mb-4 p-3 bg-white rounded-3 border shadow-sm opacity-75">
                            <h6 class="fw-bold mb-3">{{ $loop->iteration }}. {{ $question->question }}</h6>
                            <div class="row g-2">
                                @foreach(['a' => $question->option_a, 'b' => $question->option_b, 'c' => $question->option_c, 'd' => $question->option_d] as $key => $option)
                                    <div class="col-md-6">
                                        <div class="d-block border rounded-3 p-3 mb-0 {{ $question->correct_option === $key ? 'bg-success text-white border-success' : 'bg-light' }}">
                                            <strong>{{ strtoupper($key) }}:</strong> {{ $option }}
                                            @if($question->correct_option === $key)
                                                <i class="fa-solid fa-check-circle float-end"></i>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endauth
            </div>
        @endif

    </div>
</div>
@endsection
