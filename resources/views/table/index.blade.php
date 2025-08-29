@extends('layouts.backend')
@section('title', 'Table Management')

@section('content')
<div class="min-h-0">
    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded-lg">
            {{ session('error') }}
        </div>
    @endif
    <!-- Header / Actions -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Table Management</h2>
                <p class="text-gray-600">View and manage restaurant tables, status, capacity, and QR links</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('table.create') }}"
                   class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 5v14M5 12h14"/>
                    </svg>
                    Add Table
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
            <div class="p-3 bg-indigo-100 rounded-lg">
                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $total ?? (method_exists($tables,'total') ? $tables->total() : $tables->count()) }}</div>
                <div class="text-sm text-gray-500">Total Tables</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
            <div class="p-3 bg-green-100 rounded-lg">
                <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $active ?? \App\Models\TableModel::where('status','active')->count() }}</div>
                <div class="text-sm text-gray-500">Active</div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-md p-6 flex items-center gap-4">
            <div class="p-3 bg-gray-100 rounded-lg">
                <span class="inline-block w-3 h-3 bg-gray-400 rounded-full"></span>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ $inactive ?? \App\Models\TableModel::where('status','inactive')->count() }}</div>
                <div class="text-sm text-gray-500">Inactive</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-md p-6 mb-6">
        <form method="GET" action="{{ route('table') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Table No.</label>
                <input type="number" name="number" value="{{ request('number') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                       placeholder="e.g., 12" min="1">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All</option>
                    <option value="active" {{ request('status')==='active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status')==='inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                <select name="capacity"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="">All</option>
                    @foreach(\App\Models\TableModel::CAPACITIES as $cap)
                        <option value="{{ $cap }}" {{ (string)request('capacity')===(string)$cap ? 'selected' : '' }}>
                            {{ $cap }} seats
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2 flex items-end gap-2">
                <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">Filter</button>
                <a href="{{ route('table') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">Reset</a>
            </div>
        </form>
    </div>

    <!-- Table List -->
    <div class="bg-white rounded-xl shadow-md p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-left">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Table No.</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Capacity</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">QR Link</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Notes</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Created</th>
                        <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200 text-sm">
                    @php
                        // Blade may need Str facade for limit; ensure alias exists
                    @endphp
                    @forelse($tables as $t)
                    <tr>
                        <td class="px-6 py-4 font-semibold text-gray-900">{{ $t->display_number ?? ('#'.$t->number) }}</td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded-full {{ $t->status_badge_class ?? ($t->status==='active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700') }}">
                                {{ $t->status_display ?? ucfirst($t->status) }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2 py-1 rounded bg-blue-50 text-blue-700">
                                {{ $t->capacity_display ?? ($t->capacity.' seats') }}
                            </span>
                        </td>

                        <td class="px-6 py-4">
                            @if($t->qr_link)
                                <a href="{{ $t->qr_link }}" target="_blank" class="text-indigo-600 hover:text-indigo-800 break-all">
                                    {{ \Illuminate\Support\Str::limit($t->qr_link, 40) }}
                                </a>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>

                        <td class="px-6 py-4 text-gray-700">
                            {{ $t->notes ? \Illuminate\Support\Str::limit($t->notes, 40) : '—' }}
                        </td>

                        <td class="px-6 py-4 text-gray-600">
                            {{ $t->created_at?->format('d M Y') }}
                        </td>

                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if(Route::has('tables.edit'))
                                <a href="" class="text-indigo-600 hover:text-indigo-800">Edit</a>
                                @endif

                                @if(Route::has('tables.qr') && $t->qr_link)
                                <a href="" class="text-emerald-700 hover:text-emerald-900">QR</a>
                                @endif

                                <form method="POST" action="{{ route('tables.destroy', $t->id) }}" class="inline"
                                    onsubmit="return confirm('Delete this table? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">Delete</button>
                                </form>

                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-6 text-center text-gray-500">No tables found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if(method_exists($tables, 'links'))
        <div class="mt-6">
            {{ $tables->withQueryString()->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
