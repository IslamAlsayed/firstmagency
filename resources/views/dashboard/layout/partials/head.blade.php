<title>@yield('title', 'FirstMagency')</title>
<base href="../../">
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<script>
    window.USERID = "{{ getActiveUserId() }}";
    window.APP_LANG = "{{ app()->getLocale() }}";
    window.APP_DEBUG = {{ config('app.debug') ? 'true' : 'false' }};
</script>
<meta content="follow, index" name="robots" />
<link href="{{ url(request()->path()) }}" rel="canonical" />
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
<meta content="Sign in page" name="description" />

<meta content="@firstmagency" name="twitter:site" />
<meta content="@firstmagency" name="twitter:creator" />
<meta content="summary_large_image" name="twitter:card" />
<meta content="FirstMagency " name="twitter:title" />
<meta content="Sign in page" name="twitter:description" />
<meta content="{{ url(request()->path()) }}" property="og:url" />
<meta content="en_US" property="og:locale" />
<meta content="website" property="og:type" />
<meta content="@firstmagency" property="og:site_name" />
<meta content="FirstMagency" property="og:title" />
<meta content="Sign in page" property="og:description" />

{{-- Google Fonts + Cairo for bolder weights --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800&family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap"
    rel="stylesheet">

{{-- ? Start plugins --}}
{{-- Select multiple plugin --}}
<link href="{{ asset('assets/plugins/select2@4.1.0-rc.0/css/select2.min.css') }}" rel="stylesheet" />
{{-- Fontawesome icons pro --}}
<link href="{{ asset('assets/plugins/fontawesome-icons/css/all.min.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/keenicons/styles.bundle.css') }}" rel="stylesheet" />
{{-- Text editor --}}
<link href="{{ asset('assets/plugins/trix@2.0.0/trix@2.0.0.css') }}" rel="stylesheet" />
<!-- Tailwind CSS -->
<link href="{{ asset('assets/plugins/tailwind/tailwind.css') }}" rel="stylesheet">
{{-- ? End plugins --}}

{{-- custom css --}}
<link href="{{ asset('assets/dashboard/css/init.css') }}" rel="stylesheet">
<link href="{{ asset('assets/dashboard/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/dashboard/css/toggle-input.css') }}" rel="stylesheet">
<link href="{{ asset('assets/dashboard/css/checkbox-input.css') }}" rel="stylesheet">

{{-- Toasts Styles --}}
<link rel="stylesheet" href="{{ asset('vendor/toasts/css/toasts.css') }}">
{{-- Toasts Scripts --}}
<script type="module" src="{{ asset('vendor/toasts/js/toasts.js') }}"></script>

<!-- Compiled App Styles -->
@vite(['resources/css/app.css'])

{{-- Trix Editor Custom Styles --}}
<style>
    trix-editor,
    trix-toolbar {
        font-family: inherit !important;
        font-size: 1rem !important;
    }

    trix-editor {
        overflow-x: hidden !important;
        width: 100% !important;
        min-height: 150px !important;
        border: 2px solid #d1d5db !important;
        border-radius: 0.5rem !important;
        padding: 0.75rem !important;
        background: white !important;
        box-sizing: border-box !important;
        z-index: 1 !important;
    }

    trix-editor:focus {
        outline: none !important;
        border-color: #8b5cf6 !important;
        ring: 2px solid #8b5cf6 !important;
    }

    trix-toolbar {
        overflow-x: auto !important;
        width: 100% !important;
        background: #f9fafb !important;
        border: 2px solid #d1d5db !important;
        border-bottom: none !important;
        border-radius: 0.5rem 0.5rem 0 0 !important;
        padding: 0.5rem !important;
        box-sizing: border-box !important;
        z-index: 2 !important;
    }

    trix-toolbar .trix-button-group {
        flex-wrap: wrap !important;
    }

    trix-toolbar .trix-button {
        background: white !important;
        border: 1px solid #d1d5db !important;
        border-radius: 0.375rem !important;
        padding: 0.5rem 0.75rem !important;
        cursor: pointer !important;
    }

    trix-toolbar .trix-button:hover {
        background: #f3f4f6 !important;
    }

    trix-toolbar .trix-button.trix-active {
        background: #8b5cf6 !important;
        color: white !important;
        border-color: #8b5cf6 !important;
    }
</style>

@yield('styles')
@stack('styles')
