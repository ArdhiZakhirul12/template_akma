<x-layouts.app :title="__('RAB')">


    <div id="myModal" onclick="if (event.target === this) closeModal()"
        class="addModal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <!-- Modal Content -->
        <div
            class="bg-white dark:bg-zinc-800 dark:bg-zinc-800 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Form Tambah Data</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('rab.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <input type="text" name="kategori" placeholder="Nama" class="w-full border rounded px-3 py-2" />
                    <!-- Bisa tambah field sebanyak yang kamu mau -->
                </div>
                <div class="mt-6 text-right">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white font-semibold px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>



    <x-template.success-alert title="Kategori" />

    <div id="myNotification" onclick="if (event.target === this) closeModal()"
        class="addModal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

        <!-- Modal Content -->
        <div
            class="bg-white dark:bg-zinc-800 dark:bg-zinc-800 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Notifikasi Pengeluaran</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
            </div>

            @if (count($notifikasi) === 0)
                <div class="flex flex-col items-center justify-center h-86">
                    <img src="{{ asset('images/notifvector.png') }}" alt="No Data" class="w-100 h-80">
                    <p class="text-gray-500 dark:text-white">Tidak ada notifikasi</p>
                </div>
            @endif



            @foreach ($notifikasi as $item)
                <a href="{{ route('rab.showUraian', $item['id']) }}">
                    <div href="{{ route('rab.showUraian', $item['id']) }}"
                        class="shadow-lg mb-2 cursor-pointer hover:bg-gray-100 dark:bg-zinc-800 dark:hover:bg-zinc-700 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
                        <p>{{ $item['uraian'] }}</p>
                        <p class="text-sm text-gray-500">{{ $item['kategori'] }} / {{ $item['sub_kategori'] }}</p>
                        <hr class="my-2">
                        <div class="flex items-center">
                            <span class="w-3 h-3 rounded-full mr-2"
                                style="background-color: {{ $item['status'] === 'Mendekati batas maksimal' ? 'yellow' : ($item['status'] === 'Mencapai batas maksimal' ? 'orange' : 'red') }};"></span>
                            <p>{{ $item['status'] }}</p>
                        </div>

                    </div>
                </a>
            @endforeach
        </div>
    </div>



    <div class="sm:flex sm:justify-between sm:items-center">
        <h1 class="text-3xl font-bold mb-2">Rencana Anggaran Belanja</h1>

        <div class="flex">
            <x-template.button-with-icon title="Rekap RAB" color="blue" onclick="location.href='{{ route('rab.showRekap', ['id' => 'all']) }}'"
                icon="<path fill='currentColor' d='M6 2H14C15.1 2 16 2.9 16 4V16C16 17.1 15.1 18 14 18H6C4.9 18 4 17.1 4 16V4C4 2.9 4.9 2 6 2ZM6 0C3.79 0 2 1.79 2 4V16C2 18.21 3.79 20 6 20H14C16.21 20 18 18.21 18 16V4C18 1.79 16.21 0 14 0H6ZM8 6H12V8H8V6ZM8 10H12V12H8V10ZM8 14H12V16H8V14Z'/>" />
            <div class="mx-2"></div>
            <div class="relative">
                <x-template.button-with-icon title="Notifikasi" color="blue" onclick="openModalNotif()"
                    icon="<path fill='currentColor' d='M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zm0 18a2 2 0 002-2H8a2 2 0 002 2z'/>" />
                @if (count($notifikasi) > 0)
                    <span class="absolute top-2 left-3 w-3 h-3 bg-red-600 rounded-full"></span>
                @endif
            </div>

            <div class="mx-2"></div>
            <x-template.button-with-icon title="Tambah" color="green" onclick="openModal()"
                icon="<path fill='currentColor' fill-rule='evenodd' d='M10 3a1 1 0 011 1v6h6a1 1 0 110 2h-6v6a1 1 0 01-2 0v-6H4a1 1 0 110-2h6V4a1 1 0 011-1z' clip-rule='evenodd'/>" />
        </div>


    </div>
    @if ($kategoris->isEmpty())
        <div class="flex flex-col items-center justify-center h-86">
            <img src="{{ asset('images/empty.png') }}" alt="No Data" class="w-80 h-80">
            <p class="text-gray-500">Data kategori masih kosong</p>
        </div>
    @endif
    <div class="flex w-full flex-1 flex-col gap-4 rounded-xl my-8 ">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            @foreach ($kategoris as $kategori)
                <div class="ketegori-data" data-kategori="{{ $kategori->kategori }}" data-id="{{ $kategori->id }}">
                    <x-template.card-01 title="{{ $kategori->kategori }}" desk="" :image="asset('images/Shopping.svg')"
                        :edit="route('rab.update', $kategori->id)" :route="route('rab.show', $kategori->id)" />
                </div>
            @endforeach

        </div>
    </div>

    <div class="sm:flex sm:justify-between sm:items-center my-4">
        <h1 class="text-3xl font-bold mb-2">Daftar Bank</h1>



    </div>

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <div class="flex justify-between items-center mb-4">

        </div>
        <div class="bg-yellow-100 mb-5 border border-yellow-400 text-yellow-700 px-4 py-3 rounded relative"
            role="alert">
            <strong class="font-bold">Perhatian!</strong>
            <span class="block sm:inline">Total presentase harus 100%.</span>
        </div>
        <table class="dataTableClass w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">No</th>
                    <th style="text-align: center !important">Nama</th>
                    <th style="text-align: center !important">Presentase</th>
                    <th style="text-align: center !important">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($banks as $item)
                    <tr data-id="{{ $item->id }}" data-jenis="{{ $item->jenis }}"
                        data-presentase="{{ $item->presentase }}"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $loop->iteration }}</td>
                        <th scope="row" style="text-align: center !important"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->jenis }}</th>
                        <td style="text-align: center !important">{{ $item->presentase }}%</td>
                        <td class="flex justify-center">
                            <button class="btn-edit-bank mr-6" style="text-align: center !important"
                                data-target="#edit-bank-modal" id="edit-icon-button"
                                class="text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 cursor-pointer text-yellow-500"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path
                                        d="M17.414 2.586a2 2 0 010 2.828l-10 10a2 2 0 01-.707.414l-4 1a1 1 0 01-1.265-1.265l1-4a2 2 0 01.414-.707l10-10a2 2 0 012.828 0zm-2.828 2.828L4 16l-1 4 4-1 10.586-10.586-2.828-2.828z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important"></th>
                    <th style="text-align: center !important">Total</th>
                    <th style="text-align: center !important">{{ $sumBank }}%</th>
                    <th style="text-align: center !important"></th>
                </tr>
            </tfoot>
        </table>
    </div>

    <div id="edit-bank-modal"
        class="addModal hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30">
        <div class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">
            <h2 class="text-xl  font-semibold mb-4">Edit Kelas</h2>
            <form id="editForm" method="POST">
                @csrf
                @method('PUT')
                <div class="flex items-center w-full">
                    <div class="mb-4 w-1/2 mr-2">
                        <input type="text" name="id" id="id" hidden>
                        <label for="edit-tingkatan" class="block text-sm font-medium text-gray-400">Nama</label>

                        <input type="text" id="edit-jenis" class="mt-1 p-2 w-full border border-gray-300 rounded"
                            readonly>
                    </div>
                    <div class="mb-4 w-1/2 mr-2">
                        <label for="edit-kelas" class="block text-sm font-medium text-gray-400">presentase</label>
                        <input type="text" name="presentase" id="edit-presentase"
                            class="mt-1 p-2 w-full border border-gray-300 rounded" required>
                    </div>
                </div>
                <div class="flex justify-end">
                    <button type="button" class="px-4 py-2 bg-gray-500 text-white rounded mr-2"
                        onclick="document.getElementById('edit-bank-modal').classList.add('hidden')">Kembali</button>
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        $(document).on('click', '.btn-edit-bank', function() {
            var row = $(this).closest('tr');
            $('#id').val(row.data('id'));
            $('#edit-jenis').val(row.data('jenis'));
            $('#edit-presentase').val(row.data('presentase'));
            $('#edit-bank-modal').removeClass('hidden');
            $('#editForm').attr('action', '/rab/bank/');
        });
    </script>
    <script>
        function openModal() {
            document.getElementById('myModal').classList.remove('hidden');
            document.getElementById('myModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('myModal').classList.add('hidden');
            document.getElementById('myModal').classList.remove('flex');
            document.getElementById('myNotification').classList.add('hidden');
            document.getElementById('myNotification').classList.remove('flex');
        }

        function openModalNotif() {
            document.getElementById('myNotification').classList.remove('hidden');
            document.getElementById('myNotification').classList.add('flex');
        }
    </script>


</x-layouts.app>
