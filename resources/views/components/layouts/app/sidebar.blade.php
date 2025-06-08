<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')   
        @livewireStyles
    </head>
    <body class="min-h-screen bg-slate-100 dark:bg-zinc-800 flex flex-col">
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
                    <div class="h-4"></div>
                    <x-template.button-navbar color="text-lime-500" route="pages.siswa.index" icon="{{ asset('images/siswa.svg') }}" title="Siswa" />
                    <div class="h-4"></div>
                    <x-template.button-navbar color="text-amber-500" route="kelas.index" icon="{{ asset('images/room.png') }}" title="Kelas" />
                    <div class="h-4"></div>
                    <x-template.button-navbar color="text-red-800" route="rab.index" icon="{{ asset('images/Details.svg') }}" title="RAB" />
                    <div class="h-4"></div>
                    <div class="{{ request()->routeIs("pembukuan.listPembukuan") ? 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-white oppacity-100' : 'text-gray-400 dark:text-gray-500 opacity-60' }} flex items-center space-x-2 rtl:space-x-reverse p-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer rounded-lg hover:text-gray-800 dark:hover:text-white transition duration-200 ease-in-out hover:opacity-100"
                        onclick="window.location.href='{{ route('pembukuan.listPembukuan', ['id' => 'all', 'inputYear' => now()->year, 'inputMonth' => 'semua bulan']) }}'">
                        <img src="{{ asset('images/pembukuan.svg') }}" alt="Pembukuan" class="w-5 ">
                        <span class="text-sm font-medium text-violet-600 ">Pembukuan</span>
                    </div>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

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
