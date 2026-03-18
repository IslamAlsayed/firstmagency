@extends('dashboard.layout.master')

@section('title', __('main.dashboard'))
@section('page-title', '🏠 ' . __('main.dashboard'))

@push('styles')
    <style>
        .container {
            display: flex;
            height: 100vh;
        }

        .sidebar {
            width: 200px;
            padding: 15px;
            background-color: #f4f4f4;
            border-right: 1px solid #ccc;
        }

        .item {
            padding: 10px;
            margin-bottom: 10px;
            background-color: #007bff;
            color: white;
            cursor: grab;
            border-radius: 4px;
        }

        .main-content {
            flex-grow: 1;
            padding: 20px;
            background-color: #fff;
        }

        .drop-zone {
            border: 2px dashed #ccc;
            padding: 20px;
            min-height: 200px;
            background-color: #fafafa;
        }

        /* Optional: Add styles for when an item is being dragged over a drop target */
        .drop-zone.drag-over {
            background-color: #e9e9e9;
            border-color: #000;
        }
    </style>
@endpush

@section('content')
    <aside id="sidebar" class="sidebar fixed top-0 left-0 bg-gray-900 text-white shadow-lg flex flex-col">
        <ul id="sidebarMenu" class="nav-menu" data-group="sidebar-items">
            <!-- System Management -->
            @if (auth()->user()->can('users-read') || auth()->user()->can('users-create') || auth()->user()->can('departments-read') || auth()->user()->can('departments-create'))
                <li class="relative group submenu-item" data-item-id="system-management" draggable="true">
                    <button type="button" data-toggle="submenu"
                        class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.users.*', 'dashboard.departments.*') ? 'active' : '' }}">
                        <div class="flex items-center gap-3">
                            <span class="main-icon">⚙️</span>
                            <span class="span-text">{{ __('main.system') }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs nav-icon"></i>
                    </button>

                    <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.users.*', 'dashboard.departments.*') ? 'show' : '' }}">
                        @if (auth()->user()->can('users-read') || auth()->user()->can('users-create'))
                            <li class="relative">
                                <a href="{{ route('dashboard.users.index') }}"
                                    class="nav-link {{ request()->routeIs('dashboard.users.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                    <span class="text-sm">{{ __('main.user') }}</span>
                                </a>
                            </li>
                        @endif

                        <!-- Departments -->
                        @if (auth()->user()->can('departments-read') || auth()->user()->can('departments-create'))
                            <li class="relative">
                                <a href="{{ route('dashboard.departments.index') }}"
                                    class="nav-link {{ request()->routeIs('dashboard.departments.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                    <span class="text-sm">{{ __('main.department') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Roles & Permissions -->
            @if (auth()->user()->can('roles-read') || auth()->user()->can('roles-create') || auth()->user()->can('permissions-read') || auth()->user()->can('permissions-create'))
                <li class="relative group submenu-item" data-item-id="roles-permissions" draggable="true">
                    <button type="button" data-toggle="submenu"
                        class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }}">
                        <div class="flex items-center gap-3">
                            <span class="main-icon">🔐</span>
                            <span class="span-text">{{ __('main.permissions') }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs nav-icon"></i>
                    </button>

                    <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.roles.*') ? 'show' : '' }}">
                        @if (auth()->user()->can('roles-read') || auth()->user()->can('roles-create'))
                            <li class="relative">
                                <a href="{{ route('dashboard.roles.index') }}"
                                    class="nav-link {{ request()->routeIs('dashboard.roles.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                    <span class="main-icon">🔐</span>
                                    <span class="text-sm">{{ __('main.role') }}</span>
                                </a>
                            </li>
                        @endif
                        @if (auth()->user()->can('permissions-read') || auth()->user()->can('permissions-create'))
                            <li class="relative">
                                <a href="{{ route('dashboard.permissions.index') }}"
                                    class="nav-link {{ request()->routeIs('dashboard.permissions.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                    <span class="main-icon">🔐</span>
                                    <span class="text-sm">{{ __('main.permission') }}</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </li>
            @endif

            <!-- Tickets -->
            @if (auth()->user()->can('tickets-read') || auth()->user()->can('tickets-create'))
                <li class="relative group submenu-item" data-item-id="tickets" draggable="true">
                    <button type="button" data-toggle="submenu"
                        class="submenu-btn nav-link w-full flex items-center justify-between cursor-pointer rounded-lg text-slate-300 group-hover:text-white group-hover {{ request()->routeIs('dashboard.tickets.*') ? 'active' : '' }}">
                        <div class="flex items-center gap-3">
                            <span class="main-icon">🎫</span>
                            <span class="span-text">{{ __('main.tickets') }}</span>
                        </div>
                        <i class="fas fa-chevron-down text-xs nav-icon"></i>
                    </button>

                    <ul class="submenu-list group-hover:block rounded-lg shadow-sm overflow-hidden {{ request()->routeIs('dashboard.tickets.*') ? 'show' : '' }}">
                        <li class="relative">
                            <a href="{{ route('dashboard.tickets.index') }}"
                                class="nav-link {{ request()->routeIs('dashboard.tickets.*') ? 'active' : '' }} flex items-center gap-3 text-slate-300 hover:bg-slate-700 hover:text-white border-l-2 border-transparent hover:border-blue-500">
                                <span class="main-icon">🎫</span>
                                <span class="text-sm">{{ __('main.tickets') }}</span>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </aside>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const menu = document.getElementById('sidebarMenu');
            let draggingItem = null;

            // 1. عند بدء السحب
            menu.addEventListener('dragstart', (e) => {
                draggingItem = e.target.closest('.submenu-item'); // نضمن سحب الـ li بالكامل
                e.dataTransfer.effectAllowed = 'move';

                // تأخير بسيط لإخفاء العنصر الأصلي بصرياً أثناء السحب
                setTimeout(() => draggingItem.classList.add('opacity-20'), 0);
            });

            // 2. أثناء التحريك فوق العناصر الأخرى
            menu.addEventListener('dragover', (e) => {
                e.preventDefault(); // ضروري للسماح بالإسقاط
                const target = e.target.closest('.submenu-item');

                if (target && target !== draggingItem) {
                    // تحديد مكان الإسقاط (قبل أو بعد العنصر المستهدف)
                    const rect = target.getBoundingClientRect();
                    const next = (e.clientY - rect.top) / (rect.bottom - rect.top) > 0.5;

                    menu.insertBefore(draggingItem, next ? target.nextSibling : target);
                }
            });

            // 3. عند انتهاء السحب (الإفلات)
            menu.addEventListener('dragend', () => {
                draggingItem.classList.remove('opacity-20');
                draggingItem = null;

                // الحصول على الترتيب الجديد (اختياري للإرسال للسيرفر)
                const newOrder = Array.from(menu.querySelectorAll('.submenu-item'))
                    .map(item => item.getAttribute('data-item-id'));
                console.log("الترتيب الجديد:", newOrder);
            });

            // منع السحب من داخل الروابط أو الأزرار مباشرة لتجنب التداخل
            menu.querySelectorAll('a, button').forEach(el => {
                el.setAttribute('draggable', 'false');
            });
        });
    </script>
@endpush

@push('scripts2')
    <script>
        // Function to allow dropping (prevents default browser behavior)
        function allowDrop(event) {
            event.preventDefault();
        }

        // Function to handle the start of a drag operation
        function drag(event) {
            // Specify what data to be dragged (in this case, the element's ID)
            event.dataTransfer.setData("text", event.target.id);
            // Optional: Add a class for visual feedback during drag
            event.dataTransfer.effectAllowed = "move";
        }

        // Function to handle the drop operation
        function drop(event) {
            event.preventDefault();
            // Get the dragged data (the element ID)
            var data = event.dataTransfer.getData("text");
            // Append the dragged element to the drop zone
            event.target.appendChild(document.getElementById(data));
        }

        // Optional: Add/remove 'drag-over' class for better visual feedback
        const dropZone = document.getElementById('drop-zone');

        dropZone.addEventListener('dragenter', (e) => {
            e.preventDefault();
            dropZone.classList.add('drag-over');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('drag-over');
        });

        dropZone.addEventListener('drop', () => {
            dropZone.classList.remove('drag-over');
        }); <
        />
    @endpush
