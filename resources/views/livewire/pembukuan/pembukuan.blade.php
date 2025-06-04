<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <h1 class="text-3xl font-bold mb-2">Pembukuan</h1>
        <div class="flex items-center">
        
            <input type="month" class="form-control me-2" wire:model="selectedMonthYear">
        {{-- <select class="yearpicker form-select me-2" wire:model="selectedYear">
            @for ($year = now()->year; $year >= 2000; $year--)
                <option value="{{ $year }}">{{ $year }}</option>
            @endfor
        </select> --}}
        <select class="form-select me-2" wire:model="selectedYear">
            @foreach ($banks as $bank)
                <option value="{{ $bank->jenis }}">{{ $bank->jenis }}</option>
            @endforeach
        </select>
        {{-- <select class="form-select me-2" wire:model="selectedMonth">
            @foreach (range(1, 12) as $month)
                <option value="{{ $month }}">{{ DateTime::createFromFormat('!m', $month)->format('F') }}</option>
            @endforeach
        </select>
        <div class=" mx-2 width-32">
            <input type="text" class="yearpicker" value="" placeholder="Pilih Tahun" >
        </div>
        <script>
            $(".yearpicker").yearpicker()
        </script> --}}
        
        </select>
            <button wire:click="openedModalForm"
                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block me-1" viewBox="0 0 20 20"
                    fill="currentColor">
                    <path
                        d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.878.516l-4 1a1 1 0 01-1.265-1.265l1-4a2 2 0 01.516-.878l10-10a2 2 0 012.828 0zm-3.707 3.707L5 15l-.707-.707 8.707-8.707.707.707z" />
                </svg>
                Edit Data
            </button>
        </div>
    </div>

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table class="dataTableClass w-full text-sm text-left text-gray-500 dark:text-gray-400" style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th rowspan="2" style="text-align: center !important">NO</th>
                    <th rowspan="2">Nama Kegiatan</th>
                    
                    <th colspan="3" style="text-align: center !important ;background-color: rgba(121, 233, 121, 0.431);">Pemasukan</th>
                    <th colspan="3" style="text-align: center !important ;background-color:  rgba(255, 166, 0, 0.532);">Pengeluaran</th>
            
                    <th rowspan="2">Saldo Kas</th>
                </tr>
                <tr>
            
                    <th style="background-color: rgba(121, 233, 121, 0.431);">SPP</th>
                    <th style="background-color:  rgba(121, 233, 121, 0.431);">Tabungan</th>
                    <th style="background-color:  rgba(121, 233, 121, 0.431);">DPP</th>
                    <th style="background-color:  rgba(255, 166, 0, 0.532);">DPP</th>
                    <th style="background-color: rgba(255, 166, 0, 0.532);">Tabungan</th>
                    <th style="background-color:  rgba(255, 166, 0, 0.532);">SPP</th>
                
                </tr>
            </thead>
            @php $currentSaldo = 0; @endphp

<tbody>
    @foreach($pemasukans as $pemasukan)
        {{-- Hitung total pemasukan bulan ini --}}
        @php
            $pemasukanDPP = $pemasukan->total * ($banks[0]->presentase / 100);
            $pemasukanTabungan = $pemasukan->total * ($banks[1]->presentase / 100);
            $pemasukanSPP = $pemasukan->total * ($banks[2]->presentase / 100);
            $totalPemasukan = $pemasukanDPP + $pemasukanTabungan + $pemasukanSPP;
            $currentSaldo += $totalPemasukan;
        @endphp

        {{-- Row Saldo Bulan --}}
        <tr>
            <td style="text-align: center"><b>-</b></td>
            <td><b>Saldo Bulan {{ $pemasukan->month_name }}</b></td>
            <td><b>{{ toRupiah($pemasukanDPP) }}</b></td>
            <td><b>{{ toRupiah($pemasukanTabungan) }}</b></td>
            <td><b>{{ toRupiah($pemasukanSPP) }}</b></td>
            <td style="text-align: center"><b></b></td>
            <td style="text-align: center"><b></b></td>
            <td style="text-align: center"><b></b></td>
            <td><b>{{ toRupiah($currentSaldo) }}</b></td>
        </tr>

        {{-- Pengeluaran Bulan --}}
        @php $counter = 1; @endphp
        @foreach($pengeluarans->where('month_name', $pemasukan->month_name) as $pengeluaran)
            @php
                $pengeluaranDPP = $pengeluaran->jenis_id === $banks[0]->id ? $pengeluaran->jumlah : 0;
                $pengeluaranTabungan = $pengeluaran->jenis_id === $banks[1]->id ? $pengeluaran->jumlah : 0;
                $pengeluaranSPP = $pengeluaran->jenis_id === $banks[2]->id ? $pengeluaran->jumlah : 0;
                $totalPengeluaran = $pengeluaranDPP + $pengeluaranTabungan + $pengeluaranSPP;
                $currentSaldo -= $totalPengeluaran;
            @endphp

            <tr>
                <td style="text-align: center">{{ $counter++ }}</td>
                <td>{{ $pengeluaran->uraianKegiatan->uraian_kegiatan }}</td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>
                <td style="text-align: center"></td>

                {{-- Output Pengeluaran Per Jenis --}}
                <td style="text-align: center">{{ toRupiah($pengeluaranDPP) }}</td>
                <td style="text-align: center">{{ toRupiah($pengeluaranTabungan) }}</td>
                <td style="text-align: center">{{ toRupiah($pengeluaranSPP) }}</td>

                <td>{{ toRupiah($currentSaldo) }}</td>
            </tr>
        @endforeach
    @endforeach
</tbody>


        </table>
    
    </div>

  


</div>
