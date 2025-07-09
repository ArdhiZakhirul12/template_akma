<x-layouts.app :title="__('RAB Mahad')">


    <div id="myModal" onclick="if (event.target === this) closeModal()"
        class="addModal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <!-- Modal Content -->
        <div
            class="bg-white dark:bg-zinc-800 dark:bg-zinc-800 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Kategori Baru</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('mahad.rab.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <label for="jumlah" class="block text-sm font-medium text-gray-400">Nama Kategori</label>
                    <input type="text" name="kategori" placeholder="Masukkan nama kategori baru" class="w-full border rounded px-3 py-2" />
                    <input type="text" name="jenis_rab" class="hidden" value="mahad" />
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
                <h2 class="text-xl font-semibold">Notifikasi Pengeluaran Mahad</h2>
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
        <h1 class="text-3xl font-bold mb-2">Rencana Anggaran Mahad</h1>

        <div class="flex">
            <x-template.button-with-icon title="Rekap RAB" color="fuchsia" onclick="location.href='{{ route('mahad.rab.showRekap', ['id' => 'all']) }}'"
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
