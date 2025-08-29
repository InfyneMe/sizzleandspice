@extends('layouts.backend')
@section('title', 'Add Order')

@section('content')
<div class="container mx-auto p-6">
    <!-- Title -->
    {{-- <h1 class="text-2xl font-bold mb-6 text-gray-800">Place Order</h1> --}}
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
    <!-- Table Selection -->
    <div class="mb-8">
        {{-- <h2 class="text-lg font-semibold text-gray-800 mb-3">Select Table or Order Type</h2> --}}
        
        <!-- Takeaway Option -->
        <div class="mb-4">
            <div class="p-4 rounded-xl border shadow cursor-pointer transition hover:shadow-md text-center bg-blue-50 border-blue-300 hover:bg-blue-100"
                onclick="selectTakeaway()">
                <h3 class="text-xl font-bold text-gray-700">🥡 Takeaway</h3>
                <p class="text-sm mt-1 text-blue-600">For pickup orders</p>
            </div>
        </div>

        <!-- Tables Grid -->
        <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 lg:grid-cols-8 gap-3">
            @foreach($tables as $table)
            <div class="table-option p-3 rounded-lg border shadow-sm cursor-pointer transition hover:shadow text-center
                {{ $table->status === 'available' ? 'bg-green-50 border-green-300 hover:bg-green-100' : '' }}
                {{ $table->status === 'occupied' ? 'bg-red-50 border-red-300 hover:bg-red-100' : '' }}
                {{ $table->status === 'reserved' ? 'bg-yellow-50 border-yellow-300 hover:bg-yellow-100' : '' }}"
                data-table-id="{{ $table->id }}"
                onclick="toggleTable({{ $table->id }}, 'Table {{ $table->number }}')">

                <div class="text-lg font-bold text-gray-700">{{ $table->number }}</div>
                <div class="text-xs mt-1 
                    {{ $table->status === 'available' ? 'text-green-600' : '' }}
                    {{ $table->status === 'occupied' ? 'text-red-600' : '' }}
                    {{ $table->status === 'reserved' ? 'text-yellow-600' : '' }}">
                    {{ ucfirst($table->status) }}
                </div>
            </div>
            @endforeach
        </div>
        <p id="selectedTable" class="mt-3 text-sm text-gray-600">No table selected</p>
    </div>

    <div class="grid grid-cols-12 gap-6">
        <!-- Menu Section -->
        <div class="col-span-8">
            <!-- Search & Filter -->
            <div class="flex items-center gap-3 mb-6">
                <!-- Search Input with Icon -->
                <div class="relative flex-1">
                    <input type="text" id="search" placeholder="Search menu..."
                        class="w-full rounded-full border border-gray-300 bg-white py-2 pl-10 pr-4 text-gray-700 shadow-sm
                            focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <span class="absolute inset-y-0 left-3 flex items-center text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"/>
                        </svg>
                    </span>
                </div>

                <!-- Category Dropdown -->
                <select id="categoryFilter"
                    class="rounded-full border border-gray-300 bg-white py-2 px-4 text-gray-700 shadow-sm
                        focus:border-blue-500 focus:ring-2 focus:ring-blue-400 focus:outline-none">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat }}">{{ $cat }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Menu Grid -->
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="menuContainer">
                @foreach($menu as $item)
                    <div class="menu-item border rounded-lg p-4 shadow hover:shadow-md transition cursor-pointer"
                        data-name="{{ strtolower($item->name) }}"
                        data-category="{{ strtolower($item->category) }}"
                        onclick="addItem({{ $item->id }}, '{{ $item->name }}', {{ $item->price }})">
                        
                        <h3 class="font-semibold text-gray-800">{{ $item->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $item->description }}</p>
                        
                        <!-- Price and Quantity Display -->
                        <div class="flex justify-between items-center mt-2">
                            <p class="font-bold text-blue-600">₹{{ number_format($item->price, 2) }}</p>
                            <div class="text-right">
                                <span class="text-xs text-gray-500">Available:</span>
                                <span class="text-sm font-medium 
                                    {{ $item->quantity == 'full' ? 'text-green-600' : '' }}
                                    {{ $item->quantity == 'half' ? 'text-orange-600' : '' }}">
                                    {{ ucfirst($item->quantity) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-span-4">
            <div class="bg-white shadow rounded-lg p-4 sticky top-6">
                <h2 class="text-lg font-bold mb-4">Order Summary</h2>

                <div id="orderItems" class="space-y-2 text-sm text-gray-700">
                    <p class="text-gray-400">No items added yet.</p>
                </div>

                <div class="border-t mt-4 pt-4 space-y-1 text-sm">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span id="subtotal">₹0.00</span>
                    </div>
                    <div class="flex justify-between">
                        <span>GST (5%)</span>
                        <span id="gst">₹0.00</span>
                    </div>
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span id="total">₹0.00</span>
                    </div>
                </div>

                <!-- Customer Phone Number Field -->
                <div class="border-t mt-4 pt-4">
                    <label for="customer_phone" class="block text-sm font-medium text-gray-700 mb-2">
                        Customer Phone Number <span class="text-gray-400">(Optional)</span>
                    </label>
                    <input type="tel" 
                        id="customer_phone" 
                        name="customer_phone"
                        placeholder="Enter phone number"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none text-sm"
                        maxlength="15">
                    <p class="text-xs text-gray-500 mt-1">Phone number for order updates and pickup notifications</p>
                </div>

                <!-- Order Form -->
                <form id="orderForm" action="{{ route('queue.order') }}" method="POST">
                    @csrf
                    <input type="hidden" name="table_id" id="form_table_id" value="">
                    <input type="hidden" name="order_type" id="form_order_type" value="">
                    <input type="hidden" name="items" id="form_items" value="">
                    <input type="hidden" name="subtotal" id="form_subtotal" value="">
                    <input type="hidden" name="gst" id="form_gst" value="">
                    <input type="hidden" name="total" id="form_total" value="">
                    <input type="hidden" name="customer_phone" id="form_customer_phone" value="">
                    
                    <button type="button" onclick="submitOrder()" 
                        class="w-full mt-4 bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition disabled:bg-gray-400" 
                        id="queueOrderBtn">
                        Queue Order
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

<script>
    let order = {};
    let selectedTableId = null;
    let orderType = null; // 'dine-in' or 'takeaway'

    // Table and takeaway selection functions
    function toggleTable(id, label) {
        // If clicking the same table, deselect it
        if (selectedTableId === id) {
            deselectTable();
            return;
        }

        // Clear takeaway selection if any
        clearTakeawaySelection();

        // Select the new table
        selectedTableId = id;
        orderType = 'dine-in';
        
        document.getElementById('selectedTable').innerText = `✅ Selected: ${label} (Click to deselect)`;
        
        // Update visual feedback
        updateTableVisualFeedback();
    }

    function selectTakeaway() {
        // If takeaway is already selected, deselect it
        if (orderType === 'takeaway') {
            deselectAll();
            return;
        }

        // Clear table selection if any
        deselectTable();
        
        // Select takeaway
        selectedTableId = null;
        orderType = 'takeaway';
        
        document.getElementById('selectedTable').innerText = '✅ Selected: Takeaway Order (Click to deselect)';
        
        // Update visual feedback
        updateTakeawayVisualFeedback();
    }

    function deselectTable() {
        selectedTableId = null;
        orderType = null;
        
        document.getElementById('selectedTable').innerText = 'No table selected';
        
        // Remove visual feedback from tables
        document.querySelectorAll('.table-option').forEach(table => {
            table.classList.remove('ring-4', 'ring-blue-400');
        });
    }

    function clearTakeawaySelection() {
        const takeawayOption = document.querySelector('[onclick="selectTakeaway()"]');
        if (takeawayOption) {
            takeawayOption.classList.remove('ring-4', 'ring-blue-400');
        }
    }

    function deselectAll() {
        deselectTable();
        clearTakeawaySelection();
    }

    function updateTableVisualFeedback() {
        // Remove selection from all tables
        document.querySelectorAll('.table-option').forEach(table => {
            table.classList.remove('ring-4', 'ring-blue-400');
        });
        
        // Add selection to current table
        if (selectedTableId) {
            const selectedTable = document.querySelector(`[data-table-id="${selectedTableId}"]`);
            if (selectedTable) {
                selectedTable.classList.add('ring-4', 'ring-blue-400');
            }
        }
        
        // Clear takeaway selection
        clearTakeawaySelection();
    }

    function updateTakeawayVisualFeedback() {
        // Clear table selections
        document.querySelectorAll('.table-option').forEach(table => {
            table.classList.remove('ring-4', 'ring-blue-400');
        });
        
        // Add selection to takeaway
        const takeawayOption = document.querySelector('[onclick="selectTakeaway()"]');
        if (takeawayOption) {
            takeawayOption.classList.add('ring-4', 'ring-blue-400');
        }
    }

    // Menu and order functions
    function addItem(id, name, price) {
        if (!order[id]) {
            order[id] = { name, price, qty: 1 };
        } else {
            order[id].qty++;
        }
        renderOrder();
    }

    function updateQty(id, change) {
        order[id].qty += change;
        if (order[id].qty <= 0) delete order[id];
        renderOrder();
    }

    function renderOrder() {
        let container = document.getElementById('orderItems');
        container.innerHTML = '';
        let subtotal = 0;

        Object.keys(order).forEach(id => {
            let item = order[id];
            let itemTotal = item.qty * item.price;
            subtotal += itemTotal;

            container.innerHTML += `
                <div class="flex justify-between items-center">
                    <div>
                        <p class="font-medium">${item.name}</p>
                        <p class="text-xs text-gray-500">₹${item.price} × ${item.qty}</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <button onclick="updateQty(${id}, -1)" class="px-2 bg-gray-200 rounded">-</button>
                        <span>${item.qty}</span>
                        <button onclick="updateQty(${id}, 1)" class="px-2 bg-gray-200 rounded">+</button>
                        <span class="font-semibold">₹${itemTotal.toFixed(2)}</span>
                    </div>
                </div>
            `;
        });

        if (Object.keys(order).length === 0) {
            container.innerHTML = '<p class="text-gray-400">No items added yet.</p>';
        }

        let gst = subtotal * 0.05;
        let total = subtotal + gst;

        document.getElementById('subtotal').innerText = `₹${subtotal.toFixed(2)}`;
        document.getElementById('gst').innerText = `₹${gst.toFixed(2)}`;
        document.getElementById('total').innerText = `₹${total.toFixed(2)}`;
    }

    // Calculation helper functions
    function calculateSubtotal() {
        let subtotal = 0;
        Object.keys(order).forEach(id => {
            subtotal += order[id].qty * order[id].price;
        });
        return subtotal;
    }

    function calculateGST() {
        return calculateSubtotal() * 0.05;
    }

    function calculateTotal() {
        return calculateSubtotal() + calculateGST();
    }

    // Order submission function
    function submitOrder() {
        // Validate that table/takeaway is selected
        if (!orderType) {
            alert('Please select a table or choose takeaway option');
            return;
        }

        // Validate that items are added
        if (Object.keys(order).length === 0) {
            alert('Please add items to your order');
            return;
        }

        // Get and validate phone number (optional but if provided, should be valid)
        const phoneInput = document.getElementById('customer_phone');
        const phoneNumber = phoneInput.value.trim();
        
        // Basic phone validation if phone number is provided
        if (phoneNumber && !isValidPhoneNumber(phoneNumber)) {
            alert('Please enter a valid phone number or leave it empty');
            phoneInput.focus();
            return;
        }

        // Prepare order data
        const orderItems = Object.keys(order).map(id => ({
            menu_item_id: parseInt(id),
            // name: order[id].name,
            // price: order[id].price,
            quantity: order[id].qty,
            // subtotal: order[id].qty * order[id].price
        }));

        // Update form fields
        document.getElementById('form_table_id').value = selectedTableId || '';
        document.getElementById('form_order_type').value = orderType;
        document.getElementById('form_items').value = JSON.stringify(orderItems);
        document.getElementById('form_subtotal').value = calculateSubtotal().toFixed(2);
        document.getElementById('form_gst').value = calculateGST().toFixed(2);
        document.getElementById('form_total').value = calculateTotal().toFixed(2);
        document.getElementById('form_customer_phone').value = phoneNumber;

        // Disable button to prevent double submission
        const btn = document.getElementById('queueOrderBtn');
        btn.disabled = true;
        btn.innerText = 'Processing...';

        // Submit form
        document.getElementById('orderForm').submit();
    }

    function isValidPhoneNumber(phone) {
    // Remove all non-digit characters
        const cleanPhone = phone.replace(/\D/g, '');
        
        // Check if it's a valid length (10 digits for Indian numbers, or 10-15 for international)
        if (cleanPhone.length >= 10 && cleanPhone.length <= 15) {
            return true;
        }
        
        return false;
    }

    // Search and filter functionality
    const searchInput = document.getElementById('search');
    const categoryFilter = document.getElementById('categoryFilter');
    const menuItems = document.querySelectorAll('.menu-item');

    function filterMenu() {
        const search = searchInput.value.toLowerCase();
        const category = categoryFilter.value.toLowerCase();

        menuItems.forEach(item => {
            const name = item.getAttribute('data-name');
            const cat = item.getAttribute('data-category');

            const matchesSearch = name.includes(search);
            const matchesCategory = !category || cat === category;

            if (matchesSearch && matchesCategory) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterMenu);
    categoryFilter.addEventListener('change', filterMenu);
</script>
@endsection
