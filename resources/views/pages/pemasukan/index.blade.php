<x-layouts.app :title="__('Pemasukan')">
    @if (session('success'))
   
    <x-template.success-alert title="Pemasukan"/>
    <script>
     
      setTimeout(() => {
          document.getElementById('successAlert').style.display = 'none';
      }, 3000);
    </script>
    @endif

    <livewire:pemasukan.pemasukan/>

   

</x-layouts.app>
