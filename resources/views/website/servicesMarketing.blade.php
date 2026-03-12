@extends('layouts.master')

@section('content')
    <div class="services-marketing effect-section">
        {{-- Marketing Hero Section --}}
        @include('sections.marketing-hero')

        {{-- Operating Systems Section --}}
        @include('sections.platform-management', ['platforms' => $data['platforms']])

        {{-- Work Line Section --}}
        @include('sections.work-line', ['work_steps' => $data['work_steps']])

        {{-- Our Services Marketing Section --}}
        @include('sections.packages-marketing', ['packages' => $data['packages']])

        {{-- Important Articles Section --}}
        @include('sections.important-articles-marketing', ['articles' => $data['articles']])

        {{-- Are You Ready Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => $data['faqs'] ?? config('faqs-services-marketing')])
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
