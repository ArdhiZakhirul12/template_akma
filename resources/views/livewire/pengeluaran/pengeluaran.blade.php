<div>
    {{-- The Master doesn't talk, he acts. --}}
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Pengeluaran</h1>
     
        <button wire:click="openedModalForm"
      
            class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-5 inline-block me-1" viewBox="0 0 20 20"
                fill="currentColor">
                <path d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" />
            </svg>
            Pengeluaran Baru</button>
    </div>

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table class="dataTableClass w-full text-sm text-left text-gray-500 dark:text-gray-400" style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">NO</th>
                    <th>Nama Kegiatan</th>
                    <th>Kategori</th>
                    <th>Jumlah</th>
                    <th style="text-align: center !important">Tanggal</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengeluarans as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $item->id }}</td>
                        <td scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->uraianKegiatan->uraian_kegiatan }}</td>

                        {{-- <td>{{ $item->subKategoriRab->sub_kategori }}</td> --}}
                        <td>{{ $item->uraianKegiatan->subKategoriRab->kategori->kategori }}</td>
                        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ toRupiah($item->jumlah) }}</td>
                        <td style="text-align: center !important">{{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}</td>
                        <td>
                            <a href="{{ route('pengeluaran.show', $item->id) }}"
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

        @if ($openModal)
            <div id="add-pengeluaran-modal"  onclick="if (event.target === this) closeModal()"
                class="addModal fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
                <div class="p-6 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-xl  font-semibold mb-4">Tambah Pemasukan</h2>
                        <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
                    </div>
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
                        
            
                        
                        <div class="flex justify-end">
                            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                        </div>
                    </form>
            
                    
            
                </div>
            </div>
        @endif

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
    
            function closeModal() {
                location.reload();
                document.getElementById('add-pengeluaran-modal').classList.add('hidden');
            }
        
    
        </script>
</div>
