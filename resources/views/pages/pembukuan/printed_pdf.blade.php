<div id="testing_print">
    <div class="flex flex-col gap-4">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold">Laporan Pembukuan</h1>
            <button id="print-button" class="bg-blue-500 text-white px-4 py-2 rounded">Print</button>
        </div>
        <div id="print-area" class="p-4 bg-white shadow-md rounded">
            <!-- Content to be printed -->
            {{-- @include('components.pembukuan.printed_pdf') --}}
        </div>
    </div>
</div>