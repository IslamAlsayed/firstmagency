@extends('layouts.master')

@section('content')
    {{-- Hero Section --}}
    @include('sections.hero')

    {{-- About Section --}}
    @include('sections.about')

    {{-- Services Section --}}
    @include('sections.services')

    {{-- Projects Section --}}
    @include('sections.projects')

    {{-- Reviews Section --}}
    @include('sections.reviews')

    {{-- Clients Section --}}
    @include('sections.clients')
@endsection
