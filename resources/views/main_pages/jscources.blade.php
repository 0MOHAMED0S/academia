@extends('layouts.main')

@section('title', __('messages.course_type_js_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/jscources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس JavaScript</h1>
<p>تعلم برمجة المواقع التفاعلية باستخدام JavaScript من الصفر حتى بناء مشاريع حقيقية.</p>
<button class="bttn" onclick="alert('{{ __('messages.subscribe_btn') }}')">{{ __('messages.subscribe_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/5968/5968292.png">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>45+</h3><p>{{ __('messages.course_type_stat_hours') }}</p></div>
<div class="stat"><h3>140+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>6</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>∞</h3><p>{{ __('messages.course_type_stat_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card">أساسيات JavaScript</div>
<div class="card">الشروط والحلقات</div>
<div class="card">الدوال و Scope</div>
<div class="card">التعامل مع DOM</div>
<div class="card">الأحداث Events</div>
<div class="card">بناء مشروع تفاعلي كامل</div>
</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_content') }}</h2>

<div class="accordion">
<div class="accordion-header">الوحدة الأولى: الأساسيات</div>
<div class="accordion-content">المتغيرات، أنواع البيانات، العمليات</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثانية: التحكم والتكرار</div>
<div class="accordion-content">If Conditions، Loops، Switch</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثالثة: DOM & Events</div>
<div class="accordion-content">التعامل مع العناصر، الأحداث، التفاعل</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الرابعة: مشروع عملي</div>
<div class="accordion-content">بناء تطبيق تفاعلي كامل</div>
</div>

</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png">
<p>مدرب JavaScript بخبرة عملية في تطوير تطبيقات ويب تفاعلية حديثة.</p>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_student_reviews') }}</h2>
<div class="grid">
<div class="testimonial">أفضل كورس JavaScript حضرته ⭐⭐⭐⭐⭐</div>
<div class="testimonial">شرح عملي وواضح جدًا ⭐⭐⭐⭐⭐</div>
</div>
</div>
</section>

<section id="faq">
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>

<div class="accordion">
<div class="accordion-header">هل أحتاج خبرة سابقة؟</div>
<div class="accordion-content">يفضل معرفة HTML و CSS قبل البدء.</div>
</div>

<div class="accordion">
<div class="accordion-header">هل يوجد مشاريع عملية؟</div>
<div class="accordion-content">نعم، يتضمن الكورس مشاريع تطبيقية كاملة.</div>
</div>

</div>
</section>

<section class="cta">
<h2>{{ __('messages.course_type_ready_journey', ['course' => 'JavaScript']) }}</h2>
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
