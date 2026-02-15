<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-element-bundle.min.js"></script>
{{-- Fontawesome icons pro --}}
<script src="{{ asset('assets/js/all.min.js') }}"></script>
<script src="{{ asset('assets/js/script.js') }}"></script>
{{-- Multiples JS --}}
@vite(['resources/js/app.js'])
@yield('scripts')
@stack('scripts')
