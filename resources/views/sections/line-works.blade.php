<section class="line-works-section relative">
    <div class="info">
        <div class="title font-semibold">{{ __('main.line_works_title') }}</div>
        <div class="description">
            {{ __('main.line_works_description') }}
        </div>
    </div>

    <div class="steps">
        @if (isset($lineWorks) && $lineWorks->count() > 0)
            @foreach ($lineWorks as $lineWork)
                <div class="step">
                    <div class="text">
                        <div class="heading font-semibold">{{ $lineWork->translations[app()->getLocale()]['title'] }}</div>
                        <div class="details">{{ $lineWork->translations[app()->getLocale()]['description'] }}</div>
                    </div>
                    <div class="image">
                        @if ($lineWork->image && checkExistFile($lineWork->image))
                            <img src="{{ asset('storage/' . $lineWork->image) }}" alt="{{ $lineWork->translations[app()->getLocale()]['title'] }}" loading="lazy">
                        @else
                            <img src="{{ asset('assets/images/website/line-works/' . $lineWork->order . '.png') }}" alt="{{ $lineWork->translations[app()->getLocale()]['title'] }}" loading="lazy">
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="step">
                <div class="text">
                    <div class="heading font-semibold">{{ __('main.line_work_step1_title') }}</div>
                    <div class="details">{{ __('main.line_work_step1_desc') }}</div>
                </div>
                <div class="image">
                    <img src="{{ asset('assets/images/website/line-works/1.png') }}" alt="{{ __('main.line_work_step1_title') }}" loading="lazy">
                </div>
            </div>
            <div class="step">
                <div class="text">
                    <div class="heading font-semibold">{{ __('main.line_work_step2_title') }}</div>
                    <div class="details">{{ __('main.line_work_step2_desc') }}</div>
                </div>
                <div class="image">
                    <img src="{{ asset('assets/images/website/line-works/2.png') }}" alt="{{ __('main.line_work_step2_title') }}" loading="lazy">
                </div>
            </div>
            <div class="step">
                <div class="text">
                    <div class="heading font-semibold">{{ __('main.line_work_step3_title') }}</div>
                    <div class="details">{{ __('main.line_work_step3_desc') }}</div>
                </div>
                <div class="image">
                    <img src="{{ asset('assets/images/website/line-works/3.png') }}" alt="{{ __('main.line_work_step3_title') }}" loading="lazy">
                </div>
            </div>
            <div class="step">
                <div class="text">
                    <div class="heading font-semibold">{{ __('main.line_work_step4_title') }}</div>
                    <div class="details">{{ __('main.line_work_step4_desc') }}</div>
                </div>
                <div class="image">
                    <img src="{{ asset('assets/images/website/line-works/4.png') }}" alt="{{ __('main.line_work_step4_title') }}" loading="lazy">
                </div>
            </div>
        @endif
    </div>

    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-line-works</div>
    @endif
</section>
