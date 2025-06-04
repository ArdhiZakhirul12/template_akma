<div>
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}



    <x-template.success-alert title="Siswa" />

    </script>
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <div class="flex items-center">
            <h1 class="text-3xl font-bold mr-4">Data Siswa</h1>
            <button wire:click="$set('showNextGradeModal', true)"
            class="focus:outline-none text-white cursor-pointer bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block me-1" viewBox="0 0 20 20"
                fill="currentColor">
                <path fill-rule="evenodd"
                    d="M3.293 9.707a1 1 0 011.414 0L10 4.414l5.293 5.293a1 1 0 001.414-1.414l-6-6a1 1 0 00-1.414 0l-6 6a1 1 0 010 1.414z"
                    clip-rule="evenodd" />
            </svg>
            Naik Kelas</button>
        </div>
        
       <div>
       
    <button wire:click="openedModalForm"
        class="focus:outline-none cursor-pointer text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block me-1" viewBox="0 0 20 20"
            fill="currentColor">
            <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" />
        </svg>
        Siswa Baru</button>
       </div>
    </div>
    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table wire:ignore.self
            class="dataTableClass w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">No</th>
                    <th>Nama</th>
                    <th scope="row" style="text-align: center !important">Kelas</th>
                    <th scope="row" style="text-align: center !important">Status</th>
                    <th scope="row" style="text-align: center !important">nis</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswas as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $loop->iteration }}</td>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->nama }}</th>
                        <td scope="row" style="text-align: center !important" >{{ $item->kelas?->tingkatan }}{{ $item->kelas?->kelas }}</td>
                        <td scope="row" style="text-align: center !important" >
                            @if ($item->status === 'lulus')
                                <span class="px-4 py-1 text-sm font-medium text-white bg-green-500 rounded-full">
                                    Lulus
                                </span>
                            @elseif ($item->status === 'aktif')
                                <span class="px-4 py-1 text-sm font-medium text-white bg-blue-500 rounded-full">
                                    Aktif
                                </span>
                            @elseif ($item->status === 'tidak-aktif')
                                <span class="px-4 py-1 text-sm font-medium text-white bg-red-500 rounded-full">
                                    Tidak Aktif
                                </span>
                            @else
                                <span class="px-4 py-1 text-sm font-medium text-white bg-gray-500 rounded-full">
                                    {{ $item->status }}
                                </span>
                            @endif
                        </td>
                        <td scope="row" style="text-align: center !important">{{ $item->nis }}</td>

                        <td scope="row" style="text-align: center !important">
                            <a href="{{ route('pages.siswa.show', $item->id) }}"
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
    </div>
    @if ($showNextGradeModal)
        <div   onclick="if (event.target === this) closeModal()" class="addModal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg max-w-sm w-full">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200 mb-4">Konfirmasi</h2>
                <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">Yakin akan menaikkan semua siswa ke kelas
                    berikutnya?</p>
                <div class="flex justify-end space-x-2">
                    <button onclick="closeModal()"
                        class="px-4 py-2 text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white">
                        Kembali
                    </button>
                    <button wire:click="nextGrade"
                        class="px-4 py-2 text-sm bg-green-600 hover:bg-green-700 text-white rounded-md">
                        Yakin
                    </button>
                </div>
            </div>
        </div>
    @endif


    @if ($openModal)
        <div id="add-siswa-modal"
            class="addModal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30"
            onclick="if (event.target === this) closeModal()">
            <div class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">
                <h2 class="text-xl  font-semibold mb-4">Tambah Siswa</h2>
                <form action="{{ route('pages.siswa.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-400">Nama</label>
                        <input type="text" name="nama" id="nama"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    </div>
                    <div class="flex items-center w-full">
                        <div class="mb-4 w-1/4 mr-2">
                            <label for="tingkat" class="block text-sm font-medium text-gray-400">Tingkat</label>
                            <select wire:model.live="selectedkelas" name="tingkat" id="tingkat" required
                                class="mt-1 p-2 w-full border border-gray-300 rounded bg-white text-gray-900 dark:bg-zinc-800 dark:text-gray-200 dark:border-gray-600">
                                <option value="">Pilih Tingkat</option>
                                @foreach ($data_kelas as $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 w-1/4 mr-2">
                            <label for="kode_kelas" class="block text-sm font-medium text-gray-400">Tipe Kelas</label>
                            <select name="kode_kelas" id="kode_kelas" required
                                class="mt-1 p-2 w-full border border-gray-300 rounded bg-white text-gray-900 dark:bg-zinc-800 dark:text-gray-200 dark:border-gray-600">
                                <option value="">Pilih Tipe</option>
                                @foreach ($jenis_kelas as $item)
                                    <option value="{{ $item->kelas }}">{{ $item->kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4 w-2/4">
                            <label for="nis" class="block text-sm font-medium text-gray-400">NIS</label>
                            <input type="number" name="nis" id="nis"
                                class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                        </div>
                    </div>
                    <div class="flex items-center w-full">
                        <div class="mb-4 w-1/2 mr-2">
                            <label for="no_hp" class="block text-sm font-medium text-gray-400">No Hp</label>
                            <input type="number" name="no_hp" id="no_hp"
                                class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                        </div>
                        <div class="mb-4 w-1/2">
                            <label for="no_hp_wali" class="block text-sm font-medium text-gray-400">No HP Wali</label>
                            <input type="number" name="no_hp_wali" id="no_hp_wali"
                                class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="nama_ayah" class="block text-sm font-medium text-gray-400">Nama Ayah</label>
                        <input type="text" name="nama_ayah" id="nama_ayah"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4">
                        <label for="nama_ibu" class="block text-sm font-medium text-gray-400">Nama Ibu</label>
                        <input type="text" name="nama_ibu" id="nama_ibu"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    </div>


                    <div class="mb-4 w-full">

                        <div class="flex items-center">

                            <div class="mx-4">
                                <img id="image-preview" src="{{ asset('images/photo_dark.png') }}" alt="Preview"
                                    class="w-30 h-30 object-cover rounded dark:hidden">
                                <img id="image-preview-dark" src="{{ asset('images/photo_light.png') }}"
                                    alt="Preview" class="w-30 h-30 object-cover rounded hidden dark:block">
                            </div>
                            <div>
                                <label for="foto" class="block text-sm font-medium text-gray-400">Foto</label>
                                <input type="file" name="image" id="foto" accept="image/*"
                                    class="mt-1 p-2 w-full border border-gray-300 rounded"
                                    onchange="previewImage(event)">
                            </div>

                        </div>
                    </div>



                    <div class="flex items-center justify-end mt-4">
                        <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded mr-2"
                            onclick="closeModal()">Kembali</button>

                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                    </div>


                </form>
            </div>
        </div>
    @endif
    <script>
        function previewImage(event) {
            const input = event.target;
            const preview = document.getElementById('image-preview');
            const previewDark = document.getElementById('image-preview-dark');
            const file = input.files[0];


            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    previewDark.src = e.target.result;
                };
                reader.readAsDataURL(file);
            } else {
                preview.src = '#';
                previewDark.src = '#';
            }
        }
        window.closeModal = function() {
            location.reload();
            document.getElementById('add-siswa-modal').classList.add('hidden');

        }
    </script>



</div>
