@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.department')]))
@section('page-title', '🏢 ' . __('main.edit_type', ['type' => __('main.department')]))

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.departments.update', $department->id) ?? '#' }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-4 lg:gap-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.name') }} </label>
                        <input type="text" name="name" id="name" class="kt-input h-[45px]" value="{{ old('name', $department->name) }}" />
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="name_ar" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.name') }} (عربي)</label>
                        <input type="text" name="name_ar" id="name_ar" class="kt-input h-[45px]" value="{{ old('name_ar', $department->name_ar) }}" />
                        @error('name_ar')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="user_id" class="block text-sm font-medium text-gray-600 mb-1">{{ __('main.assignee_user') }} </label>
                        <select class="kt-select basic-single" id="user_id" name="user_id">
                            <option value="" selected disabled>--</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $department->user_id) == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->role }})</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>
                    <div>
                        <label for="icon" class="flex justify-between items-center gap-4 text-sm font-medium text-gray-600 mb-1">
                            {{ __('main.icon') }}
                            <div class="preview-icon" id="preview-icon" style="display: inline-block; margin-left: 10px; color: #6c757d;">
                                <i class="fas fa-building"></i>
                            </div>
                        </label>
                        <input type="text" name="icon" id="icon" class="kt-input h-[45px]" value="{{ old('icon', $department->icon ?: 'fas fa-building') }}" placeholder="fas fa-user">
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
                            value="{{ old('bg_color', $department->bg_color ?? '#6c757d') }}">
                    </div>
                    <div class="flex-1 text-nowrap">
                        <label for="border_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.border_color') }}</label>
                        <input type="color" id="border_color" name="border_color" class="color-input w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                            value="{{ old('border_color', $department->border_color ?? '#d1d5db') }}">
                    </div>
                    <div class="flex-1 text-nowrap">
                        <label for="border_main_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.border_main_color') }}</label>
                        <input type="color" id="border_main_color" name="border_main_color" class="color-input w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                            value="{{ old('border_main_color', $department->border_main_color ?? '#1e40af') }}">
                    </div>
                    <div class="flex-1 text-nowrap">
                        <label for="badge_color" class="block text-sm font-semibold text-gray-600 mb-1">{{ __('main.badge_color') }}</label>
                        <input type="color" id="badge_color" name="badge_color" class="color-input w-full h-12 rounded-lg cursor-pointer border-2 border-gray-300 shadow-sm"
                            value="{{ old('badge_color', $department->badge_color ?? '#1e40af') }}">
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
                                    style="background-color: {{ old('bg_color', $department->bg_color ?? '#f3f4f6') }}; border: 1px solid {{ old('border_color', $department->border_color ?? '#d1d5db') }}; border-left: 4px solid {{ old('border_main_color', $department->border_main_color ?? '#1e40af') }};">
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
                                                    <span id="badgePreview" class="w-fit block text-xs px-2 py-1 rounded-full badge-message text-white"
                                                        style="background-color: {{ old('badge_color', $department->badge_color ?? '#1e40af') }};">
                                                        <i id="iconPreview" class="{{ old('icon', $department->icon ?: 'fas fa-building') }} me-1"></i>
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
                                            <div id="bgColorBox" class="w-6 h-6 rounded border" style="background-color: {{ old('bg_color', $department->bg_color ?? '#f3f4f6') }};"></div>
                                            <code id="bgColorCode" class="text-xs">{{ old('bg_color', $department->bg_color ?? '#f3f4f6') }}</code>
                                        </div>
                                    </div>
                                    <div class="p-2 rounded border">
                                        <div class="text-gray-500 mb-1">{{ __('main.border_color') }}</div>
                                        <div class="flex items-center gap-1">
                                            <div id="borderColorBox" class="w-6 h-6 rounded border-2" style="border-color: {{ old('border_color', $department->border_color ?? '#d1d5db') }};">
                                            </div>
                                            <code id="borderColorCode" class="text-xs">{{ old('border_color', $department->border_color ?? '#d1d5db') }}</code>
                                        </div>
                                    </div>
                                    <div class="p-2 rounded border">
                                        <div class="text-gray-500 mb-1">{{ __('main.border_main_color') }}</div>
                                        <div class="flex items-center gap-1">
                                            <div id="borderMainColorBox" class="w-6 h-6 rounded border-l-4"
                                                style="border-left-color: {{ old('border_main_color', $department->border_main_color ?? '#1e40af') }};"></div>
                                            <code id="borderMainColorCode" class="text-xs">{{ old('border_main_color', $department->border_main_color ?? '#1e40af') }}</code>
                                        </div>
                                    </div>
                                    <div class="p-2 rounded border">
                                        <div class="text-gray-500 mb-1">{{ __('main.badge_color') }}</div>
                                        <div class="flex items-center gap-1">
                                            <div id="badgeColorBox" class="w-6 h-6 rounded" style="background-color: {{ old('badge_color', $department->badge_color ?? '#1e40af') }};"></div>
                                            <code id="badgeColorCode" class="text-xs">{{ old('badge_color', $department->badge_color ?? '#1e40af') }}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Update Button -->
                @include('dashboard.components.update-submit', ['models' => 'dashboard.departments', 'model' => 'department'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const colorInputs = document.querySelectorAll('.color-input');
            const messagePreview = document.getElementById('messagePreview');
            const badgePreview = document.getElementById('badgePreview');
            const iconInput = document.getElementById('icon');
            const iconPreview = document.getElementById('iconPreview');

            function updatePreview() {
                const bgColor = document.getElementById('bg_color').value;
                const borderColor = document.getElementById('border_color').value;
                const borderMainColor = document.getElementById('border_main_color').value;
                const badgeColor = document.getElementById('badge_color').value;
                const iconClass = iconInput?.value?.trim() || 'fas fa-building';

                // Update message preview styles
                messagePreview.style.backgroundColor = bgColor;
                messagePreview.style.borderColor = borderColor;
                messagePreview.style.borderLeftColor = borderMainColor;

                // Update badge preview
                badgePreview.style.backgroundColor = badgeColor;

                // Update color display boxes and codes
                document.getElementById('bgColorBox').style.backgroundColor = bgColor;
                document.getElementById('bgColorCode').textContent = bgColor;

                document.getElementById('borderColorBox').style.backgroundColor = borderColor;
                document.getElementById('borderColorCode').textContent = borderColor;

                document.getElementById('borderMainColorBox').style.backgroundColor = borderMainColor;
                document.getElementById('borderMainColorCode').textContent = borderMainColor;

                document.getElementById('badgeColorBox').style.backgroundColor = badgeColor;
                document.getElementById('badgeColorCode').textContent = badgeColor;

                if (iconPreview) {
                    iconPreview.className = iconClass + ' me-1';
                }
            }

            // Add event listeners for live updates
            colorInputs.forEach(input => {
                input.addEventListener('change', updatePreview);
                input.addEventListener('input', updatePreview);
            });

            iconInput?.addEventListener('input', updatePreview);

            // Initialize preview with current values
            updatePreview();

            // logic preview icon
            const previewIcon = document.getElementById('preview-icon');
            iconInput.addEventListener('input', function() {
                const iconClass = this.value.trim() || 'fas fa-building';
                previewIcon.innerHTML = `<i class="${iconClass}"></i>`;
            });
        });
    </script>
@endpush
