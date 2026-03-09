<section class="section operations-systems-sections text-center relative">
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
                                <img src="{{ asset('assets/images/website/' . $system['icon']) }}" alt="">
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
                                <img src="{{ asset('assets/images/website/' . $item['icon']) }}" alt="">
                            </div>
                            <h3 class="font-semibold text-lg mb-2">{{ $item['title'] }}</h3>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-operating-systems</div>
    @endif
</section>

{{-- <section class="section operations-systems-sections text-center relative">
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
                @php
                    $operatingSystems = \App\Models\DashboardsAndSystem::operatingSystems()->orderBy('order')->get();
                @endphp
                @if ($operatingSystems && count($operatingSystems) > 0)
                    @foreach ($operatingSystems as $system)
                        <div class="system-card p-3">
                            <div class="image mb-4">
                                @if ($system->image)
                                    <img src="{{ asset('storage/' . $system->image) }}"
                                        alt="{{ $system->translations[app()->getLocale()]['title'] ?? 'System' }}">
                                @endif
                            </div>
                            <h3 class="font-semibold text-lg mb-2">{{ $system->translations[app()->getLocale()]['title'] ?? '-' }}</h3>
                        </div>
                    @endforeach
                @else
                    @if (config('operating-systems') && count(config('operating-systems')) > 0)
                        @foreach (config('operating-systems') as $system)
                            <div class="system-card p-3">
                                <div class="image mb-4">
                                    <img src="{{ asset('assets/images/website/' . $system['icon']) }}" alt="">
                                </div>
                                <h3 class="font-semibold text-lg mb-2">{{ $system['title'] }}</h3>
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
        <div class="hidden" data-category="dashboards-and-apps">
            <div class="content items-center">
                @php
                    $dashboardsAndSystems = \App\Models\DashboardsAndSystem::dashboardsApps()->orderBy('order')->get();
                @endphp
                @if ($dashboardsAndSystems && count($dashboardsAndSystems) > 0)
                    @foreach ($dashboardsAndSystems as $item)
                        <div class="system-card p-3">
                            <div class="image mb-4">
                                @if ($item->image)
                                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->translations[app()->getLocale()]['title'] ?? 'App' }}">
                                @endif
                            </div>
                            <h3 class="font-semibold text-lg mb-2">{{ $item->translations[app()->getLocale()]['title'] ?? '-' }}</h3>
                        </div>
                    @endforeach
                @else
                    @if (config('dashboards-and-apps') && count(config('dashboards-and-apps')) > 0)
                        @foreach (config('dashboards-and-apps') as $item)
                            <div class="system-card p-3">
                                <div class="image mb-4">
                                    <img src="{{ asset('assets/images/website/' . $item['icon']) }}" alt="">
                                </div>
                                <h3 class="font-semibold text-lg mb-2">{{ $item['title'] }}</h3>
                            </div>
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-operating-systems</div>
    @endif
</section> --}}
