@extends('layouts.backend')
@section('title', 'Add New Table')

@section('content')
<div class="min-h-0">
    <div class="bg-white rounded-xl shadow-md p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Add New Table</h2>
                <p class="text-gray-600">Create a new table with number, status, capacity and optional QR link</p>
            </div>
            <a href="{{ route('table') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
               Back to Tables
            </a>
        </div>

        <form action="{{ route('tables.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Table Number -->
                <div>
                    <label for="number" class="block text-sm font-medium text-gray-700 mb-2">
                        Table Number *
                    </label>
                    <input type="number" id="number" name="number" min="1" value="{{ old('number') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('number') border-red-500 @enderror"
                           placeholder="e.g., 12">
                    @error('number')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                        Status *
                    </label>
                    <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacity -->
                <div>
                    <label for="capacity" class="block text-sm font-medium text-gray-700 mb-2">
                        Capacity *
                    </label>
                    <select id="capacity" name="capacity"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('capacity') border-red-500 @enderror">
                        @php
                            $caps = defined('\App\Models\TableModel::CAPACITIES') ? \App\Models\TableModel::CAPACITIES : [2,3,4,5,6];
                        @endphp
                        @foreach($caps as $cap)
                            <option value="{{ $cap }}" {{ (string)old('capacity', 2) === (string)$cap ? 'selected' : '' }}>
                                {{ $cap }} seats
                            </option>
                        @endforeach
                    </select>
                    @error('capacity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- QR Link -->
                <div>
                    <label for="qr_link" class="block text-sm font-medium text-gray-700 mb-2">
                        QR Link (optional)
                    </label>
                    <input type="url" id="qr_link" name="qr_link" value="{{ old('qr_link') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('qr_link') border-red-500 @enderror"
                           placeholder="https://example.com/qr/table-12">
                    @error('qr_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Notes -->
            <div>
                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Notes (optional)
                </label>
                <input type="text" id="notes" name="notes" value="{{ old('notes') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('notes') border-red-500 @enderror"
                       placeholder="Near window, VIP, etc.">
                @error('notes')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex justify-end gap-3">
                <a href=""
                   class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    Create Table
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
