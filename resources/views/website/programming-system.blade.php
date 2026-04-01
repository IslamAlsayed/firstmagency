@extends('layouts.master')

@push('styles')
    <style>
        .header {
            background-color: var(--light-color) !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/css/pages/programmingSystemPage.css') }}">
@endpush

@section('content')
    <div class="programming-system">
        {{-- Header Section --}}
        <div class="system-header text-center">
            <h1 class="system-title">مواقع متاجر</h1>
            <div class="system-sub">تفاصيل الخدمة + سلايدر المشروع + مقال تعريفي</div>
        </div>

        {{-- Project Section --}}
        <section class="system-card">
            <div class="system-card-head">
                <div class="system-card-kicker">مشروع مشابه</div>
                <div class="system-card-title">مواقع متاجر</div>
            </div>

            <div class="system-slider" aria-label="سلايدر صور المشروع">
                <div class="system-slider-viewport" dir="ltr">
                    <div class="system-slider-track">
                        @foreach ($programmingSystem->images as $image)
                            <div class="system-slide">
                                <img src="{{ asset('storage/' . $image) }}" alt="{{ $programmingSystem->translations[app()->getLocale()]['name'] }}" loading="lazy">
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="button" class="system-slider-prev" aria-label="السابق">‹</button>
                <button type="button" class="system-slider-next" aria-label="التالي">›</button>

                <div class="system-slider-dots" aria-hidden="true">
                    <button type="button" class="system-dot" data-dot="0"></button>
                </div>
            </div>
        </section>

        {{-- Article Section --}}
        <section class="system-card">
            <div class="system-card-head">
                <div class="system-card-kicker">محتوى</div>
                <div class="system-card-title">مقال تعريفي</div>
            </div>

            @if ($programmingSystem->translations[app()->getLocale()]['content'])
                <div class="system-article" id="article-preview">
                    {!! limitedText($programmingSystem->translations[app()->getLocale()]['content'], 1680) !!}
                </div>
            @else
                <div class="system-article" id="article-preview">
                    <p>لا يوجد محتوى متاح لهذا النظام البرمجي في الوقت الحالي. يرجى العودة لاحقًا للاطلاع على التحديثات والمقالات الجديدة حول هذا الموضوع.</p>
                </div>
            @endif

            <div class="system-actions">
                <button type="button" class="system-btn" id="toggle-article-btn">
                    مشاهدة المزيد
                </button>
            </div>
        </section>

        {{-- Features Section --}}
        <section class="system-card">
            <div class="system-card-head">
                <div class="system-card-kicker">مميزات</div>
                <div class="system-card-title">مميزات هامة للموقع</div>
            </div>

            <div class="system-features-grid">
                <div class="system-feature">
                    <div class="system-feature-icon">
                        <img src="https://firstmagency.com/wp-content/uploads/2026/01/qatar-marketing-2021-removebg-preview-1-copy-150x150.png" alt="" loading="lazy">
                    </div>
                    <div class="system-feature-title">تصميم عصري</div>
                </div>
                <div class="system-feature">
                    <div class="system-feature-icon">
                        <img src="https://firstmagency.com/wp-content/uploads/2026/01/8488732.png" alt="" loading="lazy">
                    </div>
                    <div class="system-feature-title">متجاوب مع الموبايل</div>
                </div>
                <div class="system-feature">
                    <div class="system-feature-icon">
                        <span class="system-feature-dot" aria-hidden="true"></span>
                    </div>
                    <div class="system-feature-title">سرعة تحميل عالية</div>
                </div>
                <div class="system-feature">
                    <div class="system-feature-icon">
                        <img src="https://firstmagency.com/wp-content/uploads/2025/12/google-150x150.png" alt="" loading="lazy">
                    </div>
                    <div class="system-feature-title">متوافق مع السيو SEO</div>
                </div>
                <div class="system-feature">
                    <div class="system-feature-icon">
                        <img src="https://firstmagency.com/wp-content/uploads/2026/01/6472043-150x150.png" alt="" loading="lazy">
                    </div>
                    <div class="system-feature-title">حماية وأمان</div>
                </div>
                <div class="system-feature">
                    <div class="system-feature-icon">
                        <img src="https://firstmagency.com/wp-content/uploads/2025/12/web-settings-150x150.png" alt="" loading="lazy">
                    </div>
                    <div class="system-feature-title">لوحة تحكم سهلة</div>
                </div>
                <div class="system-feature">
                    <div class="system-feature-icon">
                        <img src="https://firstmagency.com/wp-content/uploads/2026/01/5532931.png" alt="" loading="lazy">
                    </div>
                    <div class="system-feature-title">قابل للتطوير</div>
                </div>
                <div class="system-feature">
                    <div class="system-feature-icon">
                        <img src="https://firstmagency.com/wp-content/uploads/2026/01/5830682.png" alt="" loading="lazy">
                    </div>
                    <div class="system-feature-title">دعم فني سريع</div>
                </div>
            </div>
        </section>

        {{-- SEO Section --}}
        <section class="system-card">
            <div class="system-card-head">
                <div class="system-card-kicker">SEO</div>
                <div class="system-card-title">كلمات مفتاحية</div>
            </div>

            <div class="system-tags">
                @foreach ($programmingSystem->translations[app()->getLocale()]['keywords'] as $keyword)
                    <span class="system-tag">{{ $keyword }}</span>
                @endforeach
            </div>
        </section>
    </div>

    <div class="system-modal-layer hidden" id="article-modal">
        <div class="system-modal-panel" role="document">
            <div class="system-modal-head">
                <div class="system-modal-title">تفاصيل المقال</div>
                <button type="button" class="system-modal-close" aria-label="إغلاق">×</button>
            </div>
            <div class="system-modal-content">
                {!! $programmingSystem->translations[app()->getLocale()]['content'] !!}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Header scroll effect
            const header = document.getElementById('header');
            if (header) {
                header.setAttribute('data-force-scrolled', 'true');
                header.classList.add('scrolled');
            }

            // Slider functionality
            const slider = document.querySelector('.system-slider');
            if (!slider) return;
            const track = slider.querySelector('.system-slider-track');
            const slides = Array.from(slider.querySelectorAll('.system-slide'));
            const prevBtn = slider.querySelector('.system-slider-prev');
            const nextBtn = slider.querySelector('.system-slider-next');
            const dotsContainer = slider.querySelector('.system-slider-dots');
            let current = 0;
            const slideCount = slides.length;

            // Create dots dynamically
            if (dotsContainer && slideCount > 1) {
                dotsContainer.innerHTML = '';
                slides.forEach((_, idx) => {
                    const dot = document.createElement('button');
                    dot.type = 'button';
                    dot.className = 'system-dot' + (idx === 0 ? ' active' : '');
                    dot.setAttribute('data-dot', idx);
                    dot.setAttribute('aria-label', 'انتقل إلى الصورة ' + (idx + 1));
                    dot.addEventListener('click', () => goToSlide(idx));
                    dotsContainer.appendChild(dot);
                });
            }

            function updateSlider() {
                // Show current slide - calculate based on slide width
                const slideWidth = slides[0].offsetWidth;
                const offset = current * slideWidth;
                track.style.transform = `translateX(-${offset}px)`;
                // Update dots
                if (dotsContainer) {
                    Array.from(dotsContainer.children).forEach((dot, idx) => {
                        dot.classList.toggle('active', idx === current);
                    });
                }
            }

            function goToSlide(idx) {
                current = idx;
                if (current < 0) current = 0;
                if (current > slideCount - 1) current = slideCount - 1;
                updateSlider();
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    goToSlide(current - 1 < 0 ? slideCount - 1 : current - 1);
                });
            }
            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    goToSlide(current + 1 > slideCount - 1 ? 0 : current + 1);
                });
            }

            // Responsive: update on window resize
            window.addEventListener('resize', updateSlider);
            // Initial
            updateSlider();
        });

        let toggleArticleBtn = document.getElementById('toggle-article-btn');
        if (toggleArticleBtn) {
            toggleArticleBtn.addEventListener('click', function() {
                const articleModal = document.getElementById('article-modal');
                const articleModalClose = document.querySelector('.system-modal-close');
                if (articleModal) {
                    articleModal.classList.toggle('hidden');
                    document.body.style.overflow = articleModal.classList.contains('hidden') ? '' : 'hidden';
                    this.textContent = this.textContent === 'مشاهدة المزيد' ? 'مشاهدة أقل' : 'مشاهدة المزيد';
                }

                if (articleModalClose) {
                    articleModalClose.addEventListener('click', function() {
                        articleModal.classList.add('hidden');
                        toggleArticleBtn.textContent = 'مشاهدة المزيد';
                        document.body.style.overflow = '';
                    });
                }

                document.addEventListener('click', function(e) {
                    if (e.target === articleModal) {
                        articleModal.classList.add('hidden');
                        document.body.style.overflow = '';
                        toggleArticleBtn.textContent = 'مشاهدة المزيد';
                    }
                });
            });
        }
    </script>
@endpush
