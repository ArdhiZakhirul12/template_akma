<x-layouts.app :title="__('Pembukuan')">
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <h1 class="text-3xl font-bold mb-2">Pembukuan</h1>
        <form action="{{ route('pembukuan.index') }}" method="GET">
            <div class="flex items-center">
                <input type="month" name="pembayaran_bulan" id="pembayaran_bulan"
                    class="mt-1 p-2 w-full border border-gray-300 rounded" value="{{ request('pembayaran_bulan') }}">
                <button type="submit" class="ml-2 bg-blue-500 text-white px-6 py-2 rounded-lg rounded w-full mr-2">
                    Sesuaikan
                </button>
                <button onclick="printDiv('testing_print')"
                    class="focus:outline-none w-full text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 whitespace-nowrap">Cetak
                    Dokumen</button>
                {{-- <div class="ml-2">
                    <select id="printOption" class="p-2 border border-gray-300 rounded">
                        <option value="" disabled selected>Pilih Opsi Cetak</option>
                        <option value="monthly">Cetak Bulanan</option>
                        <option value="yearly">Cetak Tahunan</option>
                    </select>
                </div> --}}


            </div>
        </form>

    </div>

    <div class="grid auto-rows-min gap-4 md:grid-cols-2 mb-4">
        <x-dashboard.dashboard-card-08 title="Total Akhir Per-Bulan" total="2200000" :image="asset('images/bargrow.svg')" :exMonths="['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']"
            :exSales="$saldo_akhir_list" :thisYearTotal="1200000" :year="$yearDate" />
        <x-dashboard.dashboard-card-08 title="Total Akhir Per-Tahun" total="5000000" :image="asset('images/linegrow.svg')" :exMonths="$exYears"
            :exSales="$saldo_akhir_list_tahun" :thisYearTotal="5000000" />

    </div>

    <div class="grid auto-rows-min gap-4 md:grid-cols-2">
        @php
            function randomNominal()
            {
                return rand(50, 500) * 1000;
            }
        @endphp
        @foreach (['SALDO BULAN ' . $monthdate, 'PENERIMAAN BULAN BERJALAN', 'PENGELUARAN BULAN BERJALAN', 'SALDO AKHIR ' . \Carbon\Carbon::parse(request('pembayaran_bulan'))->translatedFormat('F Y')] as $tableTitle)
            <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
                <table class="dw-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
                    style="width:100%">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">{{ $tableTitle }}</th>
                            <th scope="col" class="px-6 py-3">Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $total = 0;
                        @endphp

                        @foreach ($bank_data_list[0] as $index => $bankName)
                            @php
                                $persen = $bank_data_list[1][$index] ?? 0;

                                switch (true) {
                                    case $tableTitle == 'PENERIMAAN BULAN BERJALAN':
                                        $nominal = $penerimaan;
                                        $hasil = $nominal * ($persen / 100);
                                        break;

                                    case $tableTitle == 'PENGELUARAN BULAN BERJALAN':
                                        $hasil = $pengeluaran['per_bank'][$bankName] ?? 0;
                                        $nominal = $pengeluaran['total'];
                                        break;

                                    case Str::contains($tableTitle, 'SALDO AKHIR'):
                                        $hasil_penerimaan = $penerimaan * ($persen / 100);
                                        $hasil_awal = $saldoAwal * ($persen / 100);
                                        $nominal = $saldoAwal + $penerimaan - $pengeluaran['total'];

                                        if (!empty($pengeluaran['per_bank'][$bankName])) {
                                            $nominal_perbank = $saldoAwal + $hasil_penerimaan - $pengeluaran['total'];
                                            $hasil = $nominal_perbank;
                                        } else {
                                            $hasil = $hasil_awal + $hasil_penerimaan;
                                        }
                                        break;

                                    default:
                                        $nominal = $saldoAwal;
                                        $hasil = $nominal * ($persen / 100);
                                        break;
                                }
                            @endphp

                            <tr
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                                <td class="px-6 py-4">{{ $bankName }}</td>
                                <td class="px-6 py-4">RP.{{ number_format($hasil, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach


                    </tbody>
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">Total</th>
                            <th scope="col" class="px-6 py-3">RP.{{ number_format($nominal, 0, ',', '.') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        @endforeach
    </div>

   



    {{-- PRINTED PDF --}}

    <div id="testing_print" class="hidden" style="width: 210mm; height: 297mm; margin: 0 auto;">
        <div class="flex justify-between items-center py-4 px-9 mx-5">
            <img src="{{ asset('images/logo_warna.png') }}" alt="logo man" class="w-25 h-25">
            <div class="justify-center items-center text-align-center text-center mr-9 pr-9"
                style="font-family: 'Times New Roman', Times, serif;">
                <h1 class="text-xl font-bold">KOMITE MADRASAH ALIYAH NEGERI TLOGO</h1>
                <h1 class="text-xl font-bold">KECAMATAN KANIGORO KABUPATEN BLITAR</h1>
                <h1>Jl. Raya Gaprang PO BOX 113 No. 32 Kanigoro Blitar</h1>
                <h1>No. Telp (0332)804047</h1>
            </div>
        </div>
        <div class="h-2 bg-gray-900 mb-4">
            <hr>
        </div>
        <div class=" items-center text-align-center text-center" style="font-family: 'Times New Roman', Times, serif;">
            <h1>BERITA ACARA PENUTUPAN BUKU KAS UMUM</h1>
            <h1 class="mb-8">NO. A20/KMT.01/3/2025</h1>
            <h1 class="text-left mb-8 py-4"> PADA HARI INI ___________, _________________ BUKU KAS UMUM KOMITE MAN 1
                BLITAR
                TAHUN AJARAN
                2024/2025 DITUTUP DALAM KEADAAN SEBAGAI BERIKUT : </h1>

            <table class="mt-8 mb-8 w-full">
                @php

                    function dataTotal($nominal, $bank_list)
                    {
                        $total = $nominal * ($bank_list / 100);

                        return toRupiah($total);
                    }
                    function totalSaldo($saldoAwal, $saldoPemasukan, $saldoPengenluaran, $bank_list)
                    {
                        $totalAwal = $saldoAwal * ($bank_list / 100);
                        $totalPemasukan = $saldoPemasukan * ($bank_list / 100);
                        $totalPengeluaran = $saldoPengenluaran;
                        $total = $totalAwal + $totalPemasukan - $totalPengeluaran;
                        return toRupiah($total);
                    }
                @endphp
                <thead>
                    <tr>
                        <th class="border border-black text-xs p-1">NO</th>
                        <th class="border border-black text-xs p-1">URAIAN</th>
                        <th class="border border-black text-xs p-1">SALDO TAHUN LALU</th>
                        <th class="border border-black text-xs p-1">PENERIMAAN TAHUN BERJALAN</th>
                        <th class="border border-black text-xs p-1">PENGELUARAN TAHUN BERJALAN</th>
                        <th class="border border-black text-xs p-1">SALDO AKHIR</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < count($bank_data_list[0]); $i++)
                        <tr>
                            <td class="border border-black text-xs p-1">{{ $i }}</td>
                            <td class="border border-black text-xs p-1">{{ $bank_data_list[0][$i] }}</td>
                            <td class="border border-black text-xs p-1">
                                {{ dataTotal($saldoAwal, $bank_data_list[1][$i]) }}</td>
                            <td class="border border-black text-xs p-1">
                                {{ dataTotal($penerimaan, $bank_data_list[1][$i]) }}</td>

                            @foreach ($pengeluaran['per_bank'] as $bank => $amount)
                                @if ($bank_data_list[0][$i] == $bank)
                                    <td class="border border-black text-xs p-1">{{ toRupiah($amount) }}</td>
                                    <td class="border border-black text-xs p-1">
                                        {{ totalSaldo($saldoAwal, $penerimaan, $pengeluaran['total'], $bank_data_list[1][$i]) }}
                                    </td>
                                @else
                                    <td class="border border-black text-xs p-1">0</td>
                                    <td class="border border-black text-xs p-1">
                                        {{ totalSaldo($saldoAwal, $penerimaan, 0, $bank_data_list[1][$i]) }}</td>
                                @endif
                            @endforeach
                            {{-- <td class="border border-black text-xs p-1">
                                {{ dataTotal($pengeluaran, $bank_data_list[1][$i]) }}</td> --}}

                        </tr>
                    @endfor
                    <tr>
                        <td colspan="2" class="border border-black text-xs p-1">TOTAL</td>
                        <td class="border border-black text-xs p-1">{{ toRupiah($saldoAwal) }}</td>
                        <td class="border border-black text-xs p-1">{{ toRupiah($penerimaan) }}</td>
                        <td class="border border-black text-xs p-1">{{ toRupiah($pengeluaran['total']) }}</td>
                        <td class="border border-black text-xs p-1">
                            {{ toRupiah($saldoAwal + $penerimaan - $pengeluaran['total']) }}</td>
                    </tr>

                </tbody>


            </table>
            <h1 class="text-left py-4">DEMIKIAN BERITA ACARA PENUTUPAN BUKU KAS UMUM INI DIBUAT, UNTUK DIPERGUNAKAN
                SEBAGAIMANA
                MESTINYA, DAN APABILA ADA KEKELIRUAN AKAN DITINJAU KEMBALI.
            </h1>



            <div class="flex justify-between items-center mt-8 px-8 py-9">
                <div class="text-center">
                    <h1 class="text-lg">MENGETAHUI,</h1>
                    <h1 class="text-lg  mb-8">KETUA</h1>
                    <div class="py-7"></div>

                    <h1 class="text-lg">H. IMRON ROSADY</h1>
                </div>
                <div class="text-center">
                    <h1 class="text-lg">BLITAR, _______________</h1>
                    <h1 class="text-lg  mb-8">BENDAHARA</h1>
                    <div class="py-7"></div>

                    <h1 class="text-lg">PRAPTI MAHMUDAH</h1>
                </div>
            </div>


        </div>
    </div>






    <script>
        document.getElementById('printOption').addEventListener('change', function() {
            const selectedOption = this.value;
            if (selectedOption === 'monthly') {
                printDiv('testing_print');
                document.getElementById('printOption').selectedIndex = 0;
            } else if (selectedOption === 'yearly') {
                printDiv('yearly_print');
                document.getElementById('printOption').selectedIndex = 0;
            }
        });
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

            var button = document.getElementById('filterDropdown')
            var subButton = document.getElementById('subDropdownFilter')
            var menu = document.getElementById('list-dropdown-bulan')
            var subMenu = document.getElementById('sub-option-filter')
            subButton.addEventListener('click', function() {
                subMenu.classList.toggle('hidden');
                if (!menu.classList.contains('hidden')) {
                    menu.classList.add('hidden');
                }
            });

            button.addEventListener('click', function() {
                menu.classList.toggle('hidden');
                if (!subMenu.classList.contains('hidden')) {
                    subMenu.classList.add('hidden');
                }
            });
        });


        function printDiv(divId) {
            let printContent = document.getElementById(divId).innerHTML;
            let originalContent = document.body.innerHTML;
            // Create a hidden print-only container
            let printArea = document.createElement("div");
            printArea.id = "print-area";
            printArea.innerHTML = printContent;
            document.body.appendChild(printArea);

            // Add print styles to hide everything else
            let style = document.createElement("style");
            style.innerHTML = `
            @media print {
            body * { visibility: hidden; }
            #print-area, #print-area * { visibility: visible; }
            #print-area {
                position: absolute;
                top: 0;
            
                width: 100%; /* Adjust width as needed */
   
                margin: 0 auto;
                padding: 0;
                text-align: center; /* Ensure text is centered */
            }
        }
        `;
            document.head.appendChild(style);

            // Trigger print
            window.print();

            // Cleanup after printing
            setTimeout(() => {
                document.body.removeChild(printArea);
                document.head.removeChild(style);
                window.livewire.emit('refreshComponent'); // Refresh Livewire component
            }, 500); // Mengembalikan halaman ke tampilan awal
        }
    </script>

</x-layouts.app>
