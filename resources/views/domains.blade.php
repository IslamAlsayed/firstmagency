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
    <div class="domains effect-section">
        {{-- Hero Section --}}
        @include('sections.your-domain')

        {{-- Pest Domains Section --}}
        @include('sections.pest-domains')

        {{-- Official Domains Section --}}
        @include('sections.official-domains')

        {{-- Are You Ready Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => config('faqs-domains')])
    </div>
@endsection
