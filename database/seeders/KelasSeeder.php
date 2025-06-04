<?php

namespace Database\Seeders;

use App\Models\hargaKelas;
use App\Models\kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        kelas::create([
            'tingkatan' => '10',
            'kelas' => 'A',            
        ]);
        kelas::create([
            'tingkatan' => '11',
            'kelas' => 'A',            
        ]);
        kelas::create([
            'tingkatan' => '12',
            'kelas' => 'A',            
        ]);

        hargaKelas::create([
            'tingkatan' => '10',
            'jumlah' => 120000
        ]);
        hargaKelas::create([
            'tingkatan' => '11',
            'jumlah' => 120000
        ]);
        hargaKelas::create([
            'tingkatan' => '12',
            'jumlah' => 120000
        ]);
    }
}
