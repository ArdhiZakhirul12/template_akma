<x-layouts.app :title="__('Pemasukan')">
    @if (session('success'))
   
    <x-template.success-alert title="Pemasukan"/>
    <script>
     
      setTimeout(() => {
          document.getElementById('successAlert').style.display = 'none';
      }, 3000);
    </script>
    @endif
    {{-- <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Pemasukan</h1>
        <button onclick="document.getElementById('add-pemasukan-modal').classList.remove('hidden')"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block me-1" viewBox="0 0 20 20"
                fill="currentColor">
                <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" />
            </svg>
            Pemasukan Baru</button>
    </div>


    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table class="dataTableClass w-full text-sm text-left text-gray-500 dark:text-gray-400" style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">No</th>
                    <th>Nama Siswa</th>
                    <th style="text-align: center !important">Pembayaran Bulan</th>
                    <th style="text-align: center !important">Pembayaran ke</th>
                    <th style="text-align: center !important">Jumlah</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pemasukans as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $item->id }}</td>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->siswa->nama }}</th>
                        <td style="text-align: center !important">
                            {{ \Carbon\Carbon::parse($item->pembayaran_bulan)->translatedFormat(' M Y') }}</td>
                        <td style="text-align: center !important">{{ $item->pembayaranKe }}</td>
                        <td style="text-align: left !important">{{ toRupiah($item->jumlah) }}</td>

                        <td>
                            <a href="{{ route('pemasukan.show', $item->id) }}"
                                class="text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M10 3C5.58 3 2.05 6.11 1 10c1.05 3.89 4.58 7 9 7s7.95-3.11 9-7c-1.05-3.89-4.58-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>
    </div> --}}

    {{-- Create Pemasukan --}}
    {{-- <div id="add-pemasukan-modal"
        class="addModal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
        <div id="modal-pemasukan-form"
            class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">

            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl  font-semibold mb-4">Tambah Pemasukan</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
            </div>
            <form action="{{ route('pemasukan.store') }}" method="POST">
                @csrf

                <div class="flex items-center w-full mb-4">
                    <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch"
                        data-dropdown-placement="bottom"
                        class="w-2/5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">
                        <div class="flex items-center justify-between w-full">
                            <span>Data Siswa </span>
                        
                            <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 4 4 4-4" />
                            </svg>
                        </div>
                       

                    </button>
                    <div class="pr-3"></div>
                    <div class="w-3/5">
                        <button class="w-1/4 rounded-lg bg-white dark:bg-blue-400 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-blue-500">10</button>
                        <button class="w-1/4 rounded-lg bg-white dark:bg-blue-400 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-blue-500">11</button>
                        <button class="w-1/4 rounded-lg bg-white dark:bg-blue-400 py-2 cursor-pointer hover:bg-gray-100 dark:hover:bg-blue-500">12</button>
                    </div>
                  
                </div>

              
                <div id="dropdownSearch"
                    class="fixed absolute z-10 hidden bg-white rounded-lg shadow-sm w-120 dark:bg-gray-700">
                    <div class="p-3">
                        <label for="input-group-search" class="sr-only">Search</label>
                        <div class="relative">
                            <div
                                class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" id="input-group-search"
                                class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Search user">
                        </div>
                    </div>
                    <ul class="h-48 px-3 pb-3 overflow-y-auto text-sm text-gray-700 dark:text-gray-200"
                        aria-labelledby="dropdownSearchButton">
                        @foreach ($siswas as $siswa)
                            <li>
                                <div class="flex items-center ps-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">

                                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">

                                        <tbody>
                                            <tr class="cursor-pointer">
                                                <td class="hidden idsiswa">{{ $siswa->id }}</td>
                                                <td
                                                    class="namaSiswa px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $siswa->nama }}</td>
                                                <td class="nisSiswa px-4 py-2 text-right">{{ $siswa->nis }}</td>
                                                <td class="namaKelas px-4 py-2 text-right w-15">{{ $siswa->kelas->tingkatan }}{{ $siswa->kelas->kelas }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        @endforeach
                    </ul>

                </div>

                <div class="mb-4">
                    <input type="text" name="nama" id="datasiswainput"
                    class="w-3/5 mt-1 p-2 w-full border border-gray-300 rounded" required readonly>
                <input type="hidden" name="siswa_id" id="siswa_id" value="">
                </div>

                <div class="mb-4">
                    <label for="jumlah" class="block text-sm font-medium text-gray-400">Jumlah</label>
                    <input type="text" name="jumlah" id="jumlah"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required oninput="formatRupiah(this)">
                </div>
    
                <div class="mb-4">
                    <label for="pembayaran_bulan" class="block text-sm font-medium text-gray-400">Pembayaran
                        Bulan</label>
                    <input type="month" name="pembayaran_bulan" id="pembayaran_bulan"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>
                <div class="flex justify-end">

                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded cursor-pointer hover:bg-gray-100 dark:hover:bg-blue-500">Simpan</button>
                </div>
            </form>

        </div>
    </div> --}}
    <livewire:pemasukan.pemasukan/>

    {{-- <script>
        function formatRupiah(angka) {
            value = angka.value.replace(/\D/g, "");

            if (value === "") {
                angka.value = "";
                return "";
            }
            console.log(value);

            let reverse = value.split('').reverse().join('');
            let formatted = reverse.match(/\d{1,3}/g).join('.').split('').reverse().join('');
          
            angka.value = formatted;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const addModal = document.getElementById('add-pemasukan-modal')
            const addModalForm = document.getElementById('modal-pemasukan-form')
            const dropdownButton = document.getElementById('dropdownSearchButton');
            const dropdownMenu = document.getElementById('dropdownSearch');
            const searchInput = document.getElementById('input-group-search');
            const listItems = dropdownMenu.querySelectorAll('ul li');

      
            dropdownButton.addEventListener('click', function() {
                dropdownMenu.classList.toggle('hidden');
            });

    
            searchInput.addEventListener('input', function() {
                const filter = searchInput.value.toLowerCase();
                listItems.forEach(function(item) {
                    const label = item.querySelector('.namaSiswa').textContent.toLowerCase();
                    const nis = item.querySelector('.nisSiswa').textContent.toLowerCase();
                    const kelas = item.querySelector('.namaKelas').textContent.toLowerCase();
                    const combinedText = label + ' ' + nis + ' ' + kelas;
                    if (combinedText.includes(filter)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });

           
            listItems.forEach(function(item) {
                item.addEventListener('click', function() {
                    const nama = item.querySelector('.namaSiswa').textContent;
                    const nis = item.querySelector('.nisSiswa').textContent;
                    const kelas = item.querySelector('.namaKelas').textContent;
                    document.getElementById('siswa_id').value = item.querySelector('.idsiswa')
                        .textContent;
                    document.getElementById('datasiswainput').value = `${nama} - ${nis} - ${kelas}`;
                    dropdownMenu.classList.add('hidden');
                });
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (!dropdownButton.contains(event.target) && !dropdownMenu.contains(event.target)) {
                    dropdownMenu.classList.add('hidden');
                }
            });

            // Close modal when clicking outside
            addModal.addEventListener('click', function(event) {
                if (!addModalForm.contains(event.target)) {
                    addModal.classList.add('hidden');
                    l
                }
            });

        });

        function closeModal() {
            document.getElementById('add-pemasukan-modal').classList.add('hidden');
        }
    </script> --}}


</x-layouts.app>
