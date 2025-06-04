@props(['title', 'total', 'desk' ,'image'])


<div 
    class="bg-white dark:bg-zinc-800 relative p-4 aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg">
    <div class="flex items-center">
        <img src="{{ $image }}" alt={{ $title }} class="w-7 object-cover mr-2">
        <h1 class="text-l font-bold">{{ $title }}</h1>
    </div>
    <h6 class="text-sm text-gray-400 mb-3">{{ $desk }}</h6>
    <div>
        <div class="text-2xl font-bold text-gray-800 dark:text-gray-100 mr-2">

            Rp. {{ number_format($total , 0, ',', '.') }}


        </div>


    </div>
</div>
