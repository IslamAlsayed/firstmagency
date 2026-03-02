{{-- ? Start plugins --}}
{{-- jquery-3.7.1 --}}
<script src="{{ asset('assets/plugins/jquery@3.7.1/jquery-3.7.1.min.js') }}"></script>
{{-- Multiple select plugin --}}
<script src="{{ asset('assets/plugins/select2@4.1.0-rc.0/js/select2.min.js') }}"></script>
{{-- Text editor --}}
<script src="{{ asset('assets/plugins/trix@2.0.0/trix@2.0.0.js') }}"></script>
{{-- Fontawesome icons pro --}}
<script src="{{ asset('assets/plugins/fontawesome-icons/js/all.min.js') }}"></script>
{{-- ? End plugins --}}

<!-- Bootstrap JS -->
{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></link> --}}

{{-- Custom Js --}}
<script src="{{ asset('assets/dashboard/js/main.js') }}"></script>
@vite(['resources/js/app.js'])
@yield('scripts')
@stack('scripts')
