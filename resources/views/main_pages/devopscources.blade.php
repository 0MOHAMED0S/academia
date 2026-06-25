@extends('layouts.main')

@section('title', __('messages.course_type_devops_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/devopscources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>كورس DevOps Engineer الشامل</h1>
<p>أغلق الفجوة بين التطوير والعمليات. تعلم أتمتة الأنظمة، إدارة الحاويات (Containers)، وبناء أنابيب الـ CI/CD باستخدام أقوى الأدوات العالمية.</p>
<a href="#content" class="bttn">{{ __('messages.course_type_start_now') }}</a>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/5115/5115293.png" alt="DevOps Logo">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>280+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>20</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>Cloud</h3><p>AWS & Azure</p></div>
<div class="stat"><h3>Infinity</h3><p>أتمتة كاملة</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card">إدارة أنظمة Linux الاحترافية</div>
<div class="card">أتمتة البنية التحتية (Terraform)</div>
<div class="card">تقنيات الحاويات (Docker & K8s)</div>
<div class="card">أنابيب النشر المستمر (Jenkins)</div>
<div class="card">إدارة الإعدادات (Ansible)</div>
<div class="card">المراقبة والتحليل (Prometheus)</div>
<div class="card">خدمات السحابة (AWS Services)</div>
<div class="card">التعامل مع Git & GitHub Actions</div>
<div class="card">أمن العمليات (DevSecOps)</div>
</div>
</div>
</section>

<section style="background: #eef2f7;">
    <div class="container">
        <h2 style="text-align: center;">{{ __('messages.course_type_free_resources') }}</h2>
        <div class="grid">
            <a href="https://www.youtube.com/@TechWorldwithNana" target="_blank" class="yt-card">
                <i class="fab fa-youtube"></i>
                <h4>TechWorld with Nana</h4>
                <p>أفضل قناة تشرح Docker, Kubernetes و CI/CD بأسلوب بصري مذهل.</p>
                <span class="yt-link-text">{{ __('messages.course_type_visit_channel') }}</span>
            </a>
            <a href="https://www.youtube.com/@TheAbdelrahman" target="_blank" class="yt-card">
                <i class="fab fa-youtube"></i>
                <h4>The Abdelrahman</h4>
                <p>قناة عربية رائدة في شرح الـ DevOps والـ Cloud بشكل عملي ومبسط.</p>
                <span class="yt-link-text">{{ __('messages.course_type_visit_channel') }}</span>
            </a>
            <a href="https://www.youtube.com/@KunalsKushwaha" target="_blank" class="yt-card">
                <i class="fab fa-youtube"></i>
                <h4>Kunal Kushwaha</h4>
                <p>دروس شاملة في الـ Open Source ومفاهيم الـ DevOps الأساسية.</p>
                <span class="yt-link-text">{{ __('messages.course_type_visit_channel') }}</span>
            </a>
        </div>
    </div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_type_diploma_curriculum') }}</h2>
<div class="accordion">
<div class="accordion-header">الوحدة 1: الأساسيات و Linux Administration <span>▼</span></div>
<div class="accordion-content">تعلم التعامل مع الـ Terminal، إدارة الصلاحيات، وكتابة Bash Scripts.</div>
</div>
<div class="accordion">
<div class="accordion-header">الوحدة 2: الحاويات والبيئات المعزولة (Docker) <span>▼</span></div>
<div class="accordion-content">بناء الصور (Images)، إدارة الـ Volumes، والـ Docker Compose.</div>
</div>
<div class="accordion">
<div class="accordion-header">الوحدة 3: الأتمتة والـ CI/CD Pipelines <span>▼</span></div>
<div class="accordion-content">بناء دورة حياة كاملة للتطبيق من الكود وحتى النشر باستخدام Jenkins و GitHub Actions.</div>
</div>
<div class="accordion">
<div class="accordion-header">الوحدة 4: إدارة الأوركسترا (Kubernetes) <span>▼</span></div>
<div class="accordion-content">إدارة تطبيقات الـ Microservices على نطاق واسع وتوزيع الأحمال.</div>
</div>
</div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Instructor">
<div>
    <h3>م. محمد سليم</h3>
    <p>خبير DevOps و SRE عمل في كبرى الشركات التقنية العالمية، متخصص في حلول السحابة وأتمتة الأنظمة المعقدة.</p>
</div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>
<div class="accordion">
<div class="accordion-header">هل الكورس يتطلب خلفية برمجية؟ <span>▼</span></div>
<div class="accordion-content">يفضل معرفة بأساسيات البرمجة (مثل Python أو Bash)، ولكننا نبدأ من الأساسيات التقنية.</div>
</div>
<div class="accordion">
<div class="accordion-header">ما هو أهم أداة سنتعلمها؟ <span>▼</span></div>
<div class="accordion-content">سنركز بشكل كبير على Docker و Kubernetes لأنهما عصب الـ DevOps في الوقت الحالي.</div>
</div>
</div>
</section>

<section class="cta">
<h2>كن المهندس الذي تبحث عنه الشركات الكبرى</h2>
<br>
<a href="payment.html?course=  دبلومه DevOps&price=2000" class="bttn" style="text-decoration:none">{{ __('messages.subscribe_btn') }}</a>
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
