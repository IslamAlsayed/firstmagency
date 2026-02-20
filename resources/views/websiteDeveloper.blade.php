@extends('layouts.master')

@push('styles')
    <style>
        .header {
            background-color: var(--light-color);
            box-shadow: 0 0px 15px -2px rgba(0, 0, 0, 0.1);
            background-image: url('../images/header-bg.png');
            background-position: center center;
            background-size: contain;
            background-repeat: repeat;
        }
    </style>
@endpush

@section('content')
    <div class="website-developer">
        {{-- Developer Section --}}
        @include('sections.developer')

        {{-- Programming Section --}}
        @include('sections.programming')

        {{-- Website Design Section --}}
        @include('sections.website-design')

        {{-- Important Articles Section --}}
        @include('sections.important-articles')

        {{-- Frequently Asked Questions Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => config('websites-faqs')])
    </div>
@endsection
