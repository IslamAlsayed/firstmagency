@extends('dashboard.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('main.categories_programming') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('main.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.categories-programmings.index') }}">{{ __('main.categories_programming') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.details') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ __('main.categories_programming_details') }}</h3>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <img src="{{ Storage::url($image->image) }}" alt="{{ $image->alt_text }}" class="img-fluid">
                        </div>
                        <div class="col-md-6">
                            <table class="table table-bordered">
                                <tr>
                                    <th style="width: 30%">{{ __('main.alt_text') }}</th>
                                    <td>{{ $image->alt_text ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('main.order') }}</th>
                                    <td>{{ $image->order }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('main.status') }}</th>
                                    <td>
                                        @if ($image->is_active)
                                            <span class="badge badge-success">{{ __('main.active') }}</span>
                                        @else
                                            <span class="badge badge-danger">{{ __('main.inactive') }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{ __('main.created_at') }}</th>
                                    <td>{{ $image->created_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('main.created_by') }}</th>
                                    <td>{{ $image->creator?->name ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('main.updated_at') }}</th>
                                    <td>{{ $image->updated_at->format('Y-m-d H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('main.updated_by') }}</th>
                                    <td>{{ $image->updater?->name ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="btn-group" role="group">
                        @can('update', $image)
                            <a href="{{ route('dashboard.categories-programmings.edit', $image) }}" class="btn btn-warning">
                                <i class="fas fa-edit"></i> {{ __('main.edit') }}
                            </a>
                        @endcan
                        @can('delete', $image)
                            <form action="{{ route('dashboard.categories-programmings.destroy', $image) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('{{ __('main.are_you_sure') }}')">
                                    <i class="fas fa-trash"></i> {{ __('main.delete') }}
                                </button>
                            </form>
                        @endcan
                        <a href="{{ route('dashboard.categories-programmings.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> {{ __('main.back') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
