@extends('layouts.master')

@section('content')
    <div class="services-marketing effect-section">
        {{-- Marketing Hero Section --}}
        @include('sections.marketing-hero')

        {{-- Operating Systems Section --}}
        @include('sections.platform-management')

        {{-- Work Line Section --}}
        @include('sections.work-line')

        {{-- Our Services Marketing Section --}}
        @include('sections.packages-marketing')

        {{-- Important Articles Section --}}
        @include('sections.important-articles-marketing')

        {{-- Are You Ready Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => config('faqs-services-marketing')])
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
