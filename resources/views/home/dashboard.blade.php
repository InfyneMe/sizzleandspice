@extends('layouts.backend')
@section('title', 'Dashboard')

@section('content')
<div class="container mx-auto py-10 space-y-8">

    <!-- Summary Cards: Orders & Status -->
    <div class="grid grid-cols-1 sm:grid-cols-4 gap-6">
        <x-card color="indigo" icon="📦" title="Total Orders" :value="$totalOrders" />
        <x-card color="blue" icon="🥡" title="Total Takeaway" :value="$totalTakeaway" />
        <x-card color="red" icon="❌" title="Total Cancelled" :value="$totalCancelled" />
        <x-card color="yellow" icon="⏳" title="Pending Orders" :value="$totalPending" />
    </div>

    <!-- Growth Metrics -->
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
        <x-growth title="Monthly Growth" :percentage="$monthlyGrowth" />
        <x-growth title="Daily Growth" :percentage="$dailyGrowth" />
    </div>

    <!-- Most Ordered Items & Categories -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Most Ordered Item</h2>
            <p class="text-3xl font-bold">{{ $mostOrderedItem->name ?? 'N/A' }}</p>
            <p class="text-gray-600">{{ $mostOrderedItem->quantity ?? 0 }} orders</p>
        </div>
        <div class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-lg font-semibold mb-4">Category Totals</h2>
            <ul>
                @foreach(['starter', 'main_course', 'drinks', 'dessert'] as $cat)
                <li class="flex justify-between border-b py-2 last:border-none text-sm text-gray-700">
                    <span class="capitalize">{{ str_replace('_', ' ', $cat) }}</span>
                    <span>{{ $categoryTotals[$cat] ?? 0 }}</span>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Recent 5 Orders -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-lg font-semibold mb-6">Recent 5 Orders</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600 uppercase">Order ID</th>
                        <th class="px-4 py-2 text-left text-gray-600 uppercase">Type</th>
                        <th class="px-4 py-2 text-left text-gray-600 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-gray-600 uppercase">Amount</th>
                        <th class="px-4 py-2 text-left text-gray-600 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach ($recentOrders as $order)
                    <tr>
                        <td class="px-4 py-2 font-mono font-semibold text-gray-900">#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-2 capitalize">{{ $order->order_type }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold
                            {{ $order->status == 'completed' ? 'bg-green-100 text-green-800' : ($order->status == 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2 font-semibold text-blue-700">₹{{ number_format($order->subtotal + $order->gst, 2) }}</td>
                        <td class="px-4 py-2 text-gray-600">{{ \Carbon\Carbon::parse($order->order_date)->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Hardcoded Most Visited Customers -->
    <div class="bg-white rounded-2xl shadow p-6">
        <h2 class="text-lg font-semibold mb-6">Most Visited Customers</h2>
        <ul class="divide-y divide-gray-100">
            @foreach ([
                ['name' => 'Akash Kumar', 'visits' => 18],
                ['name' => 'Neha Singh', 'visits' => 15],
                ['name' => 'Vivek Rao', 'visits' => 12],
                ['name' => 'Priya Patel', 'visits' => 11],
                ['name' => 'Suman Jain', 'visits' => 9],
            ] as $customer)
            <li class="py-3 flex justify-between text-gray-700">
                <span>{{ $customer['name'] }}</span>
                <span class="font-semibold">{{ $customer['visits'] }} visits</span>
            </li>
            @endforeach
        </ul>
    </div>

</div>
@endsection
