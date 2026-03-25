@extends('dashboard.layouts.app')

@push('styles')
    @include('dashboard.components.entity-index-styles')
@endpush

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
                        <li class="breadcrumb-item active">{{ __('main.categories_programming') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h3 class="card-title">{{ __('main.total_categories_programming') }}: {{ $total }}</h3>
                        @can('create', App\Models\CategoriesProgramming::class)
                            <a href="{{ route('dashboard.categories-programmings.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> {{ __('main.add_new') }}
                            </a>
                        @endcan
                    </div>
                </div>

                <div class="card-body">
                    {{-- Statistics --}}
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-info"><i class="fas fa-images"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('main.total_images') }}</span>
                                    <span class="info-box-number">{{ $total }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('main.active_images') }}</span>
                                    <span class="info-box-number">{{ $active }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="info-box">
                                <span class="info-box-icon bg-warning"><i class="fas fa-eye-slash"></i></span>
                                <div class="info-box-content">
                                    <span class="info-box-text">{{ __('main.inactive_images') }}</span>
                                    <span class="info-box-number">{{ $total - $active }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Images Grid --}}
                    @if ($images->count())
                        <div class="row">
                            @foreach ($images as $image)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <img src="{{ Storage::url($image->image) }}" class="card-img-top" alt="{{ $image->alt_text }}" style="height: 200px; object-fit: cover;">
                                        <div class="card-body">
                                            <p class="card-text">
                                                <strong>{{ __('main.alt_text') }}:</strong> {{ $image->alt_text ?? '-' }}<br>
                                                <strong>{{ __('main.order') }}:</strong> {{ $image->order }}<br>
                                                <strong>{{ __('main.status') }}:</strong>
                                                @if ($image->is_active)
                                                    <span class="badge badge-success">{{ __('main.active') }}</span>
                                                @else
                                                    <span class="badge badge-danger">{{ __('main.inactive') }}</span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <div class="btn-group btn-group-sm" role="group">
                                                @can('view', $image)
                                                    <a href="{{ route('dashboard.categories-programmings.show', $image) }}" class="btn btn-info">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                @endcan
                                                @can('update', $image)
                                                    <a href="{{ route('dashboard.categories-programmings.edit', $image) }}" class="btn btn-warning">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('delete', $image)
                                                    <form action="{{ route('dashboard.categories-programmings.destroy', $image) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('{{ __('main.are_you_sure') }}')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">{{ __('main.no_categories_programming_found') }}</div>
                    @endif
                </div>
            </div>
        </div>
    </section>
@endsection
