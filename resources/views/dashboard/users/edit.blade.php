@extends('dashboard.layout.master')

@section('title', __('main.edit_type', ['type' => __('main.user')]))
@section('page-title', '👤 ' . __('main.edit_type', ['type' => __('main.user')]))

@push('styles')
    <link href="{{ asset('assets/dashboard/css/users.css') }}" rel="stylesheet" />
@endpush

@section('content')
    <div class="shadow-lg radius-lg p-4">
        <form method="POST" action="{{ route('dashboard.users.update', $user->id) ?? '#' }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid gap-6 lg:gap-8">

                @include('dashboard.components.photo', ['record' => $user])

                <div class="ff-section ff-anim">
                    <div class="ff-s-icon"><i class="fas fa-user-pen"></i></div>
                    <div class="ff-s-title">{{ __('main.basic_information') }}</div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 ff-grid">
                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="text" class="ff-input" id="name" name="name" placeholder=" " value="{{ old('name', $user->name) }}">
                            <label class="ff-label" for="name">{{ __('main.name') }}</label>
                            <i class="fas fa-user ff-icon"></i>
                        </div>
                        @error('name')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="email" class="ff-input" id="email" name="email" placeholder=" " value="{{ old('email', $user->email) }}">
                            <label class="ff-label" for="email">{{ __('main.email') }}</label>
                            <i class="fas fa-envelope ff-icon"></i>
                        </div>
                        @error('email')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="tel" class="ff-input" id="mobile" name="mobile" placeholder=" " value="{{ old('mobile', $user->mobile) }}">
                            <label class="ff-label" for="mobile">{{ __('main.mobile') }}</label>
                            <i class="fas fa-mobile-screen ff-icon"></i>
                        </div>
                        @error('mobile')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ff-anim">
                        <div class="ff-group">
                            <input type="tel" class="ff-input" id="phone" name="phone" placeholder=" " value="{{ old('phone', $user->phone) }}">
                            <label class="ff-label" for="phone">{{ __('main.phone') }}</label>
                            <i class="fas fa-phone ff-icon"></i>
                        </div>
                        @error('phone')
                            <div class="ff-err"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    @include('dashboard.components.input-text-editor', [
                        'name' => 'address',
                        'value' => old('address', $user->address),
                    ])

                    @include('dashboard.components.input-text-editor', [
                        'name' => 'bio',
                        'value' => old('bio', $user->bio),
                    ])
                </div>

                <div class="ff-section ff-anim">
                    <div class="ff-s-icon"><i class="fas fa-shield-halved"></i></div>
                    <div class="ff-s-title">{{ __('main.permissions') }}</div>
                </div>

                <div class="ff-anim">
                    <div class="text-sm font-semibold mb-3 text-gray-500">{{ __('main.role') }}</div>
                    <div class="role-cards" id="role-cards">
                        <label class="role-card {{ old('role', $user->role) == 'superadmin' ? 'active' : '' }}">
                            <input type="radio" name="role" value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'checked' : '' }}>
                            <span class="rc-icon">🛡️</span>
                            <div class="rc-label">{{ __('main.super_admin') }}</div>
                        </label>
                        <label class="role-card {{ old('role', $user->role) == 'admin' ? 'active' : '' }}">
                            <input type="radio" name="role" value="admin" {{ old('role', $user->role) == 'admin' ? 'checked' : '' }}>
                            <span class="rc-icon">⚙️</span>
                            <div class="rc-label">{{ __('main.admin') }}</div>
                        </label>
                        <label class="role-card {{ old('role', $user->role) == 'content_manager' ? 'active' : '' }}">
                            <input type="radio" name="role" value="content_manager" {{ old('role', $user->role) == 'content_manager' ? 'checked' : '' }}>
                            <span class="rc-icon">✍️</span>
                            <div class="rc-label">{{ __('main.content_manager') }}</div>
                        </label>
                    </div>
                    @error('role')
                        <div class="ff-err mt-2"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="ff-anim">
                    <div class="text-sm font-semibold mb-3 text-gray-500">{{ __('main.status') }}</div>
                    @php $oldStatus = old('status', $user->status); @endphp
                    <div class="status-pills" id="status-pills">
                        <label class="status-pill {{ $oldStatus == 'active' ? 'active' : '' }}" data-val="active">
                            <input type="radio" name="status" value="active" {{ $oldStatus == 'active' ? 'checked' : '' }}>
                            ✅ {{ __('main.active') }}
                        </label>
                        <label class="status-pill {{ $oldStatus == 'inactive' ? 'active' : '' }}" data-val="inactive">
                            <input type="radio" name="status" value="inactive" {{ $oldStatus == 'inactive' ? 'checked' : '' }}>
                            ⏸️ {{ __('main.inactive') }}
                        </label>
                        <label class="status-pill {{ $oldStatus == 'suspended' ? 'active' : '' }}" data-val="suspended">
                            <input type="radio" name="status" value="suspended" {{ $oldStatus == 'suspended' ? 'checked' : '' }}>
                            🚫 {{ __('main.suspended') }}
                        </label>
                    </div>
                    @error('status')
                        <div class="ff-err mt-2"><i class="fas fa-circle-exclamation"></i> {{ $message }}</div>
                    @enderror
                </div>

                <input type="hidden" name="created_by" value="{{ old('created_by', $user->created_by) }}">
                <input type="hidden" name="updated_by" value="{{ old('updated_by', $user->updated_by) }}">

                @include('dashboard.components.update-submit', ['models' => 'dashboard.users', 'model' => 'user'])
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.drag-drop-images')
    <script src="https://cdn.ckeditor.com/4.22.1/standard/ckeditor.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('#role-cards .role-card').forEach(function(card) {
                card.addEventListener('change', function() {
                    document.querySelectorAll('#role-cards .role-card').forEach(function(c) {
                        c.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });

            document.querySelectorAll('#status-pills .status-pill').forEach(function(pill) {
                pill.addEventListener('change', function() {
                    document.querySelectorAll('#status-pills .status-pill').forEach(function(p) {
                        p.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });

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
