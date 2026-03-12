@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.pest_domain')]))
@section('page-title', '🌐 ' . __('main.edit_type', ['type' => __('main.pest_domain')]))

@section('content')
    <div class="kt-card mb-4">
        <div class="kt-card-header flex items-center justify-between gap-4">
            <h3 class="kt-card-title">{{ __('main.edit_type', ['type' => __('main.pest_domain')]) }}</h3>

            <a href="{{ route('dashboard.pest-domains.index') }}" class="kt-btn kt-btn-outline-primary">
                {{ __('main.back_to_types', ['types' => __('main.pest_domains')]) }}
            </a>
        </div>

        <div class="kt-card-body p-4">
            <form method="POST" action="{{ route('dashboard.pest-domains.update', $pestDomain) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="grid gap-4 lg:gap-6">
                    <!-- Media & Other Fields -->
                    <div class="grid grid-cols-1 gap-6">
                        @include('dashboard.components.photo', ['record' => $pestDomain, 'column' => 'image'])
                    </div>

                    <!-- Common Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.alt_text') }}</label>
                            <input type="text" name="alt_text" value="{{ old('alt_text', $pestDomain->alt_text) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('alt_text') border-red-500 @enderror"
                                placeholder="{{ __('main.alt_text') }}">
                            @error('alt_text')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.order') }}</label>
                            <input type="number" name="order" value="{{ old('order', $pestDomain->order) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500" min="0">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.price') }}
                                <span class="text-gray-400 text-xs">({{ __('main.current_price') }})</span>
                            </label>
                            <input type="number" name="price" value="{{ old('price', $pestDomain->price) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('price') border-red-500 @enderror"
                                placeholder="0.00" step="0.01" min="0">
                            @error('price')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.discount_percentage') }}
                                <span class="text-primary">(%)</span>
                            </label>
                            <input type="number" name="discount_percentage" value="{{ old('discount_percentage', $pestDomain->discount_percentage) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500 @error('discount_percentage') border-red-500 @enderror"
                                placeholder="0" step="0.01" min="0" max="100" id="discount_percentage">
                            @error('discount_percentage')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                            <small class="text-gray-500">{{ __('main.old_price_auto_calculated') }}</small>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">
                                {{ __('main.old_price') }}
                                <span class="text-gray-400 text-xs">({{ __('main.auto_calculated') }})</span>
                            </label>
                            <input type="number" name="old_price" value="{{ old('old_price', $pestDomain->old_price) }}"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg bg-gray-50" placeholder="0.00" step="0.01" min="0" readonly
                                id="old_price">
                            <small class="text-gray-500">{{ __('main.calculated_from_price_and_discount') }}</small>
                        </div>
                    </div>

                    <!-- Checkboxes -->
                    <div class="flex flex-wrap" style="gap: 10px 40px;">
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_active" value="0">
                            @include('dashboard.components.checkbox-button', [
                                'name' => 'is_active',
                                'id' => 'is_active',
                                'value' => '1',
                                'checked' => old('is_active', $pestDomain->is_active),
                                'label' => __('main.active'),
                            ])
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_featured" value="0">
                            @include('dashboard.components.checkbox-button', [
                                'name' => 'is_featured',
                                'id' => 'is_featured',
                                'value' => '1',
                                'checked' => old('is_featured', $pestDomain->is_featured),
                                'label' => __('main.featured'),
                            ])
                        </div>
                    </div>

                    <!-- Update Button -->
                    @include('dashboard.components.update-submit', ['models' => 'dashboard.pest-domains', 'model' => 'pest_domain'])
                </div>
            </form>
        </div>
    </div>

    <script>
        function calculateOldPrice() {
            const priceInput = document.querySelector('input[name="price"]');
            const discountInput = document.querySelector('input[name="discount_percentage"]');
            const oldPriceInput = document.getElementById('old_price');

            const price = parseFloat(priceInput.value) || 0;
            const discount = parseFloat(discountInput.value) || 0;

            if (price > 0 && discount > 0) {
                // old_price = price / (1 - discount_percentage/100)
                const oldPrice = price / (1 - (discount / 100));
                oldPriceInput.value = oldPrice.toFixed(2);
            } else {
                oldPriceInput.value = price.toFixed(2);
            }
        }

        // حساب old_price عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            calculateOldPrice();

            // حساب عند تغيير السعر أو الخصم
            document.querySelector('input[name="price"]').addEventListener('change', calculateOldPrice);
            document.querySelector('input[name="discount_percentage"]').addEventListener('input', calculateOldPrice);
        });
    </script>
@endsection
