<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')   
        @livewireStyles
    </head>
    <body class="min-h-screen bg-slate-100 dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <hr>
            
            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid bg-white dark:bg-zinc-900 rounded-lg p-3 shadow-sm">
                    <x-template.button-navbar color="text-blue-500" route="dashboard" icon="{{ asset('images/dashboard.svg') }}" title="Dashboard" />
                    <div class="h-4"></div>
                    <x-template.button-navbar color="text-green-700" route="pemasukan.index" icon="{{ asset('images/income.svg') }}" title="Pemasukan" />
                    
                    <div class="h-4"></div>
                    <x-template.button-navbar color="text-yellow-500" route="pengeluaran.index" icon="{{ asset('images/spending.svg') }}" title="Pengeluaran" />
                    {{-- <ul class="{{ request()->routeIs('pengeluaran.index') || request()->routeIs('pengeluaran.create') ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-white oppacity-100' : 'text-gray-400 dark:text-gray-500 opacity-60' }} hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer rounded-lg hover:text-gray-800 dark:hover:text-white transition duration-200 ease-in-out hover:opacity-100">
                        <li class="p-2 py-2 rounded-lg mb-0.5 last:mb-0 bg-[linear-gradient(135deg,var(--tw-gradient-stops))]"
                        x-data="{ open: {{ in_array(Request::segment(1), ['dashboard', 'pengeluaran', 'rab']) ? 1 : 0 }} }">
                        <a class="block text-gray-800 dark:text-gray-100 truncate transition"
                            href="#0" @click.prevent="open = !open; sidebarExpanded = true">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                  
                                    <img src="{{ asset('images/spending.svg') }}" alt="spending" class="w-5 ">
                                    <span
                                        class="text-sm font-medium ml-2 lg:opacity-0 2xl:opacity-100 duration-200 text-yellow-500">Pengeluaran</span>
                                </div>
                                <!-- Icon -->
                                <div
                                    class="flex shrink-0 ml-2 lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">
                                    <svg class="w-3 h-3 shrink-0 ml-1 fill-current text-gray-400 dark:text-gray-500 "
                                        :class="open ? 'rotate-180' : 'rotate-0'" viewBox="0 0 12 12">
                                        <path d="M5.9 11.4L.5 6l1.4-1.4 4 4 4-4L11.3 6z" />
                                    </svg>
                                </div>
                            </div>
                        </a>
                   
                        <div class="lg:hidden lg:sidebar-expanded:block 2xl:block">
                            <ul class="pl-7 mt-1 "
                                :class="open ? '!block' : 'hidden'">
                                <li class="mb-1 last:mb-0 cursor-pointer">
                                    <a class="{{ request()->routeIs('pengeluaran.index') ? 'bg-gray-100 text-gray-800 text-yellow-600 oppacity-100' : 'text-gray-400 dark:text-gray-500 opacity-60' }} block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate "
                                        href="{{ route('pengeluaran.index') }}"
                                        >
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">List
                                            Pengeluaran</span>
                                    </a>
                                </li>
                                <li class="mb-1 last:mb-0 cursor-pointer">
                                    <a class="{{ request()->routeIs('pengeluaran.create') ? 'bg-gray-100 text-gray-800 text-yellow-600 oppacity-100' : 'text-gray-400 dark:text-gray-500 opacity-60' }} block text-gray-500/90 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition truncate "
                                        href="{{ route('pengeluaran.create') }}"
                                       >
                                        <span
                                            class="text-sm font-medium lg:opacity-0 lg:sidebar-expanded:opacity-100 2xl:opacity-100 duration-200">Pengeluaran Baru</span>
                                    </a>
                                </li>


                            </ul>
                        </div>
                        </li>
                    </ul> --}}
                    {{-- <x-template.button-navbar route="pengeluaran.index" icon="{{ asset('images/spending.svg') }}" title="Pengeluaran" /> --}}
                    <div class="h-4"></div>
                    <x-template.button-navbar color="text-lime-500" route="pages.siswa.index" icon="{{ asset('images/siswa.svg') }}" title="Siswa" />
                    <div class="h-4"></div>
                    <x-template.button-navbar color="text-amber-500" route="kelas.index" icon="{{ asset('images/room.png') }}" title="Kelas" />
                    <div class="h-4"></div>
                    <x-template.button-navbar color="text-red-800" route="rab.index" icon="{{ asset('images/Details.svg') }}" title="RAB" />
                    <div class="h-4"></div>
                    <x-template.button-navbar color="text-violet-600" route="pembukuan.listPembukuan" icon="{{ asset('images/pembukuan.svg') }}" title="Pembukuan" />

                    
                   
                </flux:navlist.group>
                
            </flux:navlist>

            <flux:spacer />

            {{-- <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist> --}}

            <!-- Desktop User Menu -->
            <flux:dropdown position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>
       
        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

       
            {{ $slot }}
        
            
            @fluxScripts
            @livewireScripts
    </body>
   
</html>
