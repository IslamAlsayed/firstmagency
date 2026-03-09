@extends('dashboard.layout.master')

@section('title', $platformManagement->translations[app()->getLocale()]['title'] ?? 'Platform Management')
@section('page-title', '📱 ' . limitedText($platformManagement->translations[app()->getLocale()]['title'] ?? '', 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $platformManagement->translations[app()->getLocale()]['title'] ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $platformManagement->creator?->name ?? 'N/A' }} • {{ $platformManagement->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $platformManagement)
                    <a href="{{ route('dashboard.platform-management.edit', $platformManagement->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.platform-management.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_platform_management') }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.platform_management')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $platformManagement->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($platformManagement->creator)
                                    <a href="{{ route('dashboard.users.show', $platformManagement->creator->id) }}" class="text-primary hover:underline">
                                        {{ $platformManagement->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $platformManagement->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('main.status') }}
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($platformManagement->status === 'published') bg-green-100 text-green-800
                            @elseif($platformManagement->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ __('main.' . $platformManagement->status) }}
                                </span>
                            </p>
                            @include('dashboard.components.status-actions', [
                                'record' => $platformManagement,
                                'models' => 'platform-management',
                                'modelClass' => 'platform-management',
                                'availableOptions' => array_column(\App\Enum\PestDomainEnums::cases(), 'value'),
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $platformManagement->id,
                                'field' => 'is_active',
                                'value' => (bool) $platformManagement->is_active,
                                'modelClass' => 'platform_management',
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.featured') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $platformManagement->id,
                                'field' => 'is_featured',
                                'value' => (bool) $platformManagement->is_featured,
                                'modelClass' => 'platform_management',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.platform_management_content') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Language Tabs -->
                    <div class="flex gap-4 mb-6">
                        @foreach (array_keys(config('languages')) as $lang)
                            <button type="button"
                                class="language-tab cursor-pointer {{ $loop->first ? 'border-b-2 text-gray-900 font-semibold' : 'border-transparent text-gray-600' }} pb-2 px-2"
                                data-lang="{{ $lang }}">
                                {{ config("languages.$lang.flag") }} {{ __('main.' . $lang . '_content') }}
                            </button>
                        @endforeach
                    </div>

                    <!-- English Content -->
                    <div class="language-content" data-lang="en">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                            <p class="text-gray-700 leading-relaxed">{!! $platformManagement->translations['en']['title'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $platformManagement->translations['en']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                            <p class="text-gray-700 leading-relaxed">{!! $platformManagement->translations['ar']['title'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $platformManagement->translations['ar']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 pt-6 border-t">
                        {{-- Empty or add additional metadata here --}}
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-3 mb-6">
                @can('update', $platformManagement)
                    <a href="{{ route('dashboard.platform-management.edit', $platformManagement->id) }}" class="kt-btn kt-btn-primary hidden md:flex">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                @include('dashboard.components.permissions-actions', [
                    'record' => $platformManagement,
                    'models' => 'platform-management',
                ])
            </div>
        </div>
    </div>

    <!-- Language Tabs JavaScript -->
    <script>
        document.querySelectorAll('.language-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const lang = this.getAttribute('data-lang');

                document.querySelectorAll('.language-tab').forEach(t => {
                    t.classList.remove('border-b-2', 'text-gray-900', 'font-semibold');
                    t.classList.add('border-transparent', 'text-gray-600');
                });

                this.classList.add('border-b-2', 'text-gray-900', 'font-semibold');
                this.classList.remove('border-transparent', 'text-gray-600');

                document.querySelectorAll('.language-content').forEach(content => {
                    content.classList.add('hidden');
                });

                document.querySelector(`.language-content[data-lang="${lang}"]`)?.classList.remove('hidden');
            });
        });
    </script>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
