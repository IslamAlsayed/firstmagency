{{-- ? Start plugins --}}
{{-- jquery-3.7.1 --}}
<script defer src="{{ asset('assets/plugins/jquery@3.7.1/jquery-3.7.1.min.js') }}"></script>
{{-- Multiple select plugin --}}
<script defer src="{{ asset('assets/plugins/select2@4.1.0-rc.0/js/select2.min.js') }}"></script>
{{-- Text editor --}}
<script defer src="{{ asset('assets/plugins/trix@2.0.0/trix@2.0.0.js') }}"></script>
{{-- Fontawesome icons pro --}}
<script defer src="{{ asset('assets/plugins/fontawesome-icons/js/all.min.js') }}"></script>
{{-- Ably realtime --}}
<script defer src="{{ asset('assets/plugins/local-ably-cdn/ably.min.js') }}"></script>
{{-- ? End plugins --}}

{{-- Custom Js --}}
<script defer src="{{ asset('assets/dashboard/js/main.js') }}"></script>
@vite(['resources/js/app.js'])

@yield('scripts')
@stack('scripts')

<script>
    document.addEventListener('DOMContentLoaded', function() {
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
