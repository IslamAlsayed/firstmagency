<section class="website-design relative">
    <div class="layout"></div>
    <div class="content">
        <div class="text">
            <div class="title">
                @if (app()->getLocale() === 'ar' && hasDisplayableRichText($settings ?? null, 'website_design_title_ar'))
                    {!! $settings->website_design_title_ar ?? '' !!}
                @elseif (app()->getLocale() === 'en' && hasDisplayableRichText($settings ?? null, 'website_design_title'))
                    {!! $settings->website_design_title ?? '' !!}
                @else
                    {!! __('main.website_design_title') ?? '' !!}
                @endif
            </div>

            <div class="heading">
                @if (app()->getLocale() === 'ar' && hasDisplayableRichText($settings ?? null, 'website_design_heading_ar'))
                    {!! $settings->website_design_heading_ar ?? '' !!}
                @elseif (app()->getLocale() === 'en' && hasDisplayableRichText($settings ?? null, 'website_design_heading'))
                    {!! $settings->website_design_heading ?? '' !!}
                @else
                    {!! __('main.website_design_heading') ?? '' !!}
                @endif
                <span class="title-badge">{{ __('main.brand_short') }}</span>
            </div>

            <div class="description">
                @if (app()->getLocale() === 'ar' && hasDisplayableRichText($settings ?? null, 'website_design_description_ar'))
                    {!! $settings->website_design_description_ar ?? '' !!}
                @elseif (app()->getLocale() === 'en' && hasDisplayableRichText($settings ?? null, 'website_design_description'))
                    {!! $settings->website_design_description ?? '' !!}
                @else
                    {!! __('main.website_design_description') ?? '' !!}
                @endif
            </div>

            <div class="tags">
                <div class="tag flex items-center gap-2">
                    <div class="icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="font-semibold">
                        <p>{{ $stats['clients_count'] ?? 0 }}</p>
                        <span>{{ __('main.website_design_clients') }}</span>
                    </div>
                </div>

                <div class="tag flex items-center gap-2">
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="font-semibold">
                        <p>{{ $stats['projects_count'] ?? 0 }}</p>
                        <span>{{ __('main.website_design_projects') }}</span>
                    </div>
                </div>

                <div class="tag flex items-center gap-2">
                    <div class="icon">
                        <i class="fas fa-award"></i>
                    </div>
                    <div class="font-semibold">
                        <p>{{ $settings->website_design_years_experience ?? 8 }}</p>
                        <span>{{ __('main.website_design_years_experience') }}</span>
                    </div>
                </div>

                <div class="tag flex items-center gap-2">
                    <div class="icon">
                        <i class="fa-regular fa-at"></i>
                    </div>
                    <div class="font-semibold">
                        <p>{{ $stats['tickets_count'] ?? 0 }}</p>
                        <span>{{ __('main.website_design_support_ticket') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="image">
            <img src="{{ asset('assets/images/website/developer/design.png') }}" alt="{{ __('main.design_title') }}" class="clickable-img"
                data-src="{{ asset('assets/images/website/developer/design.png') }}">
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-website-designer</div>
    @endif
</section>
