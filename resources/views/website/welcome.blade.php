@extends('layouts.master')

@section('content')
    {{-- Hero Section --}}
    @include('sections.hero')

    {{-- About Section --}}
    @include('sections.about')

    {{-- Services Section --}}
    @include('sections.services', ['services' => $data['services']])

    {{-- Projects Section --}}
    @include('sections.projects', ['projects' => $data['projects']])

    {{-- Reviews Section --}}
    @include('sections.reviews', ['reviews' => $data['reviews']])

    {{-- Clients Section --}}
    @include('sections.clients', ['clients' => $data['clients']])
@endsection
