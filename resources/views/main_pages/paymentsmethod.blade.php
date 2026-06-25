@extends('layouts.main')

@section('title', __('messages.course_type_payment_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('/public/main_pages_style/paymentsmethod.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<div class="checkout-container">
    <div class="payment-section">
        <h2>{{ __('messages.payment_subscriber_data') }}</h2>
        <div class="form-group">
            <label>{{ __('messages.payment_full_name') }}</label>
            <input type="text" placeholder="{{ __('messages.payment_full_name_ph') }}">
        </div>
        <div class="form-group">
            <label>{{ __('messages.payment_email') }}</label>
            <input type="email" placeholder="{{ __('messages.payment_email_ph') }}" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
        </div>

        <h2 style="margin-top: 30px;">{{ __('messages.payment_method') }}</h2>
        <div class="pay-methods">
            <div class="method active" onclick="selectMe(this)">
                <input type="radio" name="p" checked style="margin-left:10px">
                <i class="fas fa-credit-card"></i> {{ __('messages.payment_credit_card') }}
            </div>
            <div class="method" onclick="selectMe(this)">
                <input type="radio" name="p" style="margin-left:10px">
                <i class="fas fa-mobile-alt"></i> {{ __('messages.payment_vodafone_cash') }}
            </div>
        </div>
        <button class="pay-btn">{{ __('messages.payment_confirm_btn') }}</button>
    </div>

    <div class="order-summary">
        <h2>{{ __('messages.payment_order_summary') }}</h2>
        <div class="summary-item">
            <span>{{ __('messages.payment_course') }}</span>
            <strong id="courseName">{{ __('messages.payment_undefined_course') }}</strong>
        </div>
        <div class="summary-item">
            <span>{{ __('messages.payment_base_price') }}</span>
            <span id="basePrice">0</span>
        </div>
        <div class="summary-item" style="color: #27ae60;">
            <span>{{ __('messages.payment_registration_fee') }}</span>
            <span>{{ __('messages.payment_free') }}</span>
        </div>
        <div class="summary-item total-price">
            <span>{{ __('messages.payment_total') }}</span>
            <span id="totalPrice">0</span>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function getDetails() {
        const params = new URLSearchParams(window.location.search);
        const course = params.get('course') || "{{ __('messages.payment_undefined_course') }}";
        const price = params.get('price') || "0";
        document.getElementById('courseName').innerText = course;
        document.getElementById('basePrice').innerText = price + " {{ $currentLocale === 'en' ? 'EGP' : ($currentLocale === 'de' ? 'EGP' : 'ج.م') }}";
        document.getElementById('totalPrice').innerText = price + " {{ $currentLocale === 'en' ? 'EGP' : ($currentLocale === 'de' ? 'EGP' : 'ج.م') }}";
    }

    function selectMe(el) {
        document.querySelectorAll('.method').forEach(m => m.classList.remove('active'));
        el.classList.add('active');
        el.querySelector('input').checked = true;
    }

    window.onload = getDetails;
</script>
@endsection
