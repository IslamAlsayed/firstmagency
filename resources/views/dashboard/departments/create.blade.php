@extends('dashboard.layout.master')

@section('title', __('main.create_type', ['type' => __('main.department')]))
@section('page-title', '🏢 ' . __('main.create_type', ['type' => __('main.department')]))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.departments.store') ?? '#' }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-4 lg:gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.name') }} <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" class="kt-input h-[45px]" required />
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="name_ar" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.name') }} (عربي)<span class="text-red-500">*</span></label>
                        <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" required />
                        @error('name_ar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.assignee_user') }} <span class="text-red-500">*</span></label>
                        <select class="kt-select basic-single" id="user_id" name="user_id" required>
                            <option value="" selected disabled>--</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->role }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="icon" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.icon') }}</label>
                        <input type="text" name="icon" id="icon" class="kt-input h-[45px]" value="{{ old('icon', 'fas fa-building') }}" placeholder="fas fa-user">
                        <small class="text-gray-500 text-xs mt-1 block email">{{ __('main.icon') }}: fas fa-user / fa-solid fa-headset</small>
                        @error('icon')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="flex-1 text-nowrap">
                        <label for="bg_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.bg_color') }}</label>
                        <input type="color" id="bg_color" name="bg_color" class="color-input w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                            value="{{ old('bg_color', '#6c757d') }}">
                    </div>
                    <div class="flex-1 text-nowrap">
                        <label for="border_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.border_color') }}</label>
                        <input type="color" id="border_color" name="border_color" class="color-input w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                            value="{{ old('border_color', '#d1d5db') }}">
                    </div>
                    <div class="flex-1 text-nowrap">
                        <label for="border_main_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.border_main_color') }}</label>
                        <input type="color" id="border_main_color" name="border_main_color" class="color-input w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                            value="{{ old('border_main_color', '#1e40af') }}">
                    </div>
                    <div class="flex-1 text-nowrap">
                        <label for="badge_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.badge_color') }}</label>
                        <input type="color" id="badge_color" name="badge_color" class="color-input w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                            value="{{ old('badge_color', '#1e40af') }}">
                    </div>
                </div>

                <!-- Preview Section -->
                <div class="lg:col-span-1">
                    <div class="shadow-lg radius-lg p-4 sticky top-20">
                        <div class="kt-card-header">
                            <h3 class="kt-card-title">{{ __('main.preview') }}</h3>
                        </div>
                        <div class="kt-card-body p-4">
                            <div class="space-y-4">
                                <!-- Message Preview -->
                                <div id="messagePreview" class="flex justify-between gap-4 p-4 rounded border-l-4"
                                    style="background-color: #f3f4f6; border: 1px solid #d1d5db; border-left: 4px solid #1e40af;">
                                    <div class="flex gap-4 flex-1">
                                        <div class="avatar">
                                            <img src="{{ asset('assets/images/avatar.png') }}" alt="support" class="rounded-full w-10 h-10 shrink-0">
                                        </div>
                                        <div class="body flex-1">
                                            <div class="meta">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="who font-semibold text-sm">{{ __('main.support_user') }}</span>
                                                    <span class="time text-xs text-gray-500">15/03/2026 14:30 - منذ ساعتين</span>
                                                </div>

                                                <div class="flex gap-2">
                                                    <span id="badgePreview" class="w-fit block text-xs px-2 py-1 rounded-full badge-message text-white" style="background-color: #1e40af;">
                                                        <i id="iconPreview" class="fas fa-building me-1"></i>
                                                        {{ __('main.support') }}
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="content text-sm text-gray-700 mt-2">
                                                {{ __('main.message_example') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Color Display -->
                                <div class="grid grid-cols-2 gap-2 text-xs">
                                    <div class="p-2 rounded border">
                                        <div class="text-gray-500 mb-1">{{ __('main.bg_color') }}</div>
                                        <div class="flex items-center gap-1">
                                            <div id="bgColorBox" class="w-6 h-6 rounded border" style="background-color: #f3f4f6;"></div>
                                            <code id="bgColorCode" class="text-xs">#f3f4f6</code>
                                        </div>
                                    </div>
                                    <div class="p-2 rounded border">
                                        <div class="text-gray-500 mb-1">{{ __('main.border_color') }}</div>
                                        <div class="flex items-center gap-1">
                                            <div id="borderColorBox" class="w-6 h-6 rounded border-2" style="border-color: #d1d5db;"></div>
                                            <code id="borderColorCode" class="text-xs">#d1d5db</code>
                                        </div>
                                    </div>
                                    <div class="p-2 rounded border">
                                        <div class="text-gray-500 mb-1">{{ __('main.border_main_color') }}</div>
                                        <div class="flex items-center gap-1">
                                            <div id="borderMainColorBox" class="w-6 h-6 rounded border-l-4" style="border-left-color: #1e40af;"></div>
                                            <code id="borderMainColorCode" class="text-xs">#1e40af</code>
                                        </div>
                                    </div>
                                    <div class="p-2 rounded border">
                                        <div class="text-gray-500 mb-1">{{ __('main.badge_color') }}</div>
                                        <div class="flex items-center gap-1">
                                            <div id="badgeColorBox" class="w-6 h-6 rounded" style="background-color: #1e40af;"></div>
                                            <code id="badgeColorCode" class="text-xs">#1e40af</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                @include('dashboard.components.save-submit', ['models' => 'dashboard.departments', 'model' => 'department'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // Update preview when colors change
        const colorInputs = document.querySelectorAll('.color-input');
        const messagePreview = document.getElementById('messagePreview');
        const badgePreview = document.getElementById('badgePreview');

        // Color display elements
        const bgColorBox = document.getElementById('bgColorBox');
        const bgColorCode = document.getElementById('bgColorCode');
        const borderColorBox = document.getElementById('borderColorBox');
        const borderColorCode = document.getElementById('borderColorCode');
        const borderMainColorBox = document.getElementById('borderMainColorBox');
        const borderMainColorCode = document.getElementById('borderMainColorCode');
        const badgeColorBox = document.getElementById('badgeColorBox');
        const badgeColorCode = document.getElementById('badgeColorCode');
        const iconInput = document.getElementById('icon');
        const iconPreview = document.getElementById('iconPreview');

        function updatePreview() {
            const bgColor = document.getElementById('bg_color').value;
            const borderColor = document.getElementById('border_color').value;
            const borderMainColor = document.getElementById('border_main_color').value;
            const badgeColor = document.getElementById('badge_color').value;
            const iconClass = iconInput?.value?.trim() || 'fas fa-building';

            // Update message preview
            messagePreview.style.backgroundColor = bgColor;
            messagePreview.style.borderColor = borderColor;
            messagePreview.style.borderLeftColor = borderMainColor;

            // Update badge
            badgePreview.style.backgroundColor = badgeColor;

            // Update color boxes
            bgColorBox.style.backgroundColor = bgColor;
            bgColorCode.textContent = bgColor;

            borderColorBox.style.borderColor = borderColor;
            borderColorCode.textContent = borderColor;

            borderMainColorBox.style.borderLeftColor = borderMainColor;
            borderMainColorCode.textContent = borderMainColor;

            badgeColorBox.style.backgroundColor = badgeColor;
            badgeColorCode.textContent = badgeColor;

            if (iconPreview) {
                iconPreview.className = iconClass + ' me-1';
            }
        }

        // Add event listeners
        colorInputs.forEach(input => {
            input.addEventListener('change', updatePreview);
            input.addEventListener('input', updatePreview);
        });

        iconInput?.addEventListener('input', updatePreview);

        // Initial preview
        updatePreview();
    </script>
@endpush
