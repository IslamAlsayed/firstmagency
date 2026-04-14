<section class="section operations-systems-sections text-center relative">
    <div class="mb-8">
        <div class="title text-3xl font-semibold mb-4">
            {{ __('main.operating_systems_title') }} <span class="title-badge">{{ __('main.control_panels_badge') }}</span>
        </div>
        <p class="text-gray-600">{{ __('main.operating_systems_description') }}</p>
    </div>

    <div class="custom-background">
        <div class="filter operating-systems-filter">
            <button class="btn-link main-color dark-hover font-semibold filter-btn-style active filter-operating-systems" data-filter="operating-systems">
                {{ __('main.operating_systems_filter_label') }}
            </button>
            <button class="btn-link main-color dark-hover font-semibold filter-btn-style filter-operating-systems" data-filter="dashboards-and-apps">
                {{ __('main.control_panels_and_apps_label') }}
            </button>
        </div>

        <div>
            <div data-category="operating-systems">
                <div class="content items-center">
                    @php
                        $systems = isset($operating['systems']) && count($operating['systems']) > 0 ? $operating['systems'] : config('operating-systems') ?? [];
                    @endphp
                    @if ($systems && count($systems) > 0)
                        @foreach ($systems as $system)
                            <div class="system-card p-3">
                                <div class="image mb-4">
                                    @if ($system instanceof \App\Models\DashboardsAndSystem)
                                        @if ($system->image)
                                            <img src="{{ Storage::url($system->image) }}" alt="{{ $system->translations['title'] ?? '' }}" class="clickable-img" loading="lazy"
                                                data-src="{{ Storage::url($system->image) }}">
                                        @endif
                                    @else
                                        <img src="{{ asset('assets/images/website/' . $system['icon']) }}" alt="" class="clickable-img" loading="lazy"
                                            data-src="{{ asset('assets/images/website/' . $system['icon']) }}">
                                    @endif
                                </div>
                                <h3 class="font-semibold text-lg mb-2">
                                    @if ($system instanceof \App\Models\DashboardsAndSystem)
                                        {{ $system->translations['title'] ?? $system->slug }}
                                    @else
                                        {{ $system['title'] }}
                                    @endif
                                </h3>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
            <div class="hidden" data-category="dashboards-and-apps">
                <div class="content items-center">
                    @php
                        $apps = isset($operating['apps']) && count($operating['apps']) > 0 ? $operating['apps'] : config('dashboards-and-apps') ?? [];
                    @endphp
                    @if ($apps && count($apps) > 0)
                        @foreach ($apps as $item)
                            <div class="system-card p-3">
                                <div class="image mb-4">
                                    @if ($item instanceof \App\Models\DashboardsAndSystem)
                                        @if ($item->image)
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->translations['title'] ?? '' }}" class="clickable-img" loading="lazy"
                                                data-src="{{ Storage::url($item->image) }}">
                                        @endif
                                    @else
                                        <img src="{{ asset('assets/images/website/' . $item['icon']) }}" alt="" class="clickable-img" loading="lazy"
                                            data-src="{{ asset('assets/images/website/' . $item['icon']) }}">
                                    @endif
                                </div>
                                <h3 class="font-semibold text-lg mb-2">
                                    @if ($item instanceof \App\Models\DashboardsAndSystem)
                                        {{ $item->translations['title'] ?? $item->slug }}
                                    @else
                                        {{ $item['title'] }}
                                    @endif
                                </h3>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-operating-systems</div>
    @endif
</section>
