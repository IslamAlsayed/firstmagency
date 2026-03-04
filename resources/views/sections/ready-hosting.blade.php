<section class="section ready-hosting-sections text-center relative">
    <div class="content mx-auto px-4">
        <p class="font-semibold mb-4 opacity-95">
            {{ __('main.ready_hosting_description') }}
        </p>

        <h1 class="font-semibold font-black mb-10 tracking-wide">
            {{ __('main.ready_heading') }}
        </h1>

        <div class="ready-actions flex flex-row-reverse justify-center gap-4">
            <a href="{{ route('hosting') }}" class="btn-outline-white text-lg font-semibold">
                {{ __('main.start_now_btn') }}
            </a>
            <a href="{{ route('contact') }}" class="btn-outline-white text-lg font-semibold">
                {{ __('main.contact_us_btn') }}
            </a>
        </div>
    </div>
    @if (isDebugModeEnabled())
        <div class="debug-flag-badge">🚩 flag-ready-hosting</div>
    @endif
</section>
