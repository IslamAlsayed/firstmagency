@extends('dashboard.layout.master')

@section('title', __('main.articles'))
@section('page-title', '📝 ' . __('main.articles'))

@section('content')
    <div class="w-full">
        <!-- {{ __('main.statistics') }} -->
        <div class="flex flex-wrap gap-4 mb-6">
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-gray-800" id="stat-total">{{ $allItems }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.total_types', ['types' => __('main.articles')]) }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-green-600" id="stat-published">{{ $published }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.published') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-yellow-600" id="stat-draft">{{ $draft }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.draft') }}</small>
            </div>
            <div class="flex-1 text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                <div class="text-2xl font-bold text-red-600" id="stat-archived">{{ $archived }}</div>
                <small class="text-primary font-semibold text-nowrap">{{ __('main.archived') }}</small>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow">
            <div class="flex justify-between items-center p-4 border-gray-200">
                <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-newspaper mr-2"></i> {{ __('main.articles') }}</h5>

                <div class="flex justify-between items-center gap-4">
                    <input type="text" id="searchBox"
                        class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                        placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.articles')]) }}">
                    <a href="{{ route('dashboard.articles.create') }}" class="kt-btn kt-btn-outline-primary">
                        {{ __('main.create_article') }}
                    </a>
                </div>
            </div>
            <div class="scroll-container">
                <div class="p-4">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-300">
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.title') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.featured') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.views') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.status') }}</th>
                                <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                                <tr id="row-{{ $article->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition" data-status="{{ $article->status }}"
                                    data-active="{{ (int) $article->is_active }}">
                                    <td title="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}" class="p-4">
                                        <div class="relative w-fit">
                                            @if ($article->image && checkExistFile($article->image))
                                                <img src="{{ asset('storage/' . $article->image) }}"
                                                    alt="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}" class="rounded-full size-9 shrink-0">
                                            @else
                                                <i class="fas fa-pencil" title="{{ $article->translations[app()->getLocale()]['title'] ?? '' }}"></i>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="p-4">
                                        <strong class="text-sm text-gray-800 block">
                                            {{ limitedText($article->translations[app()->getLocale()]['title'] ?? '', 50) }}
                                        </strong>
                                    </td>
                                    <td>
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $article->id,
                                            'field' => 'is_active',
                                            'value' => (bool) $article->is_active,
                                            'modelClass' => 'article',
                                        ])
                                    </td>
                                    <td>
                                        @include('dashboard.components.toggle-hold', [
                                            'modelId' => $article->id,
                                            'field' => 'is_featured',
                                            'value' => (bool) $article->is_featured,
                                            'modelClass' => 'article',
                                        ])
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">
                                        @if ($article->creator)
                                            <a href="{{ route('dashboard.users.show', $article->creator->id) }}" class="text-primary hover:underline">
                                                {{ $article->creator->name }}
                                                <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                            </a>
                                        @else
                                            <span class="text-gray-400 italic">N/A</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-sm text-gray-600">{{ $article->created_at?->format('d/m/Y') }}</td>
                                    <td class="p-4 text-sm text-gray-600">
                                        <i class="fas fa-eye text-blue-500"></i> {{ $article->view_count ?? 0 }}
                                    </td>
                                    <td class="p-4 text-sm">
                                        <span
                                            class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if ($article->status === 'published') bg-green-100 text-green-800
                                                @elseif($article->status === 'draft') bg-yellow-100 text-yellow-800
                                                @else bg-red-100 text-red-800 @endif">
                                            {{ __('main.' . $article->status) }}
                                        </span>
                                    </td>
                                    <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                        @include('dashboard.components.status-actions', [
                                            'record' => $article,
                                            'models' => 'articles',
                                            'modelClass' => 'article',
                                            'availableOptions' => array_column(\App\Enum\ArticleEnums::cases(), 'value'),
                                        ])
                                        @include('dashboard.components.permissions-actions', [
                                            'record' => $article,
                                            'models' => 'articles',
                                        ])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-gray-400">
                                        {{ __('messages.no_records_found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($articles->hasPages())
                    <div class="mt-6 border-t pt-4">
                        {{ $articles->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
