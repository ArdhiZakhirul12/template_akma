<x-layouts.app :title="__('RAB')">
    <x-template.success-alert title="Uraian"/>
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-4">Detail Uraian Kegiatan</h1>

        <x-template.button-with-icon title="Edit" color="blue"
            onclick="document.getElementById('myModalEdit').classList.remove('hidden')"
            icon="<path fill='currentColor' d='M4 13.25V16h2.75l8.086-8.086-2.75-2.75L4 13.25zm10.414-7.414l1.336-1.336a1 1 0 011.414 0l1.336 1.336a1 1 0 010 1.414l-1.336 1.336-2.75-2.75z' />" />
        {{-- <button onclick="document.getElementById('myModalEdit').classList.remove('hidden')"
            class="btn-edit bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
            Edit
        </button> --}}
    </div>



    <div class="uraianketegori-data grid auto-rows-min gap-4 md:grid-cols-2 w-full items-start"
        data-kategori="{{ $uraian->uraian_kegiatan }}" data-id="{{ $uraian->id }}">
        <div class="flex items-start border p-4 rounded-lg shadow-md bg-white dark:bg-zinc-700 mb-4">
            <img src="{{ asset('images/Details.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
            <div>
                <h1 class="text-xl font-bold mb-2">Uraian Data</h1>
                <table>

                    <tbody>

                        <tr>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Nama
                                Kegiatan</td>
                            <td class="text-l text-gray-500 dark:text-gray-400">{{ $uraian->uraian_kegiatan }} </td>

                        </tr>

                        <tr>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Volume
                            </td>
                            <td class="text-l text-gray-500 dark:text-gray-400">{{ $uraian->volume }} </td>

                        </tr>

                        <tr>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Satuan
                            </td>
                            <td class="text-l text-gray-500 dark:text-gray-400">{{ $uraian->satuan }}</td>

                        </tr>

                        <tr>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Biaya
                                Satuan</td>
                            <td class="text-l text-gray-500 dark:text-gray-400">{{ toRupiah($uraian->biaya_satuan) }} </td>

                        </tr>

                        <tr>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Batas
                                Maksimal</td>
                            <td class="text-l text-gray-500 dark:text-gray-400">{{ toRupiah($uraian->batas_max) }} </td>

                        </tr>

                        <tr>
                            <td scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Keterangan
                            </td>

                            <td class="text-l text-gray-500 dark:text-gray-400">{{ $uraian->keterangan }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div class="justify-end">
            <div class="flex items-start border p-4 rounded-lg shadow-md bg-white dark:bg-zinc-700 mb-4">
            <img src="{{ asset('images/pembukuan.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
            <div>
                <h1 class="text-xl font-bold mb-2">Detail Bagian</h1>
                <table>
                <tbody>
                    <tr>
                    <td scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Kelompok
                        Pengeluaran</td>
                    <td class="text-l text-gray-500 dark:text-gray-400">
                        {{ $uraian->subKategoriRab->sub_kategori }} </td>
                    </tr>
                    <tr>
                    <td scope="row"
                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">Kategori
                    </td>
                    <td class="text-l text-gray-500 dark:text-gray-400">
                        {{ $uraian->subKategoriRab->kategori->kategori }} </td>
                    </tr>
                </tbody>
                </table>
            </div>
            </div>
            <div class="border p-4 rounded-lg shadow-md bg-white dark:bg-zinc-700">
                <table class="w-full text-left">
                    <tbody>
                        <tr>
                            <td class="text-gray-500 dark:text-gray-400">Total Pengeluaran</td>
                            <td class="font-bold justify-between flex">
                                <h1>{{ toRupiah($total) }}</h1>
                                <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $status === 'Normal' ? 'green' : ($status === 'Mendekati batas maksimal' ? 'yellow' : ($status === 'Mencapai batas maksimal' ? 'orange' : 'red')) }};"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-3"></td>
                        </tr>
                        <tr>
                            <td class="text-gray-500 dark:text-gray-400">Status Pengeluaran</td>
                            <td class="font-bold">{{ $status }}</td>
                        </tr>
                    </tbody>
                </table>
         
            </div>
        </div>
   
       
    </div>


    <div id="myModalEdit"
        class="addModal flex fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50"
        onclick="if (event.target === this) this.classList.add('hidden')">
        <!-- Modal Content -->
        <div class="bg-white dark:bg-zinc-800 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Form Edit Data</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('rab.uraianUpdate', $uraian->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="space-y-4">
                    <label for="uraian_kegiatan" class="text-sm font-medium text-gray-700 dark:text-white">Nama
                        Kegiatan</label>
                    <input type="text" name="uraian_kegiatan" id="edit-kegiatan"
                        value="{{ $uraian->uraian_kegiatan }} " class="w-full border rounded px-3 py-2" />

                    <div class="flex items-center w-full">
                        <div>
                            <label for="volume"
                                class="text-sm font-medium text-gray-700 dark:text-white">Volume</label>
                            <input type="number" name="volume" id="edit-maksimal" value="{{ $uraian->volume }}"
                                class="w-full border rounded px-3 py-2" />
                        </div>
                        <div class="mx-2"></div>
                        <div>
                            <label for="satuan"
                                class="text-sm font-medium text-gray-700 dark:text-white">Satuan</label>
                            <input type="text" name="satuan" id="edit-satuan" value="{{ $uraian->satuan }}"
                                class="w-full border rounded px-3 py-2" />
                        </div>
                    </div>

                    <label for="biaya_satuan" class="text-sm font-medium text-gray-700 dark:text-white">Biaya
                        Satuan</label>
                    <input type="text" name="biaya_satuan" id="edit-maksimal"
                        value="{{ number_format($uraian->biaya_satuan, 0, ',', '.') }}"
                        class="w-full border rounded px-3 py-2" oninput="formatRupiah(this)" />

                    <label for="batas_max" class="text-sm font-medium text-gray-700 dark:text-white">Batas
                        Maksimal</label>
                    <input type="text" name="batas_max" id="edit-maksimal" value="{{  number_format($uraian->batas_max, 0, ',', '.')  }}"
                        class="w-full border rounded px-3 py-2" oninput="formatRupiah(this)"/>

                    <label for="kegiatan" class="text-sm font-medium text-gray-700 dark:text-white">Keterangan</label>
                    <input type="text" name="keterangan" id="edit-keterangan" value="{{ $uraian->keterangan }}"
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


    <script>
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

        function closeModal() {
            document.getElementById('myModalEdit').classList.add('hidden');
            document.getElementById('myModalEdit').classList.remove('flex');
        }
    </script>





</x-layouts.app>
