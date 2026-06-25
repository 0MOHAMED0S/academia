@extends('layouts.main')

@section('title', __('messages.course_type_mobile_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/mobilecources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس تطوير تطبيقات الموبايل الشامل</h1>
<p>تعلم بناء تطبيقات احترافية لنظامي Android و iOS باستخدام كود واحد. من أساسيات البرمجة حتى رفع تطبيقك على App Store و Google Play.</p>
<button class="bttn">{{ __('messages.course_type_start_now') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/2586/2586488.png" alt="Mobile App Icon">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>150+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>8</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>Cross-Platform</h3><p>Android & iOS</p></div>
<div class="stat"><h3>Lifetime</h3><p>{{ __('messages.course_type_stat_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card"><i class="fas fa-mobile-alt"></i> تصميم واجهات UI/UX جذابة</div>
<div class="card"><i class="fas fa-code"></i> لغة البرمجة (Dart / JavaScript)</div>
<div class="card"><i class="fas fa-database"></i> التعامل مع Firebase وقواعد البيانات</div>
<div class="card"><i class="fas fa-sync-alt"></i> إدارة الحالة (State Management)</div>
<div class="card"><i class="fas fa-cloud-download-alt"></i> التعامل مع الـ APIs والبيانات الخارجية</div>
<div class="card"><i class="fas fa-rocket"></i> رفع التطبيقات للمتاجر الرسمية</div>
</div>
</div>
</section>

<section style="background: #fff;">
<div class="container text-center">
<h2>{{ __('messages.course_type_environment_tools') }}</h2>
<p style="margin-bottom: 30px;">سنتدرب على أحدث الأدوات المستخدمة في كبرى شركات التكنولوجيا:</p>
<div class="tool-tag">Flutter SDK</div>
<div class="tool-tag">VS Code</div>
<div class="tool-tag">Android Studio</div>
<div class="tool-tag">Firebase</div>
<div class="tool-tag">Git & GitHub</div>
<div class="tool-tag">Figma</div>
<div class="tool-tag">Postman</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_type_study_plan') }}</h2>

<div class="accordion">
<div class="accordion-header">المرحلة الأولى: أساسيات البرمجة واللغة <span>+</span></div>
<div class="accordion-content">تعلم أساسيات لغة البرمجة المستخدمة، المتغيرات، الدوال، والبرمجة كائنية التوجه (OOP).</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة الثانية: بناء الواجهات (UI Design) <span>+</span></div>
<div class="accordion-content">كيفية بناء صفحات التطبيق، الأزرار، القوائم، وتنسيق الألوان والخطوط لتبدو كالتطبيقات العالمية.</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة الثالثة: الربط بالخوادم والبيانات <span>+</span></div>
<div class="accordion-content">شرح كيفية جلب البيانات من الإنترنت، التعامل مع الـ JSON، وتخزين البيانات محلياً.</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة الرابعة: الميزات المتقدمة <span>+</span></div>
<div class="accordion-content">استخدام الخرائط (Maps)، الإشعارات (Notifications)، والكاميرا داخل تطبيقك.</div>
</div>

</div>
</section>

<section class="youtube-section">
<div class="container">
<h2>{{ __('messages.course_type_free_resources') }}</h2>
<div class="grid">
    <div class="yt-card">
        <i class="fab fa-youtube"></i>
        <h4>The Net Ninja</h4>
        <p>من أفضل القنوات الأجنبية التي تشرح Flutter و React Native بأسلوب ممتع.</p>
        <a href="#" class="yt-link">{{ __('messages.course_type_watch_now') }}</a>
    </div>
    <div class="yt-card">
        <i class="fab fa-youtube"></i>
        <h4>Muhammed Issa</h4>
        <p>قناة عربية رائدة في شرح تطوير تطبيقات الاندرويد والـ Flutter بشكل مبسط.</p>
        <a href="#" class="yt-link">{{ __('messages.course_type_watch_now') }}</a>
    </div>
    <div class="yt-card">
        <i class="fab fa-youtube"></i>
        <h4>Wael Abo Hamza</h4>
        <p>متخصص في شرح الـ Flutter وبناء مشاريع كاملة وتطبيقات واقعية باللغة العربية.</p>
        <a href="#" class="yt-link">{{ __('messages.course_type_watch_now') }}</a>
    </div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_projects_you_build') }}</h2>
<div class="grid">
    <div class="card">
        <h4>تطبيق متجر إلكتروني</h4>
        <p>عرض المنتجات، سلة تسوق، وإتمام عملية الشراء.</p>
    </div>
    <div class="card">
        <h4>تطبيق محادثة (Chat App)</h4>
        <p>إرسال واستقبال الرسائل فوراً باستخدام Firebase.</p>
    </div>
    <div class="card">
        <h4>تطبيق أخبار عالمي</h4>
        <p>جلب الأخبار من API خارجي وتصنيفها حسب الدولة.</p>
    </div>
</div>
</div>
</section>

<section id="instructor" style="background: #fdfdfd;">
<div class="container">
<h2>{{ __('messages.course_type_about_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/4333/4333609.png" alt="Instructor">
<div>
    <h3>م. مصطفى محمود</h3>
    <p>مطور تطبيقات موبايل أول (Senior Mobile Developer) بخبرة 7 سنوات. قام بإطلاق أكثر من 30 تطبيقاً على المتاجر العالمية وعمل مع كبرى الشركات الناشئة.</p>
</div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>
<div class="accordion">
    <div class="accordion-header">هل أحتاج لتعلم لغتين مختلفتين لـ Android و iOS؟ <span>?</span></div>
    <div class="accordion-content">لا، في هذا الكورس نركز على تقنيات الـ Cross-platform التي تتيح لك كتابة كود واحد يعمل على النظامين.</div>
</div>
<div class="accordion">
    <div class="accordion-header">هل أحتاج لجهاز Mac لتطوير تطبيقات iPhone؟ <span>?</span></div>
    <div class="accordion-content">للبرمجة لا بأس بأي جهاز، ولكن لرفع التطبيق لمتجر Apple ستحتاج لجهاز Mac أو استخدام خدمات سحابية سنشرحها في الكورس.</div>
</div>
</div>
</section>

<section class="cta">
<div class="container">
<h2>ابدأ ببناء تطبيقك الأول اليوم!</h2>
<p style="margin-bottom: 30px; color: #eee;">انضم لأكثر من 3000 طالب وباشر في تحويل أفكارك إلى تطبيقات حقيقية.</p>
<a href="payment.html?course=  دبلومه تطبيقات الموبايل&price=2500" class="bttn" style="text-decoration:none">{{ __('messages.subscribe_btn') }}</a>
</div>
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
