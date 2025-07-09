<?php

namespace App\Livewire\Siswa;

use App\Models\hargaKelas;
use App\Models\kelas;
use App\Models\siswa;
use App\Models\pemasukan;
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
    public $totalDpp;
    public $statusDpp;
    public $pemasukanDpp;

    public function mount($id)
    {
        $this->dataSiswa = siswa::find($id);
        $pemasukan = pemasukan::with('siswa.kelas')->where('siswa_id', $id)->get();
        $this->pemasukanDpp = $pemasukan->where('dpp', '!=', 0);
        $hargaPerkelas = hargaKelas::where('tingkatan', '10')->get();


    
        $this->totalDpp = 0;
        foreach ($pemasukan as $item) {
            
            $this->totalDpp += (int)$item->dpp;
        }

     

        if($this->totalDpp < $hargaPerkelas->first()->target_dpp){ 
            $this->statusDpp = 'Kurang -' . toRupiah(($hargaPerkelas->first()->target_dpp - $this->totalDpp));
        } elseif ($this->totalDpp == $hargaPerkelas->first()->target_dpp) {
            $this->statusDpp = 'Lunas';
        } elseif ($this->totalDpp > $hargaPerkelas->first()->target_dpp) {
            $this->statusDpp = 'Lebih + ' . toRupiah(abs($this->totalDpp - $hargaPerkelas->first()->target_dpp));
        } 
        else {
            $this->statusDpp = 'Belum Membayar';
        }
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
