@extends('layouts.master')

@section('content')
    <div class="domains effect-section">
        {{-- Hero Section --}}
        @include('sections.your-domain')

        {{-- Pest Domains Section --}}
        @include('sections.pest-domains', ['domains' => $data['pest_domains'] ?? []])

        {{-- Official Domains Section --}}
        @include('sections.official-domains', ['domains' => $data['official_domains'] ?? []])

        {{-- Why Us Section --}}
        @include('sections.why-us', ['whyUs' => $data['why_us'] ?? []])

        {{-- Are You Ready Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => $data['faqs'] ?? config('faqs-domains')])
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
