@props(['title', 'dataName', 'amountData', 'bank', 'selected_date', 'total_saldo_akhir', 'dateName'])

@php
    $chartId = Str::slug($title) . '-chart';
@endphp
<div
    class="bg-white min-h-[375px] dark:bg-zinc-800 relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg">
    @if (count($bank) > 1)
        <div class="flex items-center p-4">
            <img src="{{ asset('images/pie.svg') }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
            <div class="flex items-center justify-between w-full">
                <h1 class="text-l font-bold">Persentase Komposisi Saldo Akhir</h1>
                <h1>{{ $dateName }}</h1>
            </div>
        </div>
        <div class="w-full h-[220px]">
            <canvas id="{{ $chartId }}" class="pl-6"></canvas>
        </div>
        <div class="p-8 flex items-center space-x-4 justify-between">
            <div class="">
                <span class="text-gray-500">DPP</span>
                <h1 class="font-bold text-xl">
                    {{ isset($selected_date) ? toRupiah($total_saldo_akhir * ($bank[0]->presentase / 100)) : toRupiah($bank[0]->saldo) }}
                </h1>
            </div>
            <div class="">
                <span class="text-gray-500">Tabungan</span>
                <h1 class="font-bold text-xl">
                    {{ isset($selected_date) ? toRupiah($total_saldo_akhir * ($bank[1]->presentase / 100)) : toRupiah($bank[1]->saldo) }}
                </h1>
            </div>
            <div class="">
                <span class="text-gray-500">SPP</span>
                <h1 class="font-bold text-xl">
                    {{ isset($selected_date) ? toRupiah($total_saldo_akhir * ($bank[2]->presentase / 100)) : toRupiah($bank[2]->saldo) }}
                </h1>
            </div>
            {{-- <h1>Tabungan: {{ toRupiah($bank[1]->saldo) }}</h1>
        <h1>SPP: {{ toRupiah($bank[2]->saldo )}}</h1> --}}
        </div>
</div>
@endif

{{-- <div class="flex flex-col col-span-full sm:col-span-6 xl:col-span-4 bg-white dark:bg-gray-800 shadow-sm rounded-xl">
    <header class="flex items-center px-3 py-4 border-b border-gray-100 dark:border-gray-700/60">
        
        @if ($title == '10 Model terbanyak')
            <img src="{{ asset('images/Multiple_Devices.svg') }}"  class="w-7 h-7 mr-2">
        @elseif($title == '10 servis terbanyak')
            <img src="{{ asset('images/Request_service.svg') }}"  class="w-7 h-7 mr-2">
        @elseif($title == 'Repeat Order')
            <img src="{{ asset('images/Consumable.svg') }}"  class="w-7 h-7 mr-2">
        @endif
        <h2 class="font-semibold text-gray-800 dark:text-gray-100">{{ $title }}</h2>
    </header>
    <canvas id="{{ $chartId }}" class="p-4"></canvas>
</div> --}}



<script>
    var months = @json($dataName);
    var sales = @json($amountData);

    var ctx = document.getElementById('{{ $chartId }}').getContext('2d');
    var myChart = new Chart(ctx, {
        type: "doughnut",
        data: {
            labels: months,
            datasets: [{
                label: 'Monthly Sales',
                data: sales,
                borderWidth: 2,
                backgroundColor: months.map((_, index) =>
                    `hsl(${index * 360 / months.length}, 100%, 75%)`),
                fill: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    labels: {

                        font: {
                            size: 13
                        }
                    },
                    position: 'left'
                },
                tooltip: {
                    callbacks: {
                        label: function(tooltipItem) {
                            let total = tooltipItem.dataset.data.reduce((a, b) => a + b, 0);
                            let value = tooltipItem.raw;
                            let percentage = ((value / total) * 100).toFixed(2);
                            return `${tooltipItem.label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
</script>
