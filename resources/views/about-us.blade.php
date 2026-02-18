@extends('layouts.master')

@section('content')
    {{-- About Section --}}
    @include('sections.about')

    {{-- Line Works Section --}}
    @include('sections.line-works')

    {{-- Partners Section --}}
    @include('sections.partners')
@endsection
