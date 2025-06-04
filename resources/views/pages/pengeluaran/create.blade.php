<x-layouts.app :title="__('Pengeluaran Baru')">

  
   
    <x-template.success-alert title="Pemasukan"/>


<livewire:pengeluaran.create/>


{{-- 
<div id="add-pengeluaran-modal"
class="flex items-center justify-center">
<div class="bg-white dark:bg-zinc-700 rounded-lg p-10 rounded-lg shadow-lg w-full max-w-xl">

    <form method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama" class="block text-sm font-medium text-gray-400">Nama</label>
            <input type="text" name="nama" id="nama"
                class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label for="no_hp" class="block text-sm font-medium text-gray-400">No WA</label>
            <input type="text" name="no_hp" id="no_hp"
                class="mt-1 p-2 w-full border border-gray-300 rounded" required>
        </div>
        <div class="mb-4">
            <label for="alamat" class="block text-sm font-medium text-gray-400">Alamat</label>
            <textarea name="alamat" id="alamat" class="mt-1 p-2 w-full border border-gray-300 rounded" required></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded">Simpan</button>
        </div>
    </form>

</div>
</div> --}}

</x-layouts.app>