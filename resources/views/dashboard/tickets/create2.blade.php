@extends('dashboard.layout.master')

@section('title', __('main.create_ticket'))
@section('page-title', '➕ ' . __('main.create_ticket'))

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1>{{ __('main.create_ticket') }}</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.tickets.store') }}" method="POST">
                    @csrf
                    @include('dashboard.tickets._form')

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard.tickets.index') }}" class="btn btn-secondary">
                            {{ __('main.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('main.create') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
