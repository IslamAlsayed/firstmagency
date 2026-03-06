@extends('dashboard.layout.master')

@section('title', __('main.edit_ticket'))
@section('page-title', '✏️ ' . __('main.edit_ticket'))

@section('content')
    <div class="container-fluid">
        <div class="mb-4">
            <h1>{{ __('main.edit_ticket') }}</h1>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('dashboard.tickets.update', $ticket) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('dashboard.tickets._form')

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('dashboard.tickets.index') }}" class="btn btn-secondary">
                            {{ __('main.cancel') }}
                        </a>
                        <button type="submit" class="btn btn-primary">
                            {{ __('main.update') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
