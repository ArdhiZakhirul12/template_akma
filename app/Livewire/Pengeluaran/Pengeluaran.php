<?php

namespace App\Livewire\Pengeluaran;

use App\Models\bank;
use App\Models\kategoriRab;
use App\Models\pengeluaran as ModelsPengeluaran;
use App\Models\subKategoriRab;
use App\Models\uraianKegiatan;
use Livewire\Component;

class Pengeluaran extends Component
{
    public $pengeluarans;
    public $openModal;
    public $kategoriList;

    public $subKategoriList;
    public $uraianKegiatanList;
    public $bankList;

    public $selectedKategori;
    public $selectedSubKategori;

    public function mount()
    {
        $this->pengeluarans = ModelsPengeluaran::with('uraianKegiatan.subKategoriRab.kategori','bank')->get();
        $this->openModal = false;
        $this->kategoriList = kategoriRab::all(); // load all categories at start
        $this->subKategoriList = []; // initialize subcategories
        $this->uraianKegiatanList = []; // initialize activities
        $this->bankList = bank::all();
        $this->selectedKategori = null; // initialize selected category
        $this->selectedSubKategori = null; // initialize selected subcategory
    }

    public function openedModalForm()
    {
        $this->openModal = true;
    }

    public function updatedSelectedKategori($value)
    {  
        $this->subKategoriList = subKategoriRab::where('kategori_rabs_id', $value)->get();
        $this->uraianKegiatanList = []; 
        $this->selectedSubKategori = null;
        // $this->sub_kategori_id = null;
    }

    public function updatedSelectedSubKategori($value)
    {
        $this->uraianKegiatanList = uraianKegiatan::where('sub_kategori_id', $value)->get();
        // dd($this->selectedKategori, $this->selectedSubKategori,$this->uraianKegiatanList);
    }

    public function render()
    {
        return view('livewire.pengeluaran.pengeluaran');
    }
}
