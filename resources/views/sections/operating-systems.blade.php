<div class="section operations-systems-sections text-center">
    <div class="mb-8">
        <div class="title text-3xl font-semibold mb-4">
            انظمة تشغيل <span class="title-badge">ولوحات تحكم</span>
        </div>
        <p class="text-gray-600">جميع البرامج ولوحات التحكم وسكربتات ادارة المحتوي وانظمة التشغيل</p>
    </div>

    <div class="filter operating-systems-filter">
        <button class="btn-link main-color dark-hover font-semibold filter-btn-style active filter-operating-systems" data-filter="operating-systems">
            أنظمة تشغيل
        </button>
        <button class="btn-link main-color dark-hover font-semibold filter-btn-style filter-operating-systems" data-filter="dashboards-and-apps">
            لوحات تحكم وتطبيقات
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
</div>
