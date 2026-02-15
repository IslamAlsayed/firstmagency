<title>@yield('title', 'First Magency')</title>
<base href="../../">
<meta charset="utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta content="follow, index" name="robots" />
<link href="{{ url(request()->path()) }}" rel="canonical" />
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport" />
<meta content="Sign in page using Tailwind CSS" name="description" />
<meta content="@firstmagency" name="twitter:site" />
<meta content="@firstmagency" name="twitter:creator" />
<meta content="summary_large_image" name="twitter:card" />
<meta content="Metronic - Tailwind CSS" name="twitter:title" />
<meta content="Sign in page using Tailwind CSS" name="twitter:description" />
<meta content="{{ asset('metronic/media/app/og-image.png') }}" name="twitter:image" />

<meta content="{{ url(request()->path()) }}" property="og:url" />
<meta content="en_US" property="og:locale" />
<meta content="website" property="og:type" />
<meta content="@firstmagency" property="og:site_name" />
<meta content="First Magency" property="og:title" />
<meta content="" property="og:description" />

{{-- Google Fonts - Tajawal --}}
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@12/swiper-bundle.min.css" />
{{-- metronic css --}}
<link href="{{ asset('assets/css/metronic.css') }}" rel="stylesheet" />
{{-- font awesome icons --}}
<link href="{{ asset('assets/css/all.min.css') }}" rel="stylesheet" />
{{-- custom css --}}
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
