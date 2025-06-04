<x-layouts.app :title="__('show')">
    <x-template.success-alert title="Sub Kategori"/>
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-4">Kategori Pengeluaran </h1>
        <button onclick="openModal()"
            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded-lg shadow-md">
            + Tambah
        </button>
    </div>
    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table class="dataTableClass w-full text-sm text-left text-gray-500 dark:text-gray-400" style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">No</th>
                    <th>Nama Pengeluaran</th>
                    <th>Kategori</th>
                    <th>action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($subs as $sub)
                    <tr data-id="{{ $sub->id }}" data-kategori="{{ $sub->sub_kategori }}"
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $loop->iteration }}</td>
                        <td scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ $sub->sub_kategori }} </td>
                        
                        <td >
                            {{ $sub->kategori->kategori }}</td>
                       
                        <td class="space-x-2 text-center">
                            <a href="{{ route('rab.uraianShow', $sub->id) }}"
                                class="inline-block px-3 py-1 text-sm text-white bg-blue-500 rounded hover:bg-blue-600">
                                Lihat
                            </a>
                            <a 
                                class="btn-edit inline-block px-3 py-1 text-sm text-white bg-yellow-500 rounded hover:bg-yellow-600">
                                Edit
                            </a>
                        </td>

                    </tr>
                @endforeach


            </tbody>

        </table>
    </div>
    <div id="myModal" class="addModal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <!-- Modal Content -->
        <div class="bg-white dark:bg-zinc-800 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Form Tambah Data</h2>
                <button onclick="closeModal()" class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
            </div>

            <!-- Modal Body -->
            <form action="{{ route('rab.subStore') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <input type="hidden" name="kategori_rabs_id" value="{{ $id }}">
                    <input type="text" name="sub_kategori" placeholder="Nama"
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
    @if ($subs->count() > 0)
        <div id="myModalEdit"
            class="addModal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
            <!-- Modal Content -->
            <div class="bg-white dark:bg-zinc-800 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold">Form Edit Data</h2>
                    <button onclick="closeModalEdit()"
                        class="text-gray-500 hover:text-gray-100 text-xl">&times;</button>
                </div>

                <!-- Modal Body -->
                <form action="{{ route('rab.subEdit', $sub->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="space-y-4">
                        <input type="text" name="sub_kategori" id="edit-kategori"
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
    @endif
    <script>
        function openModal() {
            document.getElementById('myModal').classList.remove('hidden');
            document.getElementById('myModal').classList.add('flex');
        }

        function closeModal() {
            document.getElementById('myModal').classList.add('hidden');
            document.getElementById('myModal').classList.remove('flex');
        }
    </script>
    <script>
        function openModalEdit() {
            document.getElementById('myModalEdit').classList.remove('hidden');
            document.getElementById('myModalEdit').classList.add('flex');
        }

        function closeModalEdit() {
            document.getElementById('myModalEdit').classList.add('hidden');
            document.getElementById('myModalEdit').classList.remove('flex');
        }
    </script>

<script>
    $(document).on('click', '.btn-edit', function() {
        var parent = $(this).closest('tr');
        var kategori = parent.data('kategori');
        var id = parent.data('id');

    // Set form values
        $('#edit-kategori').val(kategori);
        $('#myModalEdit').removeClass('hidden');
        $('#myModalEdit').addClass('flex');
        $('#editForm').attr('action', '/rab/kategori/sub/' + parent.data('id'));
    });
</script>
</x-layouts.app>
