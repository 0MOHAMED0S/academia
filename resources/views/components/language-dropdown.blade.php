{{-- Language Dropdown Component --}}
<!-- Language Dropdown in Navbar -->
<li class="nav-item dropdown mx-lg-2 d-flex align-items-center">
    <a class="nav-link dropdown-toggle" href="javascript:void(0)" id="languageDropdown" role="button"
       data-bs-toggle="dropdown" aria-expanded="false" style="padding: 0.5rem 0.75rem !important;">
        <i class="fas fa-globe me-2"></i>{{ __('messages.nav_language') }}
    </a>
    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="languageDropdown"
        style="min-width: 160px;">
        <li>
            <a class="dropdown-item @if($currentLocale === 'ar') active @endif"
               href="{{ route('language.switch', 'ar') }}">
                <span class="me-2">🇸🇦</span> العربية
            </a>
        </li>
        <li>
            <a class="dropdown-item @if($currentLocale === 'en') active @endif"
               href="{{ route('language.switch', 'en') }}">
                <span class="me-2">🇺🇸</span> English
            </a>
        </li>
        <li>
            <a class="dropdown-item @if($currentLocale === 'de') active @endif"
               href="{{ route('language.switch', 'de') }}">
                <span class="me-2">🇩🇪</span> Deutsch
            </a>
        </li>
    </ul>
</li>
