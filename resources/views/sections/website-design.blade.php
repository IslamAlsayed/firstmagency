<section class="website-design relative">
    <div class="layout"></div>
    <div class="content">
        <div class="text">
            <div class="title">
                {{ $settings->website_design_title ?? __('main.website_design_title') }}
            </div>

            <div class="heading">
                {{ $settings->website_design_heading ?? __('main.website_design_heading') }}
                <span class="title-badge">{{ __('main.brand_short') }}</span>
            </div>

            <div class="description">
                {{ $settings->website_design_description ?? __('main.website_design_description_part1') }}
            </div>

            <div class="tags">
                <div class="tag flex items-center gap-2">
                    <div class="icon">
                        <i class="fas fa-handshake"></i>
                    </div>
                    <div class="font-semibold">
                        <p>{{ \App\Models\Client::count() }}</p>
                        <span>{{ __('main.website_design_clients') }}</span>
                    </div>
                </div>

                <div class="tag flex items-center gap-2">
                    <div class="icon">
                        <i class="fas fa-briefcase"></i>
                    </div>
                    <div class="font-semibold">
                        <p>{{ \App\Models\Company::count() }}</p>
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
                        <p>{{ \App\Models\Ticket::count() }}</p>
                        <span>{{ __('main.website_design_support_ticket') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="image">
            <img src="{{ asset('assets/images/website/developer/design.png') }}" alt="{{ __('main.design_title') }}">
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-website-designer</div>
    @endif
</section>
