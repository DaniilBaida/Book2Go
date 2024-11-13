@props(['title', 'value', 'percentage', 'icon', 'increase' => true])

<div class="flex items-center p-4 bg-white rounded-lg shadow-sm">
    <!-- Icon -->
    <div class="flex items-center justify-center w-12 h-12 mr-4 bg-blue-100 rounded-full">
        <i class="text-blue-500 text-lg 
            {{ $icon == 'users' ? 'fas fa-users' : ($icon == 'box' ? 'fas fa-box' : ($icon == 'wallet' ? 'fas fa-wallet' : '')) }}">
        </i>
    </div>

    <!-- Text content -->
    <div class="flex-1">
        <div class="text-sm font-medium text-gray-500">{{ $title }}</div>
        <div class="text-xl font-bold text-gray-900">{{ $value }}</div>
    </div>

    <!-- Percentage change -->
    <div class="flex items-center ml-auto text-sm font-medium 
        @if($increase) text-green-500 bg-green-100 @else text-red-500 bg-red-100 @endif rounded-full px-2">
        {{ $percentage }}
        <i class="ml-1 {{ $increase ? 'fas fa-arrow-up' : 'fas fa-arrow-down' }}"></i>
    </div>
</div>
