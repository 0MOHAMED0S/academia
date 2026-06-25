@extends('layouts.main')

@section('title', __('messages.course_type_ai_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('main_pages_style/aicources.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
<div class="hero-content">
<div class="hero-text">
<h1>اصنع المستقبل مع دبلومة الذكاء الاصطناعي وعلوم البيانات</h1>
<p>انضم إلى الثورة التكنولوجية. تعلم كيف تحول البيانات الخام إلى قرارات ذكية، وابنِ نماذج تتعلم وتفكر وتتوقع المستقبل باستخدام أقوى خوارزميات الـ Machine Learning.</p>
<button class="bttn">{{ __('messages.book_seat_btn') }}</button>
</div>
<img src="https://cdn-icons-png.flaticon.com/512/2103/2103811.png" alt="AI Brain Icon">
</div>
</section>

<section>
<div class="container">
<div class="stats">
<div class="stat"><h3>300+</h3><p>{{ __('messages.course_type_training_hours') }}</p></div>
<div class="stat"><h3>12</h3><p>{{ __('messages.course_type_practical_projects') }}</p></div>
<div class="stat"><h3>Mastery</h3><p>{{ __('messages.course_type_from_scratch') }}</p></div>
<div class="stat"><h3>Premium</h3><p>{{ __('messages.course_type_expert_support') }}</p></div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_main_topics') }}</h2>
<div class="grid">
<div class="card"><i class="fas fa-chart-line"></i> تحليل البيانات الضخمة (Big Data Analysis)</div>
<div class="card"><i class="fas fa-robot"></i> تعلم الآلة (Machine Learning)</div>
<div class="card"><i class="fas fa-brain"></i> التعلم العميق (Deep Learning)</div>
<div class="card"><i class="fas fa-database"></i> هندسة البيانات و SQL / NoSQL</div>
<div class="card"><i class="fas fa-eye"></i> الرؤية الحاسوبية (Computer Vision)</div>
<div class="card"><i class="fas fa-comment-dots"></i> معالجة اللغات الطبيعية (NLP)</div>
</div>
</div>
</section>

<section style="background: #fff;">
<div class="container text-center">
<h2>{{ __('messages.course_type_tools') }}</h2>
<p style="margin-bottom: 35px;">ستتقن العمل على الأدوات التي تستخدمها Google و Meta و Amazon:</p>
<div class="tool-tag">Python (Pandas, NumPy)</div>
<div class="tool-tag">TensorFlow & PyTorch</div>
<div class="tool-tag">Scikit-Learn</div>
<div class="tool-tag">Matplotlib & Seaborn</div>
<div class="tool-tag">Jupyter Notebooks</div>
<div class="tool-tag">Power BI & Tableau</div>
<div class="tool-tag">Hadoop & Spark</div>
<div class="tool-tag">Keras</div>
</div>
</section>

<section id="content">
<div class="container">
<h2>{{ __('messages.course_type_roadmap') }}</h2>

<div class="accordion">
<div class="accordion-header">المرحلة الأولى: التأسيس البرمجي والرياضي <span>+</span></div>
<div class="accordion-content">
    * إتقان لغة Python للبيانات.<br>
    * الاحتمالات والإحصاء لعلوم البيانات.<br>
    * الجبر الخطي وحساب التفاضل للمبرمجين.
</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة الثانية: استكشاف ومعالجة البيانات <span>+</span></div>
<div class="accordion-content">
    * تنظيف البيانات (Data Cleaning).<br>
    * تصور البيانات (Data Visualization).<br>
    * استخراج الأنماط من البيانات غير المنظمة.
</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة الثالثة: احتراف الـ Machine Learning <span>+</span></div>
<div class="accordion-content">
    * خوارزميات التصنيف والتنبؤ (Regression & Classification).<br>
    * التعلم غير الخاضع للإشراف (Clustering).<br>
    * تقييم النماذج وتحسين الأداء.
</div>
</div>

<div class="accordion">
<div class="accordion-header">المرحلة الرابعة: التعلم العميق والذكاء التوليدي <span>+</span></div>
<div class="accordion-content">
    * الشبكات العصبية (Neural Networks).<br>
    * التعامل مع الصور والنصوص.<br>
    * مقدمة في LLMs و Generative AI.
</div>
</div>

</div>
</section>

<section class="youtube-section">
<div class="container">
<h2>{{ __('messages.course_type_best_resources') }}</h2>
<div class="grid">
    <div class="yt-card">
        <i class="fab fa-youtube"></i>
        <h4>Sentdex</h4>
        <p>المرجع الأول لتعلم الـ Machine Learning والبرمجة المتقدمة بباثيون.</p>
        <a href="#" class="yt-link">{{ __('messages.course_type_go_to_channel') }}</a>
    </div>
    <div class="yt-card">
        <i class="fab fa-youtube"></i>
        <h4>Hesham Asem</h4>
        <p>من أفضل القنوات العربية التي تشرح الذكاء الاصطناعي بشكل أكاديمي وعملي مذهل.</p>
        <a href="#" class="yt-link">{{ __('messages.course_type_go_to_channel') }}</a>
    </div>
    <div class="yt-card">
        <i class="fab fa-youtube"></i>
        <h4>Krish Naik</h4>
        <p>قناة شاملة تغطي مسارات علم البيانات من البداية وحتى التوظيف.</p>
        <a href="#" class="yt-link">{{ __('messages.course_type_go_to_channel') }}</a>
    </div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_projects_you_build') }}</h2>
<div class="grid">
    <div class="card">
        <h4>التنبؤ بأسعار الأسهم</h4>
        <p>بناء نموذج يتوقع اتجاهات السوق باستخدام البيانات التاريخية.</p>
    </div>
    <div class="card">
        <h4>نظام التعرف على الوجوه</h4>
        <p>تطبيق يستخدم Computer Vision لتمييز الأشخاص بدقة عالية.</p>
    </div>
    <div class="card">
        <h4>تحليل مشاعر العملاء</h4>
        <p>نظام يحلل آلاف التقييمات ويحدد هل هي إيجابية أم سلبية آلياً.</p>
    </div>
</div>
</div>
</section>

<section id="instructor" style="background: #fdfdfd;">
<div class="container">
<h2>{{ __('messages.course_type_instructor') }}</h2>
<div class="instructor">
<img src="https://cdn-icons-png.flaticon.com/512/1995/1995531.png" alt="AI Expert">
<div>
    <h3>د. أحمد سامي</h3>
    <p>باحث في مجال الذكاء الاصطناعي ومستشار بيانات لشركات دولية. حاصل على الدكتوراه في Machine Learning ولديه خبرة في تدريب أكثر من 10,000 طالب عبر الإنترنت.</p>
</div>
</div>
</div>
</section>

<section>
<div class="container">
<h2>{{ __('messages.course_type_faq') }}</h2>
<div class="accordion">
    <div class="accordion-header">هل يجب أن أكون عبقرياً في الرياضيات؟ <span>?</span></div>
    <div class="accordion-content">لا، نحن نشرح الرياضيات المطلوبة فقط للذكاء الاصطناعي بأسلوب مبسط وعملي بعيداً عن التعقيد الأكاديمي.</div>
</div>
<div class="accordion">
    <div class="accordion-header">ما هي فرص العمل المتاحة بعد الكورس؟ <span>?</span></div>
    <div class="accordion-content">يمكنك العمل كـ Data Scientist, ML Engineer, Data Analyst، أو AI Developer، وهي من أعلى الوظائف أجراً حالياً.</div>
</div>
</div>
</section>

<section class="cta">
<div class="container">
<h2>ابدأ عصرك الجديد مع الذكاء الاصطناعي</h2>
<p style="margin-bottom: 40px; color: #e2e8f0; font-size: 1.2rem;">المستقبل لا ينتظر، كن أنت من يصنعه.</p>
<a href="payment.html?course=دبلومة الذكاء الاصطناعي&price=3800" class="bttn" style="text-decoration:none">{{ __('messages.subscribe_btn') }}</a>
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
