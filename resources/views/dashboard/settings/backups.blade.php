@extends('dashboard.layout.master')

@section('title', __('main.backup_management'))
@section('page-title', '⚡ ' . __('main.backup_management'))

@push('styles')
    @include('dashboard.components.entity-index-styles')

    <style>
        .toggle-icon {
            width: 30px;
            height: 30px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: #e5e7eb;
            border-radius: 9999px;
            transition: background-color 0.3s ease, transform 0.3s ease;

            &:hover {
                transform: translateY(-2px);
            }
        }

        @media (max-width: 640px) {
            #backups-list * {
                font-size: 10px;
            }

            #backup-section * {
                font-size: 12px;
            }

            #backup-section-title,
            #create-backup-btn {
                font-size: 12px;
            }

            #backups-list button {
                padding: 5px 7px;
                height: fit-content;
                border-radius: 3px;
            }
        }

        @media (max-width: 425px) {
            #backups-list * {
                font-size: 8px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="entity-index-page" style="--page-accent: #10b981;">
        <section class="entity-hero">
            <div class="entity-hero-grid">
                <div>
                    <span class="entity-kicker">
                        <i class="fas fa-database"></i>
                        {{ __('main.backup_management') }}
                    </span>

                    <h1 class="entity-hero-title">{{ __('main.backup_management') }}</h1>
                    <p class="entity-hero-subtitle">{{ __('main.dashboard') }} - {{ __('main.settings_database_backup_restore') }}</p>
                </div>

                @include('dashboard.components.entity-hero-summary', [
                    'icon' => 'fas fa-shield-halved',
                    'items' => [
                        ['id' => 'stat-backups', 'value' => '-', 'label' => __('main.settings_available_backups')],
                        ['id' => 'stat-safety', 'value' => '100%', 'label' => __('main.settings_backup_safe_storage')],
                    ],
                ])
            </div>
        </section>

        <section class="entity-panel">
            @include('dashboard.components.entity-panel-heading', [
                'icon' => 'fas fa-database',
                'title' => __('main.settings_database_backup_restore'),
                'description' => __('main.settings_backup_restore_anytime'),
            ])

            <div class="entity-content">
                <div id="backup-section">
                    <div class="space-y-5 mt-4">
                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between bg-emerald-50 border border-emerald-100 radius-lg p-4">
                            <div>
                                <p class="text-sm font-semibold text-emerald-800">{{ __('main.settings_create_new_backup') }}</p>
                                <p class="text-xs text-emerald-700">{{ __('main.settings_backup_safe_storage') }}</p>
                            </div>

                            <button id="create-backup-btn" type="button"
                                class="cursor-pointer inline-flex items-center justify-center gap-2 px-4 py-2 radius-lg font-semibold text-white shadow-sm transition"
                                style="background-color: var(--button_color); color: var(--text_color);">
                                <i class="fas fa-plus-circle"></i>
                                {{ __('main.settings_create_backup_now') }}
                            </button>
                        </div>

                        <div id="backup-status" class="hidden radius-lg border border-gray-200 bg-gray-50 px-4 py-3 text-sm"></div>

                        <div class="bg-gray-50 border border-gray-200 radius-lg p-4">
                            <h6 class="text-sm font-semibold text-gray-700 mb-3">
                                <i class="fas fa-list text-blue-500"></i>
                                {{ __('main.settings_available_backups') }}
                            </h6>

                            <div id="backups-list" class="space-y-3">
                                <p class="text-center text-gray-500 py-6">{{ __('main.settings_no_backups') }}</p>
                            </div>
                        </div>

                        <div class="radius-lg border border-amber-200 bg-amber-50 p-4">
                            <h6 class="text-sm font-semibold text-amber-800 mb-2">
                                <i class="fas fa-circle-info"></i>
                                {{ __('main.settings_backup_important_info') }}
                            </h6>
                            <ul class="space-y-1 text-xs text-amber-800">
                                <li>• {{ __('main.settings_backup_restore_anytime') }}</li>
                                <li>• {{ __('main.settings_backup_download_local') }}</li>
                                <li>• {{ __('main.settings_backup_restore_overwrite_warning') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const createBtn = document.getElementById('create-backup-btn');
            const backupsList = document.getElementById('backups-list');
            const statusDiv = document.getElementById('backup-status');

            function loadBackups() {
                fetch("{{ route('dashboard.backups.list') }}")
                    .then(res => res.json())
                    .then(data => {
                        if (data.success && data.backups.length > 0) {
                            document.getElementById('stat-backups').textContent = data.backups.length;
                            backupsList.innerHTML = data.backups.map(backup => `
                                <div class="flex items-center justify-between bg-gray-100 p-4 radius-lg hover:bg-gray-150 transition">
                                    <div class="flex-1">
                                        <p class="font-semibold text-gray-700">
                                            <i class="fas fa-file-archive text-orange-500"></i>
                                            ${backup.filename}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            <i class="fas fa-calendar"></i> ${new Date(backup.created_at).toLocaleString('ar-EG')} |
                                            <i class="fas fa-database"></i> ${formatBytes(backup.size)}
                                        </p>
                                    </div>
                                    <div class="flex gap-2">
                                        <button class="cursor-pointer download-backup px-3 py-2 bg-blue-500 hover:bg-blue-600 text-white radius-lg transition" data-filename="${backup.filename}" title="{{ __('main.settings_download') }}">
                                            <i class="fas fa-download"></i>
                                        </button>
                                        <button class="cursor-pointer restore-backup px-3 py-2 bg-yellow-500 hover:bg-yellow-600 text-white radius-lg transition" data-filename="${backup.filename}" title="{{ __('main.settings_restore') }}">
                                            <i class="fas fa-redo-alt"></i>
                                        </button>
                                        <button class="cursor-pointer delete-backup px-3 py-2 bg-red-500 hover:bg-red-600 text-white radius-lg transition" data-filename="${backup.filename}" title="{{ __('main.settings_delete') }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            `).join('');
                            attachBackupListeners();
                        } else {
                            document.getElementById('stat-backups').textContent = 0;
                            backupsList.innerHTML = '<p class="text-center text-gray-500 py-8">{{ __('main.settings_no_backups') }}</p>';
                        }
                    })
                    .catch(() => {
                        backupsList.innerHTML = '<p class="text-center text-red-500 py-8">{{ __('main.settings_connection_error') }}</p>';
                    });
            }

            createBtn.addEventListener('click', function() {
                if (!confirm('{{ __('main.settings_create_backup_confirm') }}')) return;

                createBtn.disabled = true;
                statusDiv.classList.remove('hidden');
                statusDiv.innerHTML = '<div class="text-blue-600"><i class="fas fa-spinner fa-spin"></i> {{ __('main.settings_creating_backup') }}</div>';

                fetch("{{ route('dashboard.backups.create') }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            statusDiv.innerHTML = '<div class="text-green-600"><i class="fas fa-check-circle"></i> {{ __('main.settings_backup_created_success') }}</div>';
                            loadBackups();
                        } else {
                            statusDiv.innerHTML = '<div class="text-red-600"><i class="fas fa-times-circle"></i> {{ __('main.settings_error_prefix') }}: ' + data.message + '</div>';
                        }
                        createBtn.disabled = false;
                        setTimeout(() => statusDiv.classList.add('hidden'), 4000);
                    })
                    .catch(() => {
                        statusDiv.innerHTML = '<div class="text-red-600"><i class="fas fa-times-circle"></i> {{ __('main.settings_connection_error') }}</div>';
                        createBtn.disabled = false;
                        setTimeout(() => statusDiv.classList.add('hidden'), 4000);
                    });
            });

            function attachBackupListeners() {
                document.querySelectorAll('.download-backup').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const filename = this.dataset.filename;
                        window.location.href = "{{ url('dashboard/backups/download') }}/" + filename;
                    });
                });

                document.querySelectorAll('.restore-backup').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const filename = this.dataset.filename;
                        if (confirm('{{ __('main.settings_restore_confirm') }}')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('dashboard.backups.restore') }}";
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="filename" value="${filename}">
                            `;
                            document.body.appendChild(form);
                            alert('{{ __('main.settings_restore_in_progress') }}');
                            form.submit();
                        }
                    });
                });

                document.querySelectorAll('.delete-backup').forEach(btn => {
                    btn.addEventListener('click', function() {
                        const filename = this.dataset.filename;
                        if (confirm('{{ __('main.settings_delete_backup_confirm') }}')) {
                            const form = document.createElement('form');
                            form.method = 'POST';
                            form.action = "{{ route('dashboard.backups.delete') }}";
                            form.innerHTML = `
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="filename" value="${filename}">
                                <input type="hidden" name="_method" value="DELETE">
                            `;
                            document.body.appendChild(form);
                            form.submit();
                        }
                    });
                });
            }

            function formatBytes(bytes) {
                if (bytes === 0) return '0 {{ __('main.bytes') }}';
                const k = 1024;
                const sizes = ['{{ __('main.bytes') }}', '{{ __('main.kb') }}', '{{ __('main.mb') }}', '{{ __('main.gb') }}'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            loadBackups();
        });
    </script>
@endpush
