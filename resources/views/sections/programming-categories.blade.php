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
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->alt_text }}">
                        @else
                            <img src="{{ asset('assets/images/website/categories/' . $category->id . '.png') }}" alt="{{ $category->alt_text }}">
                        @endif
                    </div>
                @endforeach
            @else
                <div class="image" data-image-slot="0">
                    <img src="{{ asset('assets/images/website/categories/1.png') }}" alt="{{ __('main.ecommerce_programming') }}">
                </div>
                <div class="image" data-image-slot="1">
                    <img src="{{ asset('assets/images/website/categories/2.png') }}" alt="{{ __('main.ecommerce_programming') }}">
                </div>
                <div class="image" data-image-slot="2">
                    <img src="{{ asset('assets/images/website/categories/3.png') }}" alt="{{ __('main.ecommerce_programming') }}">
                </div>
            @endif
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-categories-programming</div>
    @endif
</section>


{{-- @php
    $categoriesProgrammingImages = \App\Models\CategoriesProgramming::active()->ordered()->get();
@endphp

<section class="section categories-programming-section relative">
    <div class="content flex items-center justify-between">
        <div class="text">
            <div class="title font-semibold">{{ __('main.categories_title') }} <span class="title-badge">{{ __('main.brand_short') }}</span></div>
            <div class="description">
                {{ __('main.categories_description') }}
            </div>
        </div>

        <div class="images flex items-center" data-random-images>
            @forelse ($categoriesProgrammingImages as $index => $image)
                <div class="image" data-image-slot="{{ $index }}">
                    <img src="{{ Storage::url($image->image) }}" alt="{{ $image->alt_text ?? __('main.ecommerce_programming') }}">
                </div>
            @empty
                Fallback to static images if no dynamic images exist
                <div class="image" data-image-slot="0">
                    <img src="{{ asset('assets/images/website/categories/1.png') }}" alt="{{ __('main.ecommerce_programming') }}">
                </div>
                <div class="image" data-image-slot="1">
                    <img src="{{ asset('assets/images/website/categories/2.png') }}" alt="{{ __('main.ecommerce_programming') }}">
                </div>
                <div class="image" data-image-slot="2">
                    <img src="{{ asset('assets/images/website/categories/3.png') }}" alt="{{ __('main.ecommerce_programming') }}">
                </div>
            @endforelse
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-categories-programming</div>
    @endif
</section> --}}
