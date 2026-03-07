@extends('dashboard.layouts.app')

@section('content')
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ __('main.create_categories_programming') }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb m-0 float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('main.dashboard') }}</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('dashboard.categories-programmings.index') }}">{{ __('main.categories_programming') }}</a></li>
                        <li class="breadcrumb-item active">{{ __('main.create') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <form action="{{ route('dashboard.categories-programmings.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('main.categories_programming_information') }}</h3>
                    </div>

                    <div class="card-body">
                        {{-- Image Upload --}}
                        <div class="form-group">
                            <label for="image">{{ __('main.image') }} <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input @error('image') is-invalid @enderror" id="image" name="image" accept="image/*"
                                    required>
                                <label class="custom-file-label" for="image">{{ __('main.choose_image') }}</label>
                            </div>
                            <small class="form-text text-muted">{{ __('main.allowed_formats') }}: JPG, PNG, GIF | {{ __('main.max_size') }}: 5MB</small>
                            @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Alt Text --}}
                        <div class="form-group">
                            <label for="alt_text">{{ __('main.alt_text') }}</label>
                            <input type="text" class="form-control @error('alt_text') is-invalid @enderror" id="alt_text" name="alt_text"
                                placeholder="{{ __('main.alt_text') }}" value="{{ old('alt_text') }}" maxlength="255">
                            @error('alt_text')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Order --}}
                        <div class="form-group">
                            <label for="order">{{ __('main.order') }}</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" placeholder="0"
                                value="{{ old('order', 0) }}" min="0">
                            @error('order')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        {{-- Is Active --}}
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1"
                                    {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">{{ __('main.active') }}</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <a href="{{ route('dashboard.categories-programmings.index') }}" class="btn btn-secondary">{{ __('main.cancel') }}</a>
                    <button type="submit" class="btn btn-primary">{{ __('main.create') }}</button>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.getElementById('image').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || '{{ __('main.choose_image') }}';
            e.target.nextElementSibling.textContent = fileName;
        });
    </script>
@endsection
