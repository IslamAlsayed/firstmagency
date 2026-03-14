@extends('layouts.master')

@section('content')
    <div class="website-developer">
        {{-- Developer Section --}}
        @include('sections.developer')

        {{-- Programming Section --}}
        @include('sections.programming-systems', ['programming_systems' => $data['programming_systems'] ?? []])

        {{-- Website Design Section --}}
        @include('sections.website-design', ['stats' => $data['website_design'] ?? []])

        {{-- Important Articles Section --}}
        @if (isset($data['articles']) && count($data['articles']) > 0)
            @include('sections.important-articles', [
                'articles' => $data['articles'] ?? [],
                'title' => __('main.important_articles_title'),
                'desc' => __('main.important_articles_description'),
            ])
        @endif

        {{-- Frequently Asked Questions Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => $data['faqs'] ?? []])
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
