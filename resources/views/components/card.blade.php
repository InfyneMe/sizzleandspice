@props(['color' => 'indigo', 'icon' => '📦', 'title', 'value'])

<div class="bg-white border border-gray-100 shadow rounded-2xl flex items-center px-6 py-4">
    <div class="flex items-center justify-center w-10 h-10 bg-{{ $color }}-100 rounded-full mr-4">
        <span class="text-{{ $color }}-500 text-lg font-bold">{{ $icon }}</span>
    </div>
    <div>
        <p class="text-2xl font-extrabold text-gray-900">{{ $value }}</p>
        <p class="text-sm text-gray-400">{{ $title }}</p>
    </div>
</div>
