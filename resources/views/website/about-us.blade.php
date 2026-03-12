@extends('layouts.master')

@section('content')
    {{-- About Section --}}
    @include('sections.about-us')

    {{-- Line Works Section --}}
    @include('sections.line-works', ['lineWorks' => $data['lineWorks']])

    {{-- Partners Section --}}
    @include('sections.partners', ['partners' => $data['partners']])
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
