@props(['title', 'percentage'])

<div class="bg-white rounded-2xl shadow p-6 flex items-center justify-between">
    <h3 class="text-lg font-semibold text-gray-800">{{ $title }}</h3>
    <p class="text-xl font-bold text-blue-600">{{ $percentage }}%</p>
</div>
