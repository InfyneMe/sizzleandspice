@extends('layouts.backend')
@section('title', isset($menu) ? 'Edit Menu Item' : 'Add New Menu Item')

@section('content')
<div class="min-h-0">
    <div class="bg-white rounded-xl shadow-md p-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">
                    {{ isset($menu) ? 'Edit Menu Item' : 'Add New Menu Item' }}
                </h2>
                <p class="text-gray-600">
                    {{ isset($menu) ? 'Update this menu item details' : 'Create a new item for your restaurant menu' }}
                </p>
            </div>
            <a href="{{ route('menu') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">Back to Menu</a>
        </div>

        <form action="{{ route('menu.store') }}" 
              method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="id" value="{{ $menu->id ?? '' }}">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Item Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Item Name *</label>
                    <input type="text" id="name" name="name" 
                           value="{{ old('name', $menu->name ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                           placeholder="Enter unique item name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select id="category" name="category"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('category') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        <option value="Indian" {{ old('category', $menu->category ?? '') == 'Indian' ? 'selected' : '' }}>Indian</option>
                        <option value="Chinese" {{ old('category', $menu->category ?? '') == 'Chinese' ? 'selected' : '' }}>Chinese</option>
                        <option value="Healthy" {{ old('category', $menu->category ?? '') == 'Healthy' ? 'selected' : '' }}>Healthy</option>
                    </select>
                    @error('category')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dietary Info -->
                <div>
                    <label for="dietary_info" class="block text-sm font-medium text-gray-700 mb-2">Dietary Type *</label>
                    <select id="dietary_info" name="dietary_info"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('dietary_info') border-red-500 @enderror">
                        <option value="">Select Dietary Type</option>
                        <option value="veg" {{ old('dietary_info', $menu->dietary_info ?? '') == 'veg' ? 'selected' : '' }}>🟢 Vegetarian</option>
                        <option value="non_veg" {{ old('dietary_info', $menu->dietary_info ?? '') == 'non_veg' ? 'selected' : '' }}>🔴 Non-Vegetarian</option>
                        <option value="vegan" {{ old('dietary_info', $menu->dietary_info ?? '') == 'vegan' ? 'selected' : '' }}>🌱 Vegan</option>
                        <option value="gluten_free" {{ old('dietary_info', $menu->dietary_info ?? '') == 'gluten_free' ? 'selected' : '' }}>🌾 Gluten-Free</option>
                        <option value="both" {{ old('dietary_info', $menu->dietary_info ?? '') == 'both' ? 'selected' : '' }}>🟡 Both Veg & Non-Veg</option>
                    </select>
                    @error('dietary_info')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price (₹) *</label>
                    <input type="number" id="price" name="price" step="0.01" 
                           value="{{ old('price', $menu->price ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('price') border-red-500 @enderror">
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select id="status" name="status"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('status') border-red-500 @enderror">
                        <option value="available" {{ old('status', $menu->status ?? '') == 'available' ? 'selected' : '' }}>Available</option>
                        <option value="out_of_stock" {{ old('status', $menu->status ?? '') == 'out_of_stock' ? 'selected' : '' }}>Out of Stock</option>
                        <option value="low_stock" {{ old('status', $menu->status ?? '') == 'low_stock' ? 'selected' : '' }}>Low Stock</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Rating -->
                <div>
                    <label for="rating" class="block text-sm font-medium text-gray-700 mb-2">Rating (0-5) *</label>
                    <select id="rating" name="rating"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('rating') border-red-500 @enderror">
                        @for($i=0; $i<=5; $i++)
                            <option value="{{ $i }}" {{ old('rating', $menu->rating ?? '') == $i ? 'selected' : '' }}>
                                {{ $i }} {{ $i == 1 ? 'Star' : 'Stars' }}
                            </option>
                        @endfor
                    </select>
                    @error('rating')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Quantity -->
                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                    <select id="quantity" name="quantity"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('quantity') border-red-500 @enderror">
                        <option value="">Select Quantity</option>
                        <option value="half" {{ old('quantity', $menu->quantity ?? '') == 'half' ? 'selected' : '' }}>Half</option>
                        <option value="full" {{ old('quantity', $menu->quantity ?? '') == 'full' ? 'selected' : '' }}>Full</option>
                    </select>
                    @error('quantity')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Course Type -->
                <div>
                    <label for="course_type" class="block text-sm font-medium text-gray-700 mb-2">Course Type *</label>
                    <select id="course_type" name="course_type"
                            class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('course_type') border-red-500 @enderror">
                        <option value="">Select Course</option>
                        <option value="starter" {{ old('course_type', $menu->course_type ?? '') == 'starter' ? 'selected' : '' }}>Starter</option>
                        <option value="main_course" {{ old('course_type', $menu->course_type ?? '') == 'main_course' ? 'selected' : '' }}>Main Course</option>
                        <option value="dessert" {{ old('course_type', $menu->course_type ?? '') == 'dessert' ? 'selected' : '' }}>Dessert</option>
                        <option value="drink" {{ old('course_type', $menu->course_type ?? '') == 'drink' ? 'selected' : '' }}>Drink</option>
                    </select>
                    @error('course_type')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                          placeholder="Enter item description...">{{ old('description', $menu->description ?? '') }}</textarea>
            </div>

            <!-- Additional Fields Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Preparation Time -->
                <div>
                    <label for="preparation_time" class="block text-sm font-medium text-gray-700 mb-2">Preparation Time (minutes)</label>
                    <input type="number" id="preparation_time" name="preparation_time" 
                           value="{{ old('preparation_time', $menu->preparation_time ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="e.g., 15">
                </div>

                <!-- Discount Price -->
                <div>
                    <label for="discount_price" class="block text-sm font-medium text-gray-700 mb-2">Discount Price (₹)</label>
                    <input type="number" id="discount_price" name="discount_price" step="0.01" 
                           value="{{ old('discount_price', $menu->discount_price ?? '') }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                           placeholder="Enter discounted price (optional)">
                </div>
            </div>

            <!-- Checkboxes -->
            <div class="space-y-4">
                <div class="flex items-center space-x-6">
                    <div class="flex items-center">
                        <input type="checkbox" id="is_popular" name="is_popular" value="1"
                               {{ old('is_popular', $menu->is_popular ?? false) ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_popular" class="ml-2 text-sm text-gray-700">Popular Item</label>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" id="is_available" name="is_available" value="1"
                               {{ old('is_available', $menu->is_available ?? true) ? 'checked' : '' }}
                               class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="is_available" class="ml-2 text-sm text-gray-700">Currently Available</label>
                    </div>
                </div>
            </div>

            <!-- Submit Buttons -->
            <div class="flex justify-end space-x-4">
                <a href="{{ route('menu') }}" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                    {{ isset($menu) ? 'Update Menu Item' : 'Add Menu Item' }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
