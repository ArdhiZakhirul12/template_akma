<?php

namespace App\Livewire\Kelas;

use App\Models\siswa;
use Livewire\Component;

class Alumni extends Component
{

    public $selectedYear;
    public $siswas;
    public $idData;

    public function mount($inputYear)
    {
      
        $this->selectedYear = $inputYear ?? date('Y');
        $this->siswas = siswa::where('status', 'lulus')
        ->whereYear('tanggal_masuk', $this->selectedYear)
        ->get();
    }

    public function updatedselectedYear($value)
    {

        return redirect()->route('kelas.alumni', ['inputYear' => $value]);
    }


    public function render()
    {
        return view('livewire.kelas.alumni');
    }
}
