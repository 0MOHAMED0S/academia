@extends('layouts.main')

@section('title', __('messages.course_show_title', ['title' => $course->title]))

@section('styles')
<link rel="stylesheet" href="{{ asset('courses_pages/show.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('footer')
@endsection

@section('content')
<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
            <i class="fa-solid fa-circle-xmark me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ url('/') }}" class="btn btn-outline-primary"><i class="fa-solid fa-arrow-right"></i> {{ __('messages.course_back_home') }}</a>
        </div>
    </div>

    <div class="course-header mb-4">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h1 class="mb-2 fw-bold text-dark">{{ $course->title }}</h1>
                <span class="badge {{ $course->type === 'paid' ? 'bg-warning text-dark' : 'bg-success' }} mb-3 p-2">
                    {{ $course->type === 'paid' ? __('messages.course_paid') : __('messages.course_free') }}
                </span>
            </div>
        </div>

        <p class="text-muted fs-5 mb-3">{{ $course->description }}</p>

        <div class="d-flex gap-4 small text-secondary mb-4">
            <span><i class="fa-solid fa-chalkboard-user text-primary me-1"></i> {{ __('messages.course_instructor', ['name' => $course->instructor->name]) }}</span>
            @if($course->track)
                <span><i class="fa-solid fa-layer-group text-primary me-1"></i> {{ __('messages.course_track', ['name' => $course->track->name]) }}</span>
            @endif
        </div>

        @if($course->isPaid() && ! $hasAccess)
            <div class="alert alert-info border-0 shadow-sm p-4 text-center mb-4">
                <p class="fw-bold fs-5 mb-3"><i class="fa-solid fa-circle-info me-2"></i> {{ __('messages.course_payment_notice') }}</p>
                @auth('web')
                    <button type="button" class="btn btn-primary btn-lg px-5 shadow" data-bs-toggle="modal" data-bs-target="#paymentModal">
                        <i class="fa-solid fa-credit-card me-2"></i> {{ __('messages.course_payment_button') }}
                    </button>
                @else
                    <a href="{{ route('student_login_page') }}" class="btn btn-primary btn-lg px-5 shadow">{{ __('messages.course_login_to_pay') }}</a>
                @endauth
            </div>
        @endif

        @if($progress)
            <div class="mt-4 p-3 bg-light rounded-3 border">
                <div class="d-flex justify-content-between small fw-bold mb-2">
                    <span>{{ __('messages.course_progress') }}</span>
                    <span class="text-primary">{{ $progress['percent'] }}%</span>
                </div>
                <div class="progress" style="height: 14px; border-radius: 7px;">
                    <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" style="width: {{ $progress['percent'] }}%"></div>
                </div>
            </div>
        @elseif(Auth::guard('web')->check())
             <div class="mt-4 p-3 bg-light rounded-3 border">
                <div class="d-flex justify-content-between small fw-bold mb-2">
                    <span>{{ __('messages.course_progress_label') }}</span>
                    <span class="text-muted">0%</span>
                </div>
                <div class="progress" style="height: 14px; border-radius: 7px;">
                    <div class="progress-bar bg-secondary" style="width: 0%"></div>
                </div>
            </div>
        @endif

        @auth('web')
            <div class="d-flex gap-2 mt-4">
                <form method="POST" action="{{ route('courses.save', $course) }}">
                    @csrf
                    <button type="submit" class="btn {{ $saved ? 'btn-success' : 'btn-outline-primary' }}" @if($saved) disabled @endif>
                        <i class="fa-solid fa-{{ $saved ? 'check-double' : 'bookmark' }} me-1"></i>
                        {{ $saved ? __('messages.course_saved') : __('messages.course_save') }}
                    </button>
                </form>
                @if($saved && optional(Auth::user()->savedCourses()->where('course_id', $course->id)->first())->pivot?->completed_at)
                    <a href="{{ route('courses.certificate', $course) }}" target="_blank" class="btn btn-warning">
                        <i class="fa-solid fa-certificate me-1"></i> {{ __('messages.course_download_certificate') }}
                    </a>
                @endif
            </div>
        @endauth
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h3 class="h5 mb-4 fw-bold text-dark"><i class="fa-solid fa-list-ul text-primary me-2"></i> {{ __('messages.course_content') }}</h3>
                    @if($course->lessons->isEmpty())
                        <div class="alert alert-warning border-0">{{ __('messages.course_no_videos') }}</div>
                    @else
                        <div class="list-group list-group-flush">
                            @foreach($course->lessons as $lesson)
                                @if($hasAccess || (Auth::guard('instructor')->check() && Auth::guard('instructor')->id() === $course->instructor_id))
                                    <div class="list-group-item border-0 mb-2 lesson-card p-3 bg-light" style="border-radius: 12px;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1 fw-bold">{{ $lesson->title }}</h6>
                                                <p class="mb-0 text-muted small">{{ \Illuminate\Support\Str::limit($lesson->description, 150) }}</p>
                                            </div>
                                            <div class="d-flex gap-2 flex-shrink-0">
                                                <a href="{{ route('lessons.show', $lesson) }}" class="btn btn-sm btn-primary px-3 rounded-pill">{{ __('messages.course_watch') }} <i class="fa-solid fa-play ms-1" style="font-size: 10px;"></i></a>
                                                @if(Auth::guard('instructor')->check() && Auth::guard('instructor')->id() === $course->instructor_id)
                                                    <a href="{{ route('instructor.lesson.edit', $lesson) }}" class="btn btn-sm btn-warning px-3 rounded-pill">{{ __('messages.course_edit') }} <i class="fa-solid fa-pen-to-square ms-1" style="font-size: 10px;"></i></a>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="list-group-item border-0 mb-2 p-3 bg-white opacity-75 border" style="border-radius: 12px;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <h6 class="mb-1 fw-bold text-secondary">{{ $lesson->title }}</h6>
                                                <p class="mb-0 text-muted small">{{ \Illuminate\Support\Str::limit($lesson->description, 150) }}</p>
                                            </div>
                                            <span class="badge bg-secondary p-2 rounded-pill"><i class="fa-solid fa-lock me-1"></i> {{ __('messages.course_locked') }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @if($course->roadmap)
                <div class="card shadow-sm border-0 sticky-top" style="border-radius: 16px; top: 120px;">
                    <div class="card-body p-4">
                        <h3 class="h5 mb-3 fw-bold text-dark"><i class="fa-solid fa-route text-primary me-2"></i> {{ __('messages.course_roadmap') }}</h3>
                        <div class="roadmap-timeline">
                            @php
                                $steps = array_filter(explode("\n", $course->roadmap));
                            @endphp
                            @foreach($steps as $step)
                                <div class="roadmap-step">
                                    <span class="roadmap-step-title">{{ $step }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@auth('web')
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <form method="POST" action="{{ route('courses.payment.verify', $course) }}">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold fs-4" id="paymentModalLabel">{{ __('messages.course_payment_modal_title') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-light border small text-muted mb-4">
                        {{ __('messages.course_payment_modal_desc') }}
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.course_payment_student_name') }}</label>
                        <input type="text" name="name" class="form-control p-2" value="{{ Auth::user()->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.course_payment_email') }}</label>
                        <input type="email" name="email" class="form-control p-2" value="{{ Auth::user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.course_payment_unique_id') }}</label>
                        <input type="text" name="unique_course_id" class="form-control p-2" placeholder="{{ __('messages.course_payment_enter_code') }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('messages.course_payment_student_id') }}</label>
                        <input type="text" name="student_id" class="form-control p-2" placeholder="{{ __('messages.course_payment_enter_sid') }}" required>
                        <div class="form-text small text-danger mt-2">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ __('messages.course_payment_warning') }}
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">{{ __('messages.course_payment_cancel') }}</button>
                    <button type="submit" class="btn btn-primary px-4 shadow-sm">{{ __('messages.course_payment_confirm') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endauth
@endsection
