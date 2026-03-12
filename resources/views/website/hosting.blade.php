@extends('layouts.master')

@push('styles')
    <style>
        .header {
            background-color: var(--light-color) !important;
        }
    </style>
@endpush

@section('content')
    <div class="hosting effect-section">
        {{-- Hero Section --}}
        @include('sections.hero-hosting')

        {{-- Hosting Features Section --}}
        @include('sections.features-hosting', ['features' => $data['features_hosting'] ?? []])

        {{-- Hosting Packages Section --}}
        @include('sections.packages-hosting', ['packages' => $data['packages']])

        {{-- Are You Ready Section --}}
        @include('sections.ready-hosting')

        {{-- Don't Worry Section --}}
        @include('sections.support-hosting')

        {{-- Don't Worry Section --}}
        @include('sections.dont-worry-hosting')

        {{-- Operating systems Section --}}
        @include('sections.operating-systems', ['operating' => $data['operating'] ?? []])

        {{-- Easy management Section --}}
        @include('sections.easy-management')

        {{-- Are You Ready Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => $data['faqs'] ?? config('faqs-hosting')])
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
