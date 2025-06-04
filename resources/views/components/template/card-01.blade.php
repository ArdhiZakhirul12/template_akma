@props(['title', 'desk', 'image', 'edit', 'route'])


<div 
    class="bg-white dark:bg-zinc-800 relative min-h-[200px] flex flex-col items-center justify-center aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg">

    {{-- <img src="{{ $image }}" alt="{{ $title }}" class="w-10 object-cover mb-4"> --}}
    <h6 class="text-sm text-gray-400 mb-2">BIDANG :</h6>
    <h1 class="text-xl font-bold mb-8">{{ $title }}</h1>

    <!-- Button Group -->
    <div class="flex gap-2">
        <x-template.button-with-icon title="Detail" color="teal" onclick="window.location.href='{{ $route }}'"
            icon="<path fill='currentColor' d='M12 4a8 8 0 100 16 8 8 0 000-16zm0 2a6 6 0 110 12A6 6 0 0112 6zm0 2a1 1 0 100 2 1 1 0 000-2zm0 3a1 1 0 00-1 1v3a1 1 0 102 0v-3a1 1 0 00-1-1z'/>" />
        {{-- <x-template.button-with-icon title="Edit" color="blue" onclick="openModalEdit()" icon="<path fill='currentColor' d='M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zm2.92-1.42L14.06 7.69l1.42 1.42L7.34 17.25H5.92v-1.42zM18.37 5.63a1.5 1.5 0 010 2.12l-1.06 1.06-2.12-2.12 1.06-1.06a1.5 1.5 0 012.12 0z'/>" /> --}}
        <button  data-target="#myModalEdit"
            class="btn-edit flex items-center focus:outline-none text-white dark:text-white bg-blue-500 hover:bg-blue-500 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-400">

            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path fill='currentColor'
                    d='M3 17.25V21h3.75l11.06-11.06-3.75-3.75L3 17.25zm2.92-1.42L14.06 7.69l1.42 1.42L7.34 17.25H5.92v-1.42zM18.37 5.63a1.5 1.5 0 010 2.12l-1.06 1.06-2.12-2.12 1.06-1.06a1.5 1.5 0 012.12 0z' />
            </svg>


            <span class="ml-1">Edit</span>
        </button>
    </div>
</div>

<div id="myModalEdit" onclick="if (event.target === this) this.classList.add('hidden')" class="addModal fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <!-- Modal Content -->
    <div class= "bg-white dark:bg-zinc-700 max-h-[80vh] overflow-y-auto rounded-lg p-6 w-full max-w-md">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold">Form Edit kategori</h2>
            <button onclick="closeModalEdit()" class="text-gray-500 hover:text-gray-800 text-xl">&times;</button>
        </div>

        <!-- Modal Body -->
        <form id="editForm" method="POST">
            
            @csrf
            @method('PUT')
            <div class="space-y-4">
                <input type="text" name="kategori" class="w-full border rounded px-3 py-2" id="edit-kategori"
                   />
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
        var parent = $(this).closest('.ketegori-data');
        var kategori = parent.data('kategori');
        var id = parent.data('id');

    // Set form values
        $('#edit-kategori').val(kategori);
        $('#myModalEdit').removeClass('hidden');
        $('#myModalEdit').addClass('flex');
        $('#editForm').attr('action', '/rab/kategori/' + parent.data('id'));
    });
</script>
