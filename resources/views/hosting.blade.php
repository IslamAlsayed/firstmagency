@extends('layouts.master')

@push('styles')
    <style>
        .header {
            background-color: var(--light-color);
            box-shadow: 0 0px 15px -2px rgba(0, 0, 0, 0.1);
            background-image: url('../assets/images/header-bg.png');
            background-position: center center;
            background-size: contain;
            background-repeat: repeat;
        }
    </style>
@endpush

@section('content')
    <div class="hosting effect-section">
        {{-- Hero Section --}}
        @include('sections.hero-hosting')

        {{-- Hosting Features Section --}}
        @include('sections.features-hosting')

        {{-- Hosting Packages Section --}}
        @include('sections.packages-hosting')

        {{-- Are You Ready Section --}}
        @include('sections.ready-hosting')

        {{-- Don't Worry Section --}}
        @include('sections.support-hosting')

        {{-- Don't Worry Section --}}
        @include('sections.dont-worry-hosting')

        {{-- Operating systems Section --}}
        @include('sections.operating-systems')

        {{-- Easy management Section --}}
        @include('sections.easy-management')

        {{-- Are You Ready Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => config('faqs-hosting')])
    </div>
@endsection
