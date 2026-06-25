@extends('layouts.main')

@section('title', __('messages.about_page_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/about.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
  <h1>{{ __('messages.about_hero_title') }}</h1>
  <p>{{ __('messages.about_hero_desc') }}</p>
</section>

<section class="mission">
  <div class="box">
    <h2>{{ __('messages.about_vision') }}</h2>
    <p>{{ __('messages.about_vision_desc') }}</p>
  </div>
  <div class="box">
    <h2>{{ __('messages.about_mission') }}</h2>
    <p>{{ __('messages.about_mission_desc') }}</p>
  </div>
</section>

<section class="stats">
  <div class="stat-box"><h3>200+</h3><p>{{ __('messages.about_students') }}</p></div>
  <div class="stat-box"><h3>20+</h3><p>{{ __('messages.about_instructors') }}</p></div>
  <div class="stat-box"><h3>300+</h3><p>{{ __('messages.about_projects') }}</p></div>
  <div class="stat-box"><h3>10+</h3><p>{{ __('messages.about_experience') }}</p></div>
</section>

<section class="courses">
<h2>{{ __('messages.about_courses_title') }}</h2>
<div class="courses-grid">
  <div class="course-card">
    <img src="https://cdn-icons-png.flaticon.com/512/919/919826.png" alt="HTML & CSS">
    <h3>{{ __('messages.about_course_html') }}</h3>
    <p>{{ __('messages.about_course_html_desc') }}</p>
    <button class="btn-sub">{{ __('messages.about_subscribe') }}</button>
  </div>
  <div class="course-card">
    <img src="https://cdn-icons-png.flaticon.com/512/919/919828.png" alt="JavaScript">
    <h3>{{ __('messages.about_course_js') }}</h3>
    <p>{{ __('messages.about_course_js_desc') }}</p>
    <button class="btn-sub">{{ __('messages.about_subscribe') }}</button>
  </div>
  <div class="course-card">
    <img src="https://cdn-icons-png.flaticon.com/512/919/919831.png" alt="React">
    <h3>{{ __('messages.about_course_react') }}</h3>
    <p>{{ __('messages.about_course_react_desc') }}</p>
    <button class="btn-sub">{{ __('messages.about_subscribe') }}</button>
  </div>
  <div class="course-card">
    <img src="https://cdn-icons-png.flaticon.com/512/919/919830.png" alt="Python">
    <h3>{{ __('messages.about_course_python') }}</h3>
    <p>{{ __('messages.about_course_python_desc') }}</p>
    <button class="btn-sub">{{ __('messages.about_subscribe') }}</button>
  </div>
  <div class="course-card">
    <img src="https://cdn-icons-png.flaticon.com/512/919/919835.png" alt="PHP">
    <h3>{{ __('messages.about_course_php') }}</h3>
    <p>{{ __('messages.about_course_php_desc') }}</p>
    <button class="btn-sub">{{ __('messages.about_subscribe') }}</button>
  </div>
  <div class="course-card">
    <img src="https://cdn-icons-png.flaticon.com/512/919/919839.png" alt="Node.js">
    <h3>{{ __('messages.about_course_node') }}</h3>
    <p>{{ __('messages.about_course_node_desc') }}</p>
    <button class="btn-sub">{{ __('messages.about_subscribe') }}</button>
  </div>
</div>
</section>

<section class="team">
<h2>{{ __('messages.about_team_title') }}</h2>
<div class="team-grid">
  <div class="team-card">
    <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="">
    <h3>أحمد سامي</h3>
    <p>Front-End Expert، خبرة 8 سنوات، أكثر من 50 مشروع عملي ناجح.</p>
  </div>
  <div class="team-card">
    <img src="https://cdn-icons-png.flaticon.com/512/149/149072.png" alt="">
    <h3>خالد يوسف</h3>
    <p>Full Stack Developer، خبرة في Node.js, React, Databases، أكثر من 40 كورس.</p>
  </div>
  <div class="team-card">
    <img src="https://cdn-icons-png.flaticon.com/512/149/149073.png" alt="">
    <h3>منى جمال</h3>
    <p>Mobile App Specialist، خبرة في Flutter و React Native، تطوير تطبيقات عملية.</p>
  </div>
</div>
</section>
@endsection

@section('scripts')
<script>
const faders = document.querySelectorAll('.hero h1, .hero p, .mission .box, .stat-box, .courses h2, .course-card, .team h2, .team-card');
const appearOptions = {threshold:0.2, rootMargin:"0px 0px -50px 0px"};
const appearOnScroll = new IntersectionObserver(function(entries, observer){
  entries.forEach(entry=>{
    if(!entry.isIntersecting) return;
    entry.target.style.opacity='1';
    entry.target.style.transform='translateY(0)';
    observer.unobserve(entry.target);
  });
}, appearOptions);
faders.forEach(fader=>{appearOnScroll.observe(fader);});
</script>
@endsection
