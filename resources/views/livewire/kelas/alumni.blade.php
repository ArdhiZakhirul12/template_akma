<div>
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Alumni</h1>
        <select
        class="form-select me-2 border border-gray-300 p-2 rounded-lg shadow-sm bg-white dark:bg-zinc-700"
        wire:model.live="selectedYear">
        <option value="" disabled selected>Pilih Tahun</option>
        @foreach (range(date('Y'), date('Y') - 30) as $year)
            <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
            {{ $year }}
            </option>
        @endforeach
    </select>
    </div>

    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table class="dataTableClass w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">No</th>
                    <th>Nama</th>
                    <th scope="row" style="text-align: center !important">Angkatan</th>
                    <th scope="row" style="text-align: center !important">Status</th>
                    <th scope="row" style="text-align: center !important">nis</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswas as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $loop->iteration }}</td>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->nama }}</th>
                        <td scope="row" style="text-align: center !important">
                            {{ \Carbon\Carbon::parse($item->tanggal_masuk)->format('Y') }}</td>
                        <td scope="row" style="text-align: center !important">
                            @if ($item->status === 'lulus')
                                <span class="px-4 py-1 text-sm font-medium text-white bg-green-500 rounded-full">
                                    Lulus
                                </span>
                            @elseif ($item->status === 'aktif')
                                <span class="px-4 py-1 text-sm font-medium text-white bg-blue-500 rounded-full">
                                    Aktif
                                </span>
                            @elseif ($item->status === 'tidak-aktif')
                                <span class="px-4 py-1 text-sm font-medium text-white bg-red-500 rounded-full">
                                    Tidak Aktif
                                </span>
                            @else
                                <span class="px-4 py-1 text-sm font-medium text-white bg-gray-500 rounded-full">
                                    {{ $item->status }}
                                </span>
                            @endif
                        </td>
                        <td scope="row" style="text-align: center !important">{{ $item->nis }}</td>

                        <td scope="row" style="text-align: center !important">
                            <a href="{{ route('pages.siswa.show', $item->id) }}"
                                class="text-blue-500 hover:text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M10 3C5.58 3 2.05 6.11 1 10c1.05 3.89 4.58 7 9 7s7.95-3.11 9-7c-1.05-3.89-4.58-7-9-7zm0 12a5 5 0 110-10 5 5 0 010 10zm0-8a3 3 0 100 6 3 3 0 000-6z" />
                                </svg>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
