@extends('dashboard.layout.master')

@section('title', $whyUs->translations[app()->getLocale()]['name'] ?? 'Why Us')
@section('page-title', '🌟 ' . limitedText($whyUs->translations[app()->getLocale()]['name'] ?? '', 30))

@section('content')
    <div class="shadow-md radius-lg p-6">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $whyUs->translations[app()->getLocale()]['name'] ?? '-' }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $whyUs->creator?->name ?? 'N/A' }} • {{ $whyUs->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @can('update', $whyUs)
                    <a href="{{ route('dashboard.why-us.edit', $whyUs->id) }}" class="kt-btn kt-btn-primary md:hidden" toggle-button>
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan
                <a href="{{ route('dashboard.why-us.index') }}" class="kt-btn kt-btn-outline" toggle-button>
                    {{ __('main.back_to_why_us') }}
                </a>
            </div>
        </div>

        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.why_us')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $whyUs->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($whyUs->creator)
                                    <a href="{{ route('dashboard.users.show', $whyUs->creator->id) }}" class="text-primary hover:underline">
                                        {{ $whyUs->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-blue-600"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $whyUs->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('main.status') }}
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                            @if ($whyUs->status === 'published') bg-green-100 text-green-800
                            @elseif($whyUs->status === 'draft') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                                    {{ __('main.' . $whyUs->status) }}
                                </span>
                            </p>
                            @include('dashboard.components.status-actions', [
                                'record' => $whyUs,
                                'models' => 'why-us',
                                'modelClass' => 'whyUs',
                                'availableOptions' => array_column(\App\Enum\WhyUsEnums::cases(), 'value'),
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $whyUs->id,
                                'field' => 'is_active',
                                'value' => (bool) $whyUs->is_active,
                                'modelClass' => 'why_us',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="shadow-md radius-lg">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.why_us_content') }}</h3>
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
                            <p class="text-gray-700 leading-relaxed">{!! $whyUs->translations['en']['name'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $whyUs->translations['en']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.title') }}</p>
                            <p class="text-gray-700 leading-relaxed">{!! $whyUs->translations['ar']['name'] ?? '-' !!}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $whyUs->translations['ar']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6 pt-6 border-t">
                        <div>
                            <label class="kt-label mb-1">{{ __('main.alt_text') }}</label>
                            <p class="text-gray-700">{{ $whyUs->alt_text ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Image Display -->
            @if ($whyUs->image && checkExistFile($whyUs->image))
                <div class="shadow-md radius-lg">
                    <div class="kt-card-header">
                        <h3 class="kt-card-title">{{ __('main.image') }}</h3>
                    </div>

                    <div class="kt-card-body p-4">
                        <img src="{{ asset('storage/' . $whyUs->image) }}" alt="{{ $whyUs->alt_text ?? '' }}" class="max-w-full h-auto rounded-lg">
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex gap-3 mb-6">
                @can('update', $whyUs)
                    <a href="{{ route('dashboard.why-us.edit', $whyUs->id) }}" class="kt-btn kt-btn-primary hidden md:inline-flex" toggle-button>
                        <i class="ki-filled ki-pencil"></i>
                        {{ __('main.edit') }}
                    </a>
                @endcan

                @can('delete', $whyUs)
                    <button type="button" class="kt-btn kt-btn-danger" onclick="confirmDelete('{{ route('dashboard.why-us.destroy', $whyUs->id) }}')" toggle-button>
                        <i class="ki-filled ki-trash"></i>
                        {{ __('main.delete') }}
                    </button>
                @endcan
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('.language-tab').forEach(tab => {
                tab.addEventListener('click', function() {
                    const lang = this.dataset.lang;
                    document.querySelectorAll('.language-tab').forEach(btn => {
                        btn.classList.remove('border-b-2', 'text-gray-900', 'font-semibold');
                        btn.classList.add('border-transparent', 'text-gray-600');
                    });
                    this.classList.add('border-b-2', 'text-gray-900', 'font-semibold');
                    this.classList.remove('border-transparent', 'text-gray-600');

                    document.querySelectorAll('.language-content').forEach(content => {
                        content.classList.add('hidden');
                    });
                    document.querySelector(`[data-lang="${lang}"]`).classList.remove('hidden');
                });
            });

            function confirmDelete(url) {
                if (confirm('{{ __('main.confirm_delete') }}')) {
                    let form = document.createElement('form');
                    form.method = 'POST';
                    form.action = url;
                    form.innerHTML = '@csrf @method('DELETE')';
                    document.body.appendChild(form);
                    form.submit();
                }
            }
        </script>
    @endpush
@endsection
