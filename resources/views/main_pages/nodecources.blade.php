@extends('layouts.main')

@section('title', __('messages.course_type_node_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/nodecources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس Node.js</h1>
<p>تعلم برمجة Back-End باستخدام Node.js مع بناء مشاريع ويب ديناميكية وتطبيقات حقيقية.</p>
<button class="bttn" onclick="alert('{{ __('messages.subscribe_btn') }}')">{{ __('messages.subscribe_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/919/919825.png" alt="Node.js Logo">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>50+</h3><p>{{ __('messages.course_type_stat_hours') }}</p></div>
<div class="stat"><h3>110+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>6</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>∞</h3><p>{{ __('messages.course_type_stat_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card">أساسيات Node.js</div>
<div class="card">Express.js</div>
<div class="card">REST APIs</div>
<div class="card">التعامل مع قواعد البيانات MongoDB</div>
<div class="card">Authentication & Security</div>
<div class="card">مشروع عملي كامل</div>
</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_content') }}</h2>

<div class="accordion">
<div class="accordion-header">الوحدة الأولى: أساسيات Node.js</div>
<div class="accordion-content">Modules، Events، File System، NPM</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثانية: Express.js</div>
<div class="accordion-content">Routing، Middleware، Request & Response</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الثالثة: REST APIs</div>
<div class="accordion-content">GET, POST, PUT, DELETE، JSON، CRUD operations</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الرابعة: قواعد البيانات</div>
<div class="accordion-content">MongoDB، اتصال، عمليات Create, Read, Update, Delete</div>
</div>

<div class="accordion">
<div class="accordion-header">الوحدة الخامسة: مشروع عملي</div>
<div class="accordion-content">بناء تطبيق Node.js كامل مع قاعدة بيانات ومصادقة</div>
</div>

</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Instructor">
<p>مدرب Node.js بخبرة عملية في تطوير تطبيقات ويب ديناميكية وBack-End احترافية.</p>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_student_reviews') }}</h2>
<div class="grid">
<div class="testimonial">أفضل كورس Node.js حضرته ⭐⭐⭐⭐⭐</div>
<div class="testimonial">شرح عملي وواضح جدًا ⭐⭐⭐⭐⭐</div>
</div>
</div>
</section>

<section id="faq">
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>

<div class="accordion">
<div class="accordion-header">هل أحتاج خبرة سابقة؟</div>
<div class="accordion-content">يفضل معرفة JavaScript و HTML و CSS قبل البدء.</div>
</div>

<div class="accordion">
<div class="accordion-header">هل يوجد مشاريع عملية؟</div>
<div class="accordion-content">نعم، يتضمن الكورس مشاريع تطبيقية كاملة.</div>
</div>

</div>
</section>

<section class="cta">
<h2>{{ __('messages.course_type_ready_journey', ['course' => 'Node.js']) }}</h2>
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
