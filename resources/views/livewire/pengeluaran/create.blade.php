<div>
    <x-template.success-alert title="Pengeluaran"/>

    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <h1 class="text-3xl font-bold mb-2">Pengeluaran Baru</h1>
    
    </div>
    
    {{-- Nothing in the world is as soft and yielding as water. --}}
    <div class="p-4 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <form action="{{ route('pengeluaran.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="flex items-center w-full">
                <div class="mb-4 w-1/2 mr-2">
                    <label for="kategori" class="block text-sm font-medium text-gray-400">Kategori</label>
                    <select wire:model.live="selectedKategori" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        <option  class="bg-white dark:bg-zinc-700 text-black dark:text-white" value="" selected>Pilih Kategori</option>
                        @foreach ($kategoriList as $kategori)
                            <option value="{{ $kategori->id }}" 
                                class="bg-white dark:bg-zinc-700 text-black dark:text-white">
                                {{ $kategori->kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>
               
                {{-- @if (!is_null($selectedKategori)) --}}
                    <div class="mb-4 w-1/2">
                        <label for="sub_kategori" class="block text-sm font-medium text-gray-400">Sub Kategori</label>
                        <select wire:model.live="selectedSubKategori" class="mt-1 p-2 w-full border border-gray-300 rounded">
                            <option class="bg-white dark:bg-zinc-700 text-black dark:text-white" value="" selected>Pilih Sub Kategori</option>
                            @foreach ($subKategoriList as $sub)
                                <option class="bg-white dark:bg-zinc-700 text-black dark:text-white" value="{{ $sub->id }}">{{ $sub->sub_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                {{-- @endif --}}
            </div>
            

            {{-- @if (!is_null($selectedSubKategori)) --}}
                <div class="mb-4">
                    <label for="uraian_kegiatan" class="block text-sm font-medium text-gray-400">Uraian Kegiatan</label>
                    <select name="uraian_kegiatan_id" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        <option class="bg-white dark:bg-zinc-700 text-black dark:text-white" value="" selected>Pilih Uraian Kegiatan</option>
                        @foreach ($uraianKegiatanList as $item)
                            <option class="bg-white dark:bg-zinc-700 text-black dark:text-white" value="{{ $item->id }}">{{ $item->uraian_kegiatan }}</option>
                        @endforeach
                    </select>
                </div>
            {{-- @endif --}}

            <div class="flex items-center w-full">
                <div class="mb-4 w-1/2 mr-2"> 
                    <label for="sub_kategori" class="block text-sm font-medium text-gray-400">Bank</label>
                    <select name="jenis_id" class="mt-1 p-2 w-full border border-gray-300 rounded">
                        <option class="bg-white dark:bg-zinc-700 text-black dark:text-white" value="" selected>Pilih Bank</option>
                        @foreach ($bankList as $sub)
                            <option class="bg-white dark:bg-zinc-700 text-black dark:text-white" value="{{ $sub->id }}">{{ $sub->jenis }}</option>
                        @endforeach
                    </select>
                </div>
    
                <div class="mb-4 w-1/2">
                    <label for="jumlah" class="block text-sm font-medium text-gray-400">Jumlah</label>
                    <input type="text" name="jumlah" placeholder="Masukkan Jumlah"
                    class="mt-1 p-2 w-full border border-gray-300 rounded" oninput="formatRupiah(this)" required />
                </div>
            </div>

            <div class="flex items-center w-full">
                <div class="mb-4 w-1/2 mr-2">
                    <label for="keterangan" class="block text-sm font-medium text-gray-400">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" placeholder="Masukkan Keterangan"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>
                <div class="mb-4 w-1/2">
                    <label for="image" class="block text-sm font-medium text-gray-400">Upload Gambar</label>
                    <input type="file" name="dokumen" id="image" accept="image/*"
                        class="mt-1 p-2 w-full border border-gray-300 rounded">
                </div>
            </div>
            

            {{-- <div class="mb-4">
                <label for="tanggal" class="block text-sm font-medium text-gray-400">Tanggal</label>
                <input type="date" name="tanggal" id="tanggal"
                    class="mt-1 p-2 w-full border border-gray-300 rounded" required>
            </div> --}}
            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
            </div>
        </form>

        

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
    </script>
</div>
