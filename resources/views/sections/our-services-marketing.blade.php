<section class="section our-services-marketing text-center">
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
            @if (config('our-services-marketing') && count(config('our-services-marketing')) > 0)
                @foreach (config('our-services-marketing') as $service)
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
</section>
