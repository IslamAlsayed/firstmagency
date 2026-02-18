<div class="section reviews-section">
    <div class="text-center title font-semibold">{{ __('main.reviews_title') }} <span class="title-badge">{{ __('main.reviews_subtitle') }}</span></div>
    <div class="text-center description">{{ __('main.reviews_description') }}</div>

    @php
        $reviewsReview = [
            [
                'name' => 'خالد نعمان',
                'photo' => '1.jpg',
                'country' => 'مصر',
                'rate' => 5,
                'comment' =>
                    'اتعاملت مع الشركة من سنة تقريبا في خدمات السيو وموقعي طلع الصفحة الاولي هما ناس ملتزمين بشغلهم كويس ومتابعين دايما معايا من وقت ما بدءت الشغل اشكرهم الله يوفقهم',
            ],
            [
                'name' => 'ابو عبدالله',
                'photo' => '2.jpg',
                'country' => 'السعودية',
                'rate' => 5,
                'comment' =>
                    'اتعاملت مع الشركة من سنة تقريبا في خدمات السيو وموقعي طلع الصفحة الاولي هما ناس ملتزمين بشغلهم كويس ومتابعين دايما معايا من وقت ما بدءت الشغل اشكرهم الله يوفقهم',
            ],
            [
                'name' => 'محمد احمد',
                'photo' => '1.jpg',
                'country' => 'العراق',
                'rate' => 5,
                'comment' =>
                    'اتعاملت مع الشركة من سنة تقريبا في خدمات السيو وموقعي طلع الصفحة الاولي هما ناس ملتزمين بشغلهم كويس ومتابعين دايما معايا من وقت ما بدءت الشغل اشكرهم الله يوفقهم',
            ],
            [
                'name' => 'نوح البحيري',
                'photo' => '1.jpg',
                'country' => 'مصر',
                'rate' => 5,
                'comment' =>
                    'اتعاملت مع الشركة من سنة تقريبا في خدمات السيو وموقعي طلع الصفحة الاولي هما ناس ملتزمين بشغلهم كويس ومتابعين دايما معايا من وقت ما بدءت الشغل اشكرهم الله يوفقهم',
            ],
            [
                'name' => 'مصطفي الجبوري',
                'photo' => '1.jpg',
                'country' => 'العراق',
                'rate' => 5,
                'comment' =>
                    'اتعاملت مع الشركة من سنة تقريبا في خدمات السيو وموقعي طلع الصفحة الاولي هما ناس ملتزمين بشغلهم كويس ومتابعين دايما معايا من وقت ما بدءت الشغل اشكرهم الله يوفقهم',
            ],
            [
                'name' => 'عميل 3',
                'photo' => '1.jpg',
                'country' => 'سوريا',
                'rate' => 5,
                'comment' =>
                    'اتعاملت مع الشركة من سنة تقريبا في خدمات السيو وموقعي طلع الصفحة الاولي هما ناس ملتزمين بشغلهم كويس ومتابعين دايما معايا من وقت ما بدءت الشغل اشكرهم الله يوفقهم  ',
            ],
        ];
    @endphp

    <div class="our-review-review-wrapper">
        <div class="relative">
            <div class="review-title">{{ __('main.reviews_title_review') }}</div>
            <div class="wrapper-actions">
                <div class="action">
                    <div class="swiper-button-next"></div>
                </div>
                <div class="action">
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </div>
        <div class="our-reviews-wrapper">
            <swiper-container class="mySwiper" pagination="true" pagination-clickable="true" space-between="15" slides-per-view="3" navigation="true"
                navigation-next-el=".swiper-button-next" navigation-prev-el=".swiper-button-prev"
                breakpoints='{"320": {"slidesPerView": 1, "spaceBetween": 10}, "640": {"slidesPerView": 2, "spaceBetween": 15}, "1024": {"slidesPerView": 3, "spaceBetween": 15}, "1400": {"slidesPerView": 4, "spaceBetween": 15}}'>
                @foreach ($reviewsReview as $review)
                    <swiper-slide class="review">
                        <div class="info flex items-center gap-2">
                            <div class="review-photo">
                                {{-- <img src="{{ $review['photo'] }}" alt="{{ $review['name'] }}"> --}}
                                <img src="{{ asset('assets/images/services/' . $review['photo']) }}" alt="{{ $review['name'] }}">
                            </div>
                            <div class="review-info">
                                <div class="review-name font-semibold">{{ $review['name'] }}</div>
                                <div class="review-country">{{ $review['country'] }}</div>
                                <div class="review-review">
                                    @for ($i = 1; $i <= $review['rate']; $i++)
                                        <i class="fas fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <div class="comment mt-4">{{ $review['comment'] }}</div>
                        <div class="voice mt-4">{{ __('main.reviews_no_voice') }}</div>
                    </swiper-slide>
                @endforeach
            </swiper-container>
        </div>
    </div>

    <div class="review-form text-center hidden">
        <button class="btn-link primary-color dark-hover font-semibold">
            <a href="#contact">
                {{ __('main.write_review') }}
                <i class="fas fa-circle-plus"></i>
            </a>
        </button>
    </div>
</div>
