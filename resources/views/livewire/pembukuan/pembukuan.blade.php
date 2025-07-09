<div>
    {{-- The best athlete wants his opponent at his best. --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <h1 class="text-3xl font-bold mb-2">Pembukuan</h1>
        <div class="flex items-center">

            <div class="flex items-center mr-4 ">
                <select
                    class="form-select me-2 border border-gray-300 p-2 rounded-lg shadow-sm bg-white dark:bg-zinc-700"
                    wire:model.live="selectedMonth">
                    <option value="" disabled selected>Pilih Bulan</option>
                    <option value="semua bulan">Semua Bulan</option>
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}" {{ $month == $selectedMonth ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $month)->format('F') }}
                        </option>
                    @endforeach
                </select>

                <select
                    class="form-select me-2 border border-gray-300 p-2 rounded-lg shadow-sm bg-white dark:bg-zinc-700"
                    wire:model.live="selectedYear">
                    <option value="" disabled selected>Pilih Tahun</option>
                    @foreach (range(date('Y') - 25, date('Y')) as $year)
                        <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
                <select
                    class="form-select me-2 border border-gray-300 p-2 rounded-lg shadow-sm bg-white dark:bg-zinc-700"
                    wire:model.live="selectedBank">
                    <option value="" disabled selected>Pilih Bank</option>
                    <option value="semua bank">Kas Umum</option>

                    @foreach ($banks as $bank)
                        <option value="{{ $bank->jenis }}">
                            {{ $bank->jenis == 'DPP' ? 'DPM' : ($bank->jenis == 'SPP' ? 'SOPM' : $bank->jenis) }}
                        </option>
                    @endforeach
                </select>



            </div>
            <button onclick="printDiv('printPembukuan')"
                class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block me-1" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M6 9V4a2 2 0 012-2h8a2 2 0 012 2v5h1a2 2 0 012 2v6a2 2 0 01-2 2h-1v3a2 2 0 01-2 2H8a2 2 0 01-2-2v-3H5a2 2 0 01-2-2v-6a2 2 0 012-2h1zm2-5v5h8V4H8zm8 16v-3H8v3h8zM5 11v6h14v-6H5z" />
                </svg>
                Cetak Dokumen
            </button>
            <button onclick="printDiv('berita_acara_print')"
                class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block me-1" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M6 9V4a2 2 0 012-2h8a2 2 0 012 2v5h1a2 2 0 012 2v6a2 2 0 01-2 2h-1v3a2 2 0 01-2 2H8a2 2 0 01-2-2v-3H5a2 2 0 01-2-2v-6a2 2 0 012-2h1zm2-5v5h8V4H8zm8 16v-3H8v3h8zM5 11v6h14v-6H5z" />
                </svg>
                Cetak Berita Acara
            </button>
        </div>
    </div>

    <div class="mb-4 p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table class="dataTableClass_simple w-full text-sm text-left text-gray-500 dark:text-gray-400"
            style="width:100%">

            <thead>
                <tr>
                    <th style="padding: 10px;"></th>
                    @foreach ($banks as $bank)
                        <th style="padding: 10px;">
                            {{ $bank->jenis == 'SPP' ? 'INFAQ' : $bank->jenis }}
                        </th>
                    @endforeach
                    <th style="padding: 10px;">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="padding: 4px; font-weight: bold;">SALDO AWAL</td>
                    @foreach ($banks as $bank)
                        @if ($bank->jenis == 'DPP')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanDpp) }}</b></td>
                        @elseif($bank->jenis == 'SPP')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanSpp) }}</b></td>
                        @elseif($bank->jenis == 'Tabungan')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanTabungan) }}</b>
                            </td>
                        @elseif($bank->jenis == 'MAHAD')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanMahad) }}</b></td>
                        @endif
                    @endforeach
                    <td style="padding: 4px; font-weight: bold;">
                        {{ toRupiah($totalJumlahSaldoAwal) }}</td>

                </tr>

                <tr>
                    <td style="padding: 4px; font-weight: bold;">PENERIMAAN</td>
                    @foreach ($banks as $bank)
                        @if ($bank->jenis == 'DPP')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalJumlahPemasukanDpp) }}</b></td>
                        @elseif($bank->jenis == 'SPP')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalJumlahPemasukanSpp) }}</b></td>
                        @elseif($bank->jenis == 'Tabungan')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalJumlahPemasukanTabungan) }}</b></td>
                        @elseif($bank->jenis == 'MAHAD')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalJumlahPemasukanMahad) }}</b></td>
                        @endif
                    @endforeach
                    <td style="padding: 4px; font-weight: bold;">
                        {{ toRupiah($totalSemuaPemasukan) }}</td>

                </tr>

                <tr>
                    <td style="padding: 4px; font-weight: bold;">PENGELUARAN</td>
                    @foreach ($banks->reverse() as $key => $bank)
                        @if (isset($totalJumlahPengeluaran[$banks->count() - $key]))
                            <td style="padding: 4px; font-size: smaller;"><b>
                                    {{ toRupiah($totalJumlahPengeluaran[$banks->count() - $key]) }}</b></td>
                        @else
                            <td style="padding: 4px; font-size: smaller;">-</td>
                        @endif
                    @endforeach
                    <td style="padding: 4px; font-weight: bold;">
                        {{ toRupiah($totalSemuaPengeluaran) }}</td>

                </tr>

                <tr>
                    <td style="padding: 4px; font-weight: bold;">SALDO KAS</td>
                    @foreach ($banks as $key => $bank)
                        <td style="font-size: smaller;">
                            <b>
                                {{ isset($totalJumlahPengeluaran[$bank->id])
                                    ? toRupiah(
                                        match ($bank->jenis) {
                                            'DPP' => $totalJumlahPemasukanDpp + $totalSaldoAwalPemasukanDpp - $totalJumlahPengeluaran[$bank->id],
                                            'SPP' => $totalJumlahPemasukanSpp + $totalSaldoAwalPemasukanSpp - $totalJumlahPengeluaran[$bank->id],
                                            'Tabungan' => $totalJumlahPemasukanTabungan +
                                                $totalSaldoAwalPemasukanTabungan -
                                                $totalJumlahPengeluaran[$bank->id],
                                            'MAHAD' => $totalJumlahPemasukanMahad + $totalSaldoAwalPemasukanMahad - $totalJumlahPengeluaran[$bank->id],
                                            default => 0,
                                        },
                                    )
                                    : toRupiah(
                                        match ($bank->jenis) {
                                            'DPP' => $totalJumlahPemasukanDpp,
                                            'SPP' => $totalJumlahPemasukanSpp,
                                            'Tabungan' => $totalJumlahPemasukanTabungan + $totalSaldoAwalPemasukanTabungan,
                                            'MAHAD' => $totalJumlahPemasukanMahad,
                                            default => 0,
                                        },
                                    ) }}
                            </b>
                        </td>
                    @endforeach
                    <td style="padding: 4px; font-weight: bold;">
                        {{ toRupiah($totalJumlahSaldoAwal + $totalSemuaPemasukan - $totalSemuaPengeluaran) }}</td>

                </tr>

            </tbody>
        </table>
    </div>

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">

        @if ($selectedBank == null || $selectedBank == 'semua bank')
            <table class="dataTableClass_no_print w-full text-sm text-left text-gray-500 dark:text-gray-400"
                style="width:100%">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th rowspan="2" style="text-align: center !important">NO</th>
                        <th rowspan="2" style="width: 50px !important;">Nama Kegiatan</th>

                        <th colspan="4"
                            style="text-align: center !important ;background-color: rgba(121, 233, 121, 0.431);">
                            Pemasukan
                        </th>
                        <th colspan="4"
                            style="text-align: center !important ;background-color:  rgba(255, 166, 0, 0.532);">
                            Pengeluaran
                        </th>

                        <th rowspan="2">Saldo Kas</th>
                    </tr>
                    <tr>

                        <th style="background-color: rgba(121, 233, 121, 0.431);">Infaq</th>
                        <th style="background-color:  rgba(121, 233, 121, 0.431);">Tabungan</th>
                        <th style="background-color:  rgba(121, 233, 121, 0.431);">DPP</th>
                        <th style="background-color:  rgba(121, 233, 121, 0.431);">MAHAD</th>
                        <th style="background-color:  rgba(255, 166, 0, 0.532);">Infaq</th>
                        <th style="background-color: rgba(255, 166, 0, 0.532);">Tabungan</th>
                        <th style="background-color:  rgba(255, 166, 0, 0.532);">DPP</th>
                        <th style="background-color:  rgba(255, 166, 0, 0.532);">MAHAD</th>

                    </tr>
                </thead>
                @php $currentSaldo = 0; @endphp

                <tbody>
                    @php

                        $currentSaldo += $totalJumlahSaldoAwal;
                    @endphp
                    <tr>
                        <td style="text-align: center"><b>-</b></td>
                        <td><b>Saldo Awal</b></td>
                        <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanDpp) }}</b></td>
                        <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanTabungan) }}</b></td>
                        <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanSpp) }}</b></td>
                        <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanMahad) }}</b></td>
                        <td style="text-align: center; "><b></b></td>
                        <td style="text-align: center; "><b></b></td>
                        <td style="text-align: center; "><b></b></td>
                        <td style="text-align: center; "><b></b></td>
                        <td style="font-size: smaller; "><b>{{ toRupiah($currentSaldo) }}</b></td>
                    </tr>

                    @foreach ($pemasukans as $pemasukan)
                        {{-- Hitung total pemasukan bulan ini --}}

                        @php
                            $pemasukanDPP = $pemasukan['totalDpp'];
                            $pemasukanTabungan = $pemasukan['totalTabungan'];
                            $pemasukanSPP = $pemasukan['totalSpp'];
                            $pemasukanMahad = $pemasukan['totalMahad'];
                            $totalPemasukan = $pemasukanDPP + $pemasukanTabungan + $pemasukanSPP + $pemasukanMahad;
                            $currentSaldo += $totalPemasukan;
                        @endphp

                        {{-- Row Saldo Bulan --}}
                        <tr>
                            <td style="text-align: center"><b>-</b></td>
                            <td><b>Saldo Bulan {{ $pemasukan['month_name'] }}</b></td>
                            <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanDPP) }}</b></td>
                            <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanTabungan) }}</b></td>
                            <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanSPP) }}</b></td>
                            <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanMahad) }}</b></td>
                            <td style="text-align: center; "><b></b></td>
                            <td style="text-align: center; "><b></b></td>
                            <td style="text-align: center; "><b></b></td>
                            <td style="text-align: center; "><b></b></td>
                            <td style="font-size: smaller; "><b>{{ toRupiah($currentSaldo) }}</b></td>
                        </tr>

                        {{-- Pengeluaran Bulan --}}
                        @php $counter = 1; @endphp
                        @foreach ($pengeluaranPerBank->where('month_name', $pemasukan['month_name']) as $pengeluaran)
                            @php
                                $pengeluaranDPP = $pengeluaran->jenis_id === $banks[0]->id ? $pengeluaran->jumlah : 0;
                                $pengeluaranTabungan =
                                    $pengeluaran->jenis_id === $banks[1]->id ? $pengeluaran->jumlah : 0;
                                $pengeluaranSPP = $pengeluaran->jenis_id === $banks[2]->id ? $pengeluaran->jumlah : 0;
                                $pengeluaranMahad = $pengeluaran->jenis_id === $banks[3]->id ? $pengeluaran->jumlah : 0;
                                $totalPengeluaran = $pengeluaranDPP + $pengeluaranTabungan + $pengeluaranSPP;
                                $currentSaldo -= $totalPengeluaran;
                            @endphp

                            <tr>
                                <td style="text-align: center">{{ $pengeluaran->created_at->format('d/m/Y') }}</td>
                                <td style="font-size: smaller;">{{ $pengeluaran->uraianKegiatan->uraian_kegiatan }}
                                </td>
                                <td style="text-align: center"></td>
                                <td style="text-align: center"></td>
                                <td style="text-align: center"></td>
                                <td style="text-align: center"></td>
                                {{-- Output Pengeluaran Per Jenis --}}
                                <td style="text-align: center; font-size: smaller;">{{ toRupiah($pengeluaranDPP) }}
                                </td>
                                <td style="text-align: center; font-size: smaller;">
                                    {{ toRupiah($pengeluaranTabungan) }}</td>
                                <td style="text-align: center; font-size: smaller;">{{ toRupiah($pengeluaranSPP) }}
                                </td>

                                <td style="font-size: smaller; text-align:center">{{ toRupiah($pengeluaranMahad) }}
                                </td>
                                <td style="font-size: smaller; text-align:center">{{ toRupiah($currentSaldo) }}</td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>


            </table>
        @else
            <table class="dataTableClass_no_print w-full text-sm text-left text-gray-500 dark:text-gray-400"
                style="width:100%">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th style="text-align: center !important">NO</th>
                        <th>Nama Kegiatan</th>

                        <th style="text-align: center !important ;background-color: rgba(121, 233, 121, 0.431);">
                            Pemasukan
                        </th>
                        <th style="text-align: center !important ;background-color:  rgba(255, 166, 0, 0.532);">
                            Pengeluaran
                        </th>

                        <th>Saldo Kas</th>
                    </tr>

                </thead>

                @php $currentSaldo = 0; @endphp
                <tbody>
                    @php

                        if ($selectedBank == 'DPP') {
                            $totalPemasukan = $totalSaldoAwalPemasukanDpp;
                        } elseif ($selectedBank == 'SPP') {
                            $totalPemasukan = $totalSaldoAwalPemasukanSpp;
                        } elseif ($selectedBank == 'Tabungan') {
                            $totalPemasukan = $totalSaldoAwalPemasukanTabungan;
                        } elseif ($selectedBank == 'MAHAD') {
                            $totalPemasukan = $totalSaldoAwalPemasukanMahad;
                        } else {
                            $totalPemasukan = $pemasukanDPP + $pemasukanTabungan + $pemasukanSPP + $pemasukanMahad;
                        }
                        $currentSaldo += $totalPemasukan;
                    @endphp
                    <tr>
                        <td style="text-align: center"><b>-</b></td>
                        <td><b>Saldo Awal</b></td>



                        {{-- <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanSPP) }}</b></td> --}}
                        @if ($selectedBank == 'DPP')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanDpp) }}</b></td>
                        @elseif($selectedBank == 'SPP')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanSpp) }}</b></td>
                        @elseif($selectedBank == 'Tabungan')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanTabungan) }}</b>
                            </td>
                        @elseif($selectedBank == 'MAHAD')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanMahad) }}</b></td>
                        @endif
                        {{-- <td style="text-align:center; font-size: smaller;">

                            <b>{{ toRupiah($pemasukan->total * ($banks->where('jenis', $selectedBank)->first()->presentase / 100)) }}</b>
                        </td> --}}
                        <td style="font-size: smaller;"><b></b></td>
                        {{-- <td style="font-size: smaller;"><b>{{ toRupiah($totalJumlahSaldoAwal) }}</b> --}}
                        @if ($selectedBank == 'DPP')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanDpp) }}</b></td>
                        @elseif($selectedBank == 'SPP')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanSpp) }}</b></td>
                        @elseif($selectedBank == 'Tabungan')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanTabungan) }}</b>
                            </td>
                        @elseif($selectedBank == 'MAHAD')
                            <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanMahad) }}</b></td>
                        @endif
                        </td>
                    </tr>
                    @foreach ($pemasukans as $pemasukan)
                        {{-- Hitung total pemasukan bulan ini --}}
                        @php
                            $pemasukanDPP = $pemasukan['totalDpp'];
                            $pemasukanTabungan = $pemasukan['totalTabungan'];
                            $pemasukanSPP = $pemasukan['totalSpp'];
                            $pemasukanMahad = $pemasukan['totalMahad'];
                            if ($selectedBank == 'DPP') {
                                $totalPemasukan = $pemasukanDPP;
                            } elseif ($selectedBank == 'SPP') {
                                $totalPemasukan = $pemasukanSPP;
                            } elseif ($selectedBank == 'Tabungan') {
                                $totalPemasukan = $pemasukanTabungan;
                            } elseif ($selectedBank == 'MAHAD') {
                                $totalPemasukan = $pemasukanMahad;
                            } else {
                                $totalPemasukan = $pemasukanDPP + $pemasukanTabungan + $pemasukanSPP + $pemasukanMahad;
                            }
                            $currentSaldo += $totalPemasukan;
                        @endphp
                        {{-- Row Saldo Bulan --}}
                        <tr>
                            <td style="text-align: center"><b>-</b></td>
                            <td><b>Saldo Bulan {{ $pemasukan['month_name'] }}</b></td>



                            {{-- <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanSPP) }}</b></td> --}}
                            @if ($selectedBank == 'DPP')
                                <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanDPP) }}</b></td>
                            @elseif($selectedBank == 'SPP')
                                <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanSPP) }}</b></td>
                            @elseif($selectedBank == 'Tabungan')
                                <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanTabungan) }}</b></td>
                            @elseif($selectedBank == 'MAHAD')
                                <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanMahad) }}</b></td>
                            @endif
                            {{-- <td style="text-align:center; font-size: smaller;">

                                <b>{{ toRupiah($pemasukan->total * ($banks->where('jenis', $selectedBank)->first()->presentase / 100)) }}</b>
                            </td> --}}
                            <td style="font-size: smaller;"><b></b></td>
                            <td style="font-size: smaller;"><b>{{ toRupiah($currentSaldo) }}</b>
                            </td>
                        </tr>

                        {{-- Pengeluaran Bulan --}}
                        @php $counter = 1; @endphp
                        @foreach ($pengeluaranPerBank as $pengeluaran)
                            @if ($pengeluaran->month_name == $pemasukan['month_name'])
                                @php
                                    $currentSaldo -= $pengeluaran->jumlah;
                                @endphp
                                <tr>
                                    <td>{{ $pengeluaran->created_at->format('d/m/Y') }}</td>
                                    <td>{{ $pengeluaran->uraianKegiatan->uraian_kegiatan }}</td>
                                    <td></td>
                                    <td style="font-size: smaller;">{{ toRupiah($pengeluaran->jumlah) }}</td>
                                    <td style="font-size: smaller;">{{ toRupiah($currentSaldo) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach

                </tbody>


            </table>
        @endif

    </div>

    <div id="berita_acara_print" class="hidden" style="width: 210mm; height: 297mm; margin: 0 auto;">
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
        <div class=" items-center text-align-center text-center"
            style="font-family: 'Times New Roman', Times, serif;">
            @if ($bankName == 'all' || $bankName == 'semua bank')
                <h1 class="font-bold">BUKU KAS UMUM</h1>
            @else
                <h1 class="font-bold">BUKU KAS {{ strtoupper($bankName) }}</h1>
            @endif


            <h1 class="mb-8">NO. A20/KMT.01/3/2025</h1>
            @if ($bankName == 'all' || $bankName == 'semua bank')
                <h1 class="text-left mb-8 py-4"> PADA HARI INI ___________, _________________ BUKU KAS UMUM KOMITE MAN
                    1
                    BLITAR
                    TAHUN AJARAN
                    2024/2025 DITUTUP DALAM KEADAAN SEBAGAI BERIKUT : </h1>
            @else
                <h1 class="text-left mb-8 py-4"> PADA HARI INI ___________, _________________
                    {{ strtoupper($bankName) }} KOMITE MAN 1
                    BLITAR
                    TAHUN AJARAN
                    2024/2025 DITUTUP DALAM KEADAAN SEBAGAI BERIKUT : </h1>
            @endif


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
                    @foreach ($banks as $key => $bank)
                        <tr>
                            <td class="border border-black text-xs p-1">{{ $key + 1 }}</td>
                            <td class="border border-black text-xs p-1">{{ $bank->jenis }}</td>
                            <td class="border border-black text-xs p-1">

                                @if ($bank->jenis == 'DPP')
                                    {{ toRupiah($totalSaldoAwalPemasukanDpp) }}
                                @elseif($bank->jenis == 'SPP')
                                    {{ toRupiah($totalSaldoAwalPemasukanSpp) }}
                                @elseif($bank->jenis == 'Tabungan')
                                    {{ toRupiah($totalSaldoAwalPemasukanTabungan) }}
                                @elseif($bank->jenis == 'MAHAD')
                                    {{ toRupiah($totalSaldoAwalPemasukanMahad) }}
                                @endif
                            </td>
                            <td class="border border-black text-xs p-1">
                                @if ($bank->jenis == 'DPP')
                                    {{ toRupiah($totalJumlahPemasukanDpp) }}
                                @elseif($bank->jenis == 'SPP')
                                    {{ toRupiah($totalJumlahPemasukanSpp) }}
                                @elseif($bank->jenis == 'Tabungan')
                                    {{ toRupiah($totalJumlahPemasukanTabungan) }}
                                @elseif($bank->jenis == 'MAHAD')
                                    {{ toRupiah($totalJumlahPemasukanMahad) }}
                                @endif
                            </td>

                            <td class="border border-black text-xs p-1">

                                @if (isset($totalJumlahPengeluaran[$key + 1]))
                                    {{ toRupiah($totalJumlahPengeluaran[$key + 1]) }}
                                @else
                                    -
                                @endif


                            </td>
                            <td class="border border-black text-xs p-1">

                                @if (isset($totalJumlahPengeluaran[$key + 1]))
                                    @if ($bank->jenis == 'DPP')
                                        {{ toRupiah($totalJumlahPemasukanDpp + $totalSaldoAwalPemasukanDpp - $totalJumlahPengeluaran[$key + 1]) }}
                                    @elseif($bank->jenis == 'SPP')
                                        {{ toRupiah($totalJumlahPemasukanSpp + $totalSaldoAwalPemasukanSpp - $totalJumlahPengeluaran[$key + 1]) }}
                                    @elseif($bank->jenis == 'Tabungan')
                                        {{ toRupiah($totalJumlahPemasukanTabungan + $totalSaldoAwalPemasukanTabungan) }}
                                    @elseif($bank->jenis == 'MAHAD')
                                        {{ toRupiah($totalJumlahPemasukanMahad + $totalSaldoAwalPemasukanMahad - $totalJumlahPengeluaran[$key + 1]) }}
                                    @endif
                                @else
                                    @if ($bank->jenis == 'DPP')
                                        {{ toRupiah($totalJumlahPemasukanDpp + $totalSaldoAwalPemasukanDpp) }}
                                    @elseif($bank->jenis == 'SPP')
                                        {{ toRupiah($totalJumlahPemasukanSpp + $totalSaldoAwalPemasukanSpp) }}
                                    @elseif($bank->jenis == 'Tabungan')
                                        {{ toRupiah($totalJumlahPemasukanTabungan + $totalSaldoAwalPemasukanTabungan) }}
                                    @elseif($bank->jenis == 'MAHAD')
                                        {{ toRupiah($totalJumlahPemasukanMahad + $totalSaldoAwalPemasukanMahad) }}
                                    @endif
                                @endif
                            </td>


                        </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" class="border border-black text-xs p-1">TOTAL</td>
                        <td class="border border-black text-xs p-1">{{ toRupiah($totalJumlahSaldoAwal) }}</td>
                        <td class="border border-black text-xs p-1">{{ toRupiah($totalSemuaPemasukan) }}</td>
                        <td class="border border-black text-xs p-1">{{ toRupiah($totalSemuaPengeluaran) }}</td>
                        <td class="border border-black text-xs p-1">
                            {{ toRupiah($totalJumlahSaldoAwal + $totalSemuaPemasukan + $totalSemuaPengeluaran) }}</td>
                    </tr>


                </tbody>


            </table>



            @if ($bankName == 'all' || $bankName == 'semua bank')
                <h1 class="text-left py-4">DEMIKIAN BERITA ACARA PENUTUPAN BUKU KAS UMUM INI DIBUAT, UNTUK DIPERGUNAKAN
                    SEBAGAIMANA
                    MESTINYA, DAN APABILA ADA KEKELIRUAN AKAN DITINJAU KEMBALI.
                </h1>
            @else
                <h1 class="text-left py-4">DEMIKIAN BERITA ACARA PENUTUPAN {{ strtoupper($bankName) }} INI DIBUAT,
                    UNTUK DIPERGUNAKAN
                    SEBAGAIMANA
                    MESTINYA, DAN APABILA ADA KEKELIRUAN AKAN DITINJAU KEMBALI.
                </h1>
            @endif



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


    <div id="printPembukuan" class="hidden">
        <div style="font-family: 'Times New Roman', Times, serif;">
            <div class="flex justify-between items-center py-4 px-9 mx-5">
                <img src="{{ asset('images/logo_warna.png') }}" alt="logo man" class="w-25 h-25">
                <div class="justify-center items-center text-align-center text-center mr-9 pr-9">
                    <h1 class="text-xl font-bold">KOMITE MADRASAH ALIYAH NEGERI TLOGO</h1>
                    <h1 class="text-xl font-bold">KECAMATAN KANIGORO KABUPATEN BLITAR</h1>
                    <h1>Jl. Raya Gaprang PO BOX 113 No. 32 Kanigoro Blitar</h1>
                    <h1>No. Telp (0332)804047</h1>
                </div>
            </div>
            <div class="h-2 bg-gray-900 mb-4">
                <hr>
            </div>
            <div class="text-center mb-4">
                @if ($bankName == 'all' || $bankName == 'semua bank')
                    <h1 class="font-bold">BUKU KAS UMUM</h1>
                @else
                    <h1 class="font-bold">BUKU KAS {{ strtoupper($bankName) }}</h1>
                @endif

                <h1 class="font-bold">KOMITE MAN 1 KABUPATEN BLITAR TAHUN AJARAN
                    {{ $selectedYear - 1 }}/{{ $selectedYear }}</h1>

                @if ($selectedMonth != 'semua bulan')
                    @php
                        $monthsIndonesian = [
                            1 => 'Januari',
                            2 => 'Februari',
                            3 => 'Maret',
                            4 => 'April',
                            5 => 'Mei',
                            6 => 'Juni',
                            7 => 'Juli',
                            8 => 'Agustus',
                            9 => 'September',
                            10 => 'Oktober',
                            11 => 'November',
                            12 => 'Desember',
                        ];
                    @endphp
                    <h1 class="font-bold">BULAN {{ strtoupper($monthsIndonesian[$selectedMonth]) }}
                        {{ $selectedYear }}</h1>
                @endif

            </div>



            @if ($selectedBank == null || $selectedBank == 'semua bank')
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-300"
                    style="width:100%; border-collapse: collapse;">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-300">
                        <tr>
                            <th rowspan="2" style="text-align: center !important; border: 1px solid gray;">NO</th>
                            <th rowspan="2" style="border: 1px solid gray;">Nama Kegiatan</th>

                            <th colspan="4"
                                style="text-align: center !important ;background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray;">
                                Pemasukan
                            </th>
                            <th colspan="4"
                                style="text-align: center !important ;background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray;">
                                Pengeluaran
                            </th>

                            <th rowspan="2" style="text-align:center;border: 1px solid gray;">Saldo Kas</th>
                        </tr>
                        <tr>
                            <th
                                style="text-align:center; background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray; font-size: smaller;">
                                Infaq</th>
                            <th
                                style="text-align:center; background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray; font-size: smaller;">
                                Tabungan</th>
                            <th
                                style="text-align:center; background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray; font-size: smaller;">
                                DPP</th>
                            <th
                                style="text-align:center; background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray; font-size: smaller;">
                                Mahad</th>
                            <th
                                style="text-align:center; background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray; font-size: smaller;">
                                Infaq</th>
                            <th
                                style="text-align:center; background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray; font-size: smaller;">
                                Tabungan</th>
                            <th
                                style="text-align:center; background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray; font-size: smaller;">
                                DPP</th>
                            <th
                                style="text-align:center; background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray; font-size: smaller;">
                                Mahad</th>
                        </tr>
                    </thead>
                    @php $currentSaldo = 0; @endphp

                    <tbody>
                        @php

                            $currentSaldo += $totalJumlahSaldoAwal;
                        @endphp
                        <tr>
                            <td style="text-align: center"><b>-</b></td>
                            <td><b>Saldo Awal</b></td>
                            <td style="font-size: smaller; border: 1px solid gray ">
                                <b>{{ toRupiah($totalSaldoAwalPemasukanDpp) }}</b></td>
                            <td style="font-size: smaller; border: 1px solid gray ">
                                <b>{{ toRupiah($totalSaldoAwalPemasukanTabungan) }}</b></td>
                            <td style="font-size: smaller; border: 1px solid gray ">
                                <b>{{ toRupiah($totalSaldoAwalPemasukanSpp) }}</b></td>
                            <td style="font-size: smaller; border: 1px solid gray ">
                                <b>{{ toRupiah($totalSaldoAwalPemasukanMahad) }}</b></td>
                            <td style="text-align: center; border: 1px solid gray "><b></b></td>
                            <td style="text-align: center; border: 1px solid gray"><b></b></td>
                            <td style="text-align: center; border: 1px solid gray"><b></b></td>
                            <td style="text-align: center;border: 1px solid gray "><b></b></td>
                            <td style="font-size: smaller; border: 1px solid gray ">
                                <b>{{ toRupiah($currentSaldo) }}</b></td>
                        </tr>

                        @foreach ($pemasukans as $pemasukan)
                            {{-- Hitung total pemasukan bulan ini --}}

                            @php
                                $pemasukanDPP = $pemasukan['totalDpp'];
                                $pemasukanTabungan = $pemasukan['totalTabungan'];
                                $pemasukanSPP = $pemasukan['totalSpp'];
                                $pemasukanMahad = $pemasukan['totalMahad'];
                                $totalPemasukan = $pemasukanDPP + $pemasukanTabungan + $pemasukanSPP + $pemasukanMahad;
                                $currentSaldo += $totalPemasukan;
                            @endphp

                            {{-- Row Saldo Bulan --}}
                            <tr style="border: 1px solid black;">
                                <td style="text-align: center; border: 1px solid black;"><b>-</b></td>
                                <td style="border: 1px solid black;"><b>Saldo Bulan {{ $pemasukan['month_name'] }}</b>
                                </td>
                                <td style="font-size: smaller; border: 1px solid black;">
                                    <b>{{ toRupiah($pemasukanDPP) }}</b></td>
                                <td style="font-size: smaller; border: 1px solid black;">
                                    <b>{{ toRupiah($pemasukanTabungan) }}</b></td>
                                <td style="font-size: smaller; border: 1px solid black;">
                                    <b>{{ toRupiah($pemasukanSPP) }}</b></td>
                                <td style="font-size: smaller; border: 1px solid black;">
                                    <b>{{ toRupiah($pemasukanMahad) }}</b></td>
                                <td style="text-align: center; border: 1px solid black;"><b></b></td>
                                <td style="text-align: center; border: 1px solid black;"><b></b></td>
                                <td style="text-align: center; border: 1px solid black;"><b></b></td>
                                <td style="text-align: center; border: 1px solid black;"><b></b></td>
                                <td style="font-size: smaller; border: 1px solid black;">
                                    <b>{{ toRupiah($currentSaldo) }}</b></td>
                            </tr>

                            {{-- Pengeluaran Bulan --}}
                            @php $counter = 1; @endphp
                            @foreach ($pengeluaranPerBank->where('month_name', $pemasukan['month_name']) as $pengeluaran)
                                @php
                                    $pengeluaranDPP =
                                        $pengeluaran->jenis_id === $banks[0]->id ? $pengeluaran->jumlah : 0;
                                    $pengeluaranTabungan =
                                        $pengeluaran->jenis_id === $banks[1]->id ? $pengeluaran->jumlah : 0;
                                    $pengeluaranSPP =
                                        $pengeluaran->jenis_id === $banks[2]->id ? $pengeluaran->jumlah : 0;
                                    $pengeluaranMahad =
                                        $pengeluaran->jenis_id === $banks[3]->id ? $pengeluaran->jumlah : 0;
                                    $totalPengeluaran = $pengeluaranDPP + $pengeluaranTabungan + $pengeluaranSPP;
                                    $currentSaldo -= $totalPengeluaran;
                                @endphp

                                <tr style="border: 1px solid black;">
                                    <td style="text-align: center; border: 1px solid black;">
                                        {{ $pengeluaran->created_at->format('d/m/Y') }}</td>
                                    <td style="font-size: smaller; border: 1px solid black;">
                                        {{ $pengeluaran->uraianKegiatan->uraian_kegiatan }}</td>
                                    <td style="text-align: center; border: 1px solid black;"></td>
                                    <td style="text-align: center; border: 1px solid black;"></td>
                                    <td style="text-align: center; border: 1px solid black;"></td>
                                    <td style="text-align: center; border: 1px solid black;"></td>
                                    {{-- Output Pengeluaran Per Jenis --}}
                                    <td style="text-align: center; font-size: smaller; border: 1px solid black;">
                                        {{ toRupiah($pengeluaranDPP) }}</td>
                                    <td style="text-align: center; font-size: smaller; border: 1px solid black;">
                                        {{ toRupiah($pengeluaranTabungan) }}</td>
                                    <td style="text-align: center; font-size: smaller; border: 1px solid black;">
                                        {{ toRupiah($pengeluaranSPP) }}</td>
                                    <td style="font-size: smaller; text-align:center; border: 1px solid black;">
                                        {{ toRupiah($pengeluaranMahad) }}</td>
                                    <td style="font-size: smaller; text-align:center; border: 1px solid black;">
                                        {{ toRupiah($currentSaldo) }}</td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @else
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-300"
                    style="width:100%; border-collapse: collapse;">
                    <thead
                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400 border-b border-gray-300">
                        <tr>
                            <th style="text-align: center !important; border: 1px solid gray;">NO</th>
                            <th style="border: 1px solid gray;">Nama Kegiatan</th>

                            <th
                                style="text-align: center !important ;background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray;">
                                Pemasukan
                            </th>
                            <th
                                style="text-align: center !important ;background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray;">
                                Pengeluaran
                            </th>

                            <th style="text-align:center; border: 1px solid gray;">Saldo Kas</th>
                        </tr>
                    </thead>

                    @php $currentSaldo = 0; @endphp
                    <tbody>
                    <tbody>
                        @php

                            if ($selectedBank == 'DPP') {
                                $totalPemasukan = $totalSaldoAwalPemasukanDpp;
                            } elseif ($selectedBank == 'SPP') {
                                $totalPemasukan = $totalSaldoAwalPemasukanSpp;
                            } elseif ($selectedBank == 'Tabungan') {
                                $totalPemasukan = $totalSaldoAwalPemasukanTabungan;
                            } elseif ($selectedBank == 'MAHAD') {
                                $totalPemasukan = $totalSaldoAwalPemasukanMahad;
                            } else {
                                $totalPemasukan = $pemasukanDPP + $pemasukanTabungan + $pemasukanSPP + $pemasukanMahad;
                            }
                            $currentSaldo += $totalPemasukan;
                        @endphp
                        <tr>
                            <td style="text-align: center"><b>-</b></td>
                            <td><b>Saldo Awal</b></td>



                            {{-- <td style="font-size: smaller; "><b>{{ toRupiah($pemasukanSPP) }}</b></td> --}}
                            @if ($selectedBank == 'DPP')
                                <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanDpp) }}</b>
                                </td>
                            @elseif($selectedBank == 'SPP')
                                <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanSpp) }}</b>
                                </td>
                            @elseif($selectedBank == 'Tabungan')
                                <td style="font-size: smaller; ">
                                    <b>{{ toRupiah($totalSaldoAwalPemasukanTabungan) }}</b>
                                </td>
                            @elseif($selectedBank == 'MAHAD')
                                <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanMahad) }}</b>
                                </td>
                            @endif
                            {{-- <td style="text-align:center; font-size: smaller;">
    
                                <b>{{ toRupiah($pemasukan->total * ($banks->where('jenis', $selectedBank)->first()->presentase / 100)) }}</b>
                            </td> --}}
                            <td style="font-size: smaller;"><b></b></td>
                            {{-- <td style="font-size: smaller;"><b>{{ toRupiah($totalJumlahSaldoAwal) }}</b> --}}
                            @if ($selectedBank == 'DPP')
                                <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanDpp) }}</b>
                                </td>
                            @elseif($selectedBank == 'SPP')
                                <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanSpp) }}</b>
                                </td>
                            @elseif($selectedBank == 'Tabungan')
                                <td style="font-size: smaller; ">
                                    <b>{{ toRupiah($totalSaldoAwalPemasukanTabungan) }}</b>
                                </td>
                            @elseif($selectedBank == 'MAHAD')
                                <td style="font-size: smaller; "><b>{{ toRupiah($totalSaldoAwalPemasukanMahad) }}</b>
                                </td>
                            @endif
                            </td>
                        </tr>
                        @foreach ($pemasukans as $pemasukan)
                            {{-- Hitung total pemasukan bulan ini --}}
                            @php
                                $pemasukanDPP = $pemasukan['totalDpp'];
                                $pemasukanTabungan = $pemasukan['totalTabungan'];
                                $pemasukanSPP = $pemasukan['totalSpp'];
                                $pemasukanMahad = $pemasukan['totalMahad'];
                                if ($selectedBank == 'DPP') {
                                    $totalPemasukan = $pemasukanDPP;
                                } elseif ($selectedBank == 'SPP') {
                                    $totalPemasukan = $pemasukanSPP;
                                } elseif ($selectedBank == 'Tabungan') {
                                    $totalPemasukan = $pemasukanTabungan;
                                } elseif ($selectedBank == 'MAHAD') {
                                    $totalPemasukan = $pemasukanMahad;
                                } else {
                                    $totalPemasukan =
                                        $pemasukanDPP + $pemasukanTabungan + $pemasukanSPP + $pemasukanMahad;
                                }
                                $currentSaldo += $totalPemasukan;
                            @endphp

                            {{-- Row Saldo Bulan --}}
                            <tr>
                                <td style="text-align: center; border: 1px solid gray;"><b>-</b></td>
                                <td style="border: 1px solid gray;"><b>Saldo Bulan {{ $pemasukan['month_name'] }}</b>
                                </td>
                                <td style="text-align: center;border: 1px solid gray;">
                                    <b>
                                        @if ($selectedBank == 'DPP')
                                            {{ toRupiah($pemasukanDPP) }}
                                        @elseif($selectedBank == 'SPP')
                                            {{ toRupiah($pemasukanSPP) }}
                                        @elseif($selectedBank == 'Tabungan')
                                            {{ toRupiah($pemasukanTabungan) }}
                                        @elseif($selectedBank == 'MAHAD')
                                            {{ toRupiah($pemasukanMahad) }}
                                        @endif
                                        {{-- {{ toRupiah($pemasukan->total * ($banks->where('jenis', $selectedBank)->first()->presentase / 100)) }} --}}

                                    </b>
                                </td>
                                <td style="text-align: center; border: 1px solid gray;"><b></b></td>
                                <td style="text-align: center; border: 1px solid gray;">
                                    <b>{{ toRupiah($currentSaldo) }}</b>
                                </td>
                            </tr>

                            {{-- Pengeluaran Bulan --}}
                            @php $counter = 1; @endphp
                            @foreach ($pengeluaranPerBank as $pengeluaran)
                                @if ($pengeluaran->month_name == $pemasukan['month_name'])
                                    @php
                                        $currentSaldo -= $pengeluaran->jumlah;
                                    @endphp
                                    <tr>
                                        <td style="border: 1px solid gray;">
                                            {{ $pengeluaran->created_at->format('d/m/Y') }}</td>
                                        <td
                                            style="border: 1px solid gray; font-size: smaller; width: 50%; word-wrap: break-word; padding-left: 10px; padding-right: 10px;">
                                            {{ $pengeluaran->uraianKegiatan->uraian_kegiatan }}</td>
                                        <td style="border: 1px solid gray;"></td>
                                        <td style="text-align: center; border: 1px solid gray;">
                                            <b>{{ toRupiah($pengeluaran->jumlah) }}</b>
                                        </td>
                                        <td style="text-align: center; border: 1px solid gray;">
                                            {{ toRupiah($currentSaldo) }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        <h1 style="font-family: 'Times New Roman', Times, serif;" class="text-left my-2 ">Pada hari ini ..........
            Buku Kas {{ $bankName == 'all' || $bankName == 'semua bank' ? 'Umum' : strtoupper($bankName) }} MAN 1
            Blitar
            Tahun Ajaran 2024/2025 </h1>
        <h1 style="font-family: 'Times New Roman', Times, serif;" class="text-left mb-2">ditutup dalam keadaan sebagai
            berikut.</h1>



        <div class="text-sm text-left text-gray-500 dark:text-gray-400">
            <table style="font-family: 'Times New Roman', Times, serif;">
                <thead>
                    <tr>
                        <th style="padding: 4px; border: 1px solid black;"></th>
                        @foreach ($banks as $bank)
                            <th style="padding: 4px; border: 1px solid black;">
                                {{ $bank->jenis == 'SPP' ? 'INFAQ' : $bank->jenis }}
                            </th>
                        @endforeach
                        <th style="padding: 4x; border: 1px solid black;">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="padding: 4px; font-weight: bold; border: 1px solid black;">SALDO AWAL</td>
                        @foreach ($banks as $bank)
                            @if ($bank->jenis == 'DPP')
                                <td style="font-size: smaller; border: 1px solid black;">
                                    {{ toRupiah($totalSaldoAwalPemasukanDpp) }}</td>
                            @elseif($bank->jenis == 'SPP')
                                <td style="font-size: smaller; border: 1px solid black;">
                                    {{ toRupiah($totalSaldoAwalPemasukanSpp) }}</td>
                            @elseif($bank->jenis == 'Tabungan')
                                <td style="font-size: smaller; border: 1px solid black;">
                                    {{ toRupiah($totalSaldoAwalPemasukanTabungan) }}</td>
                            @elseif($bank->jenis == 'MAHAD')
                                <td style="font-size: smaller; border: 1px solid black;">
                                    {{ toRupiah($totalSaldoAwalPemasukanMahad) }}</td>
                            @endif
                        @endforeach
                        <td style="padding: 4px; font-weight: bold; border: 1px solid black;">
                            {{ toRupiah($totalJumlahSaldoAwal) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px; font-weight: bold; border: 1px solid black;">PENERIMAAN</td>
                        @foreach ($banks as $bank)
                            @if ($bank->jenis == 'DPP')
                                <td style="font-size: smaller; border: 1px solid black;">
                                    {{ toRupiah($totalJumlahPemasukanDpp) }}</td>
                            @elseif($bank->jenis == 'SPP')
                                <td style="font-size: smaller; border: 1px solid black;">
                                    {{ toRupiah($totalJumlahPemasukanSpp) }}</td>
                            @elseif($bank->jenis == 'Tabungan')
                                <td style="font-size: smaller; border: 1px solid black;">
                                    {{ toRupiah($totalJumlahPemasukanTabungan) }}</td>
                            @elseif($bank->jenis == 'MAHAD')
                                <td style="font-size: smaller; border: 1px solid black;">
                                    {{ toRupiah($totalJumlahPemasukanMahad) }}</td>
                            @endif
                        @endforeach
                        <td style="padding: 4px; font-weight: bold; border: 1px solid black;">
                            {{ toRupiah($totalSemuaPemasukan) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px; font-weight: bold; border: 1px solid black;">PENGELUARAN</td>
                        @foreach ($banks->reverse() as $key => $bank)
                            @if (isset($totalJumlahPengeluaran[$banks->count() - $key]))
                                <td style="padding: 4px; font-size: smaller; border: 1px solid black;">
                                    {{ toRupiah($totalJumlahPengeluaran[$banks->count() - $key]) }}</td>
                            @else
                                <td style="padding: 4px; font-size: smaller; border: 1px solid black;">-</td>
                            @endif
                        @endforeach
                        <td style="padding: 4px; font-weight: bold; border: 1px solid black;">
                            {{ toRupiah($totalSemuaPengeluaran) }}</td>
                    </tr>
                    <tr>
                        <td style="padding: 4px; font-weight: bold; border: 1px solid black;">SALDO KAS</td>
                        @foreach ($banks as $key => $bank)
                            <td style="font-size: smaller; border: 1px solid black;">

                                {{ isset($totalJumlahPengeluaran[$bank->id])
                                    ? toRupiah(
                                        match ($bank->jenis) {
                                            'DPP' => $totalJumlahPemasukanDpp + $totalSaldoAwalPemasukanDpp - $totalJumlahPengeluaran[$bank->id],
                                            'SPP' => $totalJumlahPemasukanSpp + $totalSaldoAwalPemasukanSpp - $totalJumlahPengeluaran[$bank->id],
                                            'Tabungan' => $totalJumlahPemasukanTabungan +
                                                $totalSaldoAwalPemasukanTabungan -
                                                $totalJumlahPengeluaran[$bank->id],
                                            'MAHAD' => $totalJumlahPemasukanMahad + $totalSaldoAwalPemasukanMahad - $totalJumlahPengeluaran[$bank->id],
                                            default => 0,
                                        },
                                    )
                                    : toRupiah(
                                        match ($bank->jenis) {
                                            'DPP' => $totalJumlahPemasukanDpp,
                                            'SPP' => $totalJumlahPemasukanSpp,
                                            'Tabungan' => $totalJumlahPemasukanTabungan + $totalSaldoAwalPemasukanTabungan,
                                            'MAHAD' => $totalJumlahPemasukanMahad,
                                            default => 0,
                                        },
                                    ) }}

                            </td>
                        @endforeach
                        <td style="padding: 4px; font-weight: bold; border: 1px solid black;">
                            {{ toRupiah($totalJumlahSaldoAwal + $totalSemuaPemasukan - $totalSemuaPengeluaran) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="font-family: 'Times New Roman', Times, serif;"
            class="flex justify-between items-center mt-3 px-8 py-3">
            <div class="text-center">
                <h1 class="">MENGETAHUI,</h1>
                <h1 class="  mb-8">KETUA</h1>
                <div class="py-7"></div>

                <h1 class="">H. IMRON ROSADY</h1>
            </div>
            <div class="text-center">
                <h1 class="">BLITAR, _______________</h1>
                <h1 class="  mb-8">BENDAHARA</h1>
                <div class="py-7"></div>

                <h1 class="">PRAPTI MAHMUDAH</h1>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function() {
            $(".yearpicker").yearpicker();

            $('.dataTableClass_for_pembukuan').DataTable({
                dom: '<"flex mb-4 "<" "f> <""l>   <"flex-grow"B>> t <"row py-4"<"col-md-6"i><"col-md-6 text-end"p>>',
                stripeClasses: [],
                destroy: true,
                language: {
                    search: "Cari: ",

                },
                lengthMenu: [10, 25, 50, 100],
                pageLength: 10,
                ordering: false,

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


</div>
