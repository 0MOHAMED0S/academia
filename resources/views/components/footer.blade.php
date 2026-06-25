<footer class="academia-footer mt-5">
    <div class="container py-5">
        <div class="row g-4">
            <!-- Brand Column -->
            <div class="col-lg-4 col-md-6 mb-4 mb-md-0">
                <div class="footer-brand d-flex align-items-center mb-3">
                    <img src="{{ asset('main_images/images/Logo.jpg') }}" alt="logo" width="45" class="me-2 rounded-3 shadow-sm">
                    <h4 class="brand-name mb-0 ms-2">{{ __('messages.app_name') }}</h4>
                </div>
                <p class="footer-desc text-muted mb-4">
                    {{ __('messages.footer_desc') }}
                </p>
                <div class="footer-socials d-flex gap-2">
                    <a href="https://facebook.com" target="_blank" class="social-icon" title="{{ __('messages.footer_facebook') }}"><i class="fa-brands fa-facebook-f"></i></a>
                    <a href="https://twitter.com" target="_blank" class="social-icon" title="{{ __('messages.footer_twitter') }}"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="https://linkedin.com" target="_blank" class="social-icon" title="{{ __('messages.footer_linkedin') }}"><i class="fa-brands fa-linkedin-in"></i></a>
                    <a href="https://github.com" target="_blank" class="social-icon" title="{{ __('messages.footer_github') }}"><i class="fa-brands fa-github"></i></a>
                    <a href="https://youtube.com" target="_blank" class="social-icon" title="{{ __('messages.footer_youtube') }}"><i class="fa-brands fa-youtube"></i></a>
                </div>
            </div>

            <!-- Quick Links Column -->
            <div class="col-lg-3 col-md-6 mb-4 mb-md-0">
                <h5 class="footer-title fw-bold mb-4">{{ __('messages.footer_quick_links') }}</h5>
                <ul class="footer-links list-unstyled p-0 m-0">
                    <li class="mb-2"><a href="{{ url('/') }}"><i class="fa-solid fa-chevron-left me-2 small"></i>{{ __('messages.nav_home') }}</a></li>
                    <li class="mb-2"><a href="{{ route('freecourse') }}"><i class="fa-solid fa-chevron-left me-2 small"></i>{{ __('messages.nav_free_courses') }}</a></li>
                    <li class="mb-2"><a href="{{ url('/payedcources') }}"><i class="fa-solid fa-chevron-left me-2 small"></i>{{ __('messages.nav_paid_courses') }}</a></li>
                    <li class="mb-2"><a href="{{ url('/instructors') }}"><i class="fa-solid fa-chevron-left me-2 small"></i>{{ __('messages.nav_instructors') }}</a></li>
                    <li class="mb-2"><a href="{{ url('/articles') }}"><i class="fa-solid fa-chevron-left me-2 small"></i>{{ __('messages.nav_articles') }}</a></li>
                    <li class="mb-2"><a href="{{ url('/about') }}"><i class="fa-solid fa-chevron-left me-2 small"></i>{{ __('messages.nav_about') }}</a></li>
                </ul>
            </div>

            <!-- Support Column -->
            <div class="col-lg-5 col-md-12">
                <h5 class="footer-title fw-bold mb-4">{{ __('messages.footer_support') }}</h5>
                <p class="footer-desc text-muted mb-4">
                    {{ __('messages.footer_support_desc') }}
                </p>
                <div class="d-flex flex-wrap gap-3 align-items-center">
                    <a href="mailto:support@academiaplus.com" class="btn btn-premium-support d-inline-flex align-items-center gap-2">
                        <i class="fa-solid fa-envelope"></i>
                        <span>{{ __('messages.footer_email_us') }}</span>
                    </a>
                    <a href="https://wa.me/1234567890" target="_blank" class="btn btn-whatsapp-support d-inline-flex align-items-center gap-2">
                        <i class="fa-brands fa-whatsapp"></i>
                        <span>{{ __('messages.footer_whatsapp') }}</span>
                    </a>
                </div>
                <div class="contact-info mt-4 d-flex flex-column gap-2 text-muted">
                    <span class="d-flex align-items-center gap-2"><i class="fa-solid fa-envelope text-primary"></i> support@academiaplus.com</span>
                    <span class="d-flex align-items-center gap-2"><i class="fa-solid fa-clock text-primary"></i> {{ __('messages.footer_hours') }}</span>
                </div>
            </div>
        </div>

        <hr class="footer-hr my-5">

        <div class="footer-bottom d-flex flex-wrap justify-content-between align-items-center gap-3">
            <span class="copyright text-muted small">{{ __('messages.footer_copyright', ['year' => date('Y')]) }}</span>
            <div class="footer-policies d-flex gap-3 small">
                <a href="javascript:void(0)" class="text-muted text-decoration-none">{{ __('messages.footer_privacy') }}</a>
                <span class="text-muted">|</span>
                <a href="javascript:void(0)" class="text-muted text-decoration-none">{{ __('messages.footer_terms') }}</a>
