@extends('layouts.main')

@section('title', __('messages.instructors_page_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<link rel="stylesheet" href="{{ asset('main_pages_style/instructors.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="page-header text-center">
    <div class="container">
        <h1 class="fw-bold mb-3 display-4"><i class="fas fa-user-tie me-2"></i> {{ __('messages.instructors_hero_title') }}</h1>
        <p class="lead mb-0 opacity-75">{{ __('messages.instructors_hero_desc') }}</p>
    </div>
</section>

<div class="container mb-5">
    @if(isset($instructors) && $instructors->count() > 0)
        <div class="row g-4 justify-content-center">
            @foreach($instructors as $instructor)
                <div class="col-md-6 col-lg-3">
                    <div class="instructor-card">
                        <div class="instructor-photo-wrapper">
                            @if($instructor->profile_photo)
                                <img src="{{ asset($instructor->profile_photo) }}" class="instructor-photo" alt="{{ $instructor->name }}">
                            @else
                                <div class="instructor-photo d-flex align-items-center justify-content-center text-primary">
                                    <i class="fa-solid fa-user-tie fa-3x"></i>
                                </div>
                            @endif
                        </div>
                        
                        <h5 class="instructor-name">{{ $instructor->name }}</h5>
                        <p class="instructor-title">{{ $instructor->job_title ?? __('messages.instructors_default_role') }}</p>
                        
                        <p class="instructor-bio">{{ __('messages.instructors_default_bio') }}</p>

                        <div class="instructor-actions">
                            <a href="{{ url('/payedcources') }}" class="btn btn-instructor btn-courses text-decoration-none">{{ __('messages.instructors_view_courses') }}</a>
                            <button class="btn btn-instructor btn-contact">{{ __('messages.instructors_contact') }}</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-5">
            <div class="alert alert-warning d-inline-block px-5 rounded-pill shadow-sm">
                <i class="fas fa-info-circle me-2"></i> {{ __('messages.instructors_no_data') }}
            </div>
        </div>
    @endif
</div>
@endsection
