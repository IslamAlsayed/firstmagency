@extends('dashboard.layout.master')

@section('title', $article->title)
@section('page-title', '📄 ' . limitedText($article->title, 30))

@section('content')
    <div class="kt-container-fixed p-0">
        <div class="flex flex-wrap items-center lg:items-end justify-between gap-4 pb-6">
            <div class="flex flex-col justify-center gap-2">
                <h1 class="text-xl font-medium leading-none text-mono">
                    {{ $article->title }}
                </h1>
                <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{ $article->author?->name ?? 'N/A' }} • {{ $article->created_at?->format('d M Y') }}
                </div>
            </div>
            <div class="flex items-center gap-2.5">
                @if (getActiveUser()->can('update', $article))
                    <a href="{{ route('dashboard.articles.edit', $article->id) }}" class="kt-btn kt-btn-primary md:hidden">
                        <i class="ki-filled ki-pencil text-sm me-2"></i>
                        {{ __('main.edit') }}
                    </a>
                @endif
                <a href="{{ route('dashboard.articles.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.articles')]) }}
                </a>
            </div>
        </div>
    </div>

    <div class="kt-container-fixed p-0">
        <div class="grid gap-4 lg:gap-6">
            {{-- Basic Information --}}
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.type_information', ['type' => __('main.article')]) }}</h3>
                </div>

                <div class="kt-card-body p-4">
                    <!-- Status Badges -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.order') }}</p>
                            <p class="font-semibold text-gray-800">{{ $article->order ?? 0 }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_by') }}</p>
                            <p class="font-semibold text-gray-800">
                                @if ($article->creator)
                                    <a href="{{ route('dashboard.users.show', $article->creator->id) }}" class="text-primary hover:underline">
                                        {{ $article->creator->name }}
                                        <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                    </a>
                                @else
                                    <span class="text-gray-400 italic">N/A</span>
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.created_at') }}</p>
                            <p class="font-semibold text-gray-800">{{ $article->created_at?->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-2">
                                {{ __('main.status') }}
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold
                                @if ($article->status === 'published') bg-green-100 text-green-800
                                @elseif($article->status === 'draft') bg-yellow-100 text-yellow-800
                                @else bg-red-100 text-red-800 @endif">
                                    @if ($article->status === 'draft')
                                        <i class="fas fa-clock text-yellow-500"></i> {{ __('main.draft') }}
                                    @elseif ($article->status === 'published')
                                        <i class="fas fa-check-circle text-green-600"></i> {{ __('main.published') }}
                                    @elseif ($article->status === 'archived')
                                        <i class="fas fa-times-circle text-red-600"></i> {{ __('main.archived') }}
                                    @endif
                                </span>
                            </p>
                            @include('dashboard.components.article-status-actions', [
                                'record' => $article,
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.active') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $article->id,
                                'field' => 'is_active',
                                'value' => (bool) $article->is_active,
                                'modelClass' => 'article',
                            ])
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.featured') }}</p>
                            @include('dashboard.components.toggle-hold', [
                                'modelId' => $article->id,
                                'field' => 'is_featured',
                                'value' => (bool) $article->is_featured,
                                'modelClass' => 'article',
                            ])
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="kt-card">
                <div class="kt-card-header">
                    <h3 class="kt-card-title">{{ __('main.article_content') }}</h3>
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
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">{{ __('main.content') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $article->translations['en']['content'] ?? '-' !!}</div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $article->translations['en']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <!-- Arabic Content -->
                    <div class="language-content hidden" data-lang="ar">
                        <div class="mb-4">
                            <p class="text-sm text-gray-500">{{ __('main.content') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $article->translations['ar']['content'] ?? '-' !!}</div>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">{{ __('main.description') }}</p>
                            <div class="text-gray-700 leading-relaxed bg-white p-3 rounded border border-gray-200">{!! $article->translations['ar']['description'] ?? '-' !!}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-6">
                        @if ($article->category)
                            <div>
                                <label class="kt-label mb-1">{{ __('main.category') }}</label>
                                <p class="text-sm text-secondary-foreground">
                                    <span class="kt-badge kt-badge-primary">
                                        {{-- {{ __('main.' . $article->category->name) }} --}}
                                        {{ $article->category->name }}
                                    </span>
                                </p>
                            </div>
                        @endif

                        <div>
                            <label class="kt-label mb-1">{{ __('main.statistics') }}</label>
                            <p class="text-sm text-secondary-foreground">
                                <i class="fas fa-eye text-blue-500"></i> {{ $article->view_count ?? 0 }} {{ __('main.views') }}
                            </p>
                        </div>

                        @if ($article->keywords)
                            <div class="col-span-1 sm:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.keywords') }}</label>
                                <div class="flex flex-wrap gap-2">
                                    @foreach (explode(',', $article->keywords) as $keyword)
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 text-xs rounded-full">{{ trim($keyword) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        @if ($article->meta_description)
                            <div class="col-span-1 sm:col-span-2">
                                <label class="kt-label mb-1">{{ __('main.meta_description') }}</label>
                                <p class="text-sm text-secondary-foreground">{{ $article->meta_description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Media Files -->
            @if (!empty($article->image))
                @include('dashboard.components.display-photo', ['record' => $article, 'column' => 'image', 'alt' => $article->title . ' Image'])
            @endif

            @if (!empty($article->thumbnail))
                @include('dashboard.components.display-photo', [
                    'record' => $article,
                    'column' => 'thumbnail',
                    'alt' => $article->title . ' Thumbnail',
                ])
            @endif

            <!-- Metadata Card -->
            @include('dashboard.components.metadata', ['record' => $article])

            <!-- Actions -->
            <div class="flex items-center gap-4">
                @can('update', $article)
                    @include('dashboard.components.edit-button', [
                        'models' => 'dashboard.articles',
                        'id' => $article->id,
                    ])
                @endcan
                @can('delete', $article)
                    @include('dashboard.components.delete-form', [
                        'model' => 'dashboard.articles',
                        'id' => $article->id,
                    ])
                @endcan
                <a href="{{ route('dashboard.articles.index') }}" class="kt-btn kt-btn-outline">
                    {{ __('main.back_to_types', ['types' => __('main.articles')]) }}
                </a>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
