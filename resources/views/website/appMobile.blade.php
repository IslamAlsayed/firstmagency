@extends('layouts.master')

@section('content')
    <div class="app-developer">
        {{-- App Developer Section --}}
        @include('sections.app-developer')

        {{-- Order Your App Section --}}
        @include('sections.order-your-app')

        {{-- Categories Programming Section --}}
        @include('sections.categories-programming', ['categories' => $data['categories'] ?? []])

        {{-- Step Work Section --}}
        @include('sections.project-steps', ['steps' => $data['project_steps'] ?? []])

        {{-- Frequently Asked Questions Section --}}
        @include('sections.frequently-asked-questions', ['faqs' => $data['faqs'] ?? config('faqs-apps')])

        {{-- Important Articles Section --}}
        @include('sections.important-articles', [
            'articles' => $data['articles'] ?? [],
            'title' => __('main.important_articles_title'),
            'desc' => __('main.important_articles_description'),
        ])
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
