@extends('dashboard.layout.master')

@section('title', __('main.permission_management'))
@section('page-title', '🔑 ' . __('main.permission_management'))

@section('content')
    <div class="w-full">
        <div class="w-full">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                    <div class="text-2xl font-bold text-gray-800">{{ count($permissions) }}</div>
                    <small class="text-primary font-semibold">{{ __('main.total_permissions') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                    <div class="text-2xl font-bold text-blue-600">{{ $permissions->where('guard_name', 'web')->count() }}</div>
                    <small class="text-primary font-semibold">{{ __('main.web_guard') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                    <div class="text-2xl font-bold text-purple-600">{{ $permissions->where('guard_name', 'api')->count() }}</div>
                    <small class="text-primary font-semibold">{{ __('main.api_guard') }}</small>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow">
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-key mr-2"></i> {{ __('main.permissions') }}</h5>

                    <div class="flex justify-between items-center gap-4">
                        <input type="text" id="searchBox"
                            class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.permissions')]) }}">
                        <a href="{{ route('dashboard.permissions.create') }}" class="kt-btn kt-btn-outline-primary">
                            {{ __('main.create_permission') }}
                        </a>
                    </div>
                </div>
                <div class="scroll-container">
                    <div class="p-4">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b-2 border-gray-300">
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.permission_name') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.guard') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.description') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($permissions as $permission)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="p-4 text-sm text-gray-800 font-semibold">
                                            <i class="fas fa-key text-yellow-500 mr-2"></i> {{ $permission->name }}
                                        </td>
                                        <td class="p-4 text-sm">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                                {{ $permission->guard_name }}
                                            </span>
                                        </td>
                                        <td class="p-4 text-sm text-gray-600">
                                            {{ $permission->description ?? '—' }}
                                        </td>
                                        <td class="p-4 text-sm text-gray-600">{{ $permission->created_at->format('d/m/Y') }}</td>
                                        <td class="p-4 text-sm space-x-2">
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $permission,
                                                'models' => 'permissions',
                                            ])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                            {{ __('main.no_data') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchPermissions').addEventListener('keyup', function() {
            const search = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        });
    </script>
@endsection
