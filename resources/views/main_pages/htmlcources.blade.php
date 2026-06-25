@extends('layouts.main')

@section('title', __('messages.course_type_html_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/htmlcources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس HTML & CSS</h1>
<p>تعلم تصميم وتطوير صفحات الويب من الصفر حتى إنشاء مواقع احترافية متجاوبة.</p>
<button class="bttn" onclick="alert('{{ __('messages.subscribe_btn') }}')">{{ __('messages.subscribe_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/919/919826.png">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>40+</h3><p>{{ __('messages.course_type_stat_hours') }}</p></div>
<div class="stat"><h3>120+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>5</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>∞</h3><p>{{ __('messages.course_type_stat_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card">HTML من الصفر</div>
<div class="card">CSS Layout & Flexbox</div>
<div class="card">Responsive Design</div>
<div class="card">مشروع موقع كامل</div>
</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_content') }}</h2>

<div class="accordion">
<div class="accordion-header">الوحدة الأولى: HTML</div>
<div class="accordion-content">العناصر، الهيكلة، SEO basics</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثانية: CSS</div>
<div class="accordion-content">Selectors، Colors، Layout</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثالثة: Responsive</div>
<div class="accordion-content">Flexbox، Grid، Media Queries</div>
</div>

</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png">
<p>مدرب Front-End بخبرة عملية في تصميم وتطوير مواقع احترافية.</p>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_student_reviews') }}</h2>
<div class="grid">
<div class="testimonial">كورس ممتاز وسهل الفهم ⭐⭐⭐⭐⭐</div>
<div class="testimonial">شرح واضح وتطبيق عملي قوي ⭐⭐⭐⭐⭐</div>
</div>
</div>
</section>

<section id="faq">
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>

<div class="accordion">
<div class="accordion-header">هل الكورس مناسب للمبتدئين؟</div>
<div class="accordion-content">نعم، يبدأ من الصفر تماماً.</div>
</div>

<div class="accordion">
<div class="accordion-header">هل يوجد شهادة؟</div>
<div class="accordion-content">نعم بعد إتمام الكورس.</div>
</div>

</div>
</section>

<section class="cta">
<h2>{{ __('messages.course_type_ready_journey', ['course' => 'HTML & CSS']) }}</h2>
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
