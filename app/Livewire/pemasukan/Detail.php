<?php

namespace App\Livewire\Pemasukan;

use App\Models\bank;
use App\Models\pemasukan;
use App\Models\siswa;
use Livewire\Component;
use Livewire\Livewire;

class Detail extends Component
{
    public $data_siswas;
    public $kelas;
    public $pemasukan;
    public $siswas;
    public $openModal;
    public $openDropdown;
    public $search;
    public $selectedSiswaInfo;
    public $siswaId;
    public $spp;
    public $dpp;
    public $tabungan;
    public $banks;
    // public $jumlah;

    public function mount($id)
    {
        
        $this->pemasukan = pemasukan::with('siswa')->find($id);
        $this->siswas = siswa::with('kelas')->get();
        $this->banks = bank::all();
        $this->spp = bank::find(3);
        $this->dpp = bank::find(1);
        $this->tabungan = bank::find(2);
        // dd($this->spp, $this->dpp, $this->tabungan);
        $this->data_siswas = siswa::whereHas('kelas', function ($query) {
            $query->where('tingkatan', "10");
        })
            ->with('kelas') // load related kelas normally
            ->get(); // make sure 'kelas' is the relationship name
        $this->kelas = "10";
        $this->openModal = false;
        $this->openDropdown = false;
        $this->selectedSiswaInfo = "{$this->pemasukan->siswa->nama} - {$this->pemasukan->siswa->nis} - {$this->pemasukan->siswa->kelas->tingkatan}{$this->pemasukan->siswa->kelas->kelas}";
        $this->siswaId = $this->pemasukan->siswa_id;
    

    }
    public function openedModalForm()
    {
        $this->openModal = true;
    }

    public function openedDropdown()
    {
        $this->openDropdown = $this->openDropdown ? false : true;
    }


    public function updatedSearch()
    {

        $this->data_siswas = Siswa::with('kelas')
            ->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('nis', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kelas', function ($kelasQuery) {
                        $kelasQuery->whereRaw("CONCAT(tingkatan, kelas) like ?", ['%' . $this->search . '%']);
                    });
            })
            ->whereHas('kelas', function ($query) {
                $query->where('tingkatan', $this->kelas);
            })
            ->get();
    }


    public function selectSiswa($id)
    {
        $siswa = siswa::with('kelas')->findOrFail($id);
        $this->siswaId = $siswa->id;
        $this->selectedSiswaInfo = "{$siswa->nama} - {$siswa->nis} - {$siswa->kelas->tingkatan}{$siswa->kelas->kelas}";
        $this->openDropdown = $this->openDropdown ? false : true;
    }



    public function filterDataSiswa($tingkatan)
    {

        $this->data_siswas = siswa::whereHas('kelas', function ($query) use ($tingkatan) {
            $query->where('tingkatan', $tingkatan);
        })
            ->with('kelas') // load related kelas normally
            ->get();
        $this->kelas = $tingkatan;
    }

    public function render()
    {
        return view('livewire.pemasukan.detail');
    }
}
