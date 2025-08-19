@extends('layouts.backend')
@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Stat Card: Total Orders -->
    <div class="bg-white rounded-xl shadow-md px-6 py-7 flex items-center">
        <div class="p-3 bg-indigo-100 rounded-xl mr-4">
            <svg class="w-7 h-7 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"></path></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-900">128</div>
            <div class="text-sm text-gray-500">Total Orders Today</div>
        </div>
    </div>
    <!-- Stat Card: Revenue -->
    <div class="bg-white rounded-xl shadow-md px-6 py-7 flex items-center">
        <div class="p-3 bg-green-100 rounded-xl mr-4">
            <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><text x="10" y="20" font-size="15">₹</text><rect x="5" y="4" width="14" height="16" rx="2"/><line x1="9" y1="9" x2="15" y2="9"/></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-900">₹12,500</div>
            <div class="text-sm text-gray-500">Revenue</div>
        </div>
    </div>
    <!-- Stat Card: Active Tables -->
    <div class="bg-white rounded-xl shadow-md px-6 py-7 flex items-center">
        <div class="p-3 bg-yellow-100 rounded-xl mr-4">
            <svg class="w-7 h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="4" y="8" width="16" height="8" rx="2"/><path d="M4 8V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v2"/><path d="M4 20v-4"/><path d="M20 20v-4"/></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-900">7<span class="text-sm text-gray-500">/12</span></div>
            <div class="text-sm text-gray-500">Active Tables</div>
        </div>
    </div>
    <!-- Stat Card: Staff Online -->
    <div class="bg-white rounded-xl shadow-md px-6 py-7 flex items-center">
        <div class="p-3 bg-purple-100 rounded-xl mr-4">
            <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M6 21v-2a4 4 0 0 1 4-4h4a4 4 0 0 1 4 4v2"/></svg>
        </div>
        <div>
            <div class="text-2xl font-bold text-gray-900">4</div>
            <div class="text-sm text-gray-500">Staff Online</div>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-md p-8 mb-8">
    <h2 class="text-lg font-semibold mb-4">Recent Orders</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-left">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Table</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Time</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200 text-sm">
                <tr>
                    <td class="px-6 py-4 font-semibold text-gray-900">#ORD101</td>
                    <td class="px-6 py-4">Akash Kumar</td>
                    <td class="px-6 py-4">Table 4</td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Completed</span></td>
                    <td class="px-6 py-4">₹650</td>
                    <td class="px-6 py-4">12:38 PM</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 font-semibold text-gray-900">#ORD102</td>
                    <td class="px-6 py-4">Neha Singh</td>
                    <td class="px-6 py-4">Table 2</td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 font-medium">Preparing</span></td>
                    <td class="px-6 py-4">₹430</td>
                    <td class="px-6 py-4">12:42 PM</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 font-semibold text-gray-900">#ORD103</td>
                    <td class="px-6 py-4">Vivek Rao</td>
                    <td class="px-6 py-4">Takeaway</td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-blue-100 text-blue-700 font-medium">Served</span></td>
                    <td class="px-6 py-4">₹280</td>
                    <td class="px-6 py-4">12:47 PM</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 font-semibold text-gray-900">#ORD104</td>
                    <td class="px-6 py-4">Priya Patel</td>
                    <td class="px-6 py-4">Table 8</td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-red-100 text-red-700 font-medium">Cancelled</span></td>
                    <td class="px-6 py-4">₹0</td>
                    <td class="px-6 py-4">12:53 PM</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white rounded-xl shadow-md p-8">
        <h2 class="text-lg font-semibold mb-4">Low Stock Ingredients</h2>
        <ul class="space-y-3 text-sm">
            <li class="flex items-center justify-between">
                <span>Tomatoes</span>
                <span class="px-2 py-1 rounded bg-red-100 text-red-700 font-medium">5 kg left</span>
            </li>
            <li class="flex items-center justify-between">
                <span>Paneer</span>
                <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 font-medium">2 kg left</span>
            </li>
            <li class="flex items-center justify-between">
                <span>Masala Mix</span>
                <span class="px-2 py-1 rounded bg-indigo-100 text-indigo-800 font-medium">1 kg left</span>
            </li>
        </ul>
    </div>
    <div class="bg-white rounded-xl shadow-md p-8">
        <h2 class="text-lg font-semibold mb-4">Staff On Duty</h2>
        <ul class="space-y-3 text-sm">
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                    Vikram Chauhan
                </div>
                <span class="font-medium text-gray-600">Manager</span>
            </li>
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                    Suman Jain
                </div>
                <span class="font-medium text-gray-600">Chef</span>
            </li>
            <li class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                    Rahul Das
                </div>
                <span class="font-medium text-gray-600">Waiter</span>
            </li>
        </ul>
    </div>
</div>
@endsection
