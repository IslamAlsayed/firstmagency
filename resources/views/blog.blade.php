@extends('layouts.master')

@section('content')
    {{-- Articles Section --}}
    @include('sections.articles', ['title' => 'الأرشيف', 'data' => config('articles'), 'length' => 1500])
@endsection
