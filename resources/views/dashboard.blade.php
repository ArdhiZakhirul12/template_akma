<x-layouts.app :title="__('Dashboard')">

    <div >
        <div class="flex justify-between sm:items-center mb-8">
            <h1 class="text-3xl font-bold mb-2">Dashboard</h1>
    
            <form action="{{ route("dashboard") }}" method="GET">
                <div class="flex items-center">
                    <input type="month"  value="{{ request('pembayaran_bulan') }}" name="pembayaran_bulan" id="pembayaran_bulan"
                    class="mt-1 p-2 w-full border border-gray-300 rounded"
                    value="{{ now()->format('Y-m') }}">
                    <button type="submit" class="ml-2 bg-blue-500 text-white px-6 py-2 rounded w-full">
                        Pilih Bulan
                    </button>
                </div>
              
            </form>
           
            {{-- <div class="grid grid-flow-col sm:auto-cols-max justify-start sm:justify-end">
    
                <div class="relative inline-block text-left">
              
                        <input type="text" id="selected-bulan" class="border border-gray-300 rounded-md px-4 py-2 text-sm"
                            placeholder="Selected Bulan" readonly>
                        <button type="button" id="menu-button-bulan"
                            class="inline-flex justify-center w-full rounded-md border shadow-sm px-4 py-2 text-sm font-medium  focus:outline-none focus:ring-2 focus:ring-offset-2"
                            aria-expanded="true" aria-haspopup="true">
                            Pilih Bulan
                            <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd"
                                    d="M5.293 9.293a1 1 0 011.414 0L10 12.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
    
                      
                   
                 
    
                    <div id="list-dropdown-bulan"
                        class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50"
                        role="menu" aria-orientation="vertical" aria-labelledby="menu-button" tabindex="-1">
                        <div class="py-1" role="none">
                            <a  class="text-gray-700 block px-4 py-2 text-sm" role="menuitem"
                                tabindex="-1">
                                Seluruh Bulan
                            </a>
    
                            @foreach (range(1, 12) as $month)
                                <a class="text-gray-700 block px-4 py-2 text-sm" role="menuitem"
                                    tabindex="-1">
                                    {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                </a>
                            @endforeach
    
    
                        </div>
                    </div>
    
                </div>
    
            </div> --}}
    
        </div>
    
        <div class="flex w-full flex-1 flex-col gap-4 rounded-xl">
            <div class="grid auto-rows-min gap-4 md:grid-cols-4">
                <div
                    class="bg-white dark:bg-zinc-800 p-4 relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg shadow-lg">
                    {{-- <x-placeholder-pattern
                        class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" /> --}}
                    <div class="flex items-center mb-2">
                        <img src="{{ asset('images/Profit.svg') }}" alt="Saldo Awal" class="w-7 object-cover mr-2">
                        <h1 class="text-l font-bold">Saldo Awal</h1>
                    </div>
                    <h6 class="text-sm text-gray-400 mb-3">{{ $monthdate }}</h6>
                    <div>
                        <div class="text-2xl font-bold text-gray-800 dark:text-gray-100 mr-2">
    
                            Rp. {{ number_format($saldoAwal, 0, ',', '.') }}
    
    
                        </div>
    
    
                    </div>
    
                </div>
                <x-dashboard.dashboard-card-01 
                title="Penerimaan" 
                :total=$penerimaan :desk="$monthNow" :image="asset('images/income.svg')"/>
            
                <x-dashboard.dashboard-card-01 
                title="Pengeluaran" 
                :total=$pengeluaran :desk="$monthNow" :image="asset('images/spending.svg')"/>
               
                <x-dashboard.dashboard-card-01 
                title="Saldo Akhir" 
                :total=$saldoAkhir :desk="$monthNow" :image="asset('images/saldoakhir.svg')"/>
                
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-2">
                
                  
                {{-- <x-dashboard.dashboard-card-08 
                    title="Contoh Data Penjualan" 
                    total="5000000" 
                    :image="asset('images/bargrow.svg')"
                    :exMonths="['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']"
                    :exSales="[100000, 200000, 300000, 400000, 500000, 600000, 700000, 800000, 900000, 1000000, 1100000, 1200000]" 
                    :thisYearTotal="5000000" /> --}}
                    <x-dashboard.dashboard-card-08 
                    title="Detail Saldo Akhir" 
                    total="5000000" 
                    :image="asset('images/linegrow.svg')"
                    :exMonths="['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']"
                    :exSales="$saldo_akhir_list"
                    :year="$picked_year"
                    :thisYearTotal="5000000" />
    
                    <x-dashboard.dashboard-card-double-bar 
                    title="Pemasukan dan Pengeluaran" 
                    total="5000000" 
                    :exMonths="['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']"
                    :exSales=$pemasukan_bulan_list
                    :spending=$pengeluaran_bulan_list
                    :year="$picked_year"
                    :thisYearTotal="5000000" />
                </div>
    
    
                   
                {{-- <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg">
                    <div class="flex items-center p-4">
                        <img src="{{ asset('images/Profit.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                        <h1 class="text-l font-bold">Detail Saldo Akhir</h1>
                    </div>
            
                </div> --}}
                {{-- <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg">
                    
                    <div class="flex items-center p-4">
                        <img src="{{ asset('images/Profit.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                        <h1 class="text-l font-bold">Total Saldo Setiap Bulan</h1>
                    </div>
                </div> --}}
            </div>
            <div class="grid auto-rows-min gap-4 md:grid-cols-2 mt-4">
               
           
                {{-- <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg">
                    <div class="flex items-center p-4">
                        <img src="{{ asset('images/Profit.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                        <h1 class="text-l font-bold">Pengeluaran dan Pemasukan</h1>
                    </div>
                </div> --}}
            
            <x-dashboard.dashboard-card-06 title="Persentase Komposisi Saldo Akhir" :dateName="$monthNow" :bank="$banks" :dataName="['SPP','Tabungan','DPP']" :amountData="$bank_data_list[1]" :selected_date="request('pembayaran_bulan')" :total_saldo_akhir="$saldoAkhir" />
            {{-- <div
                class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
                <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
            </div> --}}
            
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var menuItems = document.querySelectorAll('#list-dropdown-bulan a');
            var selectedCabangInput = document.getElementById('selected-bulan');

            menuItems.forEach(function(item) {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    selectedCabangInput.value = this.textContent.trim();
                    document.getElementById('list-dropdown-bulan').classList.add('hidden');
                });
            });

            var button = document.getElementById('menu-button-bulan')
            var menu = document.getElementById('list-dropdown-bulan')
            // button.addEventListener('click', function() {
            //     menu.classList.toggle('hidden')

            // })
        });
    </script>
</x-layouts.app>
