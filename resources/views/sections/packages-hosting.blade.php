<section class="section packages-sections text-center">
    <div class="mb-8">
        <div class="title text-3xl font-semibold mb-4">
            باقات استضافة <span class="title-badge">{{ __('main.brand_name') }}</span>
        </div>
        <p class="text-gray-600">اختر من باقات الاستضافة او السيرفرات او خدمات الموزع</p>
    </div>

    <div class="">
        <div class="filter price-packages">
            <button class="btn-link main-color dark-hover font-semibold filter-btn-style filter-btn-price" data-filter="monthly_price">شهري</button>
            <button class="btn-link main-color dark-hover font-semibold filter-btn-style active filter-btn-price" data-filter="yearly_price">سنوي</button>
        </div>

        <div class="filter-btn-packages flex items-center justify-between gap-4 bg-white p-2 shadow-sm border mx-auto mb-4 rounded-[9px]">
            <button data-target="hosting" class="filter-btn-package active flex items-center justify-between gap-2 cursor-pointer">
                <div class="flex items-center justify-between gap-2">
                    <div class="image">
                        <img src="{{ asset('assets/images/hosting/hosting-packages/icon.png') }}" alt="">
                    </div>
                    <span class="font-semibold">{{ __('main.hosting_packages_shared') }}</span>
                </div>
                <i class="fas fa-chevron-down"></i>
            </button>
            <button data-target="reseller" class="filter-btn-package flex items-center justify-between gap-2 cursor-pointer">
                <div class="flex items-center justify-between gap-2">
                    <div class="image">
                        <img src="{{ asset('assets/images/hosting/reseller-packages/icon.png') }}" alt="">
                    </div>
                    <span class="font-semibold">{{ __('main.hosting_packages_reseller') }}</span>
                </div>
                <i class="fas fa-chevron-down"></i>
            </button>
            <button data-target="vps" class="filter-btn-package flex items-center justify-between gap-2 cursor-pointer">
                <div class="flex items-center justify-between gap-2">
                    <div class="image">
                        <img src="{{ asset('assets/images/hosting/vps-packages/icon.png') }}" alt="">
                    </div>
                    <span class="font-semibold">{{ __('main.hosting_packages_vps') }}</span>
                </div>
                <i class="fas fa-chevron-down"></i>
            </button>
            <button data-target="servers" class="filter-btn-package flex items-center justify-between gap-2 cursor-pointer">
                <div class="flex items-center justify-between gap-2">
                    <i class="fas fa-cloud"></i>
                    <span class="font-semibold">{{ __('main.hosting_packages_dedicated') }}</span>
                </div>
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>
    </div>

    <div class="">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            @if (config('packages-hosting') && count(config('packages-hosting')) > 0)
                @foreach (config('packages-hosting') as $category => $packages)
                    @foreach ($packages as $package)
                        <div class="package-card" data-category="{{ $category }}">
                            <div class="relative p-3">

                                @if ($package['is_popular'] ?? false)
                                    <div class="main-popular">{{ __('main.hosting_packages_popular') }}</div>
                                @endif

                                <div class="mb-6">
                                    <div class="image">
                                        @if (isset($package['image']) && checkExistFileInPublic($package['image']))
                                            <img src="{{ asset('assets/images/' . $package['image']) }}" class="w-16 mx-auto mb-4"
                                                alt="{{ $package['name'] }}">
                                        @else
                                            <img src="{{ asset('assets/images/placeholder.png') }}" class="w-16 mx-auto mb-4" alt="Placeholder">
                                        @endif
                                    </div>
                                    <h3 class="text-xl font-semibold">{{ $package['name'] }}</h3>
                                </div>

                                <div class="mb-8">
                                    <div class="flex justify-center items-start">
                                        <span class="font-semibold">$</span>
                                        <span class="font-semibold main-price monthly_price hidden">{{ $package['month_price'] }}</span>
                                        <span class="font-semibold main-price yearly_price">{{ $package['year_price'] }}</span>
                                    </div>
                                    <p class="text-gray-600 text-sm mt-1">{{ __('main.hosting_packages_yearly_label') }}</p>
                                </div>

                                <ul class="space-y-4 mb-8">
                                    @foreach ($package['features'] as $feature)
                                        <li class="feature-card flex items-center justify-between text-right group/item mb-2">
                                            <div class="flex items-center justify-between gap-2">
                                                <svg class="w-5 h-5 text-gray-800" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-gray-700 text-sm font-medium mr-auto">{{ $feature['title'] }}</span>
                                            </div>
                                            <span
                                                class="main-label text-gray-600 cursor-pointer font-semibold text-xs border border-gray-300 rounded-full w-5 h-5 flex items-center justify-center"
                                                data-label="{{ $feature['label'] }}">?</span>
                                        </li>
                                    @endforeach
                                </ul>

                                <button class="main-button w-full py-3 rounded-xl text-blue-600 font-semibold cursor-pointer transition-all">
                                    {{ __('main.btn_request_now') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
</section>
