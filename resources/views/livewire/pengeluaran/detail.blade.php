<div>

    <x-template.success-alert title="Pengeluaran" />

    {{-- Because she competes with no one, no one can compete with her. --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <h1 class="text-3xl font-bold mb-2">Detail Pengeluaran</h1>
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



    {{-- <div class="flex items-ceter p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md mb-4">
        <div class="grid auto-rows-min gap-4 md:grid-cols-4 w-full">
            <div class="border p-4 rounded-lg shadow-md">
                <div class="flex items-start">
                    <img src="{{ asset('images/income.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">DPP</h1>
                        <p class="text-l text-gray-500 dark:text-gray-400">Rp. 200000</p>
                    </div>
                </div>

            </div>


            <div class="border p-4 rounded-lg shadow-md">
                <div class="flex items-start">
                    <img src="{{ asset('images/income.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">Tabungan</h1>
                        <p class="text-l text-gray-500 dark:text-gray-400">Rp. 200000</p>
                    </div>
                </div>

            </div>

            <div class="border p-4 rounded-lg shadow-md">
                <div class="flex items-start">
                    <img src="{{ asset('images/dad.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">SPP</h1>
                        <p class="text-l text-gray-500 dark:text-gray-400">Rp. 200000</p>
                    </div>
                </div>

            </div>

            <div class="border p-4 rounded-lg shadow-md">
                <div class="flex items-start">
                    <img src="{{ asset('images/dad.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">Total</h1>
                        <p class="text-l text-gray-500 dark:text-gray-400">{{ $pengeluaran->jumlah }}</p>
                    </div>
                </div>

            </div>
        </div>
    </div> --}}


    <div class="grid auto-rows-min gap-4 md:grid-cols-2 w-full items-start">
        <div class="p-9 bg-white dark:bg-zinc-700 rounded-lg shadow-md">

            <div class="border p-4 rounded-lg">
                <div class="flex items-start mb-4">
                    <img src="{{ asset('images/Initiate Money Transfer.svg') }}" alt="Saldo Akhir"
                        class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">Detail Pengeluaran</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400"></p>
                    </div>
                </div>
                <div>
                    <table>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Kategori</td>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                    {{ $pengeluaran->uraianKegiatan->subKategoriRab->kategori->kategori }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">Sub
                                    Kategori</td>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                    {{ $pengeluaran->uraianKegiatan->subKategoriRab->sub_kategori }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">Nama
                                    Kegiatan</td>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                    {{ $pengeluaran->uraianKegiatan->uraian_kegiatan }}</td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Keterangan</td>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">{{ $pengeluaran->keterangan }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Tanggal</td>
                                <td class="px-4 py-2 text-gray-500 dark:text-gray-400">
                                    {{ \Carbon\Carbon::parse($pengeluaran->tanggal)->translatedFormat('d M Y') }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

        <div>
            <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md mb-4">
                <div class="border p-4 rounded-lg flex items-center shadow-md justify-between">
                    <div class="flex items-start">
                        <img src="{{ asset('images/saldoakhir.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                        <div>
                            <h1 class="text-l font-bold mb-2">Total</h1>
                            <p class="text-l text-gray-500 dark:text-gray-400">{{ toRupiah($pengeluaran->jumlah) }}</p>
                        </div>
                    </div>
                    <div class="px-4 py-2 bg-blue-100 rounded-lg shadow-md">
                        <h1 class="text-blue-700 font-bold">{{ $pengeluaran->bank->jenis }}</h1>
                    </div>

                </div>
            </div>

            <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">

                <div class="border p-4 rounded-lg">
                    <div class="flex items-start mb-4" >
                        <img src="{{ asset('images/saldoakhir.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                        <div>
                            <h1 class="text-l font-bold mb-2">Dokumen</h1>
                            <img wire:click="openImageSpending" src="{{ asset('storage/' . $pengeluaran->dokumen) }}" alt="Dokumen"
                                class="w-32 h-32 object-cover cursor-pointer rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300">
                        </div>
                    </div>

                </div>

            </div>
        </div>


    </div>
    @if ($openImage)
        <div id="open-image" onclick="if (event.target === this) @this.closeImageSpending()" 
        class="addModal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
            <div class="bg-white dark:bg-zinc-700 rounded-lg shadow-md p-4 ">
                <img src="{{ asset('storage/' . $pengeluaran->dokumen) }}" alt="Dokumen"
                     class="max-w-200 max-h-120 object-cover">
                <button wire:click="closeImageSpending"
                    class="mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Tutup</button>
            </div>
        </div>
    @endif


    @if ($openModal)
        <div id="add-pemasukan-modal" onclick="if (event.target === this) closeModal()"
            class="addModal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
            <div class="p-4 bg-white dark:bg-zinc-700 rounded-lg shadow-md w-full max-w-2xl">
                <h1 class="text-xl font-bold mb-4">Edit Pengeluaran Data</h1>
                <form action="{{ route('pengeluaran.update', $pengeluaran->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="flex items-center w-full">
                        <div class="mb-4 w-1/2 mr-2">
                            <label for="kategori" class="block text-sm font-medium text-gray-400">Kategori</label>
                            <select wire:model.live="selectedKategori"
                                class="mt-1 p-2 w-full border border-gray-300 rounded">
                                <option value="" selected>Pilih Kategori</option>
                                @foreach ($kategoriList as $kategori)
                                    <option value="{{ $kategori->id }}">{{ $kategori->kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- @if (!is_null($selectedKategori)) --}}
                        <div class="mb-4 w-1/2">
                            <label for="sub_kategori" class="block text-sm font-medium text-gray-400">Sub
                                Kategori</label>
                            <select wire:model.live="selectedSubKategori"
                                class="mt-1 p-2 w-full border border-gray-300 rounded">
                                <option value="" selected>Pilih Sub Kategori</option>
                                @foreach ($subKategoriList as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->sub_kategori }}</option>
                                @endforeach
                            </select>
                        </div>
                        {{-- @endif --}}
                    </div>

                    <div class="flex items-center w-full">

                        <div class="mb-4 w-1/2 mr-2">
                            <label for="uraian_kegiatan" class="block text-sm font-medium text-gray-400">Uraian
                                Kegiatan</label>
                            <select wire:model.live="selectedUraianKegiatan" name="uraian_kegiatan_id"
                                class="mt-1 p-2 w-full border border-gray-300 rounded">
                                <option value="" selected>Pilih Uraian Kegiatan</option>
                                @foreach ($uraianKegiatanList as $item)
                                    <option value="{{ $item->id }}">{{ $item->uraian_kegiatan }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-4 w-1/2">
                            <label for="sub_kategori" class="block text-sm font-medium text-gray-400">Bank</label>
                            <select wire:model.live="selectedBank" name="jenis_id"
                                class="mt-1 p-2 w-full border border-gray-300 rounded">
                                <option value="" selected>Pilih Bank</option>
                                @foreach ($bankList as $sub)
                                    <option value="{{ $sub->id }}">{{ $sub->jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>


                    <div class="flex items-center w-full">


                        <div class="mb-4 w-1/2 mr-2">
                            <label for="jumlah" class="block text-sm font-medium text-gray-400">Jumlah</label>
                            {{-- <input type="number" name="jumlah" id="jumlah" value="{{ $pengeluaran->jumlah }}"
                                class="mt-1 p-2 w-full border border-gray-300 rounded" required> --}}
                            <input type="text" name="jumlah" id="edit-maksimal"
                                value="{{ number_format($pengeluaran->jumlah, 0, ',', '.') }}"
                                class="w-full border rounded px-3 py-2" oninput="formatRupiah(this)" required />
                        </div>
                        <div class="mb-4 w-1/2">
                            <label for="keterangan" class="block text-sm font-medium text-gray-400">Keterangan</label>
                            <input type="text" name="keterangan" id="keterangan"
                                value="{{ $pengeluaran->keterangan }}"
                                class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                        </div>
                    </div>

                    <div class="flex items-center w-full justify-between">

                        <div class="mb-4 w-1/2">
                            <label for="image" class="block text-sm font-medium text-gray-400">Upload
                                Gambar</label>
                            <input type="file" name="dokumen" id="image" accept="image/*"
                                class="mt-1 p-2 w-full border border-gray-300 rounded">
                        </div>

                        <div class="flex items-center">
                            <div class="flex justify-end mr-2">
                                <button onclick="closeModal()"
                                    class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">Kembali</button>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Simpan</button>
                            </div>
                        </div>

                    </div>

                </form>

            </div>
        </div>
    @endif

    <script>
        function closeModal() {
            document.getElementById('add-pemasukan-modal').classList.add('hidden');
            document.getElementById('open-image').classList.add('hidden');
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

</div>
