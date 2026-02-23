<section class="section dont-worry-sections support-sections">
    <div class="content flex items-center justify-between gap-8">
        <div class="text">
            <div class="label font-semibold">{{ __('main.hosting_support_title') }}</div>
            <div class="heading font-semibold">{{ __('main.hosting_support_title') }}</div>
            <div class="descriptions">
                <p>{{ __('main.hosting_support_description') }}</p>
            </div>
            <a href="/" class="btn-link light-main-color dark-hover font-semibold">
                {{ __('main.btn_start_here') }}
            </a>
        </div>
        <div class="image">
            <img src="{{ asset('assets/images/hosting/support-hosting-bg.png') }}" alt="Support Hosting Image" class="img-fluid">
        </div>
    </div>

    <div class="support-stats grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="support-stat cursor-pointer">
            <div class="support-stat-icon">
                <i class="fas fa-bolt" aria-hidden="true"></i>
            </div>
            <div class="support-stat-value font-semibold">76%</div>
            <div class="support-stat-label font-semibold">{{ __('main.hosting_support_stat_first_contact') }}</div>
        </div>
        <div class="support-stat cursor-pointer">
            <div class="support-stat-icon">
                <i class="fas fa-heart" aria-hidden="true"></i>
            </div>
            <div class="support-stat-value font-semibold">96%</div>
            <div class="support-stat-label font-semibold">{{ __('main.hosting_support_stat_satisfaction') }}</div>
        </div>
        <div class="support-stat cursor-pointer">
            <div class="support-stat-icon">
                <i class="fas fa-hourglass" aria-hidden="true"></i>
            </div>
            <div class="support-stat-value font-semibold">sec 59</div>
            <div class="support-stat-label font-semibold">{{ __('main.hosting_support_stat_response_time') }}</div>
        </div>
        <div class="support-stat cursor-pointer">
            <div class="support-stat-icon">
                <i class="fas fa-thumbs-up" aria-hidden="true"></i>
            </div>
            <div class="support-stat-value font-semibold">3267</div>
            <div class="support-stat-label font-semibold">{{ __('main.hosting_support_stat_requests') }}</div>
        </div>
    </div>

</section>
