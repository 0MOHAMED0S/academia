@extends('layouts.main')

@section('title', __('messages.articles_page_title'))

@section('styles')
<link rel="stylesheet" href="{{ asset('/main_pages_style/articals.css') }}">
<style>
    main { padding-top: 0 !important; }
</style>
@endsection

@section('content')
<section class="hero">
  <h1>{{ __('messages.articles_hero_title') }}</h1>
  <p>{{ __('messages.articles_hero_desc') }}</p>
</section>

<section class="articles">
<h2>{{ __('messages.articles_section_title') }}</h2>
<div class="articles-grid">

  <div class="article-card">
    <img src="https://cdn-icons-png.flaticon.com/512/919/919826.png" alt="HTML & CSS">
    <h3>HTML & CSS: دليلك الكامل لبناء موقع متكامل</h3>
    <p>تعلم أساسيات HTML & CSS بشكل عملي...</p>
    <button class="btn-read">{{ __('messages.articles_read_more') }}</button>
    <div class="overlay">
      <h3>HTML & CSS: المحتوى الكامل</h3>
      <p>في هذا المقال ستجد شرح كامل لكل عناصر HTML، القوالب، Layouts، Flexbox، Grid، تصميم المواقع المتجاوبة، تحسين تجربة المستخدم، أمثلة عملية، ونصائح احترافية.</p>
      <p>ستتعلم كيفية تنظيم الكود، استخدام الفواصل المناسبة، إضافة الألوان والخطوط، وتحسين تجربة المستخدم عبر عناصر تفاعلية. كما سنتطرق لأفضل الممارسات لبناء صفحات متجاوبة وتقديم مشاريع عملية صغيرة لتثبيت التعلم.</p>
      <button class="btn-read">{{ __('messages.articles_read_full') }}</button>
    </div>
  </div>

  <div class="article-card">
    <img src="https://cdn-icons-png.flaticon.com/512/919/919828.png" alt="JavaScript">
    <h3>JavaScript: البرمجة الديناميكية والتحكم في الصفحة</h3>
    <p>تعلم DOM، الأحداث، الوظائف، والمصفوفات والكائنات...</p>
    <button class="btn-read">{{ __('messages.articles_read_more') }}</button>
    <div class="overlay">
      <h3>JavaScript: المحتوى الكامل</h3>
      <p>ستتعلم كيفية التعامل مع الفورمات، التحقق من البيانات، إضافة التأثيرات والتفاعلات، ES6، الوعود Promises، Async/Await، وبناء مشاريع عملية لتطبيق المفاهيم.</p>
      <button class="btn-read">{{ __('messages.articles_read_full') }}</button>
    </div>
  </div>

  <div class="article-card">
    <img src="https://cdn-icons-png.flaticon.com/512/919/919831.png" alt="React">
    <h3>React: بناء واجهات المستخدم الحديثة</h3>
    <p>اكتشف قوة مكتبة React في تطوير تطبيقات الويب...</p>
    <button class="btn-read">{{ __('messages.articles_read_more') }}</button>
    <div class="overlay">
      <h3>React: المحتوى الكامل</h3>
      <p>تتعلم المكونات Components، الحالة State، الخصائص Props، الأحداث، Hooks، Context API، وربط الواجهات مع APIs. كل شيء مع أمثلة عملية لتسهيل التعلم وتطبيق المفاهيم.</p>
      <button class="btn-read">{{ __('messages.articles_read_full') }}</button>
    </div>
  </div>

</div>
</section>

<section class="categories">
<h2>{{ __('messages.articles_categories') }}</h2>
<div class="category-grid">
  <div class="category-card">
    <h3>{{ __('messages.articles_frontend') }}</h3>
    <p>{{ __('messages.articles_frontend_desc') }}</p>
  </div>
  <div class="category-card">
    <h3>{{ __('messages.articles_backend') }}</h3>
    <p>{{ __('messages.articles_backend_desc') }}</p>
  </div>
  <div class="category-card">
    <h3>{{ __('messages.articles_mobile') }}</h3>
    <p>{{ __('messages.articles_mobile_desc') }}</p>
  </div>
  <div class="category-card">
    <h3>{{ __('messages.articles_ai') }}</h3>
    <p>{{ __('messages.articles_ai_desc') }}</p>
  </div>
</div>
</section>

<section class="popular">
<h2>{{ __('messages.articles_popular') }}</h2>
<div class="popular-grid">
  <div class="popular-card">
    <h3>أفضل ممارسات تصميم المواقع المتجاوبة</h3>
    <p>تعلّم كيفية بناء مواقع تعمل بشكل مثالي على كل الشاشات والأجهزة، استراتيجيات Flexbox و Grid، وأمثلة عملية لتطبيق كل ما تعلمته.</p>
  </div>
  <div class="popular-card">
    <h3>كيف تبدأ رحلة البرمجة بلغة بايثون</h3>
    <p>دليل شامل لكل مبتدئ، من أساسيات Python إلى مشاريع عملية، مع نصائح لتعلم البرمجة بشكل أسرع وأكثر فاعلية.</p>
  </div>
</div>
</section>

<section class="subscribe">
<h2>{{ __('messages.articles_subscribe_title') }}</h2>
<p>{{ __('messages.articles_subscribe_desc') }}</p>
<input type="email" placeholder="{{ __('messages.articles_email_placeholder') }}">
<button>{{ __('messages.articles_subscribe_btn') }}</button>
</section>
@endsection

@section('scripts')
<script>
const faders = document.querySelectorAll('.hero h1, .hero p, .articles h2, .article-card, .categories h2, .category-card, .popular h2, .popular-card, .subscribe h2, .subscribe p');
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
