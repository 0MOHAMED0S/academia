@extends('layouts.main')

@section('title', __('messages.course_type_flutter_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/fluttercources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس Flutter</h1>
<p>تعلم تطوير تطبيقات الهواتف الذكية المتقدمة باستخدام Flutter و Dart مع تصميم واجهات احترافية.</p>
<button class="bttn" onclick="alert('{{ __('messages.subscribe_btn') }}')">{{ __('messages.subscribe_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/888/888857.png" alt="Flutter Logo">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>45+</h3><p>{{ __('messages.course_type_stat_hours') }}</p></div>
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
<div class="card">أساسيات Dart</div>
<div class="card">Widgets & Layout</div>
<div class="card">State Management</div>
<div class="card">التعامل مع APIs</div>
<div class="card">التخزين المحلي & قواعد البيانات</div>
<div class="card">مشروع عملي كامل</div>
</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_content') }}</h2>

<div class="accordion">
<div class="accordion-header">الوحدة الأولى: أساسيات Dart</div>
<div class="accordion-content">المتغيرات، أنواع البيانات، الحلقات، الدوال</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثانية: Widgets & Layout</div>
<div class="accordion-content">Stateless و Stateful Widgets، تصميم واجهات تفاعلية</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثالثة: State Management</div>
<div class="accordion-content">Provider، setState، إدارة الحالة</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الرابعة: التعامل مع APIs</div>
<div class="accordion-content">HTTP requests، JSON، CRUD operations</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الخامسة: التخزين وقواعد البيانات</div>
<div class="accordion-content">SQLite، SharedPreferences، Hive</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة السادسة: مشروع عملي</div>
<div class="accordion-content">بناء تطبيق Flutter كامل متكامل مع واجهات جميلة وميزات عملية</div>
</div>

</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Instructor">
<p>مدرب Flutter بخبرة عملية في تطوير تطبيقات الهواتف الذكية وتصميم واجهات تفاعلية.</p>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_student_reviews') }}</h2>
<div class="grid">
<div class="testimonial">أفضل كورس Flutter حضرته ⭐⭐⭐⭐⭐</div>
<div class="testimonial">شرح عملي وواضح جدًا ⭐⭐⭐⭐⭐</div>
</div>
</div>
</section>

<section id="faq">
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>

<div class="accordion">
<div class="accordion-header">هل أحتاج خبرة سابقة؟</div>
<div class="accordion-content">يفضل معرفة أساسيات البرمجة و Dart قبل البدء.</div>
</div>

<div class="accordion">
<div class="accordion-header">هل يوجد مشاريع عملية؟</div>
<div class="accordion-content">نعم، يتضمن الكورس مشاريع تطبيقية كاملة.</div>
</div>

</div>
</section>

<section class="cta">
<h2>{{ __('messages.course_type_ready_journey', ['course' => 'Flutter']) }}</h2>
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
