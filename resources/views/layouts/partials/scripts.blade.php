{{-- ? Start plugins --}}
{{-- jquery-3.7.1 --}}
<script src="{{ asset('assets/plugins/jquery@3.7.1/jquery-3.7.1.min.js') }}"></script>
{{-- Multiple select plugin --}}
<script src="{{ asset('assets/plugins/select2@4.1.0-rc.0/js/select2.min.js') }}"></script>
{{-- Swiper slider --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-element-bundle.min.js"></script>
{{-- Text editor --}}
<script src="{{ asset('assets/plugins/trix@2.0.0/trix@2.0.0.js') }}"></script>
{{-- Fontawesome icons pro --}}
<script src="{{ asset('assets/plugins/fontawesome-icons/js/all.min.js') }}"></script>
{{-- Ably realtime --}}
<script src="{{ asset('assets/plugins/local-ably-cdn/ably.min.js') }}"></script>
{{-- <script src="{{ asset('assets/plugins/local-ably-cdn/setup.js') }}"></script> --}}

{{-- ? End plugins --}}

<script src="{{ asset('assets/js/script.js') }}"></script>
{{-- Multiples JS --}}
@vite(['resources/js/app.js'])
@yield('scripts')
@stack('scripts')

<script>
    const endWorkTime = '{{ config('app.end_work_time') }}';

    function calculateRemainingTime() {
        if (!endWorkTime) return;

        const now = new Date();
        const [hours, minutes] = endWorkTime.split(':').map(Number);

        const endTime = new Date();
        endTime.setHours(hours, minutes, 0, 0);

        // If end time has passed today, don't show negative time
        if (now > endTime) {
            document.getElementById('remaining-time').textContent =
                '{{ __('main.fixed_support_remaining_time') }}: 00:00';
            return;
        }

        const diff = endTime - now;
        const remainingHours = Math.floor(diff / (1000 * 60 * 60));
        const remainingMinutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));

        const timeString = `${String(remainingHours).padStart(2, '0')}:${String(remainingMinutes).padStart(2, '0')}`;
        document.getElementById('remaining-time').textContent =
            '{{ __('main.fixed_support_remaining_time') }}: ' + timeString;
    }

    // تحديث الوقت كل ثانية
    calculateRemainingTime();
    setInterval(calculateRemainingTime, 1000);

    document.addEventListener('DOMContentLoaded', function() {
        let openSupportContent = document.getElementById('open-fixed-support');
        let closeSupportContent = document.getElementById('close-fixed-support');
        let fixedSupportContent = document.getElementById('fixed-support-content');

        if (openSupportContent) {
            openSupportContent.addEventListener('click', function() {
                fixedSupportContent.classList.remove('hidden');
                openSupportContent.classList.add('hidden');
            });
        }

        if (closeSupportContent) {
            closeSupportContent.addEventListener('click', function(e) {
                fixedSupportContent.classList.add('hidden');
                openSupportContent.classList.remove('hidden');
            });
        }
        document.addEventListener('click', function(e) {
            if (!document.getElementById('fixed-support').contains(e.target)) {
                fixedSupportContent.classList.add('hidden');
                openSupportContent.classList.remove('hidden');
            }
        });
    });
</script>
