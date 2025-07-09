<x-layouts.app :title="__('Setor Tunai')">


    <div class="flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Setor Tunai Komite</h1>
        

        <button onclick="document.getElementById('add-pemasukan-modal').classList.remove('hidden')"
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block me-1" viewBox="0 0 20 20"
                fill="currentColor">
                <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" />
            </svg>
            Setoran Baru</button>
    </div>

    <div class="grid auto-rows-min gap-4 md:grid-cols-4 mb-4">
        <x-dashboard.dashboard-card-02 
        title="Penerimaan" 
        :total=$totalPenerimaan :desk="2025" :image="asset('images/income.svg')"/>
    
        <x-dashboard.dashboard-card-02
        title="Setor Tunai" 
        :total=$totalSetorTunai :desk="2025" :image="asset('images/spending.svg')"/>
        
    </div>
    

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table class="dataTableClass w-full text-sm text-left text-gray-500 dark:text-gray-400"
            style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">NO</th>
                    <th class="dt-orderable-none">Nama Setoran</th>
                    <th>Teller</th>
                    <th>Jumlah</th>
                    <th style="text-align: center !important">Tanggal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($setorTunai as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $item->id }}</td>
                        <td scope="row"
                            class="px-2 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white"
                            >
                           
                                {{ $item->nama_setoran }}
                         
                        </td>

                        
                        <td>{{ $item->user->name}}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ toRupiah($item->jumlah) }}</td>
                        <td style="text-align: center !important">{{ \Carbon\Carbon::parse($item->tanggal_setoran)->translatedFormat('d M Y') }}</td>
                        <td>
                            <a href="{{ route('setor.show', $item->id) }}"
                                class="text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M10 3C5.58 3 2.05 6.11 1 10c1.05 3.89 4.58 7 9 7s7.95-3.11 9-7c-1.05-3.89-4.58-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                </svg>

                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>
    </div>


    <div id="add-pemasukan-modal"  onclick="if (event.target === this) closeModal()"
        class="addModal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
        <div id="modal-pemasukan-form"
            class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">
            <form action="{{ route('setor.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl  font-semibold mb-4">Setoran Baru</h2>
                    <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
                </div>

                
                <div class="mb-4 hidden">
               
                    <input type="text" name="user_id" id="user_id" value="{{ auth()->user()->id }}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required >
                </div>

                <div class="mb-4">
                    <label for="nama_setoran" class="block text-sm font-medium text-gray-400">Nama Setoran</label>
                    <input type="text" name="nama_setoran" id="nama_setoran"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required >
                </div>

              <div class="flex">
                <div class="mb-4 w-1/2">
                    <label for="tanggal_setoran" class="block text-sm font-medium text-gray-400">Tanggal</label>
                    <input type="date" name="tanggal_setoran" id="tanggal_setoran"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>
                <div class="p-2"></div>
                <div class="mb-4 w-1/2">
                    <label for="jumlah" class="block text-sm font-medium text-gray-400">Jumlah</label>
                    <input type="text" name="jumlah" id="jumlah"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required oninput="formatRupiah(this)">
                </div>
              </div>

                <div class="mb-4">
                    <label for="keterangan" class="block text-sm font-medium text-gray-400">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan"
                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                </div>
                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-400">Upload Gambar</label>
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                </div>

                <div class="flex justify-end">
                    <button type="button" onclick="closeModal()"
                        class="px-4 py-2 mr-2 bg-gray-300 text-gray-700 rounded cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-500 text-white rounded cursor-pointer hover:bg-gray-100 dark:hover:bg-blue-500">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $('.yearpicker').yearpicker();

         function formatRupiah(angka) {
        value = angka.value.replace(/\D/g, "");

        if (value === "") {
            angka.value = "";
            return "";
        }


        let reverse = value.split('').reverse().join('');
        let formatted = reverse.match(/\d{1,3}/g).join('.').split('').reverse().join('');

        angka.value = formatted;
    }
        function closeModal() {
            // location.reload();
            document.getElementById('add-pemasukan-modal').classList.add('hidden');
        }
    </script>




</x-layouts.app>
