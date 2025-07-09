<x-layouts.app :title="__('Dashboard')">

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

                        Rp. {{ number_format($saldoAwalUmum, 0, ',', '.') }}


                    </div>


                </div>

            </div>
            <x-dashboard.dashboard-card-01 
            title="Penerimaan" 
            :total=$penerimaanUmum :desk="$monthNow" :image="asset('images/income.svg')"/>
        
            <x-dashboard.dashboard-card-01 
            title="Pengeluaran" 
            :total=$pengeluaranUmum :desk="$monthNow" :image="asset('images/spending.svg')"/>
           
            <x-dashboard.dashboard-card-01 
            title="Saldo Akhir" 
            :total=$saldoAkhirUmum :desk="$monthNow" :image="asset('images/saldoakhir.svg')"/>

            
            
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

        <div class="p-4">
            <hr>
        </div>
        <div class="grid auto-rows-min gap-4 md:grid-cols-4 mt-2">
            <x-dashboard.dashboard-card-01 
            title="Saldo Awal Mahad" 
            :total=$penerimaanMahad :desk="$monthNow" :image="asset('images/Profit.svg')"/>
        

            <x-dashboard.dashboard-card-01 
            title="Penerimaan Mahad" 
            :total=$penerimaanMahad :desk="$monthNow" :image="asset('images/income.svg')"/>
        
            <x-dashboard.dashboard-card-01 
            title="Pengeluaran Mahad" 
            :total=$pengeluaranMahad :desk="$monthNow" :image="asset('images/spending.svg')"/>
           
            <x-dashboard.dashboard-card-01 
            title="Saldo Akhir Mahad" 
            :total=$saldoAkhirMahad :desk="$monthNow" :image="asset('images/saldoakhir.svg')"/>
        </div>

        <div class="grid auto-rows-min gap-4 md:grid-cols-2 mt-4">
            
                <x-dashboard.dashboard-card-08 
                title="Detail Saldo Akhir Mahad" 
                total="5000000" 
                :image="asset('images/linegrow.svg')"
                :exMonths="['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']"
                :exSales="$saldo_akhir_list_mahad"
                :year="$picked_year"
                :thisYearTotal="5000000" />
           
                <x-dashboard.dashboard-card-double-bar 
                title="Pemasukan dan Pengeluaran Mahad" 
                total="5000000" 
                :exMonths="['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']"
                :exSales=$pemasukan_bulan_list_mahad
                :spending=$pengeluaran_bulan_list_mahad
                :year="$picked_year"
                :thisYearTotal="5000000" />
            </div>


              
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
