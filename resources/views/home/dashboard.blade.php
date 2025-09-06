@extends('layouts.backend')
@section('title', 'Restaurant Dashboard')

@section('content')

<div class=" bg-gray-100 p-8 text-gray-900 font-sans">

    <!-- Stats Cards -->
    <section class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold">120</span>
                <span class="bg-gray-900 text-white rounded p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor"><path d="M4 6h16M4 12h16M4 18h16"/></svg>
                </span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-xs text-gray-500">Total Menus</span>
                <span class="text-xs text-gray-500">45%</span>
            </div>
            <div class="w-full h-1 bg-gray-200 rounded mt-2">
                <div class="h-1 bg-gray-900 rounded" style="width: 45%"></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold">180</span>
                <span class="bg-purple-100 text-purple-600 rounded p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor"><path d="M12 17V9M9 12l3-3 3 3"/></svg>
                </span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-xs text-gray-500">Total Orders Today</span>
                <span class="text-xs text-gray-500">62%</span>
            </div>
            <div class="w-full h-1 bg-gray-200 rounded mt-2">
                <div class="h-1 bg-purple-500 rounded" style="width: 62%"></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold">240</span>
                <span class="bg-green-100 text-green-600 rounded p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor"><path d="M15 12a3 3 0 1 0-6 0"/></svg>
                </span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-xs text-gray-500">Total Client Today</span>
                <span class="text-xs text-gray-500">80%</span>
            </div>
            <div class="w-full h-1 bg-gray-200 rounded mt-2">
                <div class="h-1 bg-green-500 rounded" style="width: 80%"></div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between h-32">
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold">140</span>
                <span class="bg-pink-100 text-pink-600 rounded p-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor"><path d="M12 20V10M12 6v.01"/></svg>
                </span>
            </div>
            <div class="flex justify-between items-center mt-2">
                <span class="text-xs text-gray-500">Revenue Day Ratio</span>
                <span class="text-xs text-gray-500">85%</span>
            </div>
            <div class="w-full h-1 bg-gray-200 rounded mt-2">
                <div class="h-1 bg-pink-500 rounded" style="width: 85%"></div>
            </div>
        </div>
    </section>

    <!-- Graphs -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-2">
                <h2 class="font-bold text-lg">Revenue</h2>
                <div class="flex gap-2">
                    <button class="px-3 py-1 bg-black text-white rounded text-xs font-semibold">Monthly</button>
                    <button class="px-3 py-1 text-black border border-gray-200 rounded text-xs font-semibold">Weekly</button>
                    <button class="px-3 py-1 text-black border border-gray-200 rounded text-xs font-semibold">Today</button>
                </div>
            </div>
            <div class="mt-4 mb-2">
                <!-- REPLACE: Insert chart.js or img here -->
                <img src="https://via.placeholder.com/570x200?text=Revenue+Chart" class="w-full h-40 object-contain rounded" alt="Revenue Chart" />
            </div>
        </div>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="flex justify-between items-center mb-2">
                <h2 class="font-bold text-lg">Orders Summary</h2>
                <div class="flex gap-2">
                    <button class="px-3 py-1 text-black border border-gray-200 rounded text-xs font-semibold">Monthly</button>
                    <button class="px-3 py-1 bg-black text-white rounded text-xs font-semibold">Weekly</button>
                    <button class="px-3 py-1 text-black border border-gray-200 rounded text-xs font-semibold">Today</button>
                </div>
            </div>
            <div class="mt-4 mb-2">
                <!-- REPLACE: Insert chart.js or img here -->
                <img src="https://via.placeholder.com/400x200?text=Orders+Chart" class="w-full h-40 object-contain rounded" alt="Orders Chart" />
            </div>
        </div>
    </section>

    <!-- Order List Table -->
    <section class="bg-white rounded-xl shadow p-6 mb-8">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-bold text-lg">Order List</h2>
            <div class="flex gap-2">
                <button class="px-3 py-1 bg-black text-white rounded text-xs font-semibold">Monthly</button>
                <button class="px-3 py-1 text-black border border-gray-200 rounded text-xs font-semibold">Weekly</button>
                <button class="px-3 py-1 text-black border border-gray-200 rounded text-xs font-semibold">Today</button>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-gray-700">
                <thead>
                    <tr>
                        <th class="py-2 px-5 text-xs font-bold text-gray-500">No</th>
                        <th class="py-2 px-5 text-xs font-bold text-gray-500">ID</th>
                        <th class="py-2 px-5 text-xs font-bold text-gray-500">Date</th>
                        <th class="py-2 px-5 text-xs font-bold text-gray-500">Customer Name</th>
                        <th class="py-2 px-5 text-xs font-bold text-gray-500">Location</th>
                        <th class="py-2 px-5 text-xs font-bold text-gray-500">Amount</th>
                        <th class="py-2 px-5 text-xs font-bold text-gray-500">Status Order</th>
                        <th class="py-2 px-5 text-xs font-bold"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-t">
                        <td class="py-3 px-5">1</td>
                        <td class="py-3 px-5 font-mono">#12345</td>
                        <td class="py-3 px-5">Jan 24th, 2020</td>
                        <td class="py-3 px-5">Roberto Carlo</td>
                        <td class="py-3 px-5">Corner Street 5th Londo</td>
                        <td class="py-3 px-5">$34.20</td>
                        <td class="py-3 px-5">
                            <span class="inline-block px-2 py-1 rounded bg-gray-100 text-gray-600 text-xs">New Order</span>
                        </td>
                        <td class="py-3 px-5">
                            <button class="text-xl text-gray-400 hover:text-black">...</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="py-3 px-5">2</td>
                        <td class="py-3 px-5 font-mono">#12366</td>
                        <td class="py-3 px-5">Jan 22nd, 2020</td>
                        <td class="py-3 px-5">Rohmad Khoir</td>
                        <td class="py-3 px-5">Lando Street 5th Yogos</td>
                        <td class="py-3 px-5">$44.25</td>
                        <td class="py-3 px-5">
                            <span class="inline-block px-2 py-1 rounded bg-blue-100 text-blue-700 text-xs">On Delivery</span>
                        </td>
                        <td class="py-3 px-5">
                            <button class="text-xl text-gray-400 hover:text-black">...</button>
                        </td>
                    </tr>
                    <!-- repeat row as needed -->
                </tbody>
            </table>
        </div>
    </section>

</div>
@endsection
