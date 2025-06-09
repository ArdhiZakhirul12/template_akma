<?php

namespace App\Livewire\Pemasukan;

use App\Models\pemasukan as ModelsPemasukan;
use App\Models\siswa;
use Livewire\Component;

class Pemasukan extends Component
{

    public $data_siswas;
    public $kelas;
    public $pemasukans_data;
    public $siswas;
    public $openModal;
    public $openDropdown;
    public $search;
    public $selectedSiswaInfo;
    public $siswaId;
    // public $jumlah;

    public function mount()
    {
        
        $this->siswas = siswa::with('kelas')->get();
        $this->data_siswas = siswa::whereHas('kelas', function ($query) {
            $query->where('tingkatan', "10");
        })
            ->with('kelas') // load related kelas normally
            ->get(); // make sure 'kelas' is the relationship name
        $this->kelas = "10";
        $this->openModal = false;
        $this->openDropdown = false;
        $this->selectedSiswaInfo = '';
        $this->siswaId = '';
        $this->pemasukans_data = ModelsPemasukan::with('siswa')->get();
        // $this->search = '';
        // $this->jumlah = '';

    }
    public function calenderPage()
    {
        return redirect()->route('pemasukan.calender', ['id'=>'all']);
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
        $siswa = Siswa::with('kelas')->findOrFail($id);
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
        return view('livewire.pemasukan.pemasukan');
    }
}
