@extends('layouts.master')

@section('content')
    {{-- Articles Section --}}
    @include('sections.articles', ['title' => __('main.blog_archive'), 'data' => config('articles'), 'length' => 1500])
@endsection
