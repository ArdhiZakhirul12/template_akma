
@props(['title', 'onclick', 'icon','color'])

<button onclick="{{ $onclick }}"
class="flex cursor-pointer items-center focus:outline-none text-white dark:text-white bg-{{ $color }}-500 hover:bg-{{ $color }}-400 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-{{ $color }}-600 dark:hover:bg-{{ $color }}-700 dark:focus:ring-{{ $color }}-400">

    @if ($icon)
        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            {!! $icon !!}
        </svg>
    @endif

    <span class="ml-1">{{ $title }}</span>
</button>