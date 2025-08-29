@extends('layouts.backend')
@section('title', 'Order #'.str_pad($order->id, 6, '0', STR_PAD_LEFT))

@section('content')
<div class="container mx-auto p-6 space-y-6">
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
    <!-- Header -->
    <div class="flex flex-wrap items-center gap-3">
        <a href="{{ url()->previous() }}" class="text-sm text-blue-600 hover:underline">← Back</a>
        <h1 class="text-2xl font-bold text-gray-800">Order #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }} -> Table No : {{ $order->table_id ?? 'Take Away' }}</h1>
        <div class="ml-auto flex items-center gap-2">
            <button type="button"
               class="px-3 py-1.5 text-xs rounded border border-gray-300 text-gray-700 hover:bg-gray-50"
               onclick="window.print()">
               Print
            </button>
        </div>
    </div>

    <!-- Payment & Status (UI only for now) -->
    <div class="bg-white border rounded-lg overflow-hidden">
        <div class="p-4 border-b">
            <h2 class="text-sm font-semibold text-gray-700">Update Payment & Status</h2>
        </div>
        <form action="{{ route('order.payment.edit', $order->id) }}" method="POST" class="p-4 grid grid-cols-1 md:grid-cols-4 gap-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Payment Mode</label>
                <select id="ui_payment_mode"
                        name="payment_mode"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 outline-none">
                    @php $modes = ['cash'=>'Cash','upi'=>'UPI','card'=>'Card','online'=>'Online']; @endphp
                    @foreach($modes as $val=>$label)
                        <option value="{{ $val }}" {{ ($order->payment_mode ?? 'cash')===$val?'selected':'' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Order Status</label>
                <select id="ui_status"
                        name="status"
                        class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 outline-none">
                    @php $statuses=['pending'=>'Pending','preparing'=>'Preparing','ready'=>'Ready','served'=>'Served','completed'=>'Completed','cancelled'=>'Cancelled']; @endphp
                    @foreach($statuses as $val=>$label)
                        <option value="{{ $val }}" {{ ($order->status ?? 'pending')===$val?'selected':'' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Transaction ID <span class="text-gray-400 text-xs">(optional)</span>
                </label>
                <input type="text" name="utr_id" id="transaction_id" value="{{ $order->transaction_id }}"
                       placeholder="e.g. UPI/PG reference"
                       class="w-full rounded-lg border border-gray-300 bg-white py-2 px-3 text-sm text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 outline-none" />
                <p class="text-[11px] text-gray-500 mt-1">For UPI/Card/Online, add the payment reference.</p>
            </div>
            <div class="md:col-span-4 flex items-center justify-end">
                <button type="submit"
                        class="px-4 py-2 rounded-lg bg-gray-900 text-white text-sm font-medium hover:bg-gray-800"
                        onclick="toast('Saved locally. Wire to backend when routes are ready.')">
                    Update
                </button>
            </div>
        </form>
    </div>

    <!-- Two-column: Menu + Order Items -->
    <div class="grid grid-cols-12 gap-4" id="orderUI">
        <!-- Menu panel -->
        <div class="col-span-12 lg:col-span-5">
            <div class="bg-white border rounded-lg overflow-hidden">
                <div class="p-4 border-b">
                    <div class="relative">
                        <input type="text" id="menuSearch" placeholder="Search menu by name..."
                               class="w-full rounded-full border border-gray-300 bg-white py-2 pl-10 pr-3 text-sm text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-400 outline-none" />
                        <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                            </svg>
                        </span>
                    </div>
                </div>
                <div id="menuList" class="max-h-[520px] overflow-y-auto p-3 grid grid-cols-1 sm:grid-cols-2 gap-3">
                    @foreach($menu as $m)
                    <div class="menu-card border rounded-lg p-3 hover:shadow cursor-pointer"
                         data-id="{{ $m->id }}"
                         data-name="{{ strtolower($m->name) }}"
                         data-price="{{ $m->price }}">
                        <div class="flex items-start justify-between">
                            <div class="text-sm font-semibold text-gray-800">{{ $m->name }}</div>
                            <div class="text-sm font-bold text-blue-600">₹{{ number_format($m->price, 2) }}</div>
                        </div>
                        @if($m->description)
                        <div class="text-xs text-gray-500 mt-1 line-clamp-2">{{ $m->description }}</div>
                        @endif
                        <div class="mt-2">
                            <button class="w-full text-xs py-1.5 rounded bg-blue-600 text-white hover:bg-blue-700"
                                    onclick="addFromMenuCard(event)">
                                Add
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order items panel -->
        <div class="col-span-12 lg:col-span-7">
            <div class="bg-white border rounded-lg overflow-hidden">
                <div class="p-4 border-b flex items-center justify-between">
                    <h2 class="text-sm font-semibold text-gray-700">Order Items</h2>
                    <div class="text-xs text-gray-500">Items: <span id="itemsCount">0</span></div>
                </div>

                <div id="itemsList" class="divide-y">
                    <!-- JS will render rows -->
                </div>
                <div class="p-4 border-t flex items-center justify-end gap-6 text-sm" id="totalsRow">
                    <button type="button"
                        class="px-3 py-2 rounded-lg bg-blue-600 text-white text-sm font-medium hover:bg-blue-700"
                        onclick="submitOrderUpdate()">
                        Update Order
                    </button>
                    <div><small class="text-gray-500">Subtotal</small> <small class="ml-2 font-medium" id="subtotal">₹0.00</small></div>
                    <div><span class="text-gray-500">GST (5%)</span> <span class="ml-2 font-medium" id="gst">₹0.00</span></div>
                    <div class="text-base"><span class="font-semibold">Total</span> <span class="ml-2 font-bold text-gray-900" id="total">₹0.00</span></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toast -->
<div id="toast" class="fixed bottom-4 right-4 hidden px-3 py-2 rounded bg-gray-900 text-white text-sm shadow"></div>

<script>
    const GST_RATE = 0.05;

    // Seed menu map for quick lookups
    const menuMap = new Map();
    document.querySelectorAll('.menu-card').forEach(card => {
        menuMap.set(Number(card.dataset.id), {
            id: Number(card.dataset.id),
            name: card.querySelector('.text-gray-800').textContent.trim(),
            price: Number(card.dataset.price)
        });
    });

    // Seed items from server-provided orderedItems
    const state = {
        items: [
            @foreach($orderedItems as $oi)
            {
                id: {{ $oi->id }},                 // local row id stand-in
                menu_item_id: {{ $oi->item_id }},
                name: {!! json_encode(optional($oi->menuItem)->name ?? ('Item #'.$oi->item_id)) !!},
                unit_price: Number({{ optional($oi->menuItem)->price ?? 0 }}),
                quantity: {{ $oi->quantity ?? 1 }}
            },
            @endforeach
        ],
        subtotal: Number({{ $order->subtotal ?? 0 }}),
        gst: Number({{ $order->gst ?? 0 }}),
        total: Number({{ ($order->subtotal + $order->gst) ?? 0 }})
    };

    // Normalize existing prices from menu if missing
    state.items = state.items.map(it => {
        if (!it.unit_price || isNaN(it.unit_price)) {
            const m = menuMap.get(it.menu_item_id);
            if (m) it.unit_price = Number(m.price);
        }
        if (!it.name || it.name.startsWith('Item #')) {
            const m = menuMap.get(it.menu_item_id);
            if (m) it.name = m.name;
        }
        return it;
    });

    function submitOrderUpdate() {
        const payload = {
            items: state.items.map(it => ({
                menu_item_id: it.menu_item_id,
                quantity: it.quantity
            }))
        };

        fetch("{{ route('orders.updateItems', $order->id) }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                toast("Order updated successfully");
            } else {
                toast("Update failed");
            }
        })
        .catch(err => {
            console.error(err);
            toast("Error updating order");
        });
    }

    function toast(msg) {
        const t = document.getElementById('toast');
        t.textContent = msg;
        t.classList.remove('hidden');
        clearTimeout(t._hid);
        t._hid = setTimeout(() => t.classList.add('hidden'), 1800);
    }

    function recalc() {
        let subtotal = 0;
        state.items.forEach(it => subtotal += (it.unit_price || 0) * (it.quantity || 0));
        const gst = subtotal * GST_RATE;
        const total = subtotal + gst;
        state.subtotal = subtotal;
        state.gst = gst;
        state.total = total;
    }

    function money(n) {
        return '₹' + Number(n || 0).toFixed(2);
    }

    function render() {
        const list = document.getElementById('itemsList');
        list.innerHTML = '';
        state.items.forEach((it, idx) => {
            const row = document.createElement('div');
            row.className = 'flex items-center justify-between p-3';
            row.innerHTML = `
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-gray-100 flex items-center justify-center text-xs text-gray-700">${it.quantity}x</div>
                    <div>
                        <div class="text-sm font-medium text-gray-800">${it.name}</div>
                        <div class="text-xs text-gray-500">Menu ID: ${it.menu_item_id} • ${money(it.unit_price)}</div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <button class="px-2 py-1 rounded border text-xs" data-act="dec" data-idx="${idx}">-</button>
                    <input type="number" class="w-16 text-sm rounded border px-2 py-1 qty-input" min="1" value="${it.quantity}" data-act="set" data-idx="${idx}" />
                    <button class="px-2 py-1 rounded border text-xs" data-act="inc" data-idx="${idx}">+</button>
                    <button class="ml-3 px-3 py-1.5 text-xs rounded bg-red-600 text-white hover:bg-red-700" data-act="remove" data-idx="${idx}">Remove</button>
                </div>
            `;
            list.appendChild(row);
        });

        document.getElementById('itemsCount').textContent = state.items.length;
        document.getElementById('subtotal').textContent = money(state.subtotal);
        document.getElementById('gst').textContent = money(state.gst);
        document.getElementById('total').textContent = money(state.total);
    }

    // Delegated events for items list
    document.getElementById('itemsList').addEventListener('click', (e) => {
        const btn = e.target.closest('button');
        if (!btn) return;
        const act = btn.dataset.act;
        const idx = Number(btn.dataset.idx);
        if (Number.isNaN(idx)) return;

        if (act === 'inc') state.items[idx].quantity += 1;
        if (act === 'dec') {
            state.items[idx].quantity -= 1;
            if (state.items[idx].quantity < 1) state.items[idx].quantity = 1;
        }
        if (act === 'remove') {
            state.items.splice(idx, 1);
        }
        recalc(); render();
    });

    document.getElementById('itemsList').addEventListener('change', (e) => {
        const input = e.target.closest('input[data-act="set"]');
        if (!input) return;
        const idx = Number(input.dataset.idx);
        let val = parseInt(input.value || '1', 10);
        if (isNaN(val) || val < 1) val = 1;
        state.items[idx].quantity = val;
        recalc(); render();
    });

    // Menu search
    const menuSearch = document.getElementById('menuSearch');
    menuSearch?.addEventListener('input', () => {
        const q = (menuSearch.value || '').toLowerCase().trim();
        document.querySelectorAll('#menuList .menu-card').forEach(card => {
            const name = card.getAttribute('data-name');
            card.style.display = (!q || name.includes(q)) ? '' : 'none';
        });
    });

    // Add from a menu card (button inside card)
    function addFromMenuCard(ev) {
        ev.preventDefault();
        ev.stopPropagation();
        const card = ev.currentTarget.closest('.menu-card');
        const id = Number(card.dataset.id);
        const item = menuMap.get(id);
        if (!item) return;

        // If already in order, just inc qty
        const existing = state.items.find(it => it.menu_item_id === id);
        if (existing) {
            existing.quantity += 1;
        } else {
            state.items.push({
                id: Date.now(), // temporary local id
                menu_item_id: id,
                name: item.name,
                unit_price: Number(item.price),
                quantity: 1
            });
        }
        recalc(); render();
        toast('Item added');
    }

    // Also allow clicking anywhere on the card to add
    document.querySelectorAll('.menu-card').forEach(card => {
        card.addEventListener('click', (e) => {
            // If button handled, skip (to avoid double add)
            if (e.target.closest('button')) return;
            const id = Number(card.dataset.id);
            const item = menuMap.get(id);
            if (!item) return;
            const existing = state.items.find(it => it.menu_item_id === id);
            if (existing) existing.quantity += 1;
            else state.items.push({ id: Date.now(), menu_item_id: id, name: item.name, unit_price: Number(item.price), quantity: 1 });
            recalc(); render();
            toast('Item added');
        });
    });

    // Initialize totals from server or recalc if missing
    recalc(); render();
</script>
@endsection
