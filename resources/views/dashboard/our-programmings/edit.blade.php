@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.our_programming')]))
@section('page-title', '✏️ ' . __('main.edit_type', ['type' => __('main.our_programming')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.edit_type', ['type' => __('main.our_programming')]) }}</h3>

            <a href="{{ route('dashboard.our-programmings.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.our_programmings')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.our-programmings.update', $ourProgramming->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-6">
                    <!-- Image Upload -->
                    <div class="grid grid-cols-1 gap-6">
                        @include('dashboard.components.photo', ['column' => 'image', 'record' => $ourProgramming])
                    </div>

                    <!-- Alt Text & Order -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="alt_text" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.alt_text') }}
                            </label>
                            <input type="text" id="alt_text" name="alt_text" value="{{ old('alt_text', $ourProgramming->alt_text) }}"
                                class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40 @error('alt_text') border-red-500 @enderror"
                                placeholder="{{ __('main.alt_text') }}">
                            @error('alt_text')
                                <div class="mt-1 text-sm text-red-600">{{ $message }}</div>
                            @enderror
                        </div>

                        <div>
                            <label for="order" class="mb-2 block text-sm font-semibold text-gray-700">
                                {{ __('main.order') }}
                            </label>
                            <input type="number" id="order" name="order" value="{{ old('order', $ourProgramming->order) }}" min="0"
                                class="w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-primary/40">
                        </div>
                    </div>

                    <!-- Active & Featured -->
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('dashboard.components.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => $ourProgramming->is_active,
                                'label' => __('main.active'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_featured" value="0">
                            @include('dashboard.components.checkbox-button', [
                                'name' => 'is_featured',
                                'id' => 'is_featured',
                                'value' => '1',
                                'checked' => $ourProgramming->is_featured,
                                'label' => __('main.featured'),
                            ])
                        </div>
                    </div>

                    <!-- Update Button -->
                    @include('dashboard.components.update-submit', ['models' => 'dashboard.our-programmings', 'model' => 'our_programming'])
                </div>
            </form>
        </div>
    </div>
@endsection
