{{-- ? Start plugins --}}
{{-- jquery-3.7.1 --}}
<script src="{{ asset('assets/plugins/jquery@3.7.1/jquery-3.7.1.min.js') }}"></script>

{{-- Multiple select plugin --}}
<script src="{{ asset('assets/plugins/select2@4.1.0-rc.0/js/select2.min.js') }}"></script>

{{-- Swiper slider --}}
<script src="https://cdn.jsdelivr.net/npm/swiper@12/swiper-element-bundle.min.js"></script>
{{-- Fontawesome icons pro --}}
<script src="{{ asset('assets/plugins/fontawesome-icons/js/all.min.js') }}"></script>
{{-- ? End plugins --}}

<script src="{{ asset('assets/js/script.js') }}"></script>
{{-- Multiples JS --}}
@vite(['resources/js/app.js'])
@yield('scripts')
@stack('scripts')
