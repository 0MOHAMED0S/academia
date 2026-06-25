@extends('layouts.main')

@section('title', __('messages.course_type_game_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('/main_pages_style/gamecources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>احترف تطوير الألعاب 2D & 3D</h1>
<p>ابدأ رحلتك في صناعة الألعاب باستخدام Unity و C#. تعلم البرمجة، التصميم، والفيزياء لبناء ألعابك الخاصة ونشرها على جميع المنصات.</p>
<a href="#content" class="bttn">{{ __('messages.course_type_start_now') }}</a>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/686/686589.png" alt="Game Dev">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>250+</h3><p>{{ __('messages.course_type_training_hours') }}</p></div>
<div class="stat"><h3>10</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>C#</h3><p>لغة البرمجة</p></div>
<div class="stat"><h3>Unity</h3><p>محرك الألعاب</p></div>
</div>
</div>
</section>

<section style="background: #eef2f7;">
    <div class="container">
        <h2 style="text-align: center;">{{ __('messages.course_type_free_resources') }}</h2>
        <p style="text-align: center; margin-bottom: 40px;">قنوات نوصي بها لمتابعة أحدث دروس تطوير الألعاب</p>
        <div class="grid">
            <a href="https://www.youtube.com/@Brackeys" target="_blank" class="yt-card">
                <i class="fab fa-youtube"></i>
                <h4>Brackeys</h4>
                <p>القناة رقم 1 عالمياً لتعلم Unity وكل أساسيات تطوير الألعاب.</p>
                <span class="yt-link-text">{{ __('messages.course_type_visit_channel') }}</span>
            </a>
            <a href="https://www.youtube.com/@GameMakerToolkit" target="_blank" class="yt-card">
                <i class="fab fa-youtube"></i>
                <h4>GMTK</h4>
                <p>أفضل قناة تشرح فلسفة تصميم الألعاب (Game Design) وكيف تجعلها ممتعة.</p>
                <span class="yt-link-text">{{ __('messages.course_type_visit_channel') }}</span>
            </a>
            <a href="https://www.youtube.com/@UniqueCoding1" target="_blank" class="yt-card">
                <i class="fab fa-youtube"></i>
                <h4>Unique Coding</h4>
                <p>قناة عربية رائعة لشرح محرك Unity وبناء ألعاب كاملة باللغة العربية.</p>
                <span class="yt-link-text">{{ __('messages.course_type_visit_channel') }}</span>
            </a>
        </div>
    </div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_content') }}</h2>
<div class="accordion">
<div class="accordion-header">الوحدة 1: لغة C# ومفاهيم البرمجة <span>▼</span></div>
<div class="accordion-content">تعلم أساسيات البرمجة، المتغيرات، الدوال، وكيفية ربط الكود بقطع اللعبة.</div>
</div>
<div class="accordion">
<div class="accordion-header">الوحدة 2: بناء أول لعبة 2D <span>▼</span></div>
<div class="accordion-content">شرح الـ Sprites، الـ Physics 2D، والتحكم في القفز والحركة.</div>
</div>
<div class="accordion">
<div class="accordion-header">الوحدة 3: عالم الـ 3D والبيئة <span>▼</span></div>
<div class="accordion-content">التعامل مع الإضاءة، المواد (Materials)، وبناء مستويات ثلاثية الأبعاد.</div>
</div>
</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/3052/3052929.png" alt="Instructor">
<div>
    <h3>م. خالد الألعاب</h3>
    <p>مطور ألعاب مستقل بخبرة 7 سنوات، قام بنشر أكثر من 5 ألعاب على متجر Steam و Google Play.</p>
</div>
</div>
</div>
</section>

<section class="cta">
<h2>هل أنت مستعد لتكون Game Developer؟</h2>
<br>
<a href="payment.html?course=  دبلومه تطوير الالعاب&price=2500" class="bttn" style="text-decoration:none">{{ __('messages.subscribe_btn') }}</a>
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
