@extends('layouts.master')

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
