@extends('layouts.main')

@section('title', __('messages.course_type_network_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('/main_pages_style/networkcources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>دبلومة هندسة الشبكات المتكاملة</h1>
<p>انطلق في مسارك المهني لتصبح مهندس شبكات محترف. نغطي كافة جوانب الـ Routing, Switching, Security و Cloud في مكان واحد.</p>
<button class="bttn">{{ __('messages.book_seat_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/2885/2885417.png" alt="Network Icon">
</div>
</section>


<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>220+</h3><p>{{ __('messages.course_type_stat_lessons') }}</p></div>
<div class="stat"><h3>50+</h3><p>{{ __('messages.course_type_stat_practical') }}</p></div>
<div class="stat"><h3>CCNA/CCNP</h3><p>تأهيل دولي</p></div>
<div class="stat"><h3>24/7</h3><p>{{ __('messages.course_type_stat_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_what_you_learn') }}</h2>
<div class="grid">
<div class="card"><i class="fas fa-network-wired"></i> بناء وإعداد الشبكات المحلية (LAN)</div>
<div class="card"><i class="fas fa-route"></i> بروتوكولات التوجيه (OSPF, BGP, EIGRP)</div>
<div class="card"><i class="fas fa-user-shield"></i> حماية الشبكات من الاختراق</div>
<div class="card"><i class="fas fa-project-diagram"></i> تقسيم الشبكات (IP Subnetting)</div>
<div class="card"><i class="fas fa-server"></i> التعامل مع خوادم Windows & Linux</div>
<div class="card"><i class="fas fa-satellite-dish"></i> تكنولوجيا الشبكات اللاسلكية والـ VPN</div>
</div>
</div>
</section>

<section style="background: #fff;">
<div class="container text-center">
<h2>{{ __('messages.course_type_environment_tools') }}</h2>
<p style="margin-bottom: 30px;">سوف تتعلم العمل على أشهر برامج المحاكاة والأنظمة العالمية:</p>
<div class="tool-tag">Cisco Packet Tracer</div>
<div class="tool-tag">GNS3</div>
<div class="tool-tag">EVE-NG</div>
<div class="tool-tag">Wireshark</div>
<div class="tool-tag">SecureCRT</div>
<div class="tool-tag">VMware Workstation</div>
<div class="tool-tag">Cisco IOS</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_type_study_plan') }}</h2>

<div class="accordion">
<div class="accordion-header">المرحلة الأولى: أساسيات تقنية المعلومات <span>+</span></div>
<div class="accordion-content">مقدمة في هاردوير الحاسب، أنظمة التشغيل، وكيفية عمل الإنترنت وبروتوكولات الـ IP.</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة الثانية: مسار Cisco CCNA 200-301 <span>+</span></div>
<div class="accordion-content">شرح مفصل للسويتشات، الروترات، الـ VLANs، والـ Static/Dynamic Routing.</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة الثالثة: أمن الشبكات (Network Security) <span>+</span></div>
<div class="accordion-content">التعامل مع الـ Access Lists، حماية الـ Ports، وتشفير البيانات عبر الـ VPN.</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة الرابعة: الأتمتة والبرمجة (Automation) <span>+</span></div>
<div class="accordion-content">كيفية إدارة الشبكات الكبيرة باستخدام Python و SDN (Software Defined Networking).</div>
</div>

</div>
</section>

<section class="youtube-section">
<div class="container">
<h2>{{ __('messages.course_type_free_resources') }}</h2>
<div class="grid">
    <div class="yt-card">
        <i class="fab fa-youtube"></i>
        <h4>NetworkSet</h4>
        <p>مرجع شامل باللغة العربية لشرح شهادات سيسكو وجونيبر.</p>
        <a href="#" class="yt-link">{{ __('messages.course_type_watch_now') }}</a>
    </div>
    <div class="yt-card">
        <i class="fab fa-youtube"></i>
        <h4>Jeremy's IT Lab</h4>
        <p>أفضل كورس CCNA أجنبي تفاعلي مع لابات Anki flashcards.</p>
        <a href="#" class="yt-link">{{ __('messages.course_type_watch_now') }}</a>
    </div>
    <div class="yt-card">
        <i class="fab fa-youtube"></i>
        <h4>Abdelrahman Shaheen</h4>
        <p>قناة المهندس عبدالرحمن شاهين لشرح لابات CCNP والشبكات بشكل عملي.</p>
        <a href="#" class="yt-link">{{ __('messages.course_type_watch_now') }}</a>
    </div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_certifications') }}</h2>
<div class="grid">
    <div class="card" style="text-align: center;">
        <img src="https://cdn-icons-png.flaticon.com/512/606/606553.png" width="50" style="margin:auto">
        <h4 class="mt-3">Cisco CCNA</h4>
    </div>
    <div class="card" style="text-align: center;">
        <img src="https://cdn-icons-png.flaticon.com/512/606/606553.png" width="50" style="margin:auto">
        <h4 class="mt-3">CompTIA Network+</h4>
    </div>
    <div class="card" style="text-align: center;">
        <img src="https://cdn-icons-png.flaticon.com/512/606/606553.png" width="50" style="margin:auto">
        <h4 class="mt-3">Juniper JNCIA</h4>
    </div>
</div>
</div>
</section>

<section id="instructor" style="background: #fdfdfd;">
<div class="container">
<h2>{{ __('messages.course_type_about_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/3135/3135715.png" alt="Instructor">
<div>
    <h3>م. ياسين محمد</h3>
    <p>كبير مهندسي الشبكات بخبرة 12 عاماً. حاصل على شهادات CCIE و CCNP Security. قام بتأسيس شبكات لأكثر من 20 شركة كبرى في الشرق الأوسط.</p>
</div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>
<div class="accordion">
    <div class="accordion-header">هل أحتاج لجهاز كمبيوتر قوي؟ <span>?</span></div>
    <div class="accordion-content">تحتاج جهازاً بذاكرة عشوائية (RAM) لا تقل عن 8 جيجا لتشغيل برامج المحاكاة مثل GNS3 بسلاسة.</div>
</div>
<div class="accordion">
    <div class="accordion-header">هل الكورس مناسب للمبتدئين؟ <span>?</span></div>
    <div class="accordion-content">نعم، نبدأ من الصفر تماماً حتى المفاهيم المتقدمة.</div>
</div>
</div>
</section>

<section class="cta">
<div class="container">
<h2>ابدأ رحلتك في عالم الشبكات اليوم!</h2>
<p style="margin-bottom: 30px; color: #eee;">انضم لأكثر من 1000 طالب وباشر بتطوير مهاراتك.</p>
<a href="payment.html?course=  دبلومه الشبكات&price=3000" class="bttn" style="text-decoration:none">{{ __('messages.subscribe_btn') }}</a>
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
