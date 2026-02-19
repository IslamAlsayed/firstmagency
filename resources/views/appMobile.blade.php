@extends('layouts.master')

@section('content')
    <div class="app-developer">
        {{-- App Developer Section --}}
        @include('sections.app-developer')

        {{-- Order Your App Section --}}
        @include('sections.order-your-app')

        {{-- Categories Programming Section --}}
        @include('sections.categories-programming')

        {{-- Important Articles Section --}}
        @include('sections.important-articles')

        {{-- Step Work Section --}}
        @include('sections.step-work')

        {{-- Frequently Asked Questions Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => config('apps-faqs')])
    </div>
@endsection
