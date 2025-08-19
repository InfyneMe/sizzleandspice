@extends('layouts.backend')
@section('title', 'Menu')

@section('content')

<div class="min-h-0">
    <!-- Header Stats - Menu Categories Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Indian Items -->
        <div class="bg-white rounded-xl shadow-md px-6 py-7 flex items-center">
            <div class="p-3 bg-orange-100 rounded-xl mr-4">
                <svg class="w-7 h-7 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"></path>
                    <path d="M7 2v20"></path>
                    <path d="M21 15V2a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3z"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">6</div>
                <div class="text-sm text-gray-500">Indian Items</div>
            </div>
        </div>
        
        <!-- Chinese Items -->
        <div class="bg-white rounded-xl shadow-md px-6 py-7 flex items-center">
            <div class="p-3 bg-red-100 rounded-xl mr-4">
                <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="M8 14s1.5 2 4 2 4-2 4-2"></path>
                    <line x1="9" y1="9" x2="9.01" y2="9"></line>
                    <line x1="15" y1="9" x2="15.01" y2="9"></line>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">6</div>
                <div class="text-sm text-gray-500">Chinese Items</div>
            </div>
        </div>
        
        <!-- Healthy Items -->
        <div class="bg-white rounded-xl shadow-md px-6 py-7 flex items-center">
            <div class="p-3 bg-green-100 rounded-xl mr-4">
                <svg class="w-7 h-7 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">6</div>
                <div class="text-sm text-gray-500">Healthy Items</div>
            </div>
        </div>
        
        <!-- Total Items -->
        <div class="bg-white rounded-xl shadow-md px-6 py-7 flex items-center">
            <div class="p-3 bg-purple-100 rounded-xl mr-4">
                <svg class="w-7 h-7 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4"></path>
                    <circle cx="12" cy="12" r="10"></circle>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">18<span class="text-sm text-gray-500">/20</span></div>
                <div class="text-sm text-gray-500">Total Menu Items</div>
            </div>
        </div>
    </div>

    <!-- Add New Item Button -->
    <div class="bg-white rounded-xl shadow-md p-8 mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-lg font-semibold mb-2">Menu Management</h2>
                <p class="text-sm text-gray-500">Add, edit and manage your restaurant menu items</p>
            </div>
            <button class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-3 rounded-lg flex items-center gap-2 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 5v14M5 12h14"/>
                </svg>
                Add New Item
            </button>
        </div>
    </div>

    <!-- Navigation Tabs -->
    <div class="bg-white rounded-xl shadow-md mb-8">
        <div class="border-b border-gray-200">
            <nav class="flex space-x-8 px-8">
                <button onclick="showCategory('all')" id="tab-all" class="py-4 px-1 border-b-2 border-indigo-500 font-medium text-sm text-indigo-600 whitespace-nowrap">
                    All Items (18)
                </button>
                <button onclick="showCategory('indian')" id="tab-indian" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    Indian (6)
                </button>
                <button onclick="showCategory('chinese')" id="tab-chinese" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    Chinese (6)
                </button>
                <button onclick="showCategory('healthy')" id="tab-healthy" class="py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap">
                    Healthy Items (6)
                </button>
            </nav>
        </div>

        <!-- All Items Tab Content -->
        <div id="content-all" class="p-8">
            <h2 class="text-lg font-semibold mb-4">All Menu Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Item Name</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Category</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Popular</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Butter Chicken</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-orange-100 text-orange-700 font-medium">Indian</span></td>
                            <td class="px-6 py-4">₹280</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Dal Tadka</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-orange-100 text-orange-700 font-medium">Indian</span></td>
                            <td class="px-6 py-4">₹180</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Chicken Fried Rice</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-red-100 text-red-700 font-medium">Chinese</span></td>
                            <td class="px-6 py-4">₹250</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Hakka Noodles</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-red-100 text-red-700 font-medium">Chinese</span></td>
                            <td class="px-6 py-4">₹220</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-red-100 text-red-700 font-medium">Out of Stock</span></td>
                            <td class="px-6 py-4">⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Greek Salad</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Healthy</span></td>
                            <td class="px-6 py-4">₹320</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Quinoa Bowl</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Healthy</span></td>
                            <td class="px-6 py-4">₹380</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Indian Items Tab Content -->
        <div id="content-indian" class="p-8 hidden">
            <h2 class="text-lg font-semibold mb-4">Indian Menu Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Item Name</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Popular</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Butter Chicken</td>
                            <td class="px-6 py-4">₹280</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Dal Tadka</td>
                            <td class="px-6 py-4">₹180</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Chinese Items Tab Content -->
        <div id="content-chinese" class="p-8 hidden">
            <h2 class="text-lg font-semibold mb-4">Chinese Menu Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Item Name</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Popular</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Chicken Fried Rice</td>
                            <td class="px-6 py-4">₹250</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Hakka Noodles</td>
                            <td class="px-6 py-4">₹220</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-red-100 text-red-700 font-medium">Out of Stock</span></td>
                            <td class="px-6 py-4">⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Healthy Items Tab Content -->
        <div id="content-healthy" class="p-8 hidden">
            <h2 class="text-lg font-semibold mb-4">Healthy Menu Items</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-left">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Item Name</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Price</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Status</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Popular</th>
                            <th class="px-6 py-3 text-xs font-bold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200 text-sm">
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Greek Salad</td>
                            <td class="px-6 py-4">₹320</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 font-semibold text-gray-900">Quinoa Bowl</td>
                            <td class="px-6 py-4">₹380</td>
                            <td class="px-6 py-4"><span class="inline-flex items-center px-2 py-1 rounded-full bg-green-100 text-green-700 font-medium">Available</span></td>
                            <td class="px-6 py-4">⭐⭐⭐⭐⭐</td>
                            <td class="px-6 py-4"><div class="flex items-center gap-2"><button class="text-indigo-600 hover:text-indigo-800">Edit</button><button class="text-red-600 hover:text-red-800">Delete</button></div></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bottom Section - Category Breakdown and Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-lg font-semibold mb-4">Category Performance</h2>
            <ul class="space-y-3 text-sm">
                <li class="flex items-center justify-between">
                    <span>Indian Items</span>
                    <span class="px-2 py-1 rounded bg-orange-100 text-orange-700 font-medium">Most Popular</span>
                </li>
                <li class="flex items-center justify-between">
                    <span>Chinese Items</span>
                    <span class="px-2 py-1 rounded bg-yellow-100 text-yellow-800 font-medium">Good Sales</span>
                </li>
                <li class="flex items-center justify-between">
                    <span>Healthy Items</span>
                    <span class="px-2 py-1 rounded bg-green-100 text-green-800 font-medium">Growing</span>
                </li>
            </ul>
        </div>
        <div class="bg-white rounded-xl shadow-md p-8">
            <h2 class="text-lg font-semibold mb-4">Item Status</h2>
            <ul class="space-y-3 text-sm">
                <li class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-green-500"></span>
                        Available Items
                    </div>
                    <span class="font-medium text-gray-600">17</span>
                </li>
                <li class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-red-500"></span>
                        Out of Stock
                    </div>
                    <span class="font-medium text-gray-600">1</span>
                </li>
                <li class="flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-2 h-2 rounded-full bg-yellow-500"></span>
                        Low Stock
                    </div>
                    <span class="font-medium text-gray-600">0</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    function showCategory(category) {
        // Hide all content divs
        document.getElementById('content-all').classList.add('hidden');
        document.getElementById('content-indian').classList.add('hidden');
        document.getElementById('content-chinese').classList.add('hidden');
        document.getElementById('content-healthy').classList.add('hidden');
        
        // Remove active classes from all tabs
        document.getElementById('tab-all').className = 'py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap';
        document.getElementById('tab-indian').className = 'py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap';
        document.getElementById('tab-chinese').className = 'py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap';
        document.getElementById('tab-healthy').className = 'py-4 px-1 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300 whitespace-nowrap';
        
        // Show selected content and make tab active
        document.getElementById('content-' + category).classList.remove('hidden');
        document.getElementById('tab-' + category).className = 'py-4 px-1 border-b-2 border-indigo-500 font-medium text-sm text-indigo-600 whitespace-nowrap';
    }
</script>
@endsection
