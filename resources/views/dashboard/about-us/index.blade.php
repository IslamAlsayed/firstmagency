@extends('dashboard.layout.master')

@section('content')
    <div class="container">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            <h1 class="text-3xl font-bold">
                <i class="fas fa-building main-icon"></i>
                {{ __('main.about_us') }}
            </h1>
            @can('create', App\Models\AboutUs::class)
                <a href="{{ route('dashboard.about-us.create') }}" class="kt-btn kt-btn-primary">
                    <i class="fas fa-plus"></i>
                    {{ __('main.create_about_us') }}
                </a>
            @endcan
        </div>

        <!-- Statistics -->
        <div class="grid grid-cols-3 gap-4 mb-6">
            <div class="kt-card">
                <div class="kt-card-body">
                    <div class="text-gray-600 text-sm">{{ __('main.total') }}</div>
                    <div class="text-2xl font-bold">{{ $aboutUs->total() }}</div>
                </div>
            </div>
            <div class="kt-card">
                <div class="kt-card-body">
                    <div class="text-gray-600 text-sm">{{ __('main.active') }}</div>
                    <div class="text-2xl font-bold text-green-600">{{ $aboutUs->where('is_active', true)->count() }}</div>
                </div>
            </div>
            <div class="kt-card">
                <div class="kt-card-body">
                    <div class="text-gray-600 text-sm">{{ __('main.inactive') }}</div>
                    <div class="text-2xl font-bold text-red-600">{{ $aboutUs->where('is_active', false)->count() }}</div>
                </div>
            </div>
        </div>

        <!-- Search -->
        <div class="mb-6">
            <input type="text" placeholder="{{ __('main.search') }}" class="kt-input w-full" id="search">
        </div>

        <!-- Table -->
        <div class="kt-card">
            <div class="kt-card-body overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-4 py-3 text-left">#</th>
                            <th class="px-4 py-3 text-left">{{ __('main.title') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('main.image') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('main.status') }}</th>
                            <th class="px-4 py-3 text-left">{{ __('main.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($aboutUs as $item)
                            <tr id="row-{{ $item->id }}" class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3">{{ $item->id }}</td>
                                <td class="px-4 py-3 font-medium">{{ $item->title }}</td>
                                <td class="px-4 py-3">
                                    @if ($item->image && checkExistFile($item->image))
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->alt_text }}" class="w-12 h-12 object-cover rounded">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    <span
                                        class="px-3 py-1 rounded-full text-xs font-semibold {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $item->is_active ? __('main.active') : __('main.inactive') }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">
                                    @include('dashboard.components.permissions-actions', [
                                        'models' => 'dashboard.about-us',
                                        'id' => $item->id,
                                        'editRoute' => route('dashboard.about-us.edit', $item->id),
                                        'showRoute' => route('dashboard.about-us.show', $item->id),
                                    ])
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-6 text-center text-gray-500">
                                    {{ __('main.no_data') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6">
            {{ $aboutUs->links() }}
        </div>
    </div>

    @include('dashboard.components.delete-ajax-script')
@endsection
