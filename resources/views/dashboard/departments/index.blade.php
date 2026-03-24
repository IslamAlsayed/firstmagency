@extends('dashboard.layout.master')

@section('title', __('main.departments'))
@section('page-title', '🏢 ' . __('main.departments'))

@section('content')
    <div class="w-full">
        <div class="bg-white shadow-lg radius-lg">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-sitemap mr-2"></i> {{ __('main.departments') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox" class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.departments')]) }}">
                    <a href="{{ route('dashboard.departments.create') }}" class="kt-btn kt-btn-outline-primary" style="color: var(--text_color); background-color: var(--button_color);" toggle-button>
                        {{ __('main.create_type', ['type' => __('main.department')]) }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <table class="w-full border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b-2 border-gray-300">
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.name') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.name') }}(عربي)</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.username') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.styling') }}</th>
                            <th class="p-4 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $department)
                            <tr id="row-{{ $department->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="p-4 text-sm text-gray-600">{{ $department->name }}</td>
                                <td class="p-4 text-sm text-gray-600">{{ $department->name_ar }}</td>

                                <td class="p-4 text-sm text-gray-600">
                                    @if ($department->user)
                                        <div class="flex items-center gap-2">
                                            @if ($department->user->photo)
                                                <img src="{{ asset('assets/images/avatars/' . $department->user->photo) }}" alt="{{ $department->user->name }}" class="rounded-full size-6 shrink-0">
                                            @else
                                                <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ $department->user->name }}" class="rounded-full size-6 shrink-0">
                                            @endif
                                            <span>{{ $department->user->name }}</span>
                                        </div>
                                    @else
                                        <span class="text-gray-400">{{ __('main.na') }}</span>
                                    @endif
                                </td>
                                <td class="p-4 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded" style="background-color: {{ $department->bg_color ?? '#ccc' }}; border: 2px solid {{ $department->border_color ?? '#999' }};">
                                        </div>
                                        <span class="text-xs">{{ $department->badge_color ?? __('main.na') }}</span>
                                    </div>
                                </td>
                                <td class="p-4 text-sm space-x-2">
                                    @include('dashboard.components.permissions-actions', [
                                        'record' => $department,
                                        'models' => 'departments',
                                        'modelClass' => 'department',
                                    ])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                    {{ __('main.no_departments_found') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchBox = document.getElementById('searchBox');
            const table = document.querySelector('table tbody');
            const rows = table.querySelectorAll('tr');

            searchBox.addEventListener('keyup', function() {
                const searchTerm = this.value.toLowerCase();
                rows.forEach(row => {
                    const rowText = row.innerText.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        });
    </script>
@endpush
