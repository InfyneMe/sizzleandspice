@extends('layouts.backend')
@section('title', 'Order Management')
@section('content')
<div class="container mx-auto py-10">
    <!-- Title & Description -->
    <div class="mb-7">
        <h1 class="text-2xl font-extrabold text-gray-900">Order Management</h1>
        <p class="text-lg text-gray-500 mt-1">View and manage orders, status, payments, and more</p>
    </div>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white border border-gray-100 shadow rounded-2xl flex items-center px-6 py-4">
            <div class="flex items-center justify-center w-10 h-10 bg-blue-50 rounded-full mr-4">
                <span class="text-blue-500 text-lg font-bold">📦</span>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-900">{{ $orders->count() }}</p>
                <p class="text-sm text-gray-400">Total Orders</p>
            </div>
        </div>
        <div class="bg-white border border-gray-100 shadow rounded-2xl flex items-center px-6 py-4">
            <div class="flex items-center justify-center w-10 h-10 bg-green-50 rounded-full mr-4">
                <span class="text-green-500 text-lg font-bold">✔️</span>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-900">{{ $orders->where('status','completed')->count() }}</p>
                <p class="text-sm text-gray-400">Completed</p>
            </div>
        </div>
        <div class="bg-white border border-gray-100 shadow rounded-2xl flex items-center px-6 py-4">
            <div class="flex items-center justify-center w-10 h-10 bg-red-50 rounded-full mr-4">
                <span class="text-red-500 text-lg font-bold">❌</span>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-gray-900">{{ $orders->where('status','cancelled')->count() }}</p>
                <p class="text-sm text-gray-400">Cancelled</p>
            </div>
        </div>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('order.history') }}"
        class="flex flex-col sm:flex-row items-stretch gap-4 bg-white border border-gray-100 shadow rounded-2xl px-6 py-4 mb-6">
        <input type="text" name="search"
            class="w-full sm:w-64 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 px-4 py-2 text-gray-700 placeholder-gray-400 transition"
            placeholder="Search by phone, order id, or notes..."
            value="{{ request('search') }}">
        <input type="text" id="dateRange" name="date_range"
            class="w-full sm:w-40 rounded-lg border border-gray-200 focus:ring-2 focus:ring-blue-600 focus:border-blue-600 px-4 py-2 text-gray-700 placeholder-gray-400 transition"
            placeholder="Select date range"
            value="{{ request('date_range') }}">
        <button type="submit"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow flex items-center font-semibold transition">
            Filter
        </button>
        <a href="{{ route('order.history') }}"
            class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-xl shadow flex items-center font-semibold transition text-center">
            Reset
        </a>
    </form>

    <!-- Data Table -->
    <div class="bg-white border border-gray-100 shadow rounded-2xl overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500">ORDER ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500">STATUS</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500">PHONE</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500">AMOUNT</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500">ORDER DATE</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold tracking-wide text-gray-500">ACTIONS</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-100">
                @forelse($orders as $order)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-mono text-gray-900 font-bold">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                    <td class="px-4 py-3">
                        <span class="inline-block px-2 py-1 rounded-full text-xs font-medium
                            {{ $order->status === 'completed' ? 'bg-green-100 text-green-700' :
                               ($order->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-gray-700">{{ $order->customer_phone ?? '-' }}</td>
                    <td class="px-4 py-3 text-blue-700 font-semibold">₹{{ number_format($order->subtotal + $order->gst, 2) }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <a href=""
                           class="inline-block bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-md px-3 py-1 text-xs font-semibold transition">
                           Details
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-10 text-gray-400 font-medium">
                        No orders found for the selected filters.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-6 py-4">
            {{ $orders->withQueryString()->links() }}
        </div>
    </div>
</div>
<script>
    flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "Y-m-d",
        defaultDate: @json(request('date_range') ? explode(' to ', request('date_range')) : []),
    });
</script>
@endsection
