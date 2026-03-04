<section class="section easy-management relative">
    <div class="flex items-center">
        <div class="image-container">
            <div class="image">
                <img src="{{ asset('assets/images/website/hosting/easy-management-bg.png') }}" alt="">
            </div>
        </div>

        <div class="text">
            <div class="badge font-semibold mb-4">
                {{ __('main.easy_management_badge') }}
            </div>

            <h1 class="font-semibold">{{ __('main.easy_management_title') }}</h1>

            <div class="descriptions">
                <p>{{ __('main.easy_management_description_1') }}</p>
                <p>{{ __('main.easy_management_description_2') }}</p>
            </div>

            <a href="/" class="btn-link main-color dark-hover font-semibold">
                {{ __('main.btn_start_now') }}
            </a>
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-easy-management</div>
    @endif
</section>
