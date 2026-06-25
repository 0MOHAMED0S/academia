@extends('layouts.main')

@section('title', __('messages.course_type_cpp_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/cpluspluscources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس C++</h1>
<p>تعلم لغة C++ من الأساسيات حتى كتابة برامج ومشاريع متقدمة باستخدام البرمجة الكائنية.</p>
<button class="bttn" onclick="alert('{{ __('messages.subscribe_btn') }}')">{{ __('messages.subscribe_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/6132/6132222.png" alt="C++ Logo">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>50+</h3><p>{{ __('messages.course_type_stat_hours') }}</p></div>
<div class="stat"><h3>100+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>5</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>∞</h3><p>{{ __('messages.course_type_stat_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card">أساسيات C++</div>
<div class="card">الشروط والحلقات</div>
<div class="card">الدوال و Classes</div>
<div class="card">المؤشرات و Arrays</div>
<div class="card">البرمجة الكائنية OOP</div>
<div class="card">مشروع عملي كامل</div>
</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_content') }}</h2>

<div class="accordion">
<div class="accordion-header">الوحدة الأولى: أساسيات C++</div>
<div class="accordion-content">المتغيرات، أنواع البيانات، الطباعة، الإدخال</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثانية: التحكم والتكرار</div>
<div class="accordion-content">If, Switch, For, While، حلقات التكرار</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثالثة: الدوال و Classes</div>
<div class="accordion-content">تعريف الدوال، المعاملات، Classes، Constructors</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الرابعة: المؤشرات و Arrays</div>
<div class="accordion-content">Pointers، Arrays، Strings</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الخامسة: مشروع عملي</div>
<div class="accordion-content">بناء مشروع C++ كامل يطبق المفاهيم السابقة</div>
</div>

</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Instructor">
<p>مدرب C++ بخبرة عملية في البرمجة الكائنية وتصميم مشاريع احترافية.</p>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_student_reviews') }}</h2>
<div class="grid">
<div class="testimonial">أفضل كورس C++ حضرته ⭐⭐⭐⭐⭐</div>
<div class="testimonial">شرح عملي وواضح جدًا ⭐⭐⭐⭐⭐</div>
</div>
</div>
</section>

<section id="faq">
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>

<div class="accordion">
<div class="accordion-header">هل أحتاج خبرة سابقة؟</div>
<div class="accordion-content">يفضل معرفة أساسيات البرمجة قبل البدء.</div>
</div>

<div class="accordion">
<div class="accordion-header">هل يوجد مشاريع عملية؟</div>
<div class="accordion-content">نعم، يتضمن الكورس مشاريع تطبيقية كاملة.</div>
</div>

</div>
</section>

<section class="cta">
<h2>{{ __('messages.course_type_ready_journey', ['course' => 'C++']) }}</h2>
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
