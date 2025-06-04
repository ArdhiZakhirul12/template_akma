<div>
    <div>{{ $kelas }}</div>
    <button wire:click="filterDataSiswa('11')">Change kelas</button>
    {{-- <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <h1 class="text-3xl font-bold mb-2">Detail Pemasukan</h1>
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

    <div class="grid auto-rows-min gap-4 md:grid-cols-2 w-full items-start">
        <div>
            <div class="border p-4 rounded-lg shadow-md bg-white dark:bg-zinc-700 mb-4">
                <div class="flex items-start">
                    <img src="{{ asset('images/income.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">DPP</h1>
                        <p class="text-l text-gray-500 dark:text-gray-400">{{ toRupiah($pemasukan->jumlah * ($DPP->presentase / 100)) }}</p>
                    </div>
                </div>

            </div>


            <div class="border p-4 rounded-lg shadow-md bg-white dark:bg-zinc-700 mb-4">
                <div class="flex items-start">
                    <img src="{{ asset('images/income.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">Tabungan</h1>
                        <p class="text-l text-gray-500 dark:text-gray-400">{{ toRupiah($pemasukan->jumlah * ($TABUNGAN->presentase / 100)) }}</p>
                    </div>
                </div>

            </div>

            <div class="border p-4 rounded-lg shadow-md bg-white dark:bg-zinc-700 mb-4">
                <div class="flex items-start">
                    <img src="{{ asset('images/dad.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">SPP</h1>
                        <p class="text-l text-gray-500 dark:text-gray-400">{{ toRupiah($pemasukan->jumlah * ($SPP->presentase / 100) ) }}</p>
                    </div>
                </div>

            </div>

            <div class="border p-4 rounded-lg shadow-md bg-white dark:bg-zinc-700 mb-4">
                <div class="flex items-start">
                    <img src="{{ asset('images/dad.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">Total</h1>
                        <p class="text-l text-gray-500 dark:text-gray-400">Rp.
                            {{ number_format($pemasukan->jumlah, 0, ',', '.') }}</p>
                    </div>
                </div>

            </div>
        </div>

        <div>
            <div class="p-5 bg-white dark:bg-zinc-700 border rounded-lg shadow-md mb-4">

                <div class="flex items-start">
                    <img src="{{ asset('images/dad.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">Data Siswa</h1>
                        <table>
                            <tbody>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Nama</td>
                                    <td class="px-4 py-2 text-gray-500 dark:text-gray-400">{{ $pemasukan->siswa->nama }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">No
                                        Hp</td>
                                    <td class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                        {{ $pemasukan->siswa->no_hp }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        NIS</td>
                                    <td class="px-4 py-2 text-gray-500 dark:text-gray-400">{{ $pemasukan->siswa->nis }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Kelas</td>
                                    <td class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                        {{ $pemasukan->siswa->kelas->tingkatan }} {{ $pemasukan->siswa->kelas->kelas }}
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="p-5 bg-white dark:bg-zinc-700 border rounded-lg shadow-md">
                <table>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Pembayaran Ke</td>
                            <td class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                {{ $pemasukan->pembayaranKe }}</td>
                        </tr>
                        <tr>
                            <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                Tanggal</td>
                            <td class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($pemasukan->pembayaran_bulan)->translatedFormat('M Y') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>


    </div>


    
    @if ($openModal)
        <div id="edit-pemasukan-modal"  onclick="if (event.target === this) closeModal()"
            class="addModal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
            <div id="modal-pemasukan-form"
                class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">

                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl  font-semibold mb-4">Edit Pemasukan</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
                </div>
                <form action="{{ route('pemasukan.update', $pemasukan->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center w-full mb-4">
                        <button wire:click="openedDropdown" id="dropdownSearchButton"
                            data-dropdown-toggle="dropdownSearch" data-dropdown-placement="bottom"
                            class="w-2/5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                            <div class="flex items-center justify-between w-full">
                                <span>Data Siswa </span>

                                <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                    fill="none" viewBox="0 0 10 6">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 1 4 4 4-4" />
                                </svg>
                            </div>


                        </button>
                        <div class="pr-3"></div>
                        <p>Kelas: </p>
                        <div class="pr-3"></div>
                        <div class="w-3/5">
                            <button type="button" wire:click="filterDataSiswa('10')"
                                class="w-1/4 rounded-lg  dark:bg-blue-400 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-blue-500 
                            @if ($kelas == '10') bg-green-500 dark:bg-green-500 text-white @endif">
                                10
                            </button>
                            <button type="button" wire:click="filterDataSiswa('11')"
                                class="w-1/4 rounded-lg  dark:bg-blue-400 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-blue-500 
                            @if ($kelas == '11') bg-green-500 dark:bg-green-500 text-white @endif">
                                11
                            </button>
                            <button type="button" wire:click="filterDataSiswa('12')"
                                class="w-1/4 rounded-lg  dark:bg-blue-400 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-blue-500 
                            @if ($kelas == '12') bg-green-500 dark:bg-green-500 text-white @endif">
                                12
                            </button>
                        </div>

                    </div>

           
                    @if ($openDropdown)
                        <div id="dropdownSearch"
                            class="fixed absolute z-10 bg-white rounded-lg shadow-sm w-120 dark:bg-gray-700">
                            <div class="p-3">
                                <label for="input-group-search" class="sr-only">Search</label>
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" stroke-width="2"
                                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="search" id="input-group-search" wire:model.live="search"
                                        class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Search user">
                                </div>
                            </div>

                            <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownSearchButton">
                            
                                @forelse ($data_siswas as $siswa)
                                    <li wire:click="selectSiswa({{ $siswa->id }})">
                                        <div
                                            class="flex items-center ps-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">

                                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                                                <tbody>
                                                    <tr class="cursor-pointer">
                                                        <td class="hidden idsiswa">{{ $siswa->id }}</td>
                                                        <td
                                                            class="namaSiswa px-4 py-2 font-medium text-gray-900 dark:text-white">
                                                            {{ $siswa->nama }}</td>
                                                        <td class="nisSiswa px-4 py-2 text-right">{{ $siswa->nis }}
                                                        </td>
                                                        <td class="namaKelas px-4 py-2 text-right w-15">
                                                            {{ $siswa->kelas->tingkatan }}{{ $siswa->kelas->kelas }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </li>
                                @empty
                                    <li class="text-gray-500 mt-4">Tidak ada data siswa untuk tingkatan ini.</li>
                                @endforelse
                     
                            </ul>

                        </div>
                    @endif

                    <div class="mb-4">
                        <input type="text" name="nama" id="datasiswainput" wire:model="selectedSiswaInfo"
                        class="w-3/5 mt-1 p-2 w-full border border-gray-300 rounded" required readonly>
                        <input class="hidden" name="siswa_id" id="siswa_id" wire:model="siswaId" >
                    </div>

                    <div class="mb-4">
                        <label for="jumlah" class="block text-sm font-medium text-gray-400">Jumlah</label>
                        <input type="text" name="jumlah" id="jumlah"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" value="{{ toRupiah($pemasukan->jumlah) }}" oninput="formatRupiah(this)"
                            required>
                    </div>
                    <div class="mb-4">
                        <label for="pembayaranKe" class="block text-sm font-medium text-gray-400">Pembayaran
                            Ke</label>
                        <input type="number" name="pembayaranKe" id="pembayaranKe"
                            class="mt-1 p-2 w-full border border-gray-300 rounded"
                            value="{{ $pemasukan->pembayaranKe }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="pembayaran_bulan" class="block text-sm font-medium text-gray-400">Pembayaran
                            Bulan</label>
                        <input type="month" name="pembayaran_bulan" id="pembayaran_bulan"
                            class="mt-1 p-2 w-full border border-gray-300 rounded"
                            value="{{ \Carbon\Carbon::parse($pemasukan->pembayaran_bulan)->format('Y-m') }}" required>
                    </div>
                    <div class="flex justify-end">

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    @endif


    <script>
            function formatRupiah(angka) {
            value = angka.value.replace(/\D/g, "");

            if (value === "") {
                angka.value = "";
                return "";
            }
            
            let reverse = value.split('').reverse().join('');
            let formatted = reverse.match(/\d{1,3}/g).join('.').split('').reverse().join('');
            // formatted = formatted;
            angka.value = formatted;
        }

        function closeModal() {
            location.reload();
            document.getElementById('edit-pemasukan-modal').classList.add('hidden');
        }
    </script> --}}
</div>
