<section class="section operations-systems-sections text-center">
    <div class="mb-8">
        <div class="title text-3xl font-semibold mb-4">
            {{ __('main.operating_systems_title') }} <span class="title-badge">{{ __('main.control_panels_badge') }}</span>
        </div>
        <p class="text-gray-600">{{ __('main.operating_systems_description') }}</p>
    </div>

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
                @if (config('operating-systems') && count(config('operating-systems')) > 0)
                    @foreach (config('operating-systems') as $system)
                        <div class="system-card p-3">
                            <div class="image mb-4">
                                <img src="{{ asset('assets/images/' . $system['icon']) }}" alt="">
                            </div>
                            <h3 class="font-semibold text-lg mb-2">{{ $system['title'] }}</h3>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="hidden" data-category="dashboards-and-apps">
            <div class="content items-center">
                @if (config('dashboards-and-apps') && count(config('dashboards-and-apps')) > 0)
                    @foreach (config('dashboards-and-apps') as $item)
                        <div class="system-card p-3">
                            <div class="image mb-4">
                                <img src="{{ asset('assets/images/' . $item['icon']) }}" alt="">
                            </div>
                            <h3 class="font-semibold text-lg mb-2">{{ $item['title'] }}</h3>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</section>
