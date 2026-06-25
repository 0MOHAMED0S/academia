

// ====== Track Setup ======
const params = new URLSearchParams(window.location.search);
const track = params.get("track") || "frontend";

const trackNames = {
  frontend: "Front-End Exam / اختبار فرونت اند",
  backend: "Back-End Exam / اختبار باك اند",
  fullstack: "Full-Stack Exam / اختبار فل ستاك",
  mobile: "Mobile Dev Exam / اختبار الموبايل",
  network: "Network Exam / اختبار الشبكات",
  data: "Data Analysis Exam / اختبار تحليل البيانات",
  cyber: "Cyber Security Exam / اختبار الأمن السيبراني",
  ai: "AI & ML Exam / اختبار الذكاء الاصطناعي"
};

document.getElementById("examTitle").innerText = trackNames[track] || "Exam";

// ====== Questions ======
// كل تراك 20 سؤال
const questions = {

  frontend: [
  {q:"ما هو HTML؟ / What is HTML?", options:["لغة برمجة / Programming","CSS","JavaScript","لغة ترميز / Markup Language"], answer:"لغة ترميز / Markup Language"},
  {q:"ما هو CSS؟ / What is CSS?", options:["تصميم الواجهة / Styling","JavaScript","SQL","HTML"], answer:"تصميم الواجهة / Styling"},
  {q:"ما هو JavaScript؟ / What is JavaScript?", options:["CSS","HTML","SQL","لغة برمجة تفاعلية / Interactive Programming"], answer:"لغة برمجة تفاعلية / Interactive Programming"},
  {q:"ما هو العنصر <p> في HTML؟ / What is <p> element in HTML?", options:["رابط / Link","صورة / Image","فقرة / Paragraph","زر / Button"], answer:"فقرة / Paragraph"},
  {q:"ما هي الوسوم في HTML؟ / What are tags in HTML?", options:["وظائف JS / JS Functions","أنماط CSS / CSS Styles","أحداث / Events","عناصر الصفحة / Page Elements"], answer:"عناصر الصفحة / Page Elements"},
  {q:"ما هو DOM؟ / What is DOM?", options:["CSS","JavaScript","Database","تمثيل الصفحة / Page Representation"], answer:"تمثيل الصفحة / Page Representation"},
  {q:"ما الفرق بين id و class؟ / Difference between id & class?", options:["id يكرر و class لا","id متغير و class ثابت","id فريد و class يمكن تكراره / id unique & class reusable","لا يوجد فرق / No difference"], answer:"id فريد و class يمكن تكراره / id unique & class reusable"},
  {q:"ما هو Selector في CSS؟ / What is Selector in CSS?", options:["HTML","JS","اختيار عناصر / Element Selector","Database"], answer:"اختيار عناصر / Element Selector"},
  {q:"ما هو Flexbox؟ / What is Flexbox?", options:["HTML","JS","Database","تنسيق العناصر بشكل مرن / Flexible layout"], answer:"تنسيق العناصر بشكل مرن / Flexible layout"},
  {q:"ما هو Grid في CSS؟ / What is Grid in CSS?", options:["HTML","Database","JS","تنسيق شبكي / Grid Layout"], answer:"تنسيق شبكي / Grid Layout"},
  {q:"ما الفرق بين let و var في JS؟ / Difference between let & var in JS?", options:["let يكرر و var لا","لا فرق / No difference","let متغير ثابت و var متغير قابل للتغيير","let نطاق الكتلة، var نطاق الدالة / block vs function scope"], answer:"let نطاق الكتلة، var نطاق الدالة / block vs function scope"},
  {q:"ما هو Event في JS؟ / What is Event in JS?", options:["CSS","HTML","Database","حدث تفاعل المستخدم / User Action"], answer:"حدث تفاعل المستخدم / User Action"},
  {q:"ما هو Function في JS؟ / What is Function in JS?", options:["HTML","CSS","Database","دالة / Function"], answer:"دالة / Function"},
  {q:"ما هو Array في JS؟ / What is Array in JS?", options:["Object","Function","CSS","مصفوفة / Array"], answer:"مصفوفة / Array"},
  {q:"ما هو Object في JS؟ / What is Object in JS?", options:["Array","Function","CSS","كائن / Object"], answer:"كائن / Object"},
  {q:"ما هو AJAX؟ / What is AJAX?", options:["CSS","HTML","Database","تحديث جزئي للصفحة / Partial Page Update"], answer:"تحديث جزئي للصفحة / Partial Page Update"},
  {q:"ما هو JSON؟ / What is JSON?", options:["HTML","CSS","JS","تنسيق بيانات / Data Format"], answer:"تنسيق بيانات / Data Format"},
  {q:"ما هو LocalStorage؟ / What is LocalStorage?", options:["Database","JS","CSS","تخزين بيانات محلي / Local Storage"], answer:"تخزين بيانات محلي / Local Storage"},
  {q:"ما هو SessionStorage؟ / What is SessionStorage?", options:["Database","JS","CSS","تخزين بيانات الجلسة / Session Storage"], answer:"تخزين بيانات الجلسة / Session Storage"},
  {q:"ما الفرق بين == و === في JS؟ / Difference between == & === in JS?", options:["== مقارنة بالقيمة فقط، === مقارنة بالقيمة والنوع / value vs value+type","== تغيير CSS، === تغيير HTML","== مقارنة بالنوع فقط، === مقارنة بالقيمة","لا فرق / No difference"], answer:"== مقارنة بالقيمة فقط، === مقارنة بالقيمة والنوع / value vs value+type"}
],

 backend :[
  {q:"ما هو Server؟ / What is a Server?", options:["متصفح / Browser","حاسوب يخدم الشبكة / Computer serving network","HTML","CSS"], answer:"حاسوب يخدم الشبكة / Computer serving network"},
  {q:"ما هو Database؟ / What is Database?", options:["CSS","JS","قاعدة بيانات / Data Storage","HTML"], answer:"قاعدة بيانات / Data Storage"},
  {q:"ما هو API؟ / What is API?", options:["JS","HTML","واجهة برمجية / Application Interface","CSS"], answer:"واجهة برمجية / Application Interface"},
  {q:"ما هو HTTP؟ / What is HTTP?", options:["CSS","بروتوكول الشبكة / Network Protocol","Database","JS"], answer:"بروتوكول الشبكة / Network Protocol"},
  {q:"ما هو HTTPS؟ / What is HTTPS?", options:["HTTP","نسخة آمنة من HTTP / Secure Version of HTTP","JS","Database"], answer:"نسخة آمنة من HTTP / Secure Version of HTTP"},
  {q:"ما الفرق بين GET و POST؟ / Difference between GET & POST?", options:["GET لطلب البيانات، POST لإرسال البيانات / GET for request, POST for sending data","GET تعديل و POST حذف","GET لإرسال البيانات، POST لطلب البيانات","لا فرق / No difference"], answer:"GET لطلب البيانات، POST لإرسال البيانات / GET for request, POST for sending data"},
  {q:"ما هو REST؟ / What is REST?", options:["HTML","JS","نمط تصميم API / API Design Pattern","CSS"], answer:"نمط تصميم API / API Design Pattern"},
  {q:"ما هو CRUD؟ / What is CRUD?", options:["JS","CSS","إنشاء، قراءة، تحديث، حذف / Create, Read, Update, Delete","HTML"], answer:"إنشاء، قراءة، تحديث، حذف / Create, Read, Update, Delete"},
  {q:"ما هو Session؟ / What is Session?", options:["جلسة المستخدم / User Session","HTML","JS","CSS"], answer:"جلسة المستخدم / User Session"},
  {q:"ما هو Cookie؟ / What is Cookie?", options:["CSS","ملف صغير يخزن بيانات / Small file to store data","JS","HTML"], answer:"ملف صغير يخزن بيانات / Small file to store data"},
  {q:"ما هو SQL Injection؟ / What is SQL Injection?", options:["HTML","JS","هجوم على قاعدة البيانات / Database Attack","CSS"], answer:"هجوم على قاعدة البيانات / Database Attack"},
  {q:"ما هو ORM؟ / What is ORM?", options:["CSS","HTML","JS","ربط الكائنات بقاعدة البيانات / Object-Relational Mapping"], answer:"ربط الكائنات بقاعدة البيانات / Object-Relational Mapping"},
  {q:"ما هو Middleware؟ / What is Middleware?", options:["CSS","برنامج وسيط / Software Layer","HTML","JS"], answer:"برنامج وسيط / Software Layer"},
  {q:"ما هو JWT؟ / What is JWT?", options:["JS","CSS","HTML","رمز JSON Web Token للمصادقة / JSON Web Token for Authentication"], answer:"رمز JSON Web Token للمصادقة / JSON Web Token for Authentication"},
  {q:"ما الفرق بين SQL و NoSQL؟ / Difference between SQL & NoSQL?", options:["SQL علاقية و NoSQL غير علاقية / Relational vs Non-Relational","SQL أسرع / Faster","NoSQL فقط تخزين / Storage only","لا فرق / No difference"], answer:"SQL علاقية و NoSQL غير علاقية / Relational vs Non-Relational"},
  {q:"ما هو Load Balancer؟ / What is Load Balancer?", options:["HTML","JS","CSS","موزع الحمل بين الخوادم / Distributes load across servers"], answer:"موزع الحمل بين الخوادم / Distributes load across servers"},
  {q:"ما هو Caching؟ / What is Caching?", options:["تخزين مؤقت لتحسين الأداء / Temporary storage for performance","JS","HTML","CSS"], answer:"تخزين مؤقت لتحسين الأداء / Temporary storage for performance"},
  {q:"ما هو WebSocket؟ / What is WebSocket?", options:["اتصال ثنائي الاتجاه بين العميل والخادم / Bi-directional connection","CSS","HTML","JS"], answer:"اتصال ثنائي الاتجاه بين العميل والخادم / Bi-directional connection"},
  {q:"ما هو API Rate Limiting؟ / What is API Rate Limiting?", options:["HTML","JS","تحديد عدد الطلبات المسموح بها / Limit request rate","CSS"], answer:"تحديد عدد الطلبات المسموح بها / Limit request rate"},
  {q:"ما هو Serverless؟ / What is Serverless?", options:["JS","HTML","CSS","تنفيذ بدون خادم / Execution without server"], answer:"تنفيذ بدون خادم / Execution without server"}
],

 fullstack : [
  {q:"ما هو Full-Stack Development؟ / What is Full-Stack Development?", options:["تطوير السيرفر فقط / Back-End only","تصميم قواعد البيانات فقط / Database Design only","تطوير الواجهة والخادم / Front-End + Back-End","تطوير الواجهة فقط / Front-End only"], answer:"تطوير الواجهة والخادم / Front-End + Back-End"},
  {q:"ما هو MVC؟ / What is MVC?", options:["خادم / Server","نمط تصميم / Design Pattern","متصفح / Browser","لغة برمجة / Programming Language"], answer:"نمط تصميم / Design Pattern"},
  {q:"ما الفرق بين Front-End و Back-End؟ / Difference between Front-End & Back-End?", options:["HTML و CSS","الواجهة و الخادم / UI & Server","JS فقط","SQL و NoSQL"], answer:"الواجهة و الخادم / UI & Server"},
  {q:"ما هو Node.js؟ / What is Node.js?", options:["خادم JS / JS Server","CSS","HTML","SQL"], answer:"خادم JS / JS Server"},
  {q:"ما هو Express.js؟ / What is Express.js?", options:["إطار عمل Node / Node Framework","HTML","CSS","JS فقط"], answer:"إطار عمل Node / Node Framework"},
  {q:"ما هو REST API؟ / What is REST API?", options:["واجهة برمجية / API Interface","CSS","JS","HTML"], answer:"واجهة برمجية / API Interface"},
  {q:"ما هو CRUD في Full-Stack؟ / What is CRUD in Full-Stack?", options:["CSS","HTML","إنشاء، قراءة، تحديث، حذف / Create, Read, Update, Delete","JS"], answer:"إنشاء، قراءة، تحديث، حذف / Create, Read, Update, Delete"},
  {q:"ما هو Session؟ / What is Session?", options:["HTML","CSS","جلسة المستخدم / User Session","JS"], answer:"جلسة المستخدم / User Session"},
  {q:"ما هو Cookie؟ / What is Cookie?", options:["ملف صغير يخزن بيانات / Small file to store data","JS","HTML","CSS"], answer:"ملف صغير يخزن بيانات / Small file to store data"},
  {q:"ما الفرق بين SQL و NoSQL؟ / Difference between SQL & NoSQL?", options:["NoSQL فقط تخزين / Storage only","SQL علاقية و NoSQL غير علاقية / Relational vs Non-Relational","لا فرق / No difference","SQL أسرع / Faster"], answer:"SQL علاقية و NoSQL غير علاقية / Relational vs Non-Relational"},
  {q:"ما هو JWT؟ / What is JWT?", options:["JS","رمز JSON Web Token للمصادقة / JSON Web Token for Authentication","HTML","CSS"], answer:"رمز JSON Web Token للمصادقة / JSON Web Token for Authentication"},
  {q:"ما هو Middleware؟ / What is Middleware?", options:["HTML","برنامج وسيط / Software Layer","CSS","JS"], answer:"برنامج وسيط / Software Layer"},
  {q:"ما هو ORM؟ / What is ORM?", options:["CSS","HTML","ربط الكائنات بقاعدة البيانات / Object-Relational Mapping","JS"], answer:"ربط الكائنات بقاعدة البيانات / Object-Relational Mapping"},
  {q:"ما هو SQL Injection؟ / What is SQL Injection?", options:["هجوم على قاعدة البيانات / Database Attack","JS","HTML","CSS"], answer:"هجوم على قاعدة البيانات / Database Attack"},
  {q:"ما هو Load Balancer؟ / What is Load Balancer?", options:["JS","HTML","موزع الحمل بين الخوادم / Distributes load across servers","CSS"], answer:"موزع الحمل بين الخوادم / Distributes load across servers"},
  {q:"ما هو WebSocket؟ / What is WebSocket?", options:["اتصال ثنائي الاتجاه بين العميل والخادم / Bi-directional connection","JS","HTML","CSS"], answer:"اتصال ثنائي الاتجاه بين العميل والخادم / Bi-directional connection"},
  {q:"ما هو API Rate Limiting؟ / What is API Rate Limiting?", options:["HTML","تحديد عدد الطلبات المسموح بها / Limit request rate","JS","CSS"], answer:"تحديد عدد الطلبات المسموح بها / Limit request rate"},
  {q:"ما هو Serverless؟ / What is Serverless?", options:["JS","تنفيذ بدون خادم / Execution without server","HTML","CSS"], answer:"تنفيذ بدون خادم / Execution without server"},
  {q:"ما هو Caching؟ / What is Caching?", options:["تخزين مؤقت لتحسين الأداء / Temporary storage for performance","JS","HTML","CSS"], answer:"تخزين مؤقت لتحسين الأداء / Temporary storage for performance"},
  {q:"ما هو Deployment؟ / What is Deployment?", options:["CSS","نشر التطبيق على السيرفر / Deploy App to Server","HTML","JS"], answer:"نشر التطبيق على السيرفر / Deploy App to Server"}
],
mobile : [
  {q:"ما هو Android؟ / What is Android?", options:["نظام تشغيل للهواتف / Mobile OS","تطوير تطبيقات iOS / iOS Development","إطار عمل Flutter / Flutter Framework","واجهة برمجة التطبيقات / Mobile API"], answer:"نظام تشغيل للهواتف / Mobile OS"},
  {q:"ما هو iOS؟ / What is iOS?", options:["تطوير تطبيقات Android / Android Development","نظام تشغيل للآيفون / iPhone OS","إطار عمل React Native / React Native Framework","محاكي الهاتف / Phone Emulator"], answer:"نظام تشغيل للآيفون / iPhone OS"},
  {q:"ما هو Flutter؟ / What is Flutter?", options:["إطار عمل لتطوير التطبيقات / App Development Framework","نظام تشغيل iOS / iOS OS","تطوير الويب / Web Development","واجهة المستخدم Native / Native UI"], answer:"إطار عمل لتطوير التطبيقات / App Development Framework"},
  {q:"ما هو React Native؟ / What is React Native?", options:["تطوير تطبيقات الجوال / Mobile App Development","نظام Android / Android OS","محاكي الهاتف / Phone Emulator","إطار عمل Flutter / Flutter Framework"], answer:"تطوير تطبيقات الجوال / Mobile App Development"},
  {q:"ما الفرق بين Native و Cross-Platform؟ / Difference between Native & Cross-Platform?", options:["Native للتطبيقات الأصلية، Cross عبر منصات متعددة / Native original, Cross multi-platform","Native فقط iOS","Cross فقط Android","Native Frameworks فقط"], answer:"Native للتطبيقات الأصلية، Cross عبر منصات متعددة / Native original, Cross multi-platform"},
  {q:"ما هو SDK؟ / What is SDK?", options:["مجموعة أدوات لتطوير التطبيقات / Software Development Kit","JS Framework","HTML Template","CSS Style"], answer:"مجموعة أدوات لتطوير التطبيقات / Software Development Kit"},
  {q:"ما هو API في الموبايل؟ / What is Mobile API?", options:["واجهة برمجية للتطبيقات / API Interface for Apps","محاكي الهاتف / Emulator","Native UI","Flutter Widget"], answer:"واجهة برمجية للتطبيقات / API Interface for Apps"},
  {q:"ما هو Emulator؟ / What is Emulator?", options:["محاكي الهاتف على الكمبيوتر / Phone Simulator on PC","إطار عمل Flutter","Native UI","Android SDK"], answer:"محاكي الهاتف على الكمبيوتر / Phone Simulator on PC"},
  {q:"ما هو Simulator؟ / What is Simulator?", options:["محاكاة برنامج على النظام / Program Simulation","Mobile API","Flutter Widget","Native UI"], answer:"محاكاة برنامج على النظام / Program Simulation"},
  {q:"ما هو Mobile Testing؟ / What is Mobile Testing?", options:["اختبار التطبيقات على الهواتف / Testing apps on phones","Native UI","Flutter Framework","JS SDK"], answer:"اختبار التطبيقات على الهواتف / Testing apps on phones"},
  {q:"ما هو Push Notification؟ / What is Push Notification?", options:["إشعارات التطبيق / App Alerts","JS SDK","Native UI","Flutter Widget"], answer:"إشعارات التطبيق / App Alerts"},
  {q:"ما الفرق بين Native UI و Custom UI؟ / Difference between Native UI & Custom UI?", options:["Native جاهز للنظام، Custom مخصص للتطبيق / Native default, Custom app designed","Flutter UI","API Widgets","Simulator"], answer:"Native جاهز للنظام، Custom مخصص للتطبيق / Native default, Custom app designed"},
  {q:"ما هو App Store؟ / What is App Store?", options:["متجر التطبيقات للآيفون / iPhone App Store","Google Play","Flutter Store","Native Store"], answer:"متجر التطبيقات للآيفون / iPhone App Store"},
  {q:"ما هو Google Play؟ / What is Google Play?", options:["متجر التطبيقات للأندرويد / Android App Store","App Store","Flutter Store","JS Store"], answer:"متجر التطبيقات للأندرويد / Android App Store"},
  {q:"ما هو Hybrid App؟ / What is Hybrid App?", options:["تطبيق مختلط ويب + Native / Mixed Web + Native App","Native فقط","iOS App فقط","Android App فقط"], answer:"تطبيق مختلط ويب + Native / Mixed Web + Native App"},
  {q:"ما هو Mobile UX؟ / What is Mobile UX?", options:["تجربة المستخدم على الهاتف / User Experience on Mobile","Native UI","Flutter Widget","Mobile API"], answer:"تجربة المستخدم على الهاتف / User Experience on Mobile"},
  {q:"ما هو Mobile Performance Optimization؟ / What is Mobile Performance Optimization?", options:["تحسين أداء التطبيق / Improve App Performance","JS SDK","Flutter Widget","Native UI"], answer:"تحسين أداء التطبيق / Improve App Performance"},
  {q:"ما هو Offline Mode؟ / What is Offline Mode?", options:["تشغيل التطبيق بدون انترنت / Run app without internet","Online فقط","API Mode","Simulator Mode"], answer:"تشغيل التطبيق بدون انترنت / Run app without internet"},
  {q:"ما هو Mobile Security؟ / What is Mobile Security?", options:["حماية التطبيق وبيانات المستخدم / Protect app & user data","Simulator","Native UI","Flutter Widget"], answer:"حماية التطبيق وبيانات المستخدم / Protect app & user data"},
  {q:"ما هو App Deployment؟ / What is App Deployment?", options:["نشر التطبيق على المتجر / Publish App to Store","Flutter Store","Native Store","JS Store"], answer:"نشر التطبيق على المتجر / Publish App to Store"}
],
network : [
  {q:"ما هو IP Address؟ / What is IP Address?", options:["عنوان بروتوكول الإنترنت / Internet Protocol Address","مفتاح الشبكة / Network Key","موجه الشبكة / Network Router","جدار حماية / Firewall"], answer:"عنوان بروتوكول الإنترنت / Internet Protocol Address"},
  {q:"ما هو DNS؟ / What is DNS?", options:["نظام أسماء النطاقات / Domain Name System","مفتاح التشفير / Encryption Key","موجه الشبكة / Router","البروتوكول الآمن / Secure Protocol"], answer:"نظام أسماء النطاقات / Domain Name System"},
  {q:"ما هو Router؟ / What is Router?", options:["جهاز يربط الشبكات / Device connecting networks","خادم الشبكة / Server","عنوان IP / IP Address","محاكي الشبكة / Network Simulator"], answer:"جهاز يربط الشبكات / Device connecting networks"},
  {q:"ما هو Switch؟ / What is Switch?", options:["محوّل الشبكة / Network Switch","جدار حماية / Firewall","موجه الشبكة / Router","عنوان IP / IP Address"], answer:"محوّل الشبكة / Network Switch"},
  {q:"ما هو Subnet؟ / What is Subnet?", options:["قسم الشبكة / Network Division","مفتاح الشبكة / Network Key","البروتوكول الآمن / Secure Protocol","خادم DHCP / DHCP Server"], answer:"قسم الشبكة / Network Division"},
  {q:"ما الفرق بين TCP و UDP؟ / Difference between TCP & UDP?", options:["TCP موثوق، UDP غير موثوق / TCP Reliable, UDP Unreliable","TCP أسرع، UDP أبطأ","TCP لصفحات الويب فقط، UDP للشبكة الداخلية","TCP لتطبيقات الهاتف، UDP للخادم"], answer:"TCP موثوق، UDP غير موثوق / TCP Reliable, UDP Unreliable"},
  {q:"ما هو Firewall؟ / What is Firewall?", options:["جدار حماية الشبكة / Network Security Wall","موجه الشبكة / Router","عنوان IP / IP Address","قسم الشبكة / Network Division"], answer:"جدار حماية الشبكة / Network Security Wall"},
  {q:"ما هو VPN؟ / What is VPN?", options:["شبكة خاصة افتراضية / Virtual Private Network","شبكة عامة / Public Network","قسم الشبكة / Network Division","مفتاح الشبكة / Network Key"], answer:"شبكة خاصة افتراضية / Virtual Private Network"},
  {q:"ما هو LAN؟ / What is LAN?", options:["شبكة محلية / Local Area Network","شبكة واسعة / WAN","شبكة افتراضية / VPN","شبكة متوسطة / MAN"], answer:"شبكة محلية / Local Area Network"},
  {q:"ما هو WAN؟ / What is WAN?", options:["شبكة واسعة / Wide Area Network","شبكة محلية / LAN","شبكة افتراضية / VPN","مفتاح الشبكة / Network Key"], answer:"شبكة واسعة / Wide Area Network"},
  {q:"ما هو Packet؟ / What is Packet?", options:["وحدة بيانات صغيرة في الشبكة / Small data unit in network","جدار حماية / Firewall","موجه الشبكة / Router","قسم الشبكة / Network Division"], answer:"وحدة بيانات صغيرة في الشبكة / Small data unit in network"},
  {q:"ما هو MAC Address؟ / What is MAC Address?", options:["عنوان جهاز الشبكة / Device Network Address","عنوان IP / IP Address","شبكة محلية / LAN","جدار حماية / Firewall"], answer:"عنوان جهاز الشبكة / Device Network Address"},
  {q:"ما هو Ping؟ / What is Ping?", options:["أداة اختبار الاتصال / Connectivity Testing Tool","مفتاح الشبكة / Network Key","خادم الشبكة / Server","جدار حماية / Firewall"], answer:"أداة اختبار الاتصال / Connectivity Testing Tool"},
  {q:"ما هو Bandwidth؟ / What is Bandwidth?", options:["عرض نطاق الشبكة / Network Range","سرعة المعالج / CPU Speed","ذاكرة الوصول العشوائي / RAM","مفتاح التشفير / Encryption Key"], answer:"عرض نطاق الشبكة / Network Range"},
  {q:"ما هو Latency؟ / What is Latency?", options:["زمن استجابة الشبكة / Network Response Time","زمن تحميل الصفحة / Page Load Time","سرعة الاتصال / Connection Speed","جدار حماية / Firewall"], answer:"زمن استجابة الشبكة / Network Response Time"},
  {q:"ما هو DNS Spoofing؟ / What is DNS Spoofing?", options:["هجوم لتزوير DNS / DNS Spoofing Attack","هجوم برمجي / Software Attack","اختراق الجهاز / Device Hack","هجوم فيروسات / Virus Attack"], answer:"هجوم لتزوير DNS / DNS Spoofing Attack"},
  {q:"ما هو NAT؟ / What is NAT?", options:["ترجمة عناوين الشبكة / Network Address Translation","قسم الشبكة / Subnet","جدار حماية / Firewall","محاكي الشبكة / Network Simulator"], answer:"ترجمة عناوين الشبكة / Network Address Translation"},
  {q:"ما هو Port؟ / What is Port?", options:["منفذ الشبكة / Network Port","قسم الشبكة / Subnet","جدار حماية / Firewall","عنوان IP / IP Address"], answer:"منفذ الشبكة / Network Port"},
  {q:"ما هو SSL؟ / What is SSL?", options:["تشفير البيانات / Data Encryption","عنوان IP / IP Address","شبكة محلية / LAN","جدار حماية / Firewall"], answer:"تشفير البيانات / Data Encryption"},
  {q:"ما هو DHCP؟ / What is DHCP?", options:["تخصيص عناوين الشبكة تلقائيًا / Automatic IP Assignment","توزيع البرمجيات / Software Deployment","قسم الشبكة / Subnet","محاكي الشبكة / Network Simulator"], answer:"تخصيص عناوين الشبكة تلقائيًا / Automatic IP Assignment"}
],
data : [
  {q:"ما هو Data Cleaning؟ / What is Data Cleaning?", options:["تنظيف البيانات / Cleaning data","تخزين البيانات / Data Storage","تصميم قاعدة البيانات / DB Design","تحليل البيانات / Data Analysis"], answer:"تنظيف البيانات / Cleaning data"},
  {q:"ما هو Data Visualization؟ / What is Data Visualization?", options:["تمثيل البيانات بصرياً / Visual representation of data","تنظيف البيانات / Data Cleaning","تخزين البيانات / Data Storage","تحليل البيانات / Data Analysis"], answer:"تمثيل البيانات بصرياً / Visual representation of data"},
  {q:"ما هو SQL؟ / What is SQL?", options:["لغة استعلام قواعد البيانات / Database Query Language","لغة برمجة ويب / Web Programming Language","لغة تصميم واجهات / UI Language","لغة تحليل البيانات / Data Analysis Language"], answer:"لغة استعلام قواعد البيانات / Database Query Language"},
  {q:"ما هو Python في تحليل البيانات؟ / What is Python in Data Analysis?", options:["لغة برمجة لتحليل البيانات / Programming Language for Data Analysis","لغة تصميم واجهات / UI Language","SQL","HTML"], answer:"لغة برمجة لتحليل البيانات / Programming Language for Data Analysis"},
  {q:"ما هو ETL؟ / What is ETL?", options:["استخراج وتحويل وتحميل البيانات / Extract, Transform, Load","تخزين البيانات / Data Storage","تنظيف البيانات / Data Cleaning","تحليل البيانات / Data Analysis"], answer:"استخراج وتحويل وتحميل البيانات / Extract, Transform, Load"},
  {q:"ما هو Big Data؟ / What is Big Data?", options:["بيانات ضخمة ومعقدة / Large & Complex Data","بيانات صغيرة / Small Data","بيانات مرئية / Visual Data","بيانات وهمية / Dummy Data"], answer:"بيانات ضخمة ومعقدة / Large & Complex Data"},
  {q:"ما هو Data Mining؟ / What is Data Mining?", options:["استخراج المعلومات من البيانات / Extracting info from data","تنظيف البيانات / Data Cleaning","تخزين البيانات / Data Storage","تصميم قاعدة البيانات / DB Design"], answer:"استخراج المعلومات من البيانات / Extracting info from data"},
  {q:"ما هو Machine Learning؟ / What is Machine Learning?", options:["تعلم الآلة من البيانات / Machines learning from data","تنظيف البيانات / Data Cleaning","تخزين البيانات / Data Storage","تحليل البيانات يدوياً / Manual Data Analysis"], answer:"تعلم الآلة من البيانات / Machines learning from data"},
  {q:"ما الفرق بين Structured و Unstructured Data؟ / Difference between Structured & Unstructured Data?", options:["Structured منظم، Unstructured غير منظم / Structured organized, Unstructured unorganized","Structured فقط نصوص","Unstructured فقط أرقام","Structured فقط جداول"], answer:"Structured منظم، Unstructured غير منظم / Structured organized, Unstructured unorganized"},
  {q:"ما هو Dashboard؟ / What is Dashboard?", options:["لوحة عرض البيانات / Data Display Panel","تنظيف البيانات / Data Cleaning","تخزين البيانات / Data Storage","تحليل البيانات / Data Analysis"], answer:"لوحة عرض البيانات / Data Display Panel"},
  {q:"ما هو Data Wrangling؟ / What is Data Wrangling?", options:["تحويل البيانات الخام / Transforming raw data","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","تنظيف البيانات / Data Cleaning"], answer:"تحويل البيانات الخام / Transforming raw data"},
  {q:"ما هو Correlation؟ / What is Correlation?", options:["علاقة بين متغيرين / Relationship between variables","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","تنظيف البيانات / Data Cleaning"], answer:"علاقة بين متغيرين / Relationship between variables"},
  {q:"ما هو Regression؟ / What is Regression?", options:["توقع القيم / Predicting values","تنظيف البيانات / Data Cleaning","تخزين البيانات / Data Storage","تحليل البيانات / Data Analysis"], answer:"توقع القيم / Predicting values"},
  {q:"ما هو Data Lake؟ / What is Data Lake?", options:["تخزين البيانات الخام / Raw data storage","تحليل البيانات / Data Analysis","تنظيف البيانات / Data Cleaning","تصميم قاعدة البيانات / DB Design"], answer:"تخزين البيانات الخام / Raw data storage"},
  {q:"ما هو Data Warehouse؟ / What is Data Warehouse?", options:["تخزين البيانات المنظمة / Structured data storage","تخزين البيانات الخام / Raw data storage","تنظيف البيانات / Data Cleaning","تحليل البيانات / Data Analysis"], answer:"تخزين البيانات المنظمة / Structured data storage"},
  {q:"ما هو Data Analytics؟ / What is Data Analytics?", options:["تحليل البيانات لاتخاذ القرار / Data Analysis for decisions","تنظيف البيانات / Data Cleaning","تخزين البيانات / Data Storage","تصميم قاعدة البيانات / DB Design"], answer:"تحليل البيانات لاتخاذ القرار / Data Analysis for decisions"},
  {q:"ما هو KPI؟ / What is KPI?", options:["مؤشر الأداء الرئيسي / Key Performance Indicator","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","تنظيف البيانات / Data Cleaning"], answer:"مؤشر الأداء الرئيسي / Key Performance Indicator"},
  {q:"ما هو Outlier؟ / What is Outlier?", options:["قيمة شاذة في البيانات / Abnormal value in data","تخزين البيانات / Data Storage","تنظيف البيانات / Data Cleaning","تحليل البيانات / Data Analysis"], answer:"قيمة شاذة في البيانات / Abnormal value in data"},
  {q:"ما هو Data Governance؟ / What is Data Governance?", options:["إدارة البيانات / Managing data","تنظيف البيانات / Data Cleaning","تخزين البيانات / Data Storage","تحليل البيانات / Data Analysis"], answer:"إدارة البيانات / Managing data"},
  {q:"ما هو Data Pipeline؟ / What is Data Pipeline?", options:["مسار معالجة البيانات / Data processing pipeline","تنظيف البيانات / Data Cleaning","تخزين البيانات / Data Storage","تحليل البيانات / Data Analysis"], answer:"مسار معالجة البيانات / Data processing pipeline"}
],
 cyber : [
  {q:"ما هو Phishing؟ / What is Phishing?", options:["هجوم تصيد احتيالي / Fraudulent attack","هجوم برمجي / Software attack","شبكة افتراضية / VPN","جدار حماية / Firewall"], answer:"هجوم تصيد احتيالي / Fraudulent attack"},
  {q:"ما هو Firewall؟ / What is Firewall?", options:["جدار حماية للشبكة / Network Security Wall","محاكي الشبكة / Network Simulator","عنوان IP / IP Address","خادم الشبكة / Server"], answer:"جدار حماية للشبكة / Network Security Wall"},
  {q:"ما هو Malware؟ / What is Malware?", options:["برمجيات خبيثة / Malicious Software","مفتاح الشبكة / Network Key","خادم الشبكة / Server","جدار حماية / Firewall"], answer:"برمجيات خبيثة / Malicious Software"},
  {q:"ما هو Ransomware؟ / What is Ransomware?", options:["برمجيات تطلب فدية / Software demanding ransom","مفتاح التشفير / Encryption Key","شبكة VPN","جدار حماية / Firewall"], answer:"برمجيات تطلب فدية / Software demanding ransom"},
  {q:"ما هو SQL Injection؟ / What is SQL Injection?", options:["هجوم على قاعدة البيانات / Database attack","هجوم على الشبكة / Network attack","تخزين البيانات / Data Storage","تحليل البيانات / Data Analysis"], answer:"هجوم على قاعدة البيانات / Database attack"},
  {q:"ما هو XSS؟ / What is XSS?", options:["هجوم إدخال سكريبت عبر الويب / Web script injection attack","هجوم Malware","VPN Attack","Firewall Configuration"], answer:"هجوم إدخال سكريبت عبر الويب / Web script injection attack"},
  {q:"ما هو DOS؟ / What is DOS?", options:["هجوم حجب الخدمة / Denial of Service","هجوم Malware","تخزين البيانات / Data Storage","تحليل البيانات / Data Analysis"], answer:"هجوم حجب الخدمة / Denial of Service"},
  {q:"ما هو HTTPS؟ / What is HTTPS?", options:["بروتوكول آمن لتصفح الويب / Secure Web Protocol","HTTP فقط","SSH","FTP"], answer:"بروتوكول آمن لتصفح الويب / Secure Web Protocol"},
  {q:"ما هو SSL؟ / What is SSL?", options:["تشفير البيانات / Data Encryption","HTTP فقط","VPN","Firewall"], answer:"تشفير البيانات / Data Encryption"},
  {q:"ما هو VPN؟ / What is VPN?", options:["شبكة خاصة افتراضية / Virtual Private Network","شبكة عامة / Public Network","خادم الشبكة / Server","جدار حماية / Firewall"], answer:"شبكة خاصة افتراضية / Virtual Private Network"},
  {q:"ما هو Penetration Testing؟ / What is Penetration Testing?", options:["اختبار الاختراق / Hacking Test","VPN Test","Firewall Test","Malware Test"], answer:"اختبار الاختراق / Hacking Test"},
  {q:"ما هو Two-Factor Authentication؟ / What is 2FA?", options:["مصادقة ثنائية / Dual Authentication","Single Password","VPN Authentication","Firewall Auth"], answer:"مصادقة ثنائية / Dual Authentication"},
  {q:"ما هو Brute Force Attack؟ / What is Brute Force Attack?", options:["هجوم تخمين كلمات المرور / Password guessing attack","SQL Injection","XSS Attack","Phishing"], answer:"هجوم تخمين كلمات المرور / Password guessing attack"},
  {q:"ما هو Cyber Hygiene؟ / What is Cyber Hygiene?", options:["ممارسات أمان الشبكة / Network security practices","تخزين البيانات / Data Storage","تحليل البيانات / Data Analysis","تشفير البيانات / Data Encryption"], answer:"ممارسات أمان الشبكة / Network security practices"},
  {q:"ما هو Malware Signature؟ / What is Malware Signature?", options:["بصمة البرمجيات الخبيثة / Malicious software pattern","تشفير البيانات / Data Encryption","VPN","Firewall"], answer:"بصمة البرمجيات الخبيثة / Malicious software pattern"},
  {q:"ما هو Social Engineering؟ / What is Social Engineering?", options:["الهجوم على المستخدمين / Attacking users","هجوم SQL","XSS Attack","VPN Attack"], answer:"الهجوم على المستخدمين / Attacking users"},
  {q:"ما هو Zero-Day Attack؟ / What is Zero-Day Attack?", options:["هجوم على ثغرة جديدة / Attack on new vulnerability","هجوم DOS","VPN Attack","Firewall Attack"], answer:"هجوم على ثغرة جديدة / Attack on new vulnerability"},
  {q:"ما هو Encryption؟ / What is Encryption?", options:["تشفير البيانات / Data Encryption","تخزين البيانات / Data Storage","Firewall Config","VPN Config"], answer:"تشفير البيانات / Data Encryption"},
  {q:"ما هو Authentication؟ / What is Authentication?", options:["تحقق من هوية المستخدم / User Identity Verification","تشفير البيانات / Data Encryption","Firewall Config","VPN Config"], answer:"تحقق من هوية المستخدم / User Identity Verification"},
  {q:"ما هو Authorization؟ / What is Authorization?", options:["صلاحيات الوصول / Access Permission","تحقق من الهوية / Authentication","Firewall Config","VPN Config"], answer:"صلاحيات الوصول / Access Permission"}
],
 ai : [
  {q:"ما هو AI؟ / What is AI?", options:["الذكاء الاصطناعي / Artificial Intelligence","تحليل البيانات / Data Analysis","شبكة محلية / LAN","تشفير البيانات / Data Encryption"], answer:"الذكاء الاصطناعي / Artificial Intelligence"},
  {q:"ما هو Machine Learning؟ / What is Machine Learning?", options:["تعلم الآلة من البيانات / Machines learning from data","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","تنظيف البيانات / Data Cleaning"], answer:"تعلم الآلة من البيانات / Machines learning from data"},
  {q:"ما هو Deep Learning؟ / What is Deep Learning?", options:["شبكات عصبية عميقة / Deep Neural Networks","شبكات بسيطة / Simple Networks","خوارزمية فرز / Sorting Algorithm","تخزين البيانات / Data Storage"], answer:"شبكات عصبية عميقة / Deep Neural Networks"},
  {q:"ما هو Neural Network؟ / What is Neural Network?", options:["شبكة عصبية تحاكي الدماغ / Brain-like Neural Network","خادم الشبكة / Server","شبكة محلية / LAN","جدار حماية / Firewall"], answer:"شبكة عصبية تحاكي الدماغ / Brain-like Neural Network"},
  {q:"ما هو Supervised Learning؟ / What is Supervised Learning?", options:["تعلم تحت إشراف / Learning under supervision","تعلم بدون إشراف / Unsupervised Learning","شبكة عصبية / Neural Network","تحليل البيانات / Data Analysis"], answer:"تعلم تحت إشراف / Learning under supervision"},
  {q:"ما هو Unsupervised Learning؟ / What is Unsupervised Learning?", options:["تعلم بدون إشراف / Learning without supervision","تعلم تحت إشراف / Supervised Learning","تحليل البيانات / Data Analysis","شبكة عصبية / Neural Network"], answer:"تعلم بدون إشراف / Learning without supervision"},
  {q:"ما هو Reinforcement Learning؟ / What is Reinforcement Learning?", options:["تعلم بالتعزيز / Learning by reinforcement","تعلم تحت إشراف / Supervised Learning","شبكة عصبية / Neural Network","تحليل البيانات / Data Analysis"], answer:"تعلم بالتعزيز / Learning by reinforcement"},
  {q:"ما هو Overfitting؟ / What is Overfitting?", options:["تعلم زائد على البيانات / Model fits too much","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"تعلم زائد على البيانات / Model fits too much"},
  {q:"ما هو Underfitting؟ / What is Underfitting?", options:["تعلم غير كافي / Model fits too little","تحليل البيانات / Data Analysis","شبكة عصبية / Neural Network","تخزين البيانات / Data Storage"], answer:"تعلم غير كافي / Model fits too little"},
  {q:"ما هو Feature Extraction؟ / What is Feature Extraction?", options:["استخراج الخصائص من البيانات / Extracting features from data","تخزين البيانات / Data Storage","تحليل البيانات / Data Analysis","شبكة عصبية / Neural Network"], answer:"استخراج الخصائص من البيانات / Extracting features from data"},
  {q:"ما هو Classification؟ / What is Classification?", options:["تصنيف البيانات / Data Classification","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"تصنيف البيانات / Data Classification"},
  {q:"ما هو Regression في ML؟ / What is Regression in ML?", options:["توقع القيم / Predicting values","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"توقع القيم / Predicting values"},
  {q:"ما هو Clustering؟ / What is Clustering?", options:["تجميع البيانات / Grouping data","تحليل البيانات / Data Analysis","شبكة عصبية / Neural Network","تخزين البيانات / Data Storage"], answer:"تجميع البيانات / Grouping data"},
  {q:"ما هو Natural Language Processing؟ / What is NLP?", options:["معالجة اللغة الطبيعية / Natural Language Processing","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"معالجة اللغة الطبيعية / Natural Language Processing"},
  {q:"ما هو Computer Vision؟ / What is Computer Vision?", options:["رؤية الحاسوب / Computer Vision","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"رؤية الحاسوب / Computer Vision"},
  {q:"ما هو AI Ethics؟ / What is AI Ethics?", options:["أخلاقيات الذكاء الاصطناعي / AI Ethical Principles","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"أخلاقيات الذكاء الاصطناعي / AI Ethical Principles"},
  {q:"ما هو Backpropagation؟ / What is Backpropagation?", options:["خوارزمية تدريب الشبكات العصبية / Neural Network Training Algorithm","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"خوارزمية تدريب الشبكات العصبية / Neural Network Training Algorithm"},
  {q:"ما هو Gradient Descent؟ / What is Gradient Descent?", options:["خوارزمية تحسين الأداء / Optimization Algorithm","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"خوارزمية تحسين الأداء / Optimization Algorithm"},
  {q:"ما هو AI Model Evaluation؟ / What is AI Model Evaluation?", options:["تقييم أداء النموذج / Evaluating model performance","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"تقييم أداء النموذج / Evaluating model performance"},
  {q:"ما هو Hyperparameter Tuning؟ / What is Hyperparameter Tuning?", options:["ضبط معلمات النموذج / Model parameter tuning","تحليل البيانات / Data Analysis","تخزين البيانات / Data Storage","شبكة عصبية / Neural Network"], answer:"ضبط معلمات النموذج / Model parameter tuning"}
]
};

// ====== 1. المتغيرات الأساسية ======
let currentIndex = 0;
// تأكد أن track و questions معرفين قبل هذا الجزء
let currentQuestions = (typeof questions !== 'undefined' && questions[track]) ? questions[track] : [];
let userAnswers = Array(currentQuestions.length).fill(null);

// ====== 2. استدعاء عناصر HTML ======
const questionCard = document.getElementById("questionCard");
const questionText = document.getElementById("questionText");
const optionsList = document.getElementById("optionsList");
const nextBtn = document.getElementById("nextBtn");
const backBtn = document.getElementById("backBtn");
const progressBar = document.getElementById("progressBar");
const resultCard = document.getElementById("resultCard");
const scoreText = document.getElementById("scoreText");
const feedbackText = document.getElementById("feedbackText");

// ====== 3. دالة عرض السؤال ======
function showQuestion() {
    // التحقق من وجود أسئلة
    if (currentQuestions.length === 0) {
        if(questionText) questionText.innerText = "خطأ: لم يتم العثور على أسئلة.";
        return;
    }

    // التحقق من نهاية الاختبار
    if (currentIndex >= currentQuestions.length) {
        showResult();
        return;
    }

    const q = currentQuestions[currentIndex];
    questionText.innerText = q.q;
    optionsList.innerHTML = '';

    q.options.forEach((opt, idx) => {
        const btn = document.createElement('button');
        btn.innerText = opt;
        btn.className = "btn btn-outline-dark w-100 mb-2 p-3 text-start";

        // منطق استرجاع الإجابة لو المستخدم رجع بالـ Back
        if (userAnswers[currentIndex] !== null) {
            const isCorrect = (idx === q.answer || opt === q.answer);
            const isSelected = (idx === userAnswers[currentIndex]);

            if (isCorrect) btn.classList.add('btn-success', 'text-white');
            else if (isSelected) btn.classList.add('btn-danger', 'text-white');
            btn.disabled = true;
        }

        // عند الضغط على اختيار
        btn.onclick = function() {
            if (userAnswers[currentIndex] === null) {
                userAnswers[currentIndex] = idx;

                const isCorrect = (idx === q.answer || opt === q.answer);

                if (isCorrect) {
                    btn.classList.replace('btn-outline-dark', 'btn-success');
                    btn.classList.add('text-white');
                } else {
                    btn.classList.replace('btn-outline-dark', 'btn-danger');
                    btn.classList.add('text-white');

                    // إظهار الإجابة الصحيحة للمستخدم
                    Array.from(optionsList.querySelectorAll('button')).forEach((b, i) => {
                        if (i === q.answer || b.innerText === q.answer) {
                            b.classList.replace('btn-outline-dark', 'btn-success');
                            b.classList.add('text-white');
                        }
                    });
                }

                // تعطيل باقي الاختيارات وإظهار زر التالي
                Array.from(optionsList.querySelectorAll('button')).forEach(b => b.disabled = true);
                nextBtn.style.display = 'block';
            }
        };

        const li = document.createElement('li');
        li.style.listStyle = "none";
        li.appendChild(btn);
        optionsList.appendChild(li);
    });

    // تحديث شريط التقدم والواجهة
    progressBar.style.width = `${((currentIndex) / currentQuestions.length) * 100}%`;
    questionCard.style.display = 'block';
    resultCard.style.display = 'none';
    nextBtn.style.display = userAnswers[currentIndex] !== null ? 'block' : 'none';
    backBtn.disabled = currentIndex === 0;
}

// ====== 4. دالة عرض النتيجة النهائية ======
function showResult() {
    questionCard.style.display = 'none';
    nextBtn.style.display = 'none';
    backBtn.style.display = 'none';
    resultCard.style.display = 'block';

    let finalScore = 0;
    userAnswers.forEach((ansIdx, i) => {
        const q = currentQuestions[i];
        // مقارنة ذكية بالـ Index أو بالنص المكتوب
        if (ansIdx === q.answer || q.options[ansIdx] === q.answer) {
            finalScore++;
        }
    });

    const percent = ((finalScore / currentQuestions.length) * 100).toFixed(0);
    scoreText.innerHTML = `<h3>لقد حصلت على ${finalScore} من ${currentQuestions.length} ✅</h3>`;
    feedbackText.innerHTML = `<h5>درجة الاختبار: ${percent}% 🎉</h5>`;

    // إضافة زرار تحميل الشهادة (طباعة الصفحة)
    feedbackText.innerHTML += `
        <button class="btn btn-primary w-100 mt-4 p-3" onclick="window.print()">
            <i class="fa-solid fa-download me-2"></i> تحميل الشهادة كـ PDF
        </button>`;

    progressBar.style.width = "100%";
}

// ====== 5. أحداث الأزرار (Events) ======
nextBtn.addEventListener('click', () => {
    if (currentIndex < currentQuestions.length) {
        currentIndex++;
        showQuestion();
    }
});

backBtn.addEventListener('click', () => {
    if (currentIndex > 0) {
        currentIndex--;
        showQuestion();
    }
});

// ====== 6. تشغيل الكود ======
// ننتظر تحميل الصفحة بالكامل لضمان وجود العناصر
window.onload = function() {
    showQuestion();
};

