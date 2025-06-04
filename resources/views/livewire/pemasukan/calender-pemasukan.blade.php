<div>
    <div class="sm:flex sm:justify-between sm:items-center mb-6">
        <h1 class="text-3xl font-bold mb-2">Kalender Pemasukan</h1>

    </div>

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md overflow-auto">
        <div class="flex items-center justify-between mb-4">
            <div>
                <label for="kelas" class="text-sm font-medium text-gray-700 dark:text-gray-200">Pilih Kelas:</label>
                <select wire:model.live="selectedKelas" id="kelas"
                    class="ml-2 px-3 py-1 rounded border-gray-300 dark:bg-gray-800 dark:text-white dark:border-gray-600">
                    <option value="all">Semua Kelas</option>
                    @foreach ($daftarKelas as $kelas)
                        <option value="{{ $kelas->id }}">{{ $kelas->tingkatan }} {{ $kelas->kelas }} </option>
                    @endforeach
                </select>
            </div>
        </div>

        <table class="dataTableClass w-full text-sm text-left text-gray-500 dark:text-gray-400" style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">

                <tr>
                    <th class="text-center">No</th>
                    <th>Nama Siswa</th>
                    <th>Kelas</th>
                    <th>No HP Ortu</th>
                    @for ($i = 1; $i <= 12; $i++)
                        <th class="text-center">
                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('M') }}
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @if (count($dataPemasukan) === 0)
                    {{-- <div class="text-center py-4 text-gray-500">Tidak ada data pemasukan.</div> --}}
                @else
                    @foreach ($dataPemasukan as $index => $siswa)
                        <tr
                            class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="px-3 py-2 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $siswa['nama'] }}
                            </td>
                            <td class="text-center">{{ $siswa['kelas'] }}</td>
                            <td class="text-center">{{ $siswa['no_ortu'] }}</td>
                            @for ($i = 1; $i <= 12; $i++)
                                <td class="text-left whitespace-nowrap">
                                    @if (!empty($siswa['bulan'][$i]['bayar']))
                                        @foreach ($siswa['bulan'][$i]['bayar'] as $bayar)
                                            <div class="text-green-600">{{ toRupiah($bayar) }}</div>
                                        @endforeach
                                        <div class="text-xs italic text-gray-500">
                                            Total: {{ toRupiah($siswa['bulan'][$i]['total']) }}
                                        </div>
                                        <div class="text-xs font-semibold">
                                            Status:
                                            @php
                                                $status = $siswa['bulan'][$i]['status'];
                                                $warna = str_contains($status, 'lunas')
                                                    ? 'text-green-600'
                                                    : (str_contains($status, 'kurang')
                                                        ? 'text-yellow-600'
                                                        : 'text-red-600');
                                            @endphp
                                            <span class="{{ $warna }}">{{ $status }}</span>
                                        </div>
                                    @else
                                        <div class="text-xs text-red-500">Belum Bayar</div>
                                    @endif
                                </td>
                            @endfor
                        </tr>
                    @endforeach
                @endif
                {{-- @empty
                    <tr>    
                        <td colspan="16" class="text-center py-4 text-gray-500">Tidak ada data pemasukan.</td>
                    </tr>
                @endforelse --}}
            </tbody>
        </table>
    </div>
    @if (count($dataPemasukan) > 0)
        @push('scripts')
            <script>
                document.addEventListener("livewire:load", function() {
                    setTimeout(() => {
                        $('.dataTableClass').DataTable({
                            responsive: true
                        });
                    }, 1000); // pastikan render selesai
                });
            </script>
        @endpush
    @endif
</div>
