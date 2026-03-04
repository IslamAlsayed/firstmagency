@extends('dashboard.layout.master')

@section('title', __('main.companies'))
@section('page-title', '🏢 ' . __('main.companies'))

@section('content')
    <div class="w-full">
        <div class="w-full">
            <!-- Statistics -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-gray-800">{{ count($companies) }}</div>
                    <small class="text-primary font-semibold">{{ __('main.total_companies') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-green-600">{{ $companies->where('is_active', true)->count() }}</div>
                    <small class="text-primary font-semibold">{{ __('main.active') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-red-600">{{ $companies->where('is_active', false)->count() }}</div>
                    <small class="text-primary font-semibold">{{ __('main.inactive') }}</small>
                </div>
                <div class="text-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <div class="text-2xl font-bold text-blue-600">{{ $companies->where('is_featured', true)->count() }}</div>
                    <small class="text-primary font-semibold">{{ __('main.featured') }}</small>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow">
                <div class="flex justify-between items-center p-4 border-b border-gray-200">
                    <h5 class="text-lg font-semibold text-gray-800"><i class="fas fa-building mr-2"></i> {{ __('main.companies') }}</h5>

                    <div class="flex justify-between items-center gap-4">
                        <input type="text" id="searchBox"
                            class="w-[250px] px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-indigo-500"
                            placeholder="{{ __('main.search_types_placeholder', ['types' => __('main.companies')]) }}">
                        <a href="{{ route('dashboard.companies.create') }}" class="kt-btn kt-btn-outline-primary">
                            {{ __('main.create_company') }}
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <div class="">
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-100 border-b-2 border-gray-300">
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.logo') }}</th>
                                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">{{ __('main.name') }}</th>
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
                                @forelse($companies as $company)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                        <td title="{{ $company->translations[app()->getLocale()]['name'] ?? '' }}" class="p-4">
                                            <div class="relative w-fit">
                                                @if ($company->image && checkExistFile($company->image))
                                                    <img src="{{ asset('storage/' . $company->image) }}"
                                                        alt="{{ $company->translations[app()->getLocale()]['name'] ?? '' }}" class="rounded-full size-9 shrink-0">
                                                @else
                                                    <i class="fas fa-building text-2xl text-gray-400"></i>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="p-4">
                                            <strong class="text-sm text-gray-800 block">
                                                {{ limitedText($company->translations[app()->getLocale()]['name'] ?? '', 50) }}
                                            </strong>
                                        </td>
                                        <td title="{{ $company->website ?? '--' }}">
                                            @if ($company->website)
                                                <a href="{{ $company->website }}" target="_blank"
                                                    class="inline-block bg-primary/10 text-primary hover:underline text-xs font-medium px-2 py-0.5 rounded-[7px] ms-2">
                                                    {!! limitedText($company->website ?? '--', 30) !!}
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
                                                'modelId' => $company->id,
                                                'field' => 'is_active',
                                                'value' => (bool) $company->is_active,
                                                'modelClass' => 'company',
                                            ])
                                        </td>
                                        <td class="p-4 text-sm">
                                            @include('dashboard.components.toggle-hold', [
                                                'modelId' => $company->id,
                                                'field' => 'is_featured',
                                                'value' => (bool) $company->is_featured,
                                                'modelClass' => 'company',
                                            ])
                                        </td>
                                        <td class="p-4 text-sm text-gray-600">
                                            @if ($company->creator)
                                                <a href="{{ route('dashboard.users.show', $company->creator->id) }}" class="text-primary hover:underline">
                                                    {{ $company->creator->name }}
                                                    <i class="fa-duotone fa-solid fa-arrow-up-right-from-square text-primary"></i>
                                                </a>
                                            @else
                                                <span class="text-gray-400 italic">N/A</span>
                                            @endif
                                        </td>
                                        <td class="p-4 text-sm text-gray-600">{{ $company->created_at?->format('d/m/Y') }}</td>
                                        <td class="p-4 text-sm text-gray-600">{{ $company->order ?? 0 }}</td>
                                        <td class="p-4 text-sm space-x-2 flex items-center gap-2">
                                            @include('dashboard.components.permissions-actions', [
                                                'record' => $company,
                                                'models' => 'companies',
                                            ])
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-8 text-center text-gray-400">
                                            {{ __('main.no_companies_found') }}
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($companies->hasPages())
                        <div class="mt-6 border-t pt-4">
                            {{ $companies->links() }}
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
