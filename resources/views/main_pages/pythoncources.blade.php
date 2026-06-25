@extends('layouts.main')

@section('title', __('messages.course_type_python_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/pythoncources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس Python</h1>
<p>تعلم لغة Python من الأساسيات حتى بناء برامج ومشاريع حقيقية وتطبيقات عملية.</p>
<button class="bttn" onclick="alert('{{ __('messages.subscribe_btn') }}')">{{ __('messages.subscribe_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/1822/1822899.png" alt="Python Logo">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>60+</h3><p>{{ __('messages.course_type_stat_hours') }}</p></div>
<div class="stat"><h3>130+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>8</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>∞</h3><p>{{ __('messages.course_type_stat_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card">أساسيات Python</div>
<div class="card">الشروط والحلقات</div>
<div class="card">الدوال و Classes</div>
<div class="card">قوائم و Dictionaries</div>
<div class="card">التعامل مع الملفات</div>
<div class="card">مشروع عملي كامل</div>
</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_content') }}</h2>

<div class="accordion">
<div class="accordion-header">الوحدة الأولى: أساسيات Python</div>
<div class="accordion-content">المتغيرات، أنواع البيانات، العمليات الحسابية</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثانية: التحكم والتكرار</div>
<div class="accordion-content">If، Loops، For، While</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثالثة: الدوال و Classes</div>
<div class="accordion-content">تعريف الدوال، المعاملات، Classes، OOP basics</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الرابعة: التعامل مع البيانات</div>
<div class="accordion-content">Lists، Dictionaries، Tuples، Sets</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الخامسة: مشروع عملي</div>
<div class="accordion-content">بناء مشروع Python تفاعلي كامل</div>
</div>

</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Instructor">
<p>مدرب Python بخبرة عملية في بناء برامج وتطبيقات عملية حديثة.</p>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_student_reviews') }}</h2>
<div class="grid">
<div class="testimonial">أفضل كورس Python حضرته ⭐⭐⭐⭐⭐</div>
<div class="testimonial">شرح واضح وتطبيق عملي ⭐⭐⭐⭐⭐</div>
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
<h2>{{ __('messages.course_type_ready_journey', ['course' => 'Python']) }}</h2>
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
