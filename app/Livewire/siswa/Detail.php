<?php

namespace App\Livewire\Siswa;

use App\Models\kelas;
use App\Models\siswa;
use Livewire\Component;

class Detail extends Component
{
    public $dataSiswa;
    public $kelas;
    public $siswas;
    public $data_kelas;
    public $jenis_kelas;
    public $selectedTingkatan;
    public $selectedKelas;
    public $selectedStatus;
    public $openModal;

    public function mount($id)
    {
        $this->dataSiswa = siswa::find($id);
        $this->kelas = kelas::select('tingkatan')->distinct()->pluck('tingkatan');
        $this->siswas = siswa::all();
        $this->data_kelas = kelas::all();
        $this->jenis_kelas = kelas::where('tingkatan', $this->dataSiswa->kelas?->tingkatan)->get() ;
        $this->selectedKelas = $this->dataSiswa->kelas?->kelas;
        $this->selectedTingkatan = $this->dataSiswa->kelas?->tingkatan;
        $this->selectedStatus = $this->dataSiswa->status;
        $this->openModal = false;
        // dd($id,$this->dataSiswa, $this->kelas);
    }


    public function updatedselectedTingkatan($value)
    {
        $this->jenis_kelas = kelas::where('tingkatan', $value)->get();
    }

    public function openedModalForm()
    {
        $this->openModal = true;
    }

    public function render()
    {
        return view('livewire.siswa.detail');
    }
}
