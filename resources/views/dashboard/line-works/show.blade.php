@extends('dashboard.layout.master')

@section('title', $lineWork->translations[app()->getLocale()]['title'] ?? 'Line Work')
@section('page-title', '⚙️ ' . limitedText($lineWork->translations[app()->getLocale()]['title'] ?? '', 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $lineWork->translations[app()->getLocale()]['title'] ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $lineWork->creator?->name ?? 'N/A' }} • {{ $lineWork->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $lineWork)
                    <a href="{{ route('dashboard.line-works.edit', $lineWork->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.line-works.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.line_works')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.line_work')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $lineWork->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($lineWork->creator)
                                    <a href="{{ route('dashboard.users.show', $lineWork->creator->id) }}" class="text-primary hover:underline">
                                        {{ $lineWork->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $lineWork->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.status') }}</p>
                            <p class="text-sm text-secondary-foreground">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($lineWork->status === 'published') bg-green-100 text-green-800
                            @elseif($lineWork->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ __('main.' . $lineWork->status) }}
                                </span>
                            </p>
                        </div>

                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $lineWork->id,
                                'field' => 'is_active',
                                'value' => (bool) $lineWork->is_active,
                                'modelClass' => 'line-work',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.line_work_content') }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Language Tabs -->
                    <div class="flex gap-4 mb-6">
                        @foreach (array_keys(config('languages')) as $lang)
                            <button type="button" class="language-tab cursor-pointer {{ $loop->first ? 'border-b-2 text-gray-900 font-semibold' : 'border-transparent text-gray-600' }} pb-2 px-2"
                                data-lang="{{ $lang }}">
                                {{ config("languages.$lang.flag") }} {{ __('main.' . $lang . '_content') }}
                            </button>
                        @endforeach
                    </div>

                    <!-- English Content -->
                    <div class="language-content" data-lang="en">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                            <p class="text-gray-700 leading-relaxed">{!! $lineWork->translations['en']['title'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $lineWork->translations['en']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                            <p class="text-gray-700 leading-relaxed">{!! $lineWork->translations['ar']['title'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $lineWork->translations['ar']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 pt-6 border-t">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.order') }}</label>
                            <p class="text-sm text-secondary-foreground">{{ $lineWork->order ?? 0 }}</p>
                        </div>

                        <div>
                            <label class="kt-label mb-1">{{ __('main.slug') }}</label>
                            <p class="text-sm text-gray-800 font-mono">{{ $lineWork->slug }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image -->
            @if (!empty($lineWork->image))
                @include('dashboard.components.display-photo', [
                    'record' => $lineWork,
                    'column' => 'image',
                    'alt' => $lineWork->alt_text ?? ($lineWork->translations[app()->getLocale()]['title'] ?? 'Line Work Image'),
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $lineWork])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $lineWork)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.line-works',
                        'id' => $lineWork->id,
                    ])
                @endcan
                @can('delete', $lineWork)
                    @include('dashboard.components.delete-button', [
                        'model' => 'dashboard.line-works',
                        'modelClass' => 'lineWork',
                        'id' => $lineWork->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.line-works.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.line_works')]) }}
                </a>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.language-tab').forEach(tab => {
            tab.addEventListener('click', function() {
                const lang = this.getAttribute('data-lang');

                // Hide all content
                document.querySelectorAll('.language-content').forEach(content => {
                    content.classList.add('hidden');
                });

                // Remove active class from all tabs
                document.querySelectorAll('.language-tab').forEach(t => {
                    t.classList.remove('border-b-2', 'text-gray-900', 'font-semibold');
                    t.classList.add('border-transparent', 'text-gray-600');
                });

                // Show selected content
                document.querySelector(`[data-lang="${lang}"]`).classList.remove('hidden');

                // Add active class to selected tab
                this.classList.remove('border-transparent', 'text-gray-600');
                this.classList.add('border-b-2', 'text-gray-900', 'font-semibold');
            });
        });
    </script>
@endsection
