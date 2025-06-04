@props(['title', 'total', 'exMonths', 'exSales', 'thisYearTotal', 'image', 'year' =>"2025"])

@php
    $chartId = Str::slug($title) . '-chart';
@endphp
<div
class="bg-white dark:bg-zinc-800 relative min-h-[300px] overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 shadow-lg">

    <div class="flex items-center p-4">
        
        <img src="{{ $image }}" alt="Saldo Akhir" class="w-7 object-cover mr-2">
      
        <div class="flex items-center justify-between w-full">
            
            <h1 class="text-l font-bold">{{ $title }}</h1>
     
                <h1>{{ $year }}</h1>
            
     
           
        </div>
        
    </div>
    {{-- <div class="px-5 py-1">
        <div class="flex flex-wrap justify-between items-end gap-y-2 gap-x-4">
            <div class="flex items-start justify-end w-full">
            <div class="text-2xl font-bold text-gray-800 dark:text-gray-100 mr-2">
                @if ($title == 'Pelayanan servis per bulan')
                Rp {{ number_format($thisYearTotal, 0, ',', '.') }}
                @else
                Rp {{ number_format($thisYearTotal, 0, ',', '.') }}
                @endif
            </div>
            </div>
        </div>
    </div> --}}
    <canvas id="{{ $chartId }}" class="p-3"></canvas>
</div>


<script>
    var months = @json($exMonths);
    var sales = @json($exSales);

    var ctx = document.getElementById('{{ $chartId }}').getContext('2d');
    var chartType = '{{ $chartId }}' === 'detail-saldo-akhir-chart' ? 'line' : 'bar';
    var myChart = new Chart(ctx, {
        type: chartType,
        data: {
            labels: months,
            datasets: [
                {
                label: 'Rp',
                data: sales,
                borderColor: chartType === 'bar' ? 'transparent' : 'blue',
                borderWidth: 2,
                fill: false,
                backgroundColor: chartType === 'bar' ? sales.map((_, i) => `hsl(${i * 30}, 70%, 50%)`) : 'transparent'
            }
        ]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });

    if (document.getElementById('lineChart')) {
        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Rp',
                    data: sales,
                    borderColor: 'blue',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
    if (document.getElementById('pendapatanLineChart')) {
        var ctx = document.getElementById('pendapatanLineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: months,
                datasets: [{
                    label: 'Bulan ini',
                    data: sales,
                    borderColor: 'blue',
                    borderWidth: 2,
                    fill: false
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }
</script>
