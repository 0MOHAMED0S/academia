@extends('layouts.main')

@section('title', __('messages.course_type_react_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/reactcources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس React</h1>
<p>تعلم بناء تطبيقات ويب تفاعلية باستخدام React.js من الصفر حتى الاحتراف.</p>
<button class="bttn" onclick="alert('{{ __('messages.subscribe_btn') }}')">{{ __('messages.subscribe_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/919/919851.png">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>50+</h3><p>{{ __('messages.course_type_stat_hours') }}</p></div>
<div class="stat"><h3>150+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>7</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>∞</h3><p>{{ __('messages.course_type_stat_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card">مبادئ React</div>
<div class="card">JSX و Components</div>
<div class="card">State & Props</div>
<div class="card">React Router</div>
<div class="card">Hooks (useState, useEffect)</div>
<div class="card">مشروع تطبيق كامل</div>
</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_content') }}</h2>

<div class="accordion">
<div class="accordion-header">الوحدة الأولى: أساسيات React</div>
<div class="accordion-content">مقدمة عن React، JSX، Virtual DOM</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثانية: Components & Props</div>
<div class="accordion-content">إنشاء Components، تمرير Props، التفاعل بينها</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثالثة: State & Hooks</div>
<div class="accordion-content">State, useState, useEffect, التعامل مع البيانات</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الرابعة: Routing</div>
<div class="accordion-content">React Router، التنقل بين الصفحات</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الخامسة: مشروع عملي</div>
<div class="accordion-content">بناء تطبيق React تفاعلي كامل</div>
</div>

</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png">
<p>مدرب React بخبرة عملية في بناء تطبيقات ويب حديثة وتفاعلية.</p>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_student_reviews') }}</h2>
<div class="grid">
<div class="testimonial">أفضل كورس React حضرته ⭐⭐⭐⭐⭐</div>
<div class="testimonial">شرح واضح ومباشر وتطبيق عملي ⭐⭐⭐⭐⭐</div>
</div>
</div>
</section>

<section id="faq">
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>

<div class="accordion">
<div class="accordion-header">هل أحتاج خبرة سابقة؟</div>
<div class="accordion-content">يفضل معرفة HTML, CSS, و JavaScript قبل البدء.</div>
</div>

<div class="accordion">
<div class="accordion-header">هل يوجد مشاريع عملية؟</div>
<div class="accordion-content">نعم، يتضمن الكورس مشاريع تطبيقية كاملة.</div>
</div>

</div>
</section>

<section class="cta">
<h2>{{ __('messages.course_type_ready_journey', ['course' => 'React']) }}</h2>
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
