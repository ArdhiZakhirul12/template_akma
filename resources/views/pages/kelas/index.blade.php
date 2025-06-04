<x-layouts.app :title="__('Kelas')">
   
    @if (session('success'))
   
      <x-template.success-alert title="Kelas"/>
      <script>
       
        setTimeout(() => {
            document.getElementById('successAlert').style.display = 'none';
        }, 3000);
    </script>
    @endif
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Kelas</h1>
    <div>
     <button onclick="document.getElementById('edit-harga-modal').classList.remove('hidden')"
     class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 cursor-pointer">
     SPP Kelas</button>
    <button onclick="document.getElementById('add-kelas-modal').classList.remove('hidden')"
     class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800 cursor-pointer">
     <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-5 inline-block me-1" viewBox="0 0 20 20"
         fill="currentColor">
         <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" />
     </svg>
     Kelas Baru</button>
       </div>
    </div>

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table class="dataTableClass w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">No</th>
                    <th style="text-align: center !important">Tingkatan</th>
                    <th style="text-align: center !important">Kelas</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($kelas as $item)
                    <tr data-id="{{ $item->id }}" data-tingkatan="{{ $item->tingkatan }}"
                        data-kelas="{{ $item->kelas }}"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $loop->iteration }}</td>
                        <th scope="row" style="text-align: center !important"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->tingkatan }}</th>
                        <td style="text-align: center !important">{{ $item->kelas }}</td>
                        <td class="flex justify-center">
                            <button class="btn-edit mr-6" style="text-align: center !important"
                                data-target="#edit-kelas-modal" id="edit-icon-button"
                                class="text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-yellow-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.707.414l-4 1a1 1 0 01-1.265-1.265l1-4a2 2 0 01.414-.707l10-10a2 2 0 012.828 0zm-2.828 2.828L4 16l-1 4 4-1 10.586-10.586-2.828-2.828z" />
                                </svg>
                            </button>
                            <a href="{{ route('kelas.siswa_kelas_list', $item->id) }}"
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
    <div id="add-kelas-modal"
        class="addModal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30"
        onclick="if (event.target === this) this.classList.add('hidden')">
        <div class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">
            <h2 class="text-xl  font-semibold mb-4">Tambah Kelas</h2>
            <form action="{{ route('kelas.store') }}" method="POST">
                @csrf

                <div class="flex items-center w-full">
                    <div class="mb-4 w-1/2 mr-2">
                        <label for="tingkatan" class="block text-sm font-medium text-gray-400">Tingkatan</label>
                        <select name="tingkatan" id="tingkatan" required
                            class="mt-1 p-2 w-full border border-gray-300 rounded bg-white text-gray-900 dark:bg-zinc-800 dark:text-gray-200 dark:border-gray-600">
                            <option value="">Pilih Tingkat</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="mb-4 w-1/2 mr-2">


                        <label for="kelas" class="block text-sm font-medium text-gray-400">Kelas</label>
                        <input type="text" name="kelas" id="kelas"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>

                    </div>

                </div>
                <div class="flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded mr-2"
                        onclick="document.getElementById('add-kelas-modal').classList.add('hidden')">Kembali</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div id="edit-harga-modal"
        class="addModal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30"
        onclick="if (event.target === this) this.classList.add('hidden')">
        <div class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">
            <h2 class="text-xl  font-semibold mb-4">Harga SPP Pertingkat</h2>
            <form action="{{ route('kelas.updateSpp1') }}" method="POST">
                @csrf
                @method('PUT')
                @foreach ($hargas as $index => $item)
                    <div class="flex w-full mb-4 space-x-4">
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-gray-600">Tingkatan</label>
                            <input type="text" name="tingkatan[{{ $index }}]" readonly
                                value="{{ $item->tingkatan }}" class="mt-1 p-2 w-full border border-gray-300 rounded"
                                required>
                            <input type="hidden" name="id[{{ $index }}]" value="{{ $item->id }}">
                        </div>
                        <div class="w-1/2">
                            <label class="block text-sm font-medium text-gray-600">SPP</label>
                            <input type="text" name="jumlah[{{ $index }}]"
                                value="{{  number_format(old('spp.' . $index, $item->jumlah ?? ''), 0, ',', '.')  }}" required oninput="formatRupiah(this)"
                                class="mt-1 p-2 w-full border border-gray-300 rounded" required min="0"
                                step="1">
                        </div>
                    </div>
                @endforeach
                <div class="flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded mr-2"
                        onclick="document.getElementById('edit-harga-modal').classList.add('hidden')">Kembali</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <div id="edit-kelas-modal"
        class="addModal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30"
        onclick="if (event.target === this) this.classList.add('hidden')">
        <div class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">
            <h2 class="text-xl  font-semibold mb-4">Edit Kelas</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="flex items-center w-full">
                    <div class="mb-4 w-1/2 mr-2">
                        <input type="text" name="id" id="id" hidden>
                        <label for="edit-tingkatan" class="block text-sm font-medium text-gray-400">Tingkatan</label>
                        <select name="tingkatan" id="edit-tingkatan" required
                            class="mt-1 p-2 w-full border border-gray-300 rounded bg-white text-gray-900 dark:bg-zinc-800 dark:text-gray-200 dark:border-gray-600">
                            <option value="">Pilih Tingkat</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                        </select>
                    </div>
                    <div class="mb-4 w-1/2 mr-2">

                        <label for="edit-kelas" class="block text-sm font-medium text-gray-400">Kelas</label>
                        <input type="text" name="kelas" id="edit-kelas"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    </div>

                </div>
                <div class="flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded mr-2"
                        onclick="document.getElementById('edit-kelas-modal').classList.add('hidden')">Kembali</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
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
            

            let reverse = value.split('').reverse().join('');
            let formatted = reverse.match(/\d{1,3}/g).join('.').split('').reverse().join('');
     
            angka.value = formatted;
        }
        $(document).on('click', '.btn-edit', function() {
            var row = $(this).closest('tr');
            $('#id').val(row.data('id'));
            $('#edit-tingkatan').val(row.data('tingkatan'));
            $('#edit-kelas').val(row.data('kelas'));
            $('#edit-kelas-modal').removeClass('hidden');
            $('#editForm').attr('action', '/kelas/' + row.data('id'));
        });

    </script>
</x-layouts.app>
