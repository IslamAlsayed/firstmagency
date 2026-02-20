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
    {{-- About Section --}}
    @include('sections.about-us')

    {{-- Line Works Section --}}
    @include('sections.line-works')

    {{-- Partners Section --}}
    @include('sections.partners')
@endsection
