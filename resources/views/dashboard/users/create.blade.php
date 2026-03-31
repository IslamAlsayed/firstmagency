@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.user')]))
@section('page-title', '👤 ' . __('main.edit_type', ['type' => __('main.user')]))

@push('styles')
    <link href="{{ asset('assets/dashboard/css/users.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.users.store') ?? '#' }}" enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 lg:gap-8">
                {{-- Photo --}}
                @include('dashboard.components.photo', ['record' => $user, 'columnName' => 'photo'])

                {{-- ── Section: Basic Info ────────────────────────────────── --}}
                <div class="ff-section ff-anim">
                    <div class="ff-s-icon"><i class="fas fa-user-pen"></i></div>
                    <div class="ff-s-title">{{ __('main.basic_information') }}</div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 ff-grid">
                    {{-- Name --}}
                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="text" class="ff-input" id="name" name="name" placeholder=" " value="{{ old('name') }}" required autocomplete="name">
                            <label class="ff-label" for="name">
                                {{ __('main.name') }} <span class="text-red-400">*</span>
                            </label>
                            <i class="fas fa-user ff-icon"></i>
                        </div>
                        @error('name')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="email" class="ff-input" id="email" name="email" placeholder=" " value="{{ old('email') }}" required autocomplete="email">
                            <label class="ff-label" for="email">
                                {{ __('main.email') }} <span class="text-red-400">*</span>
                            </label>
                            <i class="fas fa-envelope ff-icon"></i>
                        </div>
                        @error('email')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Mobile --}}
                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="tel" class="ff-input" id="mobile" name="mobile" placeholder=" " value="{{ old('mobile') }}">
                            <label class="ff-label" for="mobile">{{ __('main.mobile') }}</label>
                            <i class="fas fa-mobile-screen ff-icon"></i>
                        </div>
                        @error('mobile')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Phone --}}
                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="tel" class="ff-input" id="phone" name="phone" placeholder=" " value="{{ old('phone') }}">
                            <label class="ff-label" for="phone">{{ __('main.phone') }}</label>
                            <i class="fas fa-phone ff-icon"></i>
                        </div>
                        @error('phone')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="password" class="ff-input has-eye" id="password" name="password" placeholder=" " required autocomplete="new-password">
                            <label class="ff-label" for="password">
                                {{ __('main.password') }} <span class="text-red-400">*</span>
                            </label>
                            <i class="fas fa-lock ff-icon"></i>
                            <i class="fas fa-eye ff-eye" data-target="password"></i>
                        </div>
                        <div class="pwd-strength">
                            <div class="pwd-strength-track">
                                <div class="pwd-strength-bar" id="pwd-bar"></div>
                            </div>
                            <div class="pwd-strength-text" id="pwd-text"></div>
                        </div>
                        @error('password')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Confirm Password --}}
                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="password" class="ff-input has-eye" id="password_confirmation" name="password_confirmation" placeholder=" " required autocomplete="new-password">
                            <label class="ff-label" for="password_confirmation">
                                {{ __('main.confirm_password') }} <span class="text-red-400">*</span>
                            </label>
                            <i class="fas fa-lock-open ff-icon"></i>
                            <i class="fas fa-eye ff-eye" data-target="password_confirmation"></i>
                        </div>
                        @error('password_confirmation')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                </div>

                {{-- العنوان والسيرة الذاتية --}}
                <div class="grid grid-cols-1 gap-6">
                    @include('dashboard.components.input-text-editor', ['name' => 'address', 'value' => old('address')])
                    @include('dashboard.components.input-text-editor', ['name' => 'bio', 'value' => old('bio')])
                </div>

                {{-- ── Section: Permissions & Status ────────────────────── --}}
                <div class="ff-section ff-anim">
                    <div class="ff-s-icon"><i class="fas fa-shield-halved"></i></div>
                    <div class="ff-s-title">{{ __('main.permissions') }}</div>
                </div>

                {{-- Role cards --}}
                <div class="ff-anim">
                    <div class="text-sm font-semibold mb-3 text-gray-500">
                        {{ __('main.role') }} <span class="text-red-400">*</span>
                    </div>
                    <div class="role-cards" id="role-cards">
                        <label class="role-card {{ old('role') == 'superadmin' ? 'active' : '' }}">
                            <input type="radio" name="role" value="superadmin" {{ old('role') == 'superadmin' ? 'checked' : '' }} required>
                            <span class="rc-icon">🛡️</span>
                            <div class="rc-label">{{ __('main.super_admin') }}</div>
                        </label>
                        <label class="role-card {{ old('role') == 'admin' ? 'active' : '' }}">
                            <input type="radio" name="role" value="admin" {{ old('role') == 'admin' ? 'checked' : '' }}>
                            <span class="rc-icon">⚙️</span>
                            <div class="rc-label">{{ __('main.admin') }}</div>
                        </label>
                        <label class="role-card {{ old('role') == 'content_manager' ? 'active' : '' }}">
                            <input type="radio" name="role" value="content_manager" {{ old('role') == 'content_manager' ? 'checked' : '' }}>
                            <span class="rc-icon">✍️</span>
                            <div class="rc-label">{{ __('main.content_manager') }}</div>
                        </label>
                    </div>
                    @error('role')
                        <div class="ff-err mt-2"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Status pills --}}
                <div class="ff-anim">
                    <div class="text-sm font-semibold mb-3 text-gray-500">
                        {{ __('main.status') }}
                    </div>
                    @php $oldStatus = old('status', 'active'); @endphp
                    <div class="status-pills" id="status-pills">
                        <label class="status-pill {{ $oldStatus == 'active' ? 'active' : '' }}" data-val="active">
                            <input type="radio" name="status" value="active" {{ $oldStatus == 'active' ? 'checked' : '' }}>
                            ✅ {{ __('main.active') ?? 'نشط' }}
                        </label>
                        <label class="status-pill {{ $oldStatus == 'inactive' ? 'active' : '' }}" data-val="inactive">
                            <input type="radio" name="status" value="inactive" {{ $oldStatus == 'inactive' ? 'checked' : '' }}>
                            ⏸️ {{ __('main.inactive') ?? 'غير نشط' }}
                        </label>
                        <label class="status-pill {{ $oldStatus == 'suspended' ? 'active' : '' }}" data-val="suspended">
                            <input type="radio" name="status" value="suspended" {{ $oldStatus == 'suspended' ? 'checked' : '' }}>
                            🚫 {{ __('main.suspended') ?? 'معلق' }}
                        </label>
                    </div>
                    @error('status')
                        <div class="ff-err mt-2"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="created_by" value="{{ auth()->id() }}">
                <input type="hidden" name="updated_by" value="{{ auth()->id() }}">

                @include('dashboard.components.save-submit', ['models' => 'dashboard.users', 'model' => 'user'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        // ── Password visibility toggle ────────────────────────────────
        document.querySelectorAll('.ff-eye').forEach(function(eye) {
            eye.addEventListener('click', function() {
                const input = document.getElementById(this.dataset.target);
                if (!input) return;
                const isPass = input.type === 'password';
                input.type = isPass ? 'text' : 'password';
                this.classList.toggle('fa-eye', !isPass);
                this.classList.toggle('fa-eye-slash', isPass);
            });
        });

        // ── Password strength meter ────────────────────────────────────
        (function() {
            const pwd = document.getElementById('password');
            const bar = document.getElementById('pwd-bar');
            const text = document.getElementById('pwd-text');
            if (!pwd || !bar || !text) return;

            const levels = [{
                    pct: '0%',
                    bg: '',
                    label: ''
                },
                {
                    pct: '25%',
                    bg: '#ef4444',
                    label: '{{ __('main.password_weak') }}'
                },
                {
                    pct: '50%',
                    bg: '#f97316',
                    label: '{{ __('main.password_fair') }}'
                },
                {
                    pct: '75%',
                    bg: '#eab308',
                    label: '{{ __('main.password_good') }}'
                },
                {
                    pct: '100%',
                    bg: '#22c55e',
                    label: '{{ __('main.password_strong') }}'
                },
            ];

            pwd.addEventListener('input', function() {
                const v = this.value;
                let score = 0;
                if (v.length >= 8) score++;
                if (/[A-Z]/.test(v)) score++;
                if (/[0-9]/.test(v)) score++;
                if (/[^A-Za-z0-9]/.test(v)) score++;

                const levelIndex = v.length ? Math.max(1, score) : 0;

                bar.style.width = levels[levelIndex].pct;
                bar.style.background = levels[levelIndex].bg;
                text.textContent = levels[levelIndex].label;
                text.style.color = levels[levelIndex].bg;
            });
        })();

        // ── Role card active state ────────────────────────────────────
        document.querySelectorAll('#role-cards .role-card').forEach(function(card) {
            card.addEventListener('change', function() {
                document.querySelectorAll('#role-cards .role-card').forEach(function(c) {
                    c.classList.remove('active');
                });
                this.classList.add('active');
            });
        });

        // ── Status pill active state ──────────────────────────────────
        document.querySelectorAll('#status-pills .status-pill').forEach(function(pill) {
            pill.addEventListener('change', function() {
                document.querySelectorAll('#status-pills .status-pill').forEach(function(p) {
                    p.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    </script>
@endpush

@push('scripts')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function initCkEditors() {
                if (window.CKEDITOR) {
                    document.querySelectorAll('textarea.ckeditor').forEach(function(el) {
                        if (el.id && CKEDITOR.instances[el.id]) {
                            CKEDITOR.instances[el.id].destroy(true);
                        }
                        if (!el.classList.contains('ckeditor-initialized')) {
                            CKEDITOR.replace(el.id, {
                                height: 300
                            });
                            el.classList.add('ckeditor-initialized');
                        }
                    });
                } else {
                    setTimeout(initCkEditors, 300);
                }
            }
            initCkEditors();
        });
    </script>
@endpush
