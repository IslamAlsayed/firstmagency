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
    <div class="services-marketing effect-section">
        {{-- Marketing Hero Section --}}
        @include('sections.marketing-hero')

        {{-- Operating Systems Section --}}
        @include('sections.platform-management')

        {{-- Work Line Section --}}
        @include('sections.work-line')

        {{-- Our Services Marketing Section --}}
        @include('sections.our-services-marketing')

        {{-- Important Articles Section --}}
        @include('sections.important-articles-marketing')

        {{-- Are You Ready Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => config('faqs-services-marketing')])
    </div>
@endsection
