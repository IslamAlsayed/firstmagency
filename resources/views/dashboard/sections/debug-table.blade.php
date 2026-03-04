<!-- Sections & Flags Table -->
<div class="bg-gray-50 rounded-lg p-4">
    <h6 class="text-xl font-semibold text-gray-600 mb-6 pb-3 border-b-2 border-purple-300">
        <i class="fas fa-table text-blue-500"></i>
        Sections & Debug Flags
    </h6>
    <div class="overflow-x-auto">
        <table class="min-w-full border-collapse border border-gray-300">
            <thead class="bg-purple-600 text-white">
                <tr>
                    <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">#</th>
                    <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Section Name</th>
                    <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Debug Flag</th>
                    <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Padding Setting</th>
                    <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold">Status</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $sections = \App\Models\Section::all();
                    $counter = 1;
                @endphp
                @foreach ($sections as $section)
                    <tr class="hover:bg-gray-100 transition">
                        <td class="border border-gray-300 px-4 py-3 text-sm text-gray-700 font-medium">{{ $counter++ }}</td>
                        <td class="border border-gray-300 px-4 py-3 text-sm text-gray-700">{{ $section->name }}</td>
                        <td class="border border-gray-300 px-4 py-3 text-sm">
                            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-bold">
                                {{ $section->flag }}
                            </span>
                        </td>
                        <td class="border border-gray-300 px-4 py-3 text-sm text-gray-700">
                            `{{ $section->padding_setting_key }}`
                        </td>
                        <td class="border border-gray-300 px-4 py-3 text-sm text-center">
                            @if ($section->is_active)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Active</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">Inactive</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
