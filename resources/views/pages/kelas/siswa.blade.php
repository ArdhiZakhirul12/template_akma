<x-layouts.app :title="__('Siswa Kelas')">
    <div class="sm:flex sm:justify-between sm:items-center mb-8">
        <h1 class="text-3xl font-bold mb-2">Kelas {{ $kelasName }}</h1>
  
    </div>
    <div class="p-5 bg-white dark:bg-zinc-700 rounded-lg shadow-md">
        <table wire:ignore.self
            class="dataTableClass w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400"
            style="width:100%">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th style="text-align: center !important">No</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>nis</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($siswas as $item)
                    <tr
                        class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td style="text-align: center !important">{{ $item->id }}</td>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $item->nama }}</th>
                        <td>{{ $item->kelas->tingkatan }}{{ $item->kelas->kelas }}</td>
                        <td>{{ $item->nis }}</td>

                        <td>
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
</x-layouts.app>
