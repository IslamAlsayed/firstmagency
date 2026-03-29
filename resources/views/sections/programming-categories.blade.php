<section class="section categories-programming-section relative">
    <div class="content flex items-center justify-between">
        <div class="text">
            <div class="title font-semibold">{{ __('main.categories_title') }} <span class="title-badge">{{ __('main.brand_short') }}</span></div>
            <div class="description">
                {{ __('main.categories_description') }}
            </div>
        </div>

        <div class="images flex items-center" data-random-images>
            @if ($programming_categories && count($programming_categories) > 0)
                @foreach ($programming_categories as $index => $category)
                    <div class="image" data-image-slot="{{ $index }}">
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->alt_text }}" class="clickable-img" data-src="{{ asset('storage/' . $category->image) }}">
                        @else
                            <img src="{{ asset('assets/images/website/categories/' . $category->id . '.png') }}" alt="{{ $category->alt_text }}" class="clickable-img"
                                data-src="{{ asset('assets/images/website/categories/' . $category->id . '.png') }}">
                        @endif
                    </div>
                @endforeach
            @else
                <div class="image" data-image-slot="0">
                    <img src="{{ asset('assets/images/website/categories/1.png') }}" alt="{{ __('main.ecommerce_programming') }}" class="clickable-img"
                        data-src="{{ asset('assets/images/website/categories/1.png') }}">
                </div>
                <div class="image" data-image-slot="1">
                    <img src="{{ asset('assets/images/website/categories/2.png') }}" alt="{{ __('main.ecommerce_programming') }}" class="clickable-img"
                        data-src="{{ asset('assets/images/website/categories/2.png') }}">
                </div>
                <div class="image" data-image-slot="2">
                    <img src="{{ asset('assets/images/website/categories/3.png') }}" alt="{{ __('main.ecommerce_programming') }}" class="clickable-img"
                        data-src="{{ asset('assets/images/website/categories/3.png') }}">
                </div>
            @endif
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-categories-programming</div>
    @endif
</section>
