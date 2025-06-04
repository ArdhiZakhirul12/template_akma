<x-layouts.app :title="__('Pemasukan Baru')">

    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <h1 class="text-3xl font-bold mb-2">Pemasukan Baru</h1>

    </div>

    <div id="add-pemasukan-modal" class="flex items-center justify-center "
        >
        <div class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">
            <h2 class="text-xl  font-semibold mb-4">Tambah Pemasukan</h2>
            <form action="{{ route('pemasukan.store') }}" method="POST">
                @csrf

                <div class="flex items-center w-full mb-4">
                    <button id="dropdownSearchButton" data-dropdown-toggle="dropdownSearch"
                        data-dropdown-placement="bottom"
                        class="w-2/5 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                        type="button">Data Siswa <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>

                    </button>
                    <div class="pr-2"></div>
                    <input type="text" name="nama" id="datasiswainput"
                        class="w-3/5 mt-1 p-2 w-full border border-gray-300 rounded" required>
                    <input type="hidden" name="siswa_id" id="siswa_id" value="">
                </div>

                <!-- Dropdown menu -->
                <div id="dropdownSearch" class="fixed absolute z-10 hidden bg-white rounded-lg shadow-sm w-120 dark:bg-gray-700">
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
                        @foreach($siswas as $siswa)
                        <li>
                            <div class="flex items-center ps-2 rounded-sm hover:bg-gray-100 dark:hover:bg-gray-600">

                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                
                                    <tbody>
                                        <tr class="cursor-pointer">
                                            <td class="hidden idsiswa" >{{ $siswa->id }}</td>
                                            <td class="namaSiswa px-4 py-2 font-medium text-gray-900 dark:text-white">{{ $siswa->nama }}</td>
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
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const dropdownButton = document.getElementById('dropdownSearchButton');
                        const dropdownMenu = document.getElementById('dropdownSearch');
                        const searchInput = document.getElementById('input-group-search');
                        const listItems = dropdownMenu.querySelectorAll('ul li');

                        // Toggle dropdown visibility
                        dropdownButton.addEventListener('click', function() {
                            dropdownMenu.classList.toggle('hidden');
                        });

                        // Filter list items based on search input
                        searchInput.addEventListener('input', function() {
                            const filter = searchInput.value.toLowerCase();
                            listItems.forEach(function(item) {
                                const label = item.querySelector('td').textContent.toLowerCase();
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

                        // Update input field with selected option
                        listItems.forEach(function(item) {
                            item.addEventListener('click', function() {
                                const nama = item.querySelector('.namaSiswa').textContent;
                                const nis = item.querySelector('.nisSiswa').textContent;
                                const kelas = item.querySelector('.namaKelas').textContent;
                                document.getElementById('siswa_id').value = item.querySelector('.idsiswa').textContent;
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



                    });
                </script>


                <div class="mb-4">
                    <label for="jumlah" class="block text-sm font-medium text-gray-400">Jumlah</label>
                    <input type="number" name="jumlah" id="jumlah"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>
                {{-- <div class="mb-4">
                    <label for="pembayaranKe" class="block text-sm font-medium text-gray-400">Pembayaran Ke</label>
                    <input type="number" name="pembayaranKe" id="pembayaranKe"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div> --}}
                <div class="mb-4">
                    <label for="pembayaran_bulan" class="block text-sm font-medium text-gray-400">Pembayaran Bulan</label>
                    <input type="date" name="pembayaran_bulan" id="pembayaran_bulan" class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>
                <div class="flex justify-end">
                   
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                </div>
            </form>

        </div>
    </div>

</x-layouts.app>
