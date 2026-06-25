@extends('layouts.main')

@section('title', __('messages.course_type_fullstack_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/fullstackcources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>دبلومة Full Stack Web Developer</h1>
<p>انطلق من الصفر إلى الاحتراف في عالم تطوير الويب. تعلم بناء الواجهات الأمامية (Frontend) والأنظمة الخلفية (Backend) وقواعد البيانات في مسار واحد متكامل.</p>
<a href="#content" class="bttn">{{ __('messages.course_type_explore_content') }}</a>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/2721/2721620.png" alt="Full Stack Dev">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>250+</h3><p>{{ __('messages.course_type_training_hours') }}</p></div>
<div class="stat"><h3>15</h3><p>{{ __('messages.course_type_practical_projects') }}</p></div>
<div class="stat"><h3>3</h3><p>شهادات معتمدة</p></div>
<div class="stat"><h3>24/7</h3><p>متابعة وتوجيه</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>التقنيات التي ستتقنها</h2>
<div class="grid">
<div class="card"><i class="fab fa-html5 text-danger"></i> HTML5 & CSS3 (Flexbox/Grid)</div>
<div class="card"><i class="fab fa-js text-warning"></i> JavaScript (ES6+)</div>
<div class="card"><i class="fab fa-react text-info"></i> React.js Library</div>
<div class="card"><i class="fab fa-node-js text-success"></i> Node.js & Express</div>
<div class="card"><i class="fas fa-database text-primary"></i> MongoDB & SQL</div>
<div class="card"><i class="fab fa-git-alt"></i> Git & GitHub</div>
</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_type_diploma_detail') }}</h2>

<div class="accordion">
<div class="accordion-header">المرحلة 1: أساسيات تصميم الويب (Frontend Foundations) <span>+</span></div>
<div class="accordion-content">
    <ul>
        <li>هيكلة الصفحات باستخدام HTML5.</li>
        <li>التنسيق المتقدم بـ CSS3 و CSS Variables.</li>
        <li>تصميم صفحات متجاوبة (Responsive Design).</li>
        <li>مقدمة في Bootstrap 5 و Tailwind CSS.</li>
    </ul>
</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة 2: لغة العصر JavaScript <span>+</span></div>
<div class="accordion-content">
    <ul>
        <li>أساسيات البرمجة (Variables, Loops, Functions).</li>
        <li>التعامل مع الـ DOM.</li>
        <li>مفاهيم الـ ES6 (Arrow Functions, Destructuring).</li>
        <li>البرمجة غير المتزامنة Async/Await & Fetch API.</li>
    </ul>
</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة 3: بناء الواجهات بـ React.js <span>+</span></div>
<div class="accordion-content">
    <ul>
        <li>مفهوم الـ Components و Props.</li>
        <li>إدارة الحالة باستخدام Hooks (useState, useEffect).</li>
        <li>التعامل مع الـ Global State (Context API / Redux).</li>
        <li>إنشاء تطبيقات Single Page Application (SPA).</li>
    </ul>
</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة 4: تطوير الـ Backend بـ Node.js <span>+</span></div>
<div class="accordion-content">
    <ul>
        <li>بيئة العمل Node.js و NPM.</li>
        <li>بناء سيرفر متكامل بـ Express.js.</li>
        <li>تصميم وبناء الـ RESTful APIs.</li>
        <li>نظام المصادقة وتشفير البيانات (JWT & Bcrypt).</li>
    </ul>
</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة 5: قواعد البيانات ونشر المشروع <span>+</span></div>
<div class="accordion-content">
    <ul>
        <li>التعامل مع MongoDB و Mongoose.</li>
        <li>ربط الـ Frontend بالـ Backend.</li>
        <li>رفع المشاريع على Heroku, Netlify, و Vercel.</li>
    </ul>
</div>
</div>

</div>
</section>

<section style="background: #f0f2f5;">
    <div class="container">
        <h2>{{ __('messages.course_type_best_resources') }}</h2>
        <p style="text-align: center; margin-bottom: 40px;">رشحنا لك أفضل القنوات للبدء مجاناً كدعم إضافي</p>
        <div class="grid">
            <div class="youtube-card">
                <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="youtube">
                <h4>Elzero Web School</h4>
                <p>أقوى مرجع عربي لتعلم أساسيات الويب و JavaScript.</p>
                <a href="https://www.youtube.com/@ElzeroWebSchool" target="_blank" class="youtube-link">{{ __('messages.course_type_visit_channel') }}</a>
            </div>
            <div class="youtube-card">
                <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="youtube">
                <h4>Unique Coderz Academy</h4>
                <p>شرح مميز جداً لـ React و Node.js ومشاريع كاملة.</p>
                <a href="https://www.youtube.com/@UniqueCoderzAcademy" target="_blank" class="youtube-link">{{ __('messages.course_type_visit_channel') }}</a>
            </div>
            <div class="youtube-card">
                <img src="https://cdn-icons-png.flaticon.com/512/1384/1384060.png" alt="youtube">
                <h4>Nour Homsi</h4>
                <p>متخصص في شرح الـ Full Stack ومفاهيم البرمجة المتقدمة.</p>
                <a href="https://www.youtube.com/@NourHomsi" target="_blank" class="youtube-link">{{ __('messages.course_type_visit_channel') }}</a>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container">
        <h2>{{ __('messages.course_type_projects_you_build') }}</h2>
        <div class="grid">
            <div class="card">
                <h4 style="color:#0d6efd">1. متجر إلكتروني متكامل</h4>
                <p>بناء متجر يحتوي على سلة تسوق، نظام دفع، ولوحة تحكم للمدير.</p>
            </div>
            <div class="card">
                <h4 style="color:#0d6efd">2. منصة تواصل اجتماعي</h4>
                <p>تطبيق يتيح للمستخدمين إضافة منشورات، تعليقات، ومتابعة الأصدقاء.</p>
            </div>
            <div class="card">
                <h4 style="color:#0d6efd">3. نظام إدارة مهام (Task Manager)</h4>
                <p>تطبيق لتنظيم الوقت مع ربطه بقاعدة بيانات حية لتخزين المهام.</p>
            </div>
        </div>
    </div>
</section>

<section id="instructor">
<div class="container">
<h2>{{ __('messages.course_type_instructors') }}</h2>
<div class="instructor-box">
<img src="https://cdn-icons-png.flaticon.com/512/6009/6009034.png" alt="Instructor">
<div>
    <h3>أحمد خالد & فريق الأكاديمية</h3>
    <p>خبراء في تطوير الويب بخبرة تزيد عن 8 سنوات في شركات عالمية. هدفنا ليس فقط تعليمك الكود، بل تعليمك كيف تفكر كمهندس برمجيات محترف.</p>
</div>
</div>
</div>
</section>

<section style="background: #e9ecef;">
<div class="container">
<h2>{{ __('messages.course_type_success_stories') }}</h2>
<div class="grid">
<div class="testimonial card">"بفضل هذه الدبلومة، حصلت على أول وظيفة لي كـ Frontend Developer بعد 6 أشهر فقط." <br><strong>- سارة محمد</strong></div>
<div class="testimonial card">"المشاريع العملية في الكورس هي التي صنعت الفرق في الـ Portfolio الخاص بي." <br><strong>- عمر حسن</strong></div>
</div>
</div>
</section>

<section class="cta">
<div class="container">
<h2>جاهز لتصبح Full Stack Developer محترف؟</h2>
<p style="color: #fff; margin-bottom: 30px;">انضم لأكثر من 5000 طالب بدأوا رحلتهم معنا اليوم.</p>
<a href="payment.html?course=  دبلومه full stak&price=3000" class="bttn" style="text-decoration:none">{{ __('messages.subscribe_btn') }}</a>
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
