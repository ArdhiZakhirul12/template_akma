@props(['title'])



@if (session('success'))

<div id="successAlert"
    class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md fixed top-4 right-4 z-50"
    role="alert">
    <div class="flex">
        <div class="py-1">
            <svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path
                    d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
            </svg>
        </div>
        <div>
            @if (session('action') === 'create')
                <p class="font-bold">Berhasil Menambah {{ $title }} baru</p>
            @elseif (session('action') === 'update')
                <p class="font-bold">Berhasil Mengubah {{ $title }}</p>
            @endif
            <p class="text-sm">Pastikan data yang dimasukkan sudah benar</p>

        </div>
    </div>
</div>


@php
session()->forget('success');

@endphp
<script>
  if (performance.getEntriesByType("navigation")[0].type === "back_forward") {
        const alert = document.getElementById('successAlert');
        if (alert) alert.style.display = 'none';
    }
    
    setTimeout(() => {
        const alert = document.getElementById('successAlert');
        if (alert) alert.style.display = 'none';
    }, 3000);
</script>
@endif
