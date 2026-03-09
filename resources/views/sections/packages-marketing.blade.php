<section class="section packages-marketing text-center relative">
    <div class="content">
        <div class="mb-8">
            <div class="title font-semibold mb-4">
                {{ __('main.our_services_title') }}
            </div>
            <p class="text-gray-600">{{ __('main.services_marketing_description') }}</p>
        </div>

        <div class="section-svg">
            <div class="left-svg"></div>
            <div class="right-svg"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @if (config('packages-marketing') && count(config('packages-marketing')) > 0)
                @foreach (config('packages-marketing') as $service)
                    <div class="service-card p-4">
                        <div class="mb-6">
                            <div class="image">
                                @if (isset($service['image']))
                                    <img src="{{ asset('assets/images/website/' . $service['image']) }}" class="w-16 mx-auto mb-4"
                                        alt="{{ $service['title'] }}">
                                @elseif (isset($service['icon']))
                                    {!! $service['icon'] !!}
                                @endif
                            </div>
                            <h3 class="text-xl font-semibold">{{ $service['title'] }}</h3>
                        </div>

                        <ul class="space-y-4 mb-8">
                            @foreach ($service['details'] as $detail)
                                <li class="feature-card flex justify-start gap-2 mb-2">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-600">{!! $detail !!}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-packages-marketing</div>
    @endif
</section>


{{-- <section class="section packages-marketing text-center relative">
    <div class="content">
        <div class="mb-8">
            <div class="title font-semibold mb-4">
                {{ __('main.our_services_title') }}
            </div>
            <p class="text-gray-600">{{ __('main.services_marketing_description') }}</p>
        </div>

        <div class="section-svg">
            <div class="left-svg"></div>
            <div class="right-svg"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $services = \App\Models\MarketingPackage::active()->ordered()->get() @endphp
            @forelse($services as $service)
                <div class="service-card p-4">
                    <div class="mb-6">
                        <div class="image">
                            @if ($service->image && checkExistFile($service->image))
                                <img src="{{ asset('storage/' . $service->image) }}" class="w-16 mx-auto mb-4"
                                    alt="{{ $service->alt_text ?? ($service->translations[app()->getLocale()]['title'] ?? '') }}">
                            @endif
                        </div>
                        <h3 class="text-xl font-semibold">
                            {{ $service->translations[app()->getLocale()]['title'] ?? ($service->translations['ar']['title'] ?? '') }}</h3>
                    </div>

                    <ul class="space-y-4 mb-8">
                        @foreach ($service->translations[app()->getLocale()]['features'] ?? ($service->translations['ar']['features'] ?? []) as $feature)
                            <li class="feature-card flex justify-start gap-2 mb-2">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-600">{!! $feature !!}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                @if (config('packages-marketing') && count(config('packages-marketing')) > 0)
                    @foreach (config('packages-marketing') as $service)
                        <div class="service-card p-4">
                            <div class="mb-6">
                                <div class="image">
                                    @if (isset($service['image']))
                                        <img src="{{ asset('assets/images/website/' . $service['image']) }}" class="w-16 mx-auto mb-4"
                                            alt="{{ $service['title'] }}">
                                    @elseif (isset($service['icon']))
                                        {!! $service['icon'] !!}
                                    @endif
                                </div>
                                <h3 class="text-xl font-semibold">{{ $service['title'] }}</h3>
                            </div>

                            <ul class="space-y-4 mb-8">
                                @foreach ($service['details'] as $detail)
                                    <li class="feature-card flex justify-start gap-2 mb-2">
                                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-600">{!! $detail !!}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif
            @endforelse
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-packages-marketing</div>
    @endif
</section>


{{-- <section class="section packages-marketing text-center relative">
    <div class="content">
        <div class="mb-8">
            <div class="title font-semibold mb-4">
                {{ __('main.our_services_title') }}
            </div>
            <p class="text-gray-600">{{ __('main.services_marketing_description') }}</p>
        </div>

        <div class="section-svg">
            <div class="left-svg"></div>
            <div class="right-svg"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php $services = \App\Models\PackagesMarketing::active()->published()->ordered()->get() @endphp
            @forelse($services as $service)
                <div class="service-card p-4">
                    <div class="mb-6">
                        <div class="image">
                            @if ($service->image && checkExistFile($service->image))
                                <img src="{{ asset('storage/' . $service->image) }}" class="w-16 mx-auto mb-4"
                                    alt="{{ $service->alt_text ?? ($service->translations[app()->getLocale()]['title'] ?? '') }}">
                            @elseif ($service->icon)
                                <div class="w-16 h-16 mx-auto mb-4 flex items-center justify-center">
                                    {!! $service->icon !!}
                                </div>
                            @endif
                        </div>
                        <h3 class="text-xl font-semibold">
                            {{ $service->translations[app()->getLocale()]['title'] ?? ($service->translations['ar']['title'] ?? '') }}</h3>
                    </div>

                    <ul class="space-y-4 mb-8">
                        @foreach ($service->translations[app()->getLocale()]['details'] ?? ($service->translations['ar']['details'] ?? []) as $detail)
                            <li class="feature-card flex justify-start gap-2 mb-2">
                                <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="text-gray-600">{!! $detail !!}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @empty
                @if (config('packages-marketing') && count(config('packages-marketing')) > 0)
                    @foreach (config('packages-marketing') as $service)
                        <div class="service-card p-4">
                            <div class="mb-6">
                                <div class="image">
                                    @if (isset($service['image']))
                                        <img src="{{ asset('assets/images/website/' . $service['image']) }}" class="w-16 mx-auto mb-4"
                                            alt="{{ $service['title'] }}">
                                    @elseif (isset($service['icon']))
                                        {!! $service['icon'] !!}
                                    @endif
                                </div>
                                <h3 class="text-xl font-semibold">{{ $service['title'] }}</h3>
                            </div>

                            <ul class="space-y-4 mb-8">
                                @foreach ($service['details'] as $detail)
                                    <li class="feature-card flex justify-start gap-2 mb-2">
                                        <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="text-gray-600">{!! $detail !!}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                @endif
            @endforelse
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-packages-marketing</div>
    @endif
</section> --}}
