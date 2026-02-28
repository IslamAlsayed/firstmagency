@extends('dashboard.layout.master')

@section('title', __('dashboard.role_management'))
@section('page-title', '🔐 ' . __('dashboard.role_management'))

@section('content')
    <div class="w-full">
        <div class="w-full">
            <!-- Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-gray-800">{{ count($roles) }}</div>
                    <small class="text-gray-500">{{ __('dashboard.total_roles') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-pink-600">{{ $roles->sum(fn($r) => $r->permissions->count()) }}</div>
                    <small class="text-gray-500">{{ __('dashboard.total_permissions') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-green-600">{{ $roles->filter(fn($r) => $r->permissions->count() > 0)->count() }}</div>
                    <small class="text-gray-500">{{ __('dashboard.roles_with_permissions') }}</small>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-shield-alt mr-2"></i> {{ __('dashboard.role_list') }}</h5>
                        <a href="{{ route('dashboard.roles.create') }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition">
                            <i class="fas fa-plus mr-2"></i> {{ __('dashboard.create_role') }}
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <!-- Search Filter -->
                    <div class="mb-4">
                        <input type="text" id="searchRoles"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="{{ __('dashboard.search') }} {{ __('dashboard.role_name') }}...">
                    </div>

                    <!-- Roles Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b-2 border-gray-300">
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('dashboard.role_name') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('dashboard.guard') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('dashboard.permissions') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('dashboard.created_at') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('dashboard.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($roles as $role)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-800 font-semibold">{{ $role->name }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">
                                                {{ $role->guard_name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <span class="px-2 py-1 bg-pink-100 text-pink-800 rounded text-xs font-medium">
                                                {{ $role->permissions->count() }} {{ __('dashboard.permissions') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $role->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-sm space-x-2">
                                            @include('dashboard.components.show-button', [
                                                'models' => 'dashboard.roles',
                                                'id' => $role->id,
                                            ])
                                            @include('dashboard.components.edit-button', [
                                                'models' => 'dashboard.roles',
                                                'id' => $role->id,
                                            ])
                                            @include('dashboard.components.delete-button', ['id' => $role->id])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                            {{ __('dashboard.no_data') }}
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
        document.getElementById('searchRoles').addEventListener('keyup', function() {
            const search = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        });
    </script>
@endsection
