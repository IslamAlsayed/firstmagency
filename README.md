# 🎨 First Marketing Agency

منصة ويب حديثة واحترافية لوكالة "First Marketing" متخصصة في تقديم خدمات التسويق الرقمي وتطوير الويب والتطبيقات.

## ✨ المميزات الرئيسية

### 🌍 تعدد اللغات
- دعم ثنائي اللغة (العربية والإنجليزية)
- تبديل سلس بين اللغات مع الحفاظ على البيانات

### 📱 التصميم
- **واجهة مستخدم حديثة** مبنية بـ Tailwind CSS
- **استجابة كاملة** (Responsive) لجميع الأجهزة
- **أداء عالي** مع Vite

### 🛍️ الخدمات المقدمة
- **استضافة ويب** - باقات متعددة للاستضافة المشتركة
- **خدمات الريسيلر** - لإعادة بيع الاستضافة
- **خوادم VPS** - خوادم افتراضية مخصصة
- **خوادم مخصصة** - حلول سيرفرات قوية
- **تطوير المواقع** - خدمات تطوير ويب احترافية
- **تطبيقات الجوال** - تطوير تطبيقات iOS و Android

### 📄 المحتوى
- **الصفحة الرئيسية** - عرض شامل للخدمات والمميزات
- **من نحن** - معلومات عن الوكالة
- **معرض الأعمال** - عرض المشاريع والنماذج
- **المدونة** - مقالات وموارد تسويقية
- **تواصل معنا** - نموذج للتواصل والاستفسارات
- **فعاليات وتذاكر** - إدارة الفعاليات والحجوزات

---

## 🚀 البدء السريع

### المتطلبات
- PHP 8.2 أو أعلى
- Node.js 18+ و npm
- قاعدة بيانات (SQLite/MySQL)
- Laravel 12

### التثبيت

```bash
# 1. استنساخ المشروع
git clone <repository-url>
cd firstmagency

# 2. تثبيت المكتبات
composer install
npm install

# 3. إعداد الملف البيئي
cp .env.example .env

# 4. توليد مفتاح التطبيق
php artisan key:generate

# 5. تشغيل الترجيحات والبناء
php artisan migrate
npm run build

# 6. تشغيل السيرفر
php artisan serve
npm run dev  # (في نافذة منفصلة)
```

**أو استخدم الأمر المدمج:**
```bash
composer run setup
```

---

## 📊 بنية المشروع

```
firstmagency/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   └── LocaleController.php    # إدارة تعدد اللغات
│   │   └── Middleware/
│   ├── Models/
│   ├── Helpers/
│   │   └── LocalizationHelper.php
│   └── helpers.php
│
├── config/
│   ├── packages-hosting.php            # تكوين باقات الاستضافة
│   ├── app.php
│   └── [تكوينات أخرى]
│
├── resources/
│   ├── views/
│   │   ├── welcome.blade.php          # الصفحة الرئيسية
│   │   ├── about-us.blade.php
│   │   ├── portfolio.blade.php
│   │   ├── blog.blade.php
│   │   ├── blogShow.blade.php
│   │   ├── contact.blade.php
│   │   ├── hosting.blade.php          # صفحة الاستضافة
│   │   ├── websiteDeveloper.blade.php
│   │   ├── appMobile.blade.php
│   │   ├── tickets.blade.php
│   │   ├── sections/                  # مكونات شاملة
│   │   │   └── packages-hosting.blade.php  # عرض الباقات
│   │   │   └── [مكونات أخرى]
│   │   └── layouts/
│   │
│   ├── css/
│   │   └── app.css                    # ملفات CSS
│   │
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   │
│   └── lang/                          # ملفات الترجمة
│       ├── ar/
│       └── en/
│
├── routes/
│   └── web.php                        # مسارات الويب
│
├── database/
│   ├── migrations/
│   ├── factories/
│   │   └── UserFactory.php
│   └── seeders/
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   ├── images/                    # الصور والأيقونات
│   │   │   └── [صور الباقات والمحتوى]
│   │   └── webfonts/
│   └── storage/                       # التخزين العام
│
├── composer.json
├── package.json
├── vite.config.js
└── README.md
```

---

## 🎯 الميزات الحالية

### 1️⃣ صفحات متعددة
- ✅ صفحة ترحيبية جذابة
- ✅ معرض أعمال متكامل
- ✅ مدونة تسويقية
- ✅ نموذج اتصال
- ✅ عرض الخدمات

### 2️⃣ نظام الباقات (Packages System)
نظام متطور لعرض وفلترة الباقات المختلفة:

**الباقات المتاحة:**
- 🖥️ **استضافة مشتركة** - 4 خطط (5$ - 15$/شهر)
- 🔄 **خدمات الريسيلر** - 4 خطط (25$ - 45$/شهر)
- ⚡ **خوادم VPS** - 4 خطط (28$ - 55$/شهر)
- 🗂️ **خوادم مخصصة** - (100$/شهر)

**المميزات:**
- ✅ نظام فلترة ديناميكي (جانب العميل)
- ✅ عرض الأسعار الشهرية والسنوية
- ✅ قائمة شاملة بالميزات لكل باقة
- ✅ صور توضيحية لكل باقة
- ✅ دعم الاستجابة الكاملة

### 3️⃣ نظام اللغات المتعدد
- 🌐 تبديل ديناميكي بين العربية والإنجليزية
- 📝 ملفات ترجمة منظمة لكل لغة
- 🔄 الحفاظ على الجلسة عند تبديل اللغة

