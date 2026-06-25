@extends('layouts.main')

@section('title', __('messages.course_type_php_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/phpcorces.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس PHP</h1>
<p>تعلم برمجة الويب الديناميكي باستخدام PHP مع بناء مشاريع حقيقية وتطبيقات عملية.</p>
<button class="bttn" onclick="alert('{{ __('messages.subscribe_btn') }}')">{{ __('messages.subscribe_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/919/919830.png" alt="PHP Logo">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>55+</h3><p>{{ __('messages.course_type_stat_hours') }}</p></div>
<div class="stat"><h3>120+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>6</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>∞</h3><p>{{ __('messages.course_type_stat_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card">أساسيات PHP</div>
<div class="card">التعامل مع Forms</div>
<div class="card">Sessions & Cookies</div>
<div class="card">التعامل مع قواعد البيانات MySQL</div>
<div class="card">الأمان و Validation</div>
<div class="card">مشروع عملي كامل</div>
</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_content') }}</h2>

<div class="accordion">
<div class="accordion-header">الوحدة الأولى: أساسيات PHP</div>
<div class="accordion-content">المتغيرات، أنواع البيانات، العمليات الحسابية، الطباعة</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثانية: Forms & Validation</div>
<div class="accordion-content">التعامل مع Forms، التحقق من البيانات، Sanitization</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثالثة: Sessions & Cookies</div>
<div class="accordion-content">Session management، Cookies، حفظ المعلومات</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الرابعة: قواعد البيانات</div>
<div class="accordion-content">MySQL، الاتصال، استعلامات SELECT، INSERT، UPDATE</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الخامسة: مشروع عملي</div>
<div class="accordion-content">بناء مشروع PHP ديناميكي كامل مع قاعدة بيانات</div>
</div>

</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Instructor">
<p>مدرب PHP بخبرة عملية في تطوير تطبيقات ويب ديناميكية وآمنة.</p>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_student_reviews') }}</h2>
<div class="grid">
<div class="testimonial">أفضل كورس PHP حضرته ⭐⭐⭐⭐⭐</div>
<div class="testimonial">شرح عملي وواضح جدًا ⭐⭐⭐⭐⭐</div>
</div>
</div>
</section>

<section id="faq">
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>

<div class="accordion">
<div class="accordion-header">هل أحتاج خبرة سابقة؟</div>
<div class="accordion-content">يفضل معرفة HTML و CSS و JavaScript قبل البدء.</div>
</div>

<div class="accordion">
<div class="accordion-header">هل يوجد مشاريع عملية؟</div>
<div class="accordion-content">نعم، يتضمن الكورس مشاريع تطبيقية كاملة.</div>
</div>

</div>
</section>

<section class="cta">
<h2>{{ __('messages.course_type_ready_journey', ['course' => 'PHP']) }}</h2>
<button class="bttn" onclick="alert('{{ __('messages.subscribe_btn') }}')">{{ __('messages.subscribe_btn') }}</button>
</section>

@endsection

@section('scripts')
<script>
document.querySelectorAll(".accordion-header").forEach(item=>{
item.addEventListener("click",()=>{
const content=item.nextElementSibling;
content.style.display = content.style.display==="block" ? "none":"block";
});
});
</script>
@endsection
