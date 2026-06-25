@extends('layouts.main', ['metaDescription' => __('messages.app_title')])

@section('title', __('messages.app_title'))

@section('styles')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('main_pages_style/home.css') }}">
<style>
    .video-container { display: flex; justify-content: center; padding: 40px 20px; }
    .video-card { width: 100%; max-width: 900px; border-radius: 24px; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,.15); }
    .video-card video { width: 100%; display: block; }
</style>
@endsection

@section('content')
@if(session('success_register'))
    <div id="statusAlert" class="alert alert-success alert-dismissible fade show"
        style="position: fixed; top: 90px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 90%; max-width: 600px; text-align: center; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
        role="alert">
        <i class="fa-solid fa-check-circle me-2"></i> {{ session('success_register') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('errors_register'))
<div id="statusAlert" class="alert alert-danger alert-dismissible fade show"
style="position: fixed; top: 90px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 90%; max-width: 600px; text-align: center; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
role="alert">
<i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('errors_register') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('success_login'))
    <div id="statusAlert" class="alert alert-success alert-dismissible fade show"
        style="position: fixed; top: 90px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 90%; max-width: 600px; text-align: center; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
        role="alert">
        <i class="fa-solid fa-check-circle me-2"></i> {{ session('success_login') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(session('errors_login'))
<div id="statusAlert" class="alert alert-danger alert-dismissible fade show"
style="position: fixed; top: 90px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 90%; max-width: 600px; text-align: center; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
role="alert">
<i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session('errors_login') }}
<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif
@if(session('success_contact'))
    <div id="statusAlert" class="alert alert-success alert-dismissible fade show"
        style="position: fixed; top: 90px; left: 50%; transform: translateX(-50%); z-index: 9999; width: 90%; max-width: 600px; text-align: center; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);"
        role="alert">
        <i class="fa-solid fa-check-circle me-2"></i> {{ session('success_contact') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<header id="hero" class="hero d-flex align-items-center">
    <div class="container text-center text-dark" data-aos="fade-up">
        <h1 class="display-5 fw-bold">{!! __('messages.hero_title') !!}</h1>
        <p class="lead mt-3 text-muted">{{ __('messages.hero_subtitle') }}</p>
        <div class="mt-4">
            <a href="{{ route('payedcources') }}" class="btn btn-primary btn-lg me-2">{{ __('messages.hero_browse') }}</a>
            <a href="{{ route('payedcources') }}" class="btn btn-outline-primary btn-lg">{{ __('messages.hero_popular') }}</a>
        </div>
    </div>
</header>

<section class="video-container">
    <div class="video-card">
        <video controls poster="#">
            <source src="{{ asset('main_images/images/WhatsApp Video 2026-04-19 at 4.12.45 AM.mp4') }}" type="video/mp4">
            {{ __('messages.video_not_supported') }}
        </video>
    </div>
</section>

<section class="py-5" data-aos="fade-up">
    <div class="container">
        <div class="row g-3 text-center">
            <div class="col-md-3">
                <div class="feature-card p-4 rounded shadow-sm">
                    <i class="fa-solid fa-chalkboard-teacher fa-2x text-primary mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.feature_trainers') }}</h6>
                    <p class="small text-muted">{{ __('messages.feature_trainers_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card p-4 rounded shadow-sm">
                    <i class="fa-solid fa-project-diagram fa-2x text-primary mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.feature_projects') }}</h6>
                    <p class="small text-muted">{{ __('messages.feature_projects_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card p-4 rounded shadow-sm">
                    <i class="fa-solid fa-certificate fa-2x text-primary mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.feature_certificates') }}</h6>
                    <p class="small text-muted">{{ __('messages.feature_certificates_desc') }}</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="feature-card p-4 rounded shadow-sm">
                    <i class="fa-solid fa-headset fa-2x text-primary mb-3"></i>
                    <h6 class="fw-bold">{{ __('messages.feature_support') }}</h6>
                    <p class="small text-muted">{{ __('messages.feature_support_desc') }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="coursesSection" class="py-5 bg-light" data-aos="fade-up">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="section-title">{{ __('messages.section_courses') }}</h2>
            <div class="text-muted small">{{ __('messages.section_courses_sub') }}</div>
        </div>

        @if(isset($courses) && $courses->count())
            <div class="row g-4">
                @foreach($courses as $course)
                    <div class="col-md-3">
                        <div class="card course-card h-100 shadow-sm">
                            <div class="course-card-image-wrapper" style="height: 180px; overflow: hidden; background: #f8fafc; display: flex; align-items: center; justify-content: center; position: relative;">
                                @if($course->image_path)
                                    <img src="{{ asset($course->image_path) }}" alt="{{ $course->title }}" class="course-card-img" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="color: #2f80ed; font-size: 3.5rem;">
                                        <i class="fa-solid fa-graduation-cap"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $course->title }}</h5>
                                <p class="card-text small text-muted">{{ Str::limit($course->description, 90) }}</p>
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div>
                                        <a href="{{ route('courses.show', $course) }}" class="btn btn-sm btn-outline-primary" style="margin-{{ $currentDir === 'rtl' ? 'right' : 'left' }}: 50px;">{{ __('messages.course_details') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-warning text-center">{{ __('messages.no_courses') }}</div>
        @endif
    </div>
</section>

<section id="testSectionVIP"></section>

<section class="track-section">
    <div class="big-card">
        <h2 class="section-title">{{ __('messages.section_tracks') }}</h2>
        <div class="tracks">
            @forelse($tracks as $track)
                <a class="track-card text-decoration-none" href="{{ route('tracks.show', $track) }}">
                    <h3>{{ $track->name }}</h3>
                    <p>{{ $track->description ? Str::words($track->description, 10) : __('messages.track_default_desc') }}</p>
                </a>
            @empty
                <div class="alert alert-light border w-100">{{ __('messages.no_tracks') }}</div>
            @endforelse
        </div>
    </div>
</section>

<section id="certificates" class="certificates py-5" data-aos="fade-up">
    <div class="container text-center">
        <h2 class="mb-4">{{ __('messages.section_certificates') }}</h2>
        <p class="mb-5">{{ __('messages.section_certs_desc') }}</p>

        <div class="row g-4 justify-content-center">
            <div class="col-md-3 col-sm-6">
                <div class="certificate-card shadow">
                    <a href="{{ asset('main_images/images/file_2025-10-20_13.29.57.png') }}" target="_blank" rel="noopener">
                        <img src="{{ asset('main_images/images/file_2025-10-20_13.29.57.png') }}" alt="HTML Certificate" class="img-fluid rounded-top">
                    </a>
                    <div class="p-3">
                        <h5>{{ __('messages.cert_html') }}</h5>
                        <p>{{ __('messages.cert_html_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="certificate-card shadow">
                    <a href="{{ asset('main_images/images/file_2025-10-20_13.35.51.png') }}" target="_blank" rel="noopener">
                        <img src="{{ asset('main_images/images/file_2025-10-20_13.35.51.png') }}" alt="React Certificate" class="img-fluid rounded-top">
                    </a>
                    <div class="p-3">
                        <h5>{{ __('messages.cert_react') }}</h5>
                        <p>{{ __('messages.cert_react_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="certificate-card shadow">
                    <a href="{{ asset('main_images/images/file_2025-10-20_13.33.09.png') }}" target="_blank" rel="noopener">
                        <img src="{{ asset('main_images/images/file_2025-10-20_13.33.09.png') }}" alt="UI UX Certificate" class="img-fluid rounded-top">
                    </a>
                    <div class="p-3">
                        <h5>{{ __('messages.cert_uiux') }}</h5>
                        <p>{{ __('messages.cert_uiux_desc') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-6">
                <div class="certificate-card shadow">
                    <a href="{{ asset('main_images/images/file_2025-10-20_13.31.22.png') }}" target="_blank" rel="noopener">
                        <img src="{{ asset('main_images/images/file_2025-10-20_13.31.22.png') }}" alt="MySQL Certificate" class="img-fluid rounded-top">
                    </a>
                    <div class="p-3">
                        <h5>{{ __('messages.cert_mysql') }}</h5>
                        <p>{{ __('messages.cert_mysql_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="instructors" class="py-5 bg-light" data-aos="fade-up">
    <div class="container">
        <h2 class="section-title text-center mb-4">{{ __('messages.section_instructors') }}</h2>
        <div class="row g-4 justify-content-center">
            @forelse($instructors as $instructor)
                <div class="col-sm-6 col-md-3">
                    <div class="card text-center p-3 shadow-sm instructor-card" data-aos="zoom-in">
                        @if($instructor->profile_photo)
                            <img src="{{ asset($instructor->profile_photo) }}" class="rounded-circle mx-auto instructor-img" alt="{{ $instructor->name }}">
                        @else
                            <div class="rounded-circle mx-auto instructor-img bg-primary text-white d-flex align-items-center justify-content-center fw-bold">{{ strtoupper(substr($instructor->name, 0, 1)) }}</div>
                        @endif
                        <h6 class="mt-3 mb-0">{{ $instructor->name }}</h6>
                        <small class="text-muted">{{ $instructor->job_title ?? __('messages.instructor_default_role') }}</small>
                    </div>
                </div>
            @empty
                <div class="col-12"><div class="alert alert-light border text-center">{{ __('messages.no_instructors') }}</div></div>
            @endforelse
            <div style="text-align: center;">
                <a href="{{ url('/instructors') }}"> <button class="btn btn-sm btn-outline-primary btn-level"
                        style="padding-left: 50px; padding-right: 50px; padding-top: 10px; padding-bottom: 10px;">{{ __('messages.view_all_instructors') }}</button></a>
            </div>
        </div>
    </div>
</section>

<section id="testimonials" class="testimonials section">
    <h2 class="section-title">{{ __('messages.section_testimonials') }}</h2>
    <div class="container">
        <div class="row">
            <div class="col-md-4" data-aos="fade-up">
                <div class="testimonial-card">
                    <p>"{{ __('messages.testimonial_1') }}"</p>
                    <h6>{{ __('messages.testimonial_1_author') }}</h6>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="150">
                <div class="testimonial-card">
                    <p>"{{ __('messages.testimonial_2') }}"</p>
                    <h6>{{ __('messages.testimonial_2_author') }}</h6>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="testimonial-card">
                    <p>"{{ __('messages.testimonial_3') }}"</p>
                    <h6>{{ __('messages.testimonial_3_author') }}</h6>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="faq" class="faq py-5" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center mb-4">{{ __('messages.section_faq') }}</h2>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true">
                        {{ __('messages.faq_q1') }}
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('messages.faq_a1') }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                        {{ __('messages.faq_q2') }}
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('messages.faq_a2') }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree">
                        {{ __('messages.faq_q3') }}
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('messages.faq_a3') }}</div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="headingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour">
                        {{ __('messages.faq_q4') }}
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">{{ __('messages.faq_a4') }}</div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contact" class="contact py-5" data-aos="fade-up">
    <div class="container">
        <h2 class="text-center mb-4">{{ __('messages.section_contact') }}</h2>
        <p class="text-center mb-5">{{ __('messages.contact_subtitle') }}</p>
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('contact.store') }}#contact" method="POST" id="contactForm" class="p-4 shadow rounded bg-white">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('messages.contact_name') }}</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="{{ __('messages.contact_name_ph') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('messages.contact_email') }}</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="example@email.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">{{ __('messages.contact_message') }}</label>
                        <textarea id="message" name="message" rows="4" class="form-control" placeholder="{{ __('messages.contact_message_ph') }}" required></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary px-4 py-2">{{ __('messages.contact_send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="{{ asset('main_pages_js/script.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const alertEl = document.getElementById('statusAlert');
        if (alertEl) {
            setTimeout(() => {
                if (typeof bootstrap !== 'undefined') {
                    const bsAlert = new bootstrap.Alert(alertEl);
                    bsAlert.close();
                } else {
                    alertEl.style.display = 'none';
                }
            }, 20000);
        }
    });
</script>
@endsection
