<section class="section dont-worry-sections main-dont-worry-sections">
    <div class="content flex items-center justify-between gap-8">
        <div class="text">
            <div class="label font-semibold">{{ __('main.hosting_worry_label') }}</div>
            <div class="heading font-semibold">{{ __('main.hosting_worry_title') }}</div>
            <div class="descriptions">
                <p>{{ __('main.hosting_worry_description_1') }}</p>
                <p>{{ __('main.hosting_worry_description_2') }}</p>
            </div>
            <a href="{{ route('domains') }}" class="btn-link light-main-color dark-hover font-semibold">
                {{ __('main.btn_transfer_now') }}
            </a>
        </div>
        <div class="image">
            <img src="{{ asset('assets/images/website/hosting/dont-worry-bg.png') }}" alt="{{ __('main.dont_worry_image') }}" class="img-fluid">
        </div>
    </div>
</section>
