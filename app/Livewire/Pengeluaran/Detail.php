<?php

namespace App\Livewire\Pengeluaran;

use App\Models\bank;
use App\Models\kategoriRab;
use App\Models\pengeluaran;
use App\Models\subKategoriRab;
use App\Models\uraianKegiatan;
use Livewire\Component;

class Detail extends Component
{

    public $pengeluaran;
    public $kategoriList;
    public $subKategoriList;
    public $uraianKegiatanList;
    public $bankList;
    public $openImage;
    public $selectedKategori;
    public $selectedSubKategori;
    public $selectedUraianKegiatan;
    public $selectedBank;
    public $openModal;

    public function mount($id)
    {
        $this->pengeluaran = pengeluaran::with("bank")->find($id);
        if (!$this->pengeluaran) {
            abort(404);
        }
        $this->kategoriList = kategoriRab::all(); // load all categories at start
        $this->subKategoriList = subKategoriRab::where('kategori_rabs_id', $this->pengeluaran->uraianKegiatan->subKategoriRab->kategori->id)->get(); // initialize subcategories
        $this->uraianKegiatanList = $this->uraianKegiatanList = uraianKegiatan::where('sub_kategori_id', $this->pengeluaran->uraianKegiatan->subKategoriRab->id)->get();; // initialize activities
        $this->bankList = bank::all();
        $this->selectedKategori = $this->pengeluaran->uraianKegiatan->subKategoriRab->kategori->id; // initialize selected category
        $this->selectedSubKategori = $this->pengeluaran->uraianKegiatan->subKategoriRab->id; // initialize selected subcategory
        $this->selectedUraianKegiatan = $this->pengeluaran->uraianKegiatan->id; // initialize selected activity
        $this->selectedBank = $this->pengeluaran->jenis_id; // initialize selected bank
        $this->openModal = false; // initialize modal state
        $this->openImage = false; // initialize image state
    }

    public function openedModalForm()
    {
        $this->openModal = true;
    }

    public function openImageSpending()
    {
        $this->openImage = true;

    }
    public function closeImageSpending()
    {
        $this->openImage = false;
    }

    public function updatedSelectedKategori($value)
    {
        $this->subKategoriList = subKategoriRab::where('kategori_rabs_id', $value)->get();
        $this->uraianKegiatanList = []; // reset the next dropdown
        $this->selectedSubKategori = null;
    }

    public function updatedSelectedSubKategori($value)
    {
        $this->uraianKegiatanList = uraianKegiatan::where('sub_kategori_id', $value)->get();
    }

    public function render()
    {
        return view('livewire.pengeluaran.detail');
    }
}
