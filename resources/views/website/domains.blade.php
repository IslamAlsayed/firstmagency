@extends('layouts.master')

@section('content')
    <div class="domains effect-section">
        {{-- Hero Section --}}
        @include('sections.your-domain')

        {{-- Pest Domains Section --}}
        @include('sections.pest-domains')

        {{-- Official Domains Section --}}
        @include('sections.official-domains')

        {{-- Why Us Section --}}
        @include('sections.why-us')

        {{-- Are You Ready Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => config('faqs-domains')])
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const header = document.getElementById('header');
            header.setAttribute('data-force-scrolled', 'true');
            header.classList.add('scrolled');
        });
    </script>
@endpush
