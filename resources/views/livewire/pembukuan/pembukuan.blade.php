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
                    <option value="semua bank">Semua Bank</option>

                    @foreach ($banks as $bank)
                        <option value="{{ $bank->jenis }}">{{ $bank->jenis }}</option>
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
        </div>
    </div>


    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">

        @if ($selectedBank == null || $selectedBank == 'semua bank')
            <table class="dataTableClass_for_pembukuan w-full text-sm text-left text-gray-500 dark:text-gray-400"
                style="width:100%">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th rowspan="2" style="text-align: center !important">NO</th>
                        <th rowspan="2">Nama Kegiatan</th>

                        <th colspan="3"
                            style="text-align: center !important ;background-color: rgba(121, 233, 121, 0.431);">
                            Pemasukan
                        </th>
                        <th colspan="3"
                            style="text-align: center !important ;background-color:  rgba(255, 166, 0, 0.532);">
                            Pengeluaran
                        </th>

                        <th rowspan="2">Saldo Kas</th>
                    </tr>
                    <tr>

                        <th style="background-color: rgba(121, 233, 121, 0.431);">Infaq</th>
                        <th style="background-color:  rgba(121, 233, 121, 0.431);">Tabungan</th>
                        <th style="background-color:  rgba(121, 233, 121, 0.431);">DPP</th>
                        <th style="background-color:  rgba(255, 166, 0, 0.532);">Infaq</th>
                        <th style="background-color: rgba(255, 166, 0, 0.532);">Tabungan</th>
                        <th style="background-color:  rgba(255, 166, 0, 0.532);">DPP</th>

                    </tr>
                </thead>
                @php $currentSaldo = 0; @endphp

                <tbody>
                    @foreach ($pemasukans as $pemasukan)
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
                        @foreach ($pengeluarans->where('month_name', $pemasukan->month_name) as $pengeluaran)
                            @php
                                $pengeluaranDPP = $pengeluaran->jenis_id === $banks[0]->id ? $pengeluaran->jumlah : 0;
                                $pengeluaranTabungan =
                                    $pengeluaran->jenis_id === $banks[1]->id ? $pengeluaran->jumlah : 0;
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
        @else
            <table class="dataTableClass_for_pembukuan w-full text-sm text-left text-gray-500 dark:text-gray-400"
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
                    @foreach ($pemasukans as $pemasukan)
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
                            <td style="text-align:center">
                                <b>{{ toRupiah($pemasukan->total * ($banks->where('jenis', $selectedBank)->first()->presentase / 100)) }}</b>
                            </td>
                            <td style="text-align: center"><b></b></td>
                            <td style="text-align:center"><b>{{ toRupiah($currentSaldo) }}</b></td>
                        </tr>

                        {{-- Pengeluaran Bulan --}}
                        @php $counter = 1; @endphp
                        @foreach ($pengeluaranPerBank as $pengeluaran)
                            @if ($pengeluaran->month_name == $pemasukan->month_name)
                                @php
                                    $currentSaldo -= $pengeluaran->jumlah;
                                @endphp
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $pengeluaran->uraianKegiatan->uraian_kegiatan }}</td>
                                    <td></td>
                                    <td style="text-align: center;"><b>{{ toRupiah($pengeluaran->jumlah) }}</b></td>
                                    <td style="text-align: center;">{{ toRupiah($currentSaldo) }}</td>
                                </tr>
                            @endif
                        @endforeach
                    @endforeach
                    {{-- @foreach ($pemasukans as $pemasukan)
                  
                    @php
                        $pemasukanDPP = $pemasukan->total * ($banks[0]->presentase / 100);
                        $pemasukanTabungan = $pemasukan->total * ($banks[1]->presentase / 100);
                        $pemasukanSPP = $pemasukan->total * ($banks[2]->presentase / 100);
                        $totalPemasukan = $pemasukanDPP + $pemasukanTabungan + $pemasukanSPP;
                        $currentSaldo += $totalPemasukan;
                    @endphp

                   
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

                   
                    @php $counter = 1; @endphp
                    @foreach ($pengeluarans->where('month_name', $pemasukan->month_name) as $pengeluaran)
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

                           
                            <td style="text-align: center">{{ toRupiah($pengeluaranDPP) }}</td>
                            <td style="text-align: center">{{ toRupiah($pengeluaranTabungan) }}</td>
                            <td style="text-align: center">{{ toRupiah($pengeluaranSPP) }}</td>

                            <td>{{ toRupiah($currentSaldo) }}</td>
                        </tr>
                    @endforeach
                @endforeach --}}
                </tbody>


            </table>
        @endif

    </div>


    <div id="printPembukuan" class="hidden">
        <div style="font-family: 'Times New Roman', Times, serif;">
            <div class="flex justify-between items-center py-4 px-9 mx-5">
                <img src="{{ asset('images/akse.png') }}" alt="logo man" class="w-25 h-25">
                <div class="justify-center items-center text-align-center text-center mr-9 pr-9">
                    <h1 class="text-xl font-bold">KOMITE MADRASAH/SEKOLAH NEGERI</h1>
                    <h1 class="text-xl font-bold">KECAMATAN ..... KOTA/KABUPATEN ....</h1>
                    <h1>Jl. .... Alamat lengkap sekolah</h1>
                    <h1>No. Telp (0332)80xxxxx</h1>
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

                <h1 class="font-bold">KOMITE MADRASAH/SEKOLAH TAHUN AJARAN
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

                            <th colspan="3"
                                style="text-align: center !important ;background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray;">
                                Pemasukan
                            </th>
                            <th colspan="3"
                                style="text-align: center !important ;background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray;">
                                Pengeluaran
                            </th>

                            <th rowspan="2" style="text-align:center;border: 1px solid gray;">Saldo Kas</th>
                        </tr>
                        <tr>
                            <th
                                style="text-align:center; background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray;">
                                Infaq</th>
                            <th
                                style="text-align:center; background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray;">
                                Tabungan
                            </th>
                            <th
                                style="text-align:center; background-color: rgba(121, 233, 121, 0.431); border: 1px solid gray;">
                                DPP</th>
                            <th
                                style="text-align:center; background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray;">
                                Infaq</th>
                            <th
                                style="text-align:center; background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray;">
                                Tabungan
                            </th>
                            <th
                                style="text-align:center; background-color: rgba(255, 166, 0, 0.532); border: 1px solid gray;">
                                DPP</th>
                        </tr>
                    </thead>
                    @php $currentSaldo = 0; @endphp

                    <tbody>
                        @foreach ($pemasukans as $pemasukan)
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
                                <td style="text-align: center; border: 1px solid gray;"><b>-</b></td>
                                <td style="border: 1px solid gray;"><b>Saldo Bulan {{ $pemasukan->month_name }}</b>
                                </td>
                                <td style="text-align:center ;border: 1px solid gray;">
                                    <b>{{ toRupiah($pemasukanDPP) }}</b>
                                </td>
                                <td style="text-align:center ;border: 1px solid gray;">
                                    <b>{{ toRupiah($pemasukanTabungan) }}</b>
                                </td>
                                <td style="text-align:center ;border: 1px solid gray;">
                                    <b>{{ toRupiah($pemasukanSPP) }}</b>
                                </td>
                                <td style="text-align: center; border: 1px solid gray;"><b></b></td>
                                <td style="text-align: center; border: 1px solid gray;"><b></b></td>
                                <td style="text-align: center; border: 1px solid gray;"><b></b></td>
                                <td style="padding-left:10px ;border: 1px solid gray;">
                                    <b>{{ toRupiah($currentSaldo) }}</b>
                                </td>
                            </tr>

                            {{-- Pengeluaran Bulan --}}
                            @php $counter = 1; @endphp
                            @foreach ($pengeluarans->where('month_name', $pemasukan->month_name) as $pengeluaran)
                                @php
                                    $pengeluaranDPP =
                                        $pengeluaran->jenis_id === $banks[0]->id ? $pengeluaran->jumlah : 0;
                                    $pengeluaranTabungan =
                                        $pengeluaran->jenis_id === $banks[1]->id ? $pengeluaran->jumlah : 0;
                                    $pengeluaranSPP =
                                        $pengeluaran->jenis_id === $banks[2]->id ? $pengeluaran->jumlah : 0;
                                    $totalPengeluaran = $pengeluaranDPP + $pengeluaranTabungan + $pengeluaranSPP;
                                    $currentSaldo -= $totalPengeluaran;
                                @endphp

                                <tr>
                                    <td style="text-align: center; border: 1px solid gray;">{{ $counter++ }}</td>
                                    <td style="border: 1px solid gray;">
                                        {{ $pengeluaran->uraianKegiatan->uraian_kegiatan }}</td>
                                    <td style="text-align: center; border: 1px solid gray;"></td>
                                    <td style="text-align: center; border: 1px solid gray;"></td>
                                    <td style="text-align: center; border: 1px solid gray;"></td>

                                    {{-- Output Pengeluaran Per Jenis --}}
                                    <td style="text-align: center; border: 1px solid gray;">
                                        {{ toRupiah($pengeluaranDPP) }}</td>
                                    <td style="text-align: center; border: 1px solid gray;">
                                        {{ toRupiah($pengeluaranTabungan) }}</td>
                                    <td style="text-align: center; border: 1px solid gray;">
                                        {{ toRupiah($pengeluaranSPP) }}</td>

                                    <td style="padding-left:10px ;border: 1px solid gray;">
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
                        @foreach ($pemasukans as $pemasukan)
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
                                <td style="text-align: center; border: 1px solid gray;"><b>-</b></td>
                                <td style="border: 1px solid gray;"><b>Saldo Bulan {{ $pemasukan->month_name }}</b>
                                </td>
                                <td style="text-align: center;border: 1px solid gray;">
                                    <b>{{ toRupiah($pemasukan->total * ($banks->where('jenis', $selectedBank)->first()->presentase / 100)) }}</b>
                                </td>
                                <td style="text-align: center; border: 1px solid gray;"><b></b></td>
                                <td style="text-align: center; border: 1px solid gray;">
                                    <b>{{ toRupiah($currentSaldo) }}</b>
                                </td>
                            </tr>

                            {{-- Pengeluaran Bulan --}}
                            @php $counter = 1; @endphp
                            @foreach ($pengeluaranPerBank as $pengeluaran)
                                {{ $pengeluaran->month_name }} {{ $pemasukan->month_name }}
                                @if ($pengeluaran->month_name == $pemasukan->month_name)
                                    @php
                                        $currentSaldo -= $pengeluaran->jumlah;
                                    @endphp
                                    <tr>
                                        <td style="border: 1px solid gray;">{{ $loop->iteration }}</td>
                                        <td style="border: 1px solid gray;">
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
        <h1 class="text-left my-2 ">Pada hari ini .......... Buku Kas Umum Tahun Ajaran 2024/2025 </h1>
        <h1 class="text-left mb-2">ditutup dalam keadaan sebagai berikut.</h1>

        <table class="text-sm text-left text-gray-500 dark:text-gray-400 border border-gray-300">
            <tbody>
                <tr>
                    <td style="border: 1px solid gray; padding: 4px; font-weight: bold;">PENERIMAAN</td>
                    <td style="border: 1px solid gray; padding: 4px;"></td>
                </tr>
                @foreach ($banks->reverse() as $bank)
                    <tr>
                        @if ($bank->jenis == 'SPP')
                            <td style="border: 1px solid gray; padding: 4px; ">Infaq</td>
                        @else
                            <td style="border: 1px solid gray; padding: 4px; ">{{ $bank->jenis }}</td>
                        @endif
                        <td style="border: 1px solid gray; padding: 4px;">
                            {{ toRupiah($totalJumlahPemasukan * ($bank->presentase / 100)) }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td style="border: 1px solid gray; padding: 4px; font-weight: bold;">Jumlah</td>
                    <td style="border: 1px solid gray; padding: 4px; font-weight: bold;">{{ toRupiah($totalJumlahPemasukan) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid gray; padding: 4px; font-weight: bold;">PENGELUARAN</td>
                    <td style="border: 1px solid gray; padding: 4px;"></td>
                </tr>
                @foreach ($banks->reverse() as $key => $bank)
                    <tr>
                        @if ($bank->jenis == 'SPP')
                            <td style="border: 1px solid gray; padding: 4px; ">Infaq</td>
                        @else
                            <td style="border: 1px solid gray; padding: 4px; ">{{ $bank->jenis }}</td>
                        @endif
                        @if (isset($totalJumlahPengeluaran[$banks->count() - $key]))
                            <td style="border: 1px solid gray; padding: 4px;">
                                {{ toRupiah($totalJumlahPengeluaran[$banks->count() - $key]) }}</td>
                        @else
                            <td style="border: 1px solid gray; padding: 4px;">-</td>
                        @endif  
                    </tr>
                @endforeach
                <tr>
                    <td style="border: 1px solid gray; padding: 4px; font-weight: bold;">Jumlah</td>
                    <td style="border: 1px solid gray; padding: 4px; font-weight: bold;">{{ toRupiah($totalSemuaPengeluaran) }}</td>
                </tr>
                <tr>
                    <td style="border: 1px solid gray; padding: 4px; font-weight: bold;">SALDO KAS</td>
                    <td style="border: 1px solid gray; padding: 4px;"></td>
                </tr>
                @foreach ($banks->reverse() as $key => $bank)
                    <tr>
                        @if ($bank->jenis == 'SPP')
                            <td style="border: 1px solid gray; padding: 4px; ">Infaq</td>
                        @else
                            <td style="border: 1px solid gray; padding: 4px; ">{{ $bank->jenis }}</td>
                        @endif
             
                        @if (isset($totalJumlahPengeluaran[$banks->count() - $key]))
                            <td style="border: 1px solid gray; padding: 4px;">
                                {{ toRupiah(($totalJumlahPemasukan * ($bank->presentase / 100)) - ($totalJumlahPengeluaran[$banks->count() - $key])) }}</td>
                        @else
                            <td style="border: 1px solid gray; padding: 4px;">{{ toRupiah($totalJumlahPemasukan * ($bank->presentase / 100)) }}</td>
                        @endif  
                    </tr>
                @endforeach
                <tr>
                    <td style="border: 1px solid gray; padding: 4px; font-weight: bold;">Jumlah</td>
                    <td style="border: 1px solid gray; padding: 4px; font-weight: bold;">{{ toRupiah($totalJumlahPemasukan - $totalSemuaPengeluaran ) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="flex justify-between items-center mt-3 px-8 py-3">
            <div class="text-center">
                <h1 class="">MENGETAHUI,</h1>
                <h1 class="  mb-8">KETUA</h1>
                <div class="py-7"></div>

                <h1 class="">NAMA LENGKAP</h1>
            </div>
            <div class="text-center">
                <h1 class="">KOTA/KABUPATEN, _______________</h1>
                <h1 class="  mb-8">BENDAHARA</h1>
                <div class="py-7"></div>

                <h1 class="">NAMA LENGKAP</h1>
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
