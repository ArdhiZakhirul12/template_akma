@props([
    'route','icon','title','color' => 'text-gray-500 dark:text-gray-400',
])

<div 
    class="{{ request()->routeIs($route) ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-white oppacity-100' : 'text-gray-400 dark:text-gray-500 opacity-60' }} flex items-center space-x-2 rtl:space-x-reverse p-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer rounded-lg hover:text-gray-800 dark:hover:text-white transition duration-200 ease-in-out hover:opacity-100"
    onclick="window.location.href='{{ route($route) }}'"
>
    <img src="{{ $icon }}" alt="{{ $title }}" class="w-5 ">
    <span class="text-sm font-medium {{ $color }} ">{{ $title }}</span>
</div>