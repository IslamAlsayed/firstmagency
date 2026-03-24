{{-- ? Start plugins --}}
{{-- jquery-3.7.1 --}}
<script src="{{ asset('assets/plugins/jquery@3.7.1/jquery-3.7.1.min.js') }}"></script>
{{-- Multiple select plugin --}}
<script defer src="{{ asset('assets/plugins/select2@4.1.0-rc.0/js/select2.min.js') }}"></script>
{{-- Swiper slider --}}
<script defer src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-element-bundle.min.js"></script>
{{-- Text editor --}}
<script defer src="{{ asset('assets/plugins/trix@2.0.0/trix@2.0.0.js') }}"></script>
{{-- Fontawesome icons pro --}}
<script defer src="{{ asset('assets/plugins/fontawesome-icons/js/all.min.js') }}"></script>
{{-- Ably realtime --}}
<script src="{{ asset('assets/plugins/local-ably-cdn/ably.min.js') }}"></script>
{{-- <script src="{{ asset('assets/plugins/local-ably-cdn/setup.js') }}"></script> --}}

{{-- ? End plugins --}}

<script defer src="{{ asset('assets/js/script.js') }}"></script>
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

        const copyTextToClipboard = async function(text) {
            if (!text) return false;

            if (navigator.clipboard && window.isSecureContext) {
                await navigator.clipboard.writeText(text);
                return true;
            }

            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.opacity = '0';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            const copied = document.execCommand('copy');
            document.body.removeChild(textArea);
            return copied;
        };

        const flagElements = document.querySelectorAll('.debug-flag-badge');
        flagElements.forEach(function(element) {
            element.classList.add('js-copy-flag');
            element.style.cursor = 'pointer';
            element.setAttribute('title', 'Click to copy flag');

            element.addEventListener('click', async function() {
                const extracted = (element.textContent || '').match(/flag-[a-z0-9\-_]+/i);
                const flagText = extracted ? extracted[0] : (element.textContent || '').trim();
                if (!flagText) return;

                try {
                    const copied = await copyTextToClipboard(flagText);
                    if (!copied) throw new Error('copy_failed');

                    if (window.showToast && typeof window.showToast === 'function') {
                        window.showToast({
                            type: 'success',
                            message: 'Copied: ' + flagText,
                        });
                    }
                } catch (error) {
                    if (window.showToast && typeof window.showToast === 'function') {
                        window.showToast({
                            type: 'error',
                            message: 'Failed to copy flag',
                        });
                    }
                }
            });
        });
    });
</script>
