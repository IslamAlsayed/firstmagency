@extends('dashboard.layout.master')

@section('title', __('dashboard.user_management'))
@section('page-title', '👤 ' . __('dashboard.user_management'))

@section('content')
    <div class="w-full">
        <div class="w-full">
            <!-- الإحصائيات -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-gray-800">{{ count($users) }}</div>
                    <small class="text-gray-500">إجمالي المستخدمين</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-red-600">{{ $users->where('role', 'superadmin')->count() }}</div>
                    <small class="text-gray-500">مسؤول فائق</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-yellow-600">{{ $users->where('role', 'admin')->count() }}</div>
                    <small class="text-gray-500">مسؤول</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-blue-600">{{ $users->where('role', 'content_manager')->count() }}</div>
                    <small class="text-gray-500">مدير المحتوى</small>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-users mr-2"></i> قائمة المستخدمين</h5>

                        <a href="{{ route('dashboard.users.create') }}" class="kt-btn kt-btn-outline-primary">
                            {{ __('main.create_type', ['type' => __('main.user')]) }}
                        </a>
                    </div>
                </div>
                <div class="p-6">
                    <!-- فلتر البحث -->
                    <div class="mb-4">
                        <input type="text" id="searchUsers"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="البحث عن مستخدم (الاسم أو البريد الإلكتروني)...">
                    </div>

                    <!-- جدول المستخدمين -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b-2 border-gray-300">
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">الصورة</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">الاسم</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">البريد الإلكتروني</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">الدور</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">تاريخ الانضمام</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($users as $user)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td title="{{ $user->name }}">
                                            <div class="relative w-fit">
                                                @if ($user->photo && checkExistFile($user->photo))
                                                    <img src="{{ $user->photo && checkExistFile($user->photo) ? asset('storage/' . $user->photo) : asset('metronic/media/avatars/blank.png') }}"
                                                        alt="{{ $user->name }}" class="rounded-full size-9 shrink-0">
                                                @else
                                                    <img src="{{ asset('assets/images/avatar.png') }}" alt="{{ $user->name }}"
                                                        class="rounded-full size-9 shrink-0">
                                                @endif
                                                @if (isset($models) && $models && $models == 'users')
                                                    <span
                                                        class="real-active {{ $user->user_status == 'online' ? 'active heartbeat' : '' }} user-heartbeat-{{ $user->id }}"></span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-800">{{ $user->name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                                        <td class="px-6 py-4 text-sm">
                                            <span
                                                class="px-3 py-1 rounded-full text-xs font-semibold
                                        @if ($user->isSuperAdmin()) bg-red-100 text-red-800
                                        @elseif($user->isAdmin()) bg-yellow-100 text-yellow-800
                                        @else bg-blue-100 text-blue-800 @endif">
                                                {{ $user->role }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->created_at->format('d/m/Y') }}</td>
                                        <td class="px-6 py-4 text-sm space-x-2">
                                            @include('dashboard.components.show-button', [
                                                'models' => 'dashboard.users',
                                                'id' => $user->id,
                                            ])
                                            @include('dashboard.components.edit-button', [
                                                'models' => 'dashboard.users',
                                                'id' => $user->id,
                                            ])
                                            @include('dashboard.components.delete-button', ['id' => $user->id])

                                            @include('dashboard.components.forceDelete-button', ['id' => $user->id])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-400">
                                            لا توجد مستخدمين متاحون حالياً
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

    <div class="layout hidden" id="layout">
        <!-- مودال إضافة مستخدم -->
        <div class="modal fade hidden rounded-[9px]" id="addUserModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header flex items-center justify-between gap-4 p-4 border-b border-gray-200">
                        <h5 class="modal-title font-semibold text-gray-800">إضافة مستخدم جديد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <form method="POST" action="{{ route('dashboard.users.store') ?? '#' }}">
                        @csrf
                        <div class="modal-body p-4 space-y-4">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
                                <input type="text"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" id="name"
                                    name="name" required>
                            </div>
                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                                <input type="email"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" id="email"
                                    name="email" required>
                            </div>
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">كلمة المرور</label>
                                <input type="password"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" id="password"
                                    name="password" required>
                            </div>
                            <div>
                                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">الدور</label>
                                <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    id="role" name="role" required>
                                    <option value="content_manager">مدير المحتوى</option>
                                    <option value="admin">مسؤول</option>
                                    <option value="superadmin">مسؤول فائق</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer bg-gray-50 border-t border-gray-200 p-4 flex justify-end gap-3">
                            <button type="button" class="px-4 py-2 bg-danger text-white cursor-pointer rounded-lg text-sm font-medium" data-bs-dismiss="modal">
                                <i class="fas fa-times mr-2"></i>
                                إلغاء
                            </button>
                            <button type="submit" class="px-4 py-2 bg-primary text-white cursor-pointer rounded-lg text-sm font-medium">
                                <i class="fas fa-plus mr-2"></i>
                                إضافة
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function editUser(button, userId, name, email, role) {
            document.getElementById('edit-name').value = name;
            document.getElementById('edit-email').value = email;
            document.getElementById('edit-role').value = role;
            document.getElementById('editUserForm').action = `{{ route('dashboard.users.update', ':id') }}`.replace(':id', userId);
        }

        // البحث والتصفية
        document.getElementById('searchUsers').addEventListener('keyup', function() {
            const search = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(search) ? '' : 'none';
            });
        });
    </script>
@endsection
