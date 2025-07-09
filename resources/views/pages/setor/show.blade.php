<x-layouts.app :title="__('show')">

    <x-slot name="header">
        <h1 class="text-2xl font-semibold text-gray-800 dark:text-gray-200">
            {{ __('Setor Tunai') }}
        </h1>
    </x-slot>

    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-4">Detail Setor Tunai </h1>
        <button onclick="openModal()"
            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
            Edit Data
        </button>
    </div>

    <div class="flex items-start mb-4 w-full">
        <div class="w-3/5 items-ceter p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
            <div class="flex items-start mb-4">
                <img src="{{ asset('images/dad.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                <div class="w-full">
                    <h1 class="text-l font-bold mb-2">Data Setor Tunai</h1>
                    <table class="table-auto w-full text-left  mb-4">
                        <tbody>
                            <tr>
                                <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-400">Nama</th>
                                <td class="px-4 py-2">{{ $setorTunai->nama_setoran }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-400">Jumlah</th>
                                <td class="px-4 py-2">{{ toRupiah($setorTunai->jumlah)}}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-400">Tanggal Setoran
                                </th>
                                <td class="px-4 py-2">{{ $setorTunai->tanggal_setoran }}</td>
                            </tr>
                            <tr>
                                <th class="px-4 py-2 font-semibold text-gray-600 dark:text-gray-400">Keterangan</th>
                                <td class="px-4 py-2">{{ $setorTunai->keterangan }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <div class="mx-4"></div>
        <div class="w-2/5 items-ceter p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
            <div class="flex items-start mb-4">
                <img src="{{ asset('images/dad.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                <div class="w-full">
                    <h1 class="text-l font-bold mb-2">Dokumen</h1>
                    @if ($setorTunai->image)
                        <img onclick="openImage()" src="{{ asset('storage/' . $setorTunai->image) }}" alt="Setor Image"
                            class="w-32 h-32 rounded-lg mt-4 cursor-pointer">
                    @endif
                </div>
            </div>

        </div>

    </div>

    <div id="myModalEdit" class="addModal fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <!-- Modal Content -->
        <div class="bg-white dark:bg-zinc-800 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Edit Setor Data</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('setor.update', $setorTunai->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <div>
                        <label for="nama_setoran" class="block text-sm font-medium text-gray-400">Nama Setoran</label>
                        <input type="text" name="nama_setoran" id="nama_setoran" value="{{ $setorTunai->nama_setoran }}" placeholder="Masukkan Nama Setoran" class="w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label for="jumlah" class="block text-sm font-medium text-gray-400">Jumlah</label>
                        <input type="text" name="jumlah" id="jumlah" value="{{ number_format($setorTunai->jumlah, 0, ',', '.') }}" oninput="formatRupiah(this)" placeholder="Masukkan Jumlah" class="w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-400">Keterangan</label>
                        <input type="text" name="keterangan" id="keterangan" value="{{ $setorTunai->keterangan }}" placeholder="Masukkan Keterangan" class="w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label for="tanggal_setoran" class="block text-sm font-medium text-gray-400">Tanggal Setoran</label>
                        <input type="date" name="tanggal_setoran" value="{{ $setorTunai->tanggal_setoran }}" id="tanggal_setoran" placeholder="Masukkan Tanggal Setoran" class="w-full border rounded px-3 py-2" />
                    </div>
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-400">Gambar</label>
                        <input type="file" name="image" id="image" class="w-full border rounded px-3 py-2" />
                    </div>
                    
                    <!-- Bisa tambah field sebanyak yang kamu mau -->
                </div>
                <div class="mt-6 text-right">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    
        <div id="open-image" onclick="if (event.target === this) closeModal()"
            class="addModal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
            <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-4 ">
                <img src="{{ asset('storage/' . $setorTunai->image) }}" alt="Dokumen"
                    class="max-w-200 max-h-120 object-cover">
                <button onclick="closeModal()"
                    class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Tutup</button>
            </div>
        </div>
 

    <script>
        function closeModal() {
            document.getElementById('myModalEdit').classList.add('hidden');
            document.getElementById('open-image').classList.add('hidden');
        }
        function openModal() {
            document.getElementById('myModalEdit').classList.remove('hidden');
        }
        function openImage() {
            document.getElementById('open-image').classList.remove('hidden');
        }

        function formatRupiah(angka) {
            value = angka.value.replace(/\D/g, "");

            if (value === "") {
                angka.value = "";
                return "";
            }
            console.log(value);

            let reverse = value.split('').reverse().join('');
            let formatted = reverse.match(/\d{1,3}/g).join('.').split('').reverse().join('');
            // formatted = formatted;
            angka.value = formatted;
        }
    </script>
</x-layouts.app>