### 4️⃣ التصميم الحديث
- 🎨 CSS Tailwind v4 مع دعم كامل
- 📱 تخطيطات Responsive لجميع الأجهزة
- ✨ رسوم متحركة سلسة وجذابة
- 🖼️ واجهة مستخدم متقدمة وسهلة الاستخدام

---

## 🛠️ الأدوات والتقنيات

| الأداة | الإصدار | الاستخدام |
|------|--------|----------|
| Laravel | 12.x | إطار العمل الرئيسي |
| PHP | 8.2+ | لغة البرمجة الأساسية |
| Tailwind CSS | 4.x | تصميم واجهات المستخدم |
| Vite | 7.x | بناء وتطوير الأصول |
| Node.js | 18+ | إدارة الحزم والأتمتة |
| Blade Template | - | نظام القوالب |
| MySQL/SQLite | - | قاعدة البيانات |

---

## 📝 ملفات التكوين المهمة

### `config/packages-hosting.php`
يحتوي على تكوين شامل لجميع الباقات:

```php
'hosting' => [
    [
        'name' => 'البــاقة الاولي',
        'month_price' => 5,
        'year_price' => 60,
        'image' => 'hosting/hosting-packages/plan-1.png',
        'is_popular' => false,
        'features' => [...]
    ],
    // ...
],
'reseller' => [...]
'vps' => [...]
'servers' => [...]
```

**محتويات كل باقة:**
- ✅ الاسم والسعر (شهري/سنوي)
- ✅ الصورة الخاصة بالباقة
- ✅ علامة "الأكثر طلباً"
- ✅ قائمة مفصلة بالميزات

---

## 🎨 المكونات الرئيسية

### `LocaleController`
مراقب تبديل اللغات:
```php
namespace App\Http\Controllers;

class LocaleController extends Controller
{
    public function change($locale)
    {
        session(['locale' => $locale]);
        return redirect()->back();
    }
}
```

### `packages-hosting.blade.php`
مكون عرض الباقات مع:
- نظام فلترة جانب العميل (JavaScript)
- عرض الأسعار والميزات
- صور الباقات مع Fallback
- أنيميشن انتقالات سلسة

### `app/helpers.php`
دوال مساعدة مفيدة:
```php
// التحقق من وجود الصور
checkExistFileInPublic($path)

// تحديد نص إلى طول معين
limitedText($text, $limit)
```

---

## 🔄 مسارات التطبيق

| المسار | الصفحة | الوصف |
|------|------|-------|
| `/` | welcome | الصفحة الرئيسية |
| `/about-us` | about-us | من نحن |
| `/portfolio` | portfolio | معرض الأعمال |
| `/works/show` | workShow | عرض المشروع |
| `/blog` | blog | المدونة |
| `/blog/show` | blogShow | عرض المقالة |
| `/contact` | contact | نموذج الاتصال |
| `/hosting` | hosting | صفحة الاستضافة |
| `/website-developer` | websiteDeveloper | خدمات تطوير المواقع |
| `/app-mobile` | appMobile | خدمات التطبيقات |
| `/tickets` | tickets | الفعاليات والتذاكر |
| `/locale/{locale}` | - | تغيير اللغة (ar/en) |

---

## 🚦 حالة المشروع

🟡 **قيد التطوير النشط**

### ✅ المكتمل
- ✅ الهيكل الأساسي للمشروع
- ✅ نظام الباقات كاملاً
- ✅ دعم تعدد اللغات
- ✅ جميع الصفحات الأساسية
- ✅ نظام الفلترة الديناميكي

### 🔄 قيد العمل
- 🔄 إضافة ميزات متقدمة
- 🔄 تحسين الأداء
- 🔄 تحسينات SEO

### ⏳ المخطط له
- ⏳ نظام الدفع (Stripe/PayPal)
- ⏳ لوحة تحكم إدارية
- ⏳ نظام حجز الفعاليات المتقدم
- ⏳ أتمتة البريد الإلكتروني

---

## 🎓 أوامر مفيدة

```bash
# تشغيل الخادم
php artisan serve

# تشغيل Vite للتطوير
npm run dev

# بناء الأصول للإنتاج
npm run build

# تشغيل الاختبارات
composer run test

# مسح الكاش
php artisan config:clear
php artisan cache:clear

# تشغيل الترجيحات
php artisan migrate

# إعادة تعيين قاعدة البيانات
php artisan migrate:refresh
```

---

## �‍💻 الفريق

### Lead Developer
<div align="center">

**اسلام السيد** | Islam Alsayed  
*Full Stack Developer*

📧 [eslamalsayed8133@gmail.com](mailto:eslamalsayed8133@gmail.com)  
🐙 [github.com/islamalsayed](https://github.com/islamalsayed)  
💼 [linkedin.com/in/islamalsayed00](https://linkedin.com/in/islamalsayed00)

</div>

---

## �📞 التواصل والدعم

نحن نعمل على إضافة المزيد من الميزات والتحسينات. 

| القناة | التفاصيل |
|------|----------|
| 📧 البريد الإلكتروني | info@firstmarketing.com |
| 🌐 الموقع الرسمي | https://firstmagency.com |
| 💬 الاستفسارات | من خلال نموذج الاتصال |

---

## 📄 الترخيص

هذا المشروع مرخص تحت رخصة MIT. اطلع على ملف [LICENSE](LICENSE) للمزيد من التفاصيل.

---

## 🙏 شكراً

شكراً لاستخدامك **First Marketing Agency Platform**!

---

<div align="center">

**آخر تحديث:** 22 فبراير 2026  
**الإصدار:** 1.0.0 (التطوير)  
**الحالة:** 🟡 قيد التطوير النشط

</div>
