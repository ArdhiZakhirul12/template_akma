<x-layouts.app :title="__('uraian')">
    <x-template.success-alert title="Sub Kategori" />
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-4">Uraian Kegiatan </h1>
        <button onclick="openModal()"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
            + Tambah
        </button>
    </div>

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table class="dataTableClass w-full text-sm text-left text-gray-500 dark:text-gray-400" style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">NO</th>
                    <th>uraian kegiatan</th>
                    <th>batas max</th>
                    <th>total pengeluaran</th>
                    <th>kategori</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($uraians as $uraian)
                    <tr data-id="{{ $uraian->id }}" data-batas="{{ $uraian->batas_max }}"
                        data-uraian="{{ $uraian->uraian_kegiatan }}"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $loop->iteration }}</td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ Str::limit($uraian->uraian_kegiatan, 50, '...') }}
                        </td>
                        <td>{{ toRupiah($uraian->batas_max) }} </td>
                        <td>{{ toRupiah($uraian->pengeluaran->sum('jumlah')) }} </td>
                        <td>{{ $uraian->subKategoriRAB?->sub_kategori }} </td>
                        <td class="space-x-2">
                            <a href="{{ route('rab.showUraian', $uraian->id) }}"
                                class="inline-block px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                Lihat
                            </a>
                            {{-- <a 
                                class="btn-edit inline-block px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                Edit
                            </a> --}}
                        </td>

                    </tr>
                @endforeach


            </tbody>
            <div id="myModal"
                class="addModal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
                <!-- Modal Content -->
                <div class="bg-white dark:bg-zinc-800 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl font-semibold">Form Tambah Data</h2>
                        <button onclick="closeModal()"
                            class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
                    </div>

                    <!-- Modal Body -->
                    <form action="{{ route('rab.uraianStore') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <input type="hidden" name="sub_kategori_id" value="{{ $id }}">
                            <label for="uraian_kegiatan" class="text-sm font-medium text-gray-700 dark:text-white">Nama
                                Kegiatan</label>
                            <input type="text" name="uraian_kegiatan" id="edit-kegiatan"
                                class="w-full border rounded px-3 py-2" />

                            <div class="flex items-center w-full">
                                <div>
                                    <label for="volume"
                                        class="text-sm font-medium text-gray-700 dark:text-white">Volume</label>
                                    <input type="number" name="volume" id="edit-maksimal"
                                        class="w-full border rounded px-3 py-2" />
                                </div>
                                <div class="mx-2"></div>
                                <div>
                                    <label for="satuan"
                                        class="text-sm font-medium text-gray-700 dark:text-white">Satuan</label>
                                    <input type="text" name="satuan" id="edit-satuan"
                                        class="w-full border rounded px-3 py-2" />
                                </div>
                            </div>

                            <label for="biaya_satuan" class="text-sm font-medium text-gray-700 dark:text-white">Biaya
                                Satuan</label>
                            <input type="text" name="biaya_satuan" id="edit-maksimal"
                                class="w-full border rounded px-3 py-2" oninput="formatRupiah(this)" />

                            <label for="batas_max" class="text-sm font-medium text-gray-700 dark:text-white">Batas
                                Maksimal</label>
                            <input type="text" name="batas_max" id="edit-maksimal"
                                class="w-full border rounded px-3 py-2" oninput="formatRupiah(this)" />

                            <label for="kegiatan"
                                class="text-sm font-medium text-gray-700 dark:text-white">Keterangan</label>
                            <input type="text" name="keterangan" id="edit-keterangan"
                                class="w-full border rounded px-3 py-2" />


                            <!-- Bisa tambah field sebanyak yang kamu mau -->
                        </div>
                        <div class="mt-6 text-right">
                            <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

        </table>

        <script>
            function openModal() {
                document.getElementById('myModal').classList.remove('hidden');
                document.getElementById('myModal').classList.add('flex');
            }

            function closeModal() {
                document.getElementById('myModal').classList.add('hidden');
                document.getElementById('myModal').classList.remove('flex');
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
            $(document).on('click', '.btn-edit', function() {
                var parent = $(this).closest('.ketegori-data');
                var kategori = parent.data('kategori');
                var id = parent.data('id');

                // Set form values
                $('#edit-kategori').val(kategori);
                $('#myModalEdit').removeClass('hidden');
                $('#myModalEdit').addClass('flex');
                $('#editForm').attr('action', '/rab/kategori/' + parent.data('id'));
            });
        </script>
</x-layouts.app>
