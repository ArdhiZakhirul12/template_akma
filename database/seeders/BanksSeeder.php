<?php

namespace Database\Seeders;

use App\Models\bank;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BanksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        bank::create([
            'jenis' => 'DPP',
            'saldo' => 0,
            'presentase' => 30
        ]);
        bank::create([
            'jenis' => 'Tabungan',
            'saldo' => 0,
            'presentase' => 30
        ]);
        bank::create([
            'jenis' => 'SPP',
            'saldo' => 0,
            'presentase' => 40
        ]);
    }
}
