<x-layouts.app :title="__('Detail Siswa')">
    <livewire:siswa.detail>
    {{-- <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Detail Siswa</h1>
    </div>

    <div class="flex items-center p-5 justify-between bg-white dark:bg-zinc-700 rounded-lg shadow-md mb-4">
        <div class="flex items-center">
            <img class="w-30 rounded-sm mr-4" src="{{ asset('images/profile-empty.png') }}" alt="Default avatar">
            <div>
                <h1 class="text-2xl font-bold mb-2">{{ $dataSiswa->nama }}</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-2">NIS : {{ $dataSiswa->nis }}</p>
                <p class="text-sm text-gray-500 dark:text-gray-400">Kelas :
                    {{ $dataSiswa->kelas->tingkatan }}{{ $dataSiswa->kelas->kelas }}</p>
            </div>
        </div> 
        <div class="flex items-center justify-center h-full p-4">
            <x-template.button-with-icon title="Edit" color="blue" onclick="document.getElementById('update-siswa-modal').classList.remove('hidden')" icon="<path fill='currentColor' d='M12.3 2.3a1 1 0 011.4 0l2 2a1 1 0 010 1.4l-9 9-3 1a1 1 0 01-1.3-1.3l1-3 9-9zm-8.1 9.7l1.6 1.6 8.5-8.5-1.6-1.6-8.5 8.5zm-.7 2.7l1.4-1.4-1.6-1.6-1.4 1.4-.3 1.1 1.1-.3z'/>" />
        </div>
    </div>

    <div class="flex items-ceter p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3 w-full">
            <div class="border p-4 rounded-lg shadow-md">
                <div class="flex items-start mb-4">
                    <img src="{{ asset('images/dad.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">Nama Ayah</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $dataSiswa->nama_ayah }}</p>
                    </div>
                </div>

            </div>

            <div class="border p-4 rounded-lg shadow-md">
                <div class="flex items-start mb-4">
                    <img src="{{ asset('images/mom.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">Nama Ibu</h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $dataSiswa->nama_ibu }}</p>
                    </div>
                </div>

            </div>
            <div class="border p-4 rounded-lg shadow-md">
                <div class="flex items-center mb-4 justify-between">
                    <div class="flex items-start">
                        <img src="{{ asset('images/phone.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                        <div>
                            <h1 class="text-l font-bold mb-2">No Hp Wali</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $dataSiswa->no_hp_wali }}</p>
                        </div>
                    </div>


                    <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                        Copy
                    </button>
                </div>

            </div>
            <div class="border p-4 rounded-lg shadow-md">
                <div class="flex items-center mb-4 justify-between">
                    <div class="flex items-start">
                        <img src="{{ asset('images/phone_second.svg') }}" alt="Saldo Akhir"
                            class="w-7 object-cover mr-2">
                        <div>
                            <h1 class="text-l font-bold mb-2">No Hp Siswa</h1>
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $dataSiswa->no_hp }}</p>
                        </div>
                    </div>


                    <button class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                        Copy
                    </button>
                </div>

            </div>
            <div class="border p-4 rounded-lg shadow-md">
                <div class="flex items-start mb-4">
                    <img src="{{ asset('images/Address.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
                    <div>
                        <h1 class="text-l font-bold mb-2">Alamat </h1>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $dataSiswa->nama_ayah }}</p>
                    </div>
                </div>

            </div>



        </div>
    </div>




    <div id="update-siswa-modal"
        class="addModal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30"
        onclick="if (event.target === this) this.classList.add('hidden')">
        <div class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">
            <h2 class="text-xl  font-semibold mb-4">Update Siswa</h2>
            <form action="{{ route('pages.siswa.update', $dataSiswa->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium text-gray-400">Nama</label>
                    <input type="text" name="nama" id="nama" value="{{ $dataSiswa->nama }}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>
               

                <div class="flex items-center w-full">
                    <div class="mb-4 w-1/4 mr-2">
                        <label for="tingkat" class="block text-sm font-medium text-gray-400">Tingkat</label>
                        <select name="tingkat" id="tingkat" required
                            class="mt-1 p-2 w-full border border-gray-300 rounded bg-white text-gray-900 dark:bg-zinc-800 dark:text-gray-200 dark:border-gray-600">
                            <option value="">Pilih Tingkat</option>
                            @foreach($kelas as $item)
                            <option value="{{ $item->id }}" {{ $dataSiswa->kelas->id == $item->id ? 'selected' : '' }}>
                                {{ $item->tingkatan }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 w-1/4 mr-2">
                        <label for="kode_kelas" class="block text-sm font-medium text-gray-400">Tipe Kelas</label>
                        <select name="kode_kelas" id="kode_kelas" required
                            class="mt-1 p-2 w-full border border-gray-300 rounded bg-white text-gray-900 dark:bg-zinc-800 dark:text-gray-200 dark:border-gray-600">
                            <option value="">Pilih Tipe</option>
                            @foreach($kelas as $item)
                            <option value="{{ $item->id }}" {{ $dataSiswa->kelas->id == $item->id ? 'selected' : '' }}>
                                {{ $item->kelas }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4 w-2/4">
                        <label for="nis" class="block text-sm font-medium text-gray-400">NIS</label>
                        <input type="text" name="nis" id="nis" value="{{ $dataSiswa->nis }}"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    </div>
                </div>
                
           
                <div class="flex items-center w-full">
                    <div class="mb-4 w-1/2 mr-2">
                        <label for="no_hp" class="block text-sm font-medium text-gray-400">No Hp</label>
                        <input type="text" name="no_hp" id="no_hp" value="{{ $dataSiswa->no_hp }}"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    </div>
                    <div class="mb-4 w-1/2">
                        <label for="no_hp_wali" class="block text-sm font-medium text-gray-400">No HP Wali</label>
                        <input type="text" name="no_hp_wali" id="no_hp_wali" value="{{ $dataSiswa->no_hp_wali }}"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label for="nama_ayah" class="block text-sm font-medium text-gray-400">Nama Ayah</label>
                    <input type="text" name="nama_ayah" id="nama_ayah"  value="{{ $dataSiswa->nama_ayah }}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="nama_ibu" class="block text-sm font-medium text-gray-400">Nama Ibu</label>
                    <input type="text" name="nama_ibu" id="nama_ibu" value="{{ $dataSiswa->nama_ibu }}"
                        class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                </div>
        
                <div class="flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded mr-2"
                        onclick="document.getElementById('update-siswa-modal').classList.add('hidden')">Kembali</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                </div>
            </form>
    
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const copyButtons = document.querySelectorAll('button');

            copyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const textToCopy = this.previousElementSibling.querySelector('p').innerText;
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        alert('Copied: ' + textToCopy);
                    }).catch(err => {
                        console.error('Error copying text: ', err);
                    });
                });
            });
        });
    </script> --}}
</x-layouts.app>
