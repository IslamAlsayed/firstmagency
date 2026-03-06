@extends('dashboard.layout.master')

@section('title', __('main.clients'))
@section('page-title', '👥 ' . __('main.clients'))

@section('content')
    <div class="w-full">
        <div class="w-full">
            <!-- Statistics -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                    <div class="text-2xl font-bold text-gray-800">{{ count($clients) }}</div>
                    <small class="text-primary font-semibold">{{ __('main.total_clients') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                    <div class="text-2xl font-bold text-green-600">{{ $clients->where('is_active', true)->count() }}</div>
                    <small class="text-primary font-semibold">{{ __('main.active') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                    <div class="text-2xl font-bold text-red-600">{{ $clients->where('is_active', false)->count() }}</div>
                    <small class="text-primary font-semibold">{{ __('main.inactive') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200 z--1">
                    <div class="text-2xl font-bold text-blue-600">{{ $clients->where('is_featured', true)->count() }}</div>
                    <small class="text-primary font-semibold">{{ __('main.featured') }}</small>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow">
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-users mr-2"></i> {{ __('main.clients') }}</h5>

                    <div class="flex justify-between items-center gap-4">
                        <input type="text" id="searchBox"
                            class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.clients')]) }}">
                        <a href="{{ route('dashboard.clients.create') }}" class="kt-btn kt-btn-outline-primary">
                            {{ __('main.create_client') }}
                        </a>
                    </div>
                </div>
                <div class="scroll-container">
                    <div class="p-4">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b-2 border-gray-300">
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.image') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.alt_text') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.website') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.active') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.featured') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_by') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.created_at') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.order') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($clients as $client)
                                    <tr id="row-{{ $client->id }}" class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td title="{{ $client->alt_text ?? ($client->translations[app()->getLocale()]['name'] ?? '') }}" class="p-4">
                                            <div class="relative w-fit">
                                                @if ($client->image && checkExistFile($client->image))
                                                    <img src="{{ asset('storage/' . $client->image) }}"
                                                        alt="{{ $client->alt_text ?? ($client->translations[app()->getLocale()]['name'] ?? '') }}"
                                                        class="w-[90px] h-[35px] rounded-[9px] shrink-0">
                                                @else
                                                    <i class="fas fa-users text-2xl text-gray-400"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td title="{{ $client->alt_text ?? '--' }}">
                                            <span class="inline-block bg-blue-50 text-blue-700 text-xs font-medium px-2 py-0.5 rounded-[7px]">
                                                {{ limitedText($client->alt_text ?? '--', 25) }}
                                            </span>
                                        </td>
                                        <td title="{{ $client->website ?? '--' }}">
                                            @if ($client->website)
                                                <a href="{{ $client->website }}" target="_blank"
                                                    class="inline-block bg-primary/10 text-primary hover:underline text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                                                    {!! limitedText($client->website ?? '--', 30) !!}
                                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                                </a>
                                            @else
                                                <div
                                                    class="inline-block bg-primary/10 text-primary text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2 user-select-none">
                                                    <i class="opacity-25">{{ __('main.null') }}</i>
                                                </div>
                                            @endif
                                        </td>
                                        <td class="p-4 text-sm">
                                            @include('dashboard.components.toggle-hold', [
                                                'modelId' => $client->id,
                                                'field' => 'is_active',
                                                'value' => (bool) $client->is_active,
                                                'modelClass' => 'client',
                                            ])
                                        </td>
                                        <td class="p-4 text-sm">
                                            @include('dashboard.components.toggle-hold', [
                                                'modelId' => $client->id,
                                                'field' => 'is_featured',
                                                'value' => (bool) $client->is_featured,
                                                'modelClass' => 'client',
                                            ])
                                        </td>
                                        <td class="p-4 text-sm text-gray-600">
                                            @if ($client->creator)
                                                <a href="{{ route('dashboard.users.show', $client->creator->id) }}" class="text-primary hover:underline">
                                                    {{ $client->creator->name }}
                                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic">N/A</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-sm text-gray-600">{{ $client->created_at?->format('d/m/Y') }}</td>
                                        <td class="p-4 text-sm text-gray-600">{{ $client->order ?? 0 }}</td>
                                        <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $client,
                                                'models' => 'clients',
                                            ])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="px-6 py-8 text-center text-gray-400">
                                            {{ __('main.no_clients_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($clients->hasPages())
                        <div class="mt-6 border-t pt-4">
                            {{ $clients->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    @include('dashboard.components.toggle-hold-script')
@endpush
