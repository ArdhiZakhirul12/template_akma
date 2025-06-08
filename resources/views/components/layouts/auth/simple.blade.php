<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="relative min-h-screen antialiased dark:bg-neutral-900">
        <!-- Background Image with Dark Overlay -->
        <div class="absolute inset-0 z-0">
            {{-- <img src="{{ asset('images/man1.JPG') }}"
                 alt="Background"
                 class="w-full h-full object-cover" /> --}}
            {{-- <div class="absolute inset-0 bg-gray-900 opacity-60"></div> <!-- Dark overlay --> --}}
            <div class="absolute inset-0  opacity-60"></div> <!-- Dark overlay -->
        </div>
    
        <!-- Login Content -->
        <div class="relative z-10 flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-4xl shadow-2xl rounded-lg bg-white dark:bg-zinc-800">
                <!-- Left Section with Image -->
                <div class="hidden md:flex w-1/2 items-center justify-center bg-gray-100 dark:bg-zinc-700 rounded-l-lg">
                    <img src="{{ asset('images/office.jpg') }}" alt="Side Image" class="h-full max-w-full object-cover rounded-l-lg">
                </div>
    
                <!-- Right Section with Login -->
                <div class="flex w-full md:w-1/2 flex-col gap-2 p-6 md:p-10">
                    <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                        <span class="flex mb-1 items-center justify-center rounded-md">
                            <img src="{{ asset('images/akse.png') }}" alt="logo" class="h-18">
                        </span>
                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    <div class="flex flex-col gap-6">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    
        @fluxScripts
    </body>
</html>
