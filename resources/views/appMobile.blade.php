@extends('layouts.master')

@section('content')
    <div class="app-developer">
        {{-- App Developer Section --}}
        @include('sections.app-developer')

        {{-- Order Your App Section --}}
        @include('sections.order-your-app')

        {{-- Categories Programming Section --}}
        @include('sections.categories-programming')

        {{-- Step Work Section --}}
        @include('sections.project-steps')

        {{-- Frequently Asked Questions Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => config('faqs-apps')])

        {{-- Important Articles Section --}}
        @include('sections.important-articles')
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
