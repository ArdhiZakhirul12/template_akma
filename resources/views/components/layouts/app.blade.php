<x-layouts.app.sidebar :title="$title ?? null">
   

      
            <flux:main>
                {{ $slot }}
                {{-- <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                    © {{ now()->year }} Your Company. All rights reserved.
                </p> --}}
                <div class="flex items-center justify-center mt-8">
                    <img src="{{ asset('images/mid.png') }}" alt="" class="w-5 h-4">
                    <p class="ml-2 text-sm text-gray-500"><i>© {{ now()->year }} Mitra Inovasi Digital</i></p>
                </div>
                
            </flux:main>
     
        
        {{-- <footer class="bg-gray-200 dark:bg-gray-800 text-center py-4 w-full">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                © {{ now()->year }} Your Company. All rights reserved.
            </p>
        </footer> --}}

</x-layouts.app.sidebar>

