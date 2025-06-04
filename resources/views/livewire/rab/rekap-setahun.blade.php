<div>
    <div class="flex items-center justify-between mb-4">
        <h1 class="text-3xl font-semibold mb-4">
            Rekap Biaya RAB
        </h1>

        <div class="flex items-center justify-between mb-4">
            <div>
                <label for="kelas" class="text-sm font-medium text-gray-700 dark:text-gray-200">Kategori:</label>
                <select wire:model.live="selectedSubKategori" id="kelas"
                    class="ml-2 px-3 py-1 rounded border-gray-300 bg-white shadow dark:bg-gray-800 dark:text-white dark:border-gray-600">
                    <option value="all">Semua Kategori</option>
                    @foreach ($allKategori as $kategori)
                        <option value="{{ $kategori }}">{{ $kategori }}</option>
                    @endforeach
       
                </select>
            </div>
        </div>
    </div>

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md overflow-auto">
        


        <table id="rekap-rab"
            class="dataTableClass_no_pagination w-full text-sm text-left text-gray-500 dark:text-gray-400"
            style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                <tr>
                    <th class="text-center">No</th>
                    <th>Uraian Rab</th>
                    <th>Anggaran Dana</th>

                    @for ($i = 1; $i <= 12; $i++)
                        <th class="text-center">
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                        </th>
                    @endfor
                    <th>Total Pengeluaran</th>
                    <th>Saldo Sisa</th>
                </tr>
            </thead>
            <tbody>
                <tr class="font-bold dark:text-white " style="pointer-events: none;">
                    <td style="background-color: #009c0a1d; " colspan="2">Jumlah Keseluruhan</td>
                    <td style="background-color: #009c0a1d; ">{{ toRupiah($totalSaldoAwal )}}</td>
                    
                    @for ($i = 1; $i <= 12; $i++)
                    <th style="background-color: #009c0a1d; ">
                        {{ toRupiah($allMontlyTotal[$i]) }}
                    </th>
                @endfor
                
                    <td style="background-color: #009c0a1d; ">{{ toRupiah($totalPengeluaran   ) }}</td>
                    <td style="background-color: #009c0a1d; ">{{ toRupiah($totalSaldoAkhir) }}</td>
                    <td></td>
                </tr>
                @foreach ($uraians as $subkategori => $items)
                    <tr class="font-bold text-white" style="pointer-events: none;">
                        <td style="background-color: #007bff; pointer-events: none;" colspan="2">{{ $subkategori }}</td>
                        <td style="background-color: #007bff; pointer-events: none;"></td>
                        <td style="background-color: #007bff70; pointer-events: none;"></td>
                        @for ($i = 1; $i <= 11; $i++)
                            <th style="background-color: #007bff70; pointer-events: none;">
    
                            </th>
                        @endfor
                        <td style="background-color: #007bff; pointer-events: none;"></td>
                        <td style="background-color: #007bff; pointer-events: none;"></td>
                        <td ></td>
                    </tr>
                   
                    @foreach ($items as $item)
                        <tr>

                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->uraian_kegiatan }}</td>
                            <td>{{ toRupiah($item->batas_max) }}</td>
                            @for ($i = 1; $i <= 12; $i++)
                                <th class="text-center font-light {{ $monthlySums[$item->id][$i] != 0 ? 'text-amber-500' : '' }}">
                                    {{ toRupiah($monthlySums[$item->id][$i]) }}
                                </th>
                            @endfor
                            <td class="{{ $monthlyTotal[$item->id] != 0 ? 'text-amber-500' : '' }}">
                                {{ toRupiah($monthlyTotal[$item->id]) }}
                            </td>
                            <td>{{  toRupiah($item->batas_max - $monthlyTotal[$item->id]) }}</td>
                        </tr>
                    @endforeach
                @endforeach


            </tbody>
        </table>


    </div>

</div>
