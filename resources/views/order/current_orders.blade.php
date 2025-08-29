@extends('layouts.backend')
@section('title', 'Current Orders')

@section('content')
<div class="container mx-auto p-6">
    <!-- Header + Search -->
    <div class="flex flex-wrap items-center gap-3 mb-5">
        <h1 class="text-2xl font-bold text-gray-800">Current Orders</h1>
        <span class="text-sm text-gray-500">Pending · Preparing · Served</span>

        <div class="ml-auto flex items-center gap-2">
            <!-- Search by table no or order id -->
            <div class="relative">
                <input
                    id="orderSearch"
                    type="text"
                    placeholder="Search: table no or order #"
                    class="w-72 rounded-full border border-gray-300 bg-white py-2 pl-10 pr-3 text-sm text-gray-700 shadow-sm focus:border-blue-500 focus:ring-2 focus:ring-blue-400 outline-none"
                />
                <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                    </svg>
                </span>
            </div>

            <a href="" class="text-sm text-blue-600 hover:underline">All Orders</a>
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white border rounded-lg p-6 text-center text-gray-500">
            No active orders right now.
        </div>
    @else
        <div id="ordersGrid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-4 gap-4">
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'preparing' => 'bg-blue-100 text-blue-800',
                    'ready' => 'bg-green-100 text-green-800',
                    'served' => 'bg-gray-100 text-gray-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                ];
                $paymentColors = [
                    'pending' => 'bg-orange-100 text-orange-800',
                    'paid' => 'bg-green-100 text-green-800',
                    'failed' => 'bg-red-100 text-red-800',
                    'refunded' => 'bg-gray-100 text-gray-800',
                ];
            @endphp

            @foreach($orders as $order)
            @php
                $items = $orderedItems->get($order->id) ?? collect();
                $tableNumber = $order->order_type === 'dine-in' ? (optional($order->table)->number ?? '') : 'TAKEAWAY';
                // Define action visibility
                $canPrepare = $order->status === 'pending';
                $canReady   = in_array($order->status, ['pending','preparing']);
                $canDone    = in_array($order->status, ['pending','preparing','ready']);
            @endphp

            <div
                class="order-card bg-white border rounded-xl shadow-sm hover:shadow transition"
                data-order-id="{{ $order->id }}"
                data-table-number="{{ strtoupper((string)$tableNumber) }}"
            >
                <!-- Card header -->
                <div class="p-4 border-b">
                    <div class="flex items-start justify-between">
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="text-base font-semibold text-gray-800">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</h3>
                                <span class="text-[11px] px-2 py-0.5 rounded-full {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                            <div class="mt-1 text-xs text-gray-500">
                                {{ $order->order_date ? $order->order_date->format('d M Y, h:i A') : '' }}
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500">{{ strtoupper($order->order_type) }}</div>
                            @if($order->order_type === 'dine-in')
                                <div class="text-sm font-medium text-gray-800">
                                    Table {{ optional($order->table)->number ?? '-' }}
                                </div>
                            @else
                                <div class="text-sm font-medium text-gray-800">Takeaway</div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card body -->
                <div class="p-4 space-y-3">
                    <!-- Totals + payment -->
                    <div class="flex items-center justify-between">
                        <div class="text-sm text-gray-600">
                            Subtotal: <span class="font-medium">₹{{ number_format($order->subtotal, 2) }}</span>
                            <span class="mx-1">•</span>
                            GST: <span class="font-medium">₹{{ number_format($order->gst, 2) }}</span>
                        </div>
                        <div class="text-right">
                            <div class="text-base font-bold text-gray-900">
                                ₹{{ number_format(($order->subtotal + $order->gst), 2) }}
                            </div>
                            <div class="mt-1 flex items-center gap-2 justify-end">
                                <span class="text-[11px] px-2 py-0.5 rounded-full {{ $paymentColors[$order->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                                <span class="text-[11px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-800">
                                    {{ strtoupper($order->payment_mode) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    @if($order->customer_phone)
                    <div class="text-xs text-gray-500">
                        Phone: <span class="font-medium text-gray-700">{{ $order->customer_phone }}</span>
                    </div>
                    @endif

                    <!-- Items -->
                    @php $hasItems = $items->isNotEmpty(); @endphp
                    <details class="group" {{ $hasItems ? '' : 'open' }}>
                        <summary class="text-sm font-medium text-blue-600 cursor-pointer select-none">
                            {{ $hasItems ? 'View Items' : 'No items added' }}
                        </summary>

                        @if($hasItems)
                        <div class="mt-2 rounded-lg border bg-gray-50">
                            <div class="divide-y">
                                @foreach($items as $oi)
                                    <div class="flex items-center justify-between p-2 text-sm">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-6 h-6 rounded bg-white border text-xs font-semibold">
                                                x{{ $oi->quantity ?? 1 }}
                                            </span>
                                            <div class="text-gray-800">
                                                {{ optional($oi->menuItem)->name ?? ('Item #' . $oi->item_id) }}
                                            </div>
                                        </div>
                                        <div class="text-gray-600 text-xs">
                                            ID: {{ $oi->item_id }}
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </details>
                </div>

                <!-- Card footer: simplified action row -->
                <div class="p-3 border-t flex items-center justify-between">
                    <div class="text-xs text-gray-500">
                        Updated {{ $order->updated_at?->diffForHumans() }}
                    </div>

                    <div class="flex items-center gap-2">
                        <!-- Primary utility: Print (neutral) -->
                        <a
                            href="{{ route('order.details', $order->id) }}"
                            class="px-3 py-1.5 text-xs rounded border border-gray-300 text-gray-700 hover:bg-gray-50"
                            title="Print Bill"
                        >
                            View
                        </a>

                        @if($canDone)
                            <form action="" method="POST">
                                @csrf @method('PATCH')
                                <button class="px-3 py-1.5 text-xs rounded bg-gray-800 text-white hover:bg-gray-900">
                                    Completed
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

<script>
    // Client-side filter by Order # or Table number
    const searchInput = document.getElementById('orderSearch');
    const cards = document.querySelectorAll('.order-card');

    function normalize(value) {
        return (value || '').toString().trim().toUpperCase();
    }

    function filterOrders() {
        const q = normalize(searchInput.value);

        cards.forEach(card => {
            const orderId = normalize(card.getAttribute('data-order-id'));
            const tableNo = normalize(card.getAttribute('data-table-number'));
            // Matches: order id includes query OR table number includes query
            const match =
                orderId.includes(q) ||
                tableNo.includes(q) ||
                ('TABLE ' + tableNo).includes(q) || // allow typing “Table 5”
                (q === 'TAKEAWAY' && tableNo === 'TAKEAWAY');

            card.style.display = match ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterOrders);
</script>
@endsection
