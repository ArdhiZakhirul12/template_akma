<x-layouts.app :title="__('Detail Pemasukan')">
    @if (session('success'))
   
    <x-template.success-alert title="Pemasukan"/>
    <script>
     
      setTimeout(() => {
          document.getElementById('successAlert').style.display = 'none';
      }, 3000);
    </script>
    @endif
   <livewire:pemasukan.detail :id="$pemasukan->id" />
    {{-- <livewire:pemasukan.testing-detail :id="$pemasukan->id"/> --}}
</x-layouts.app>
