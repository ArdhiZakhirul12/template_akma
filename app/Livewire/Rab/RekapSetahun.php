<?php

namespace App\Livewire\Rab;

use App\Models\kategoriRab;
use App\Models\pengeluaran;
use App\Models\uraianKegiatan;
use Livewire\Component;

class RekapSetahun extends Component
{
    public $uraians;
    public $selectedSubKategori = 'all';
    public $pengeluarans;
    public $monthlySums = [];
    public $monthlyTotal = [];
    public $allMontlyTotal = [];
    public $grandTotal = 0;
    public $totalSaldoAwal = 0;
    public $totalPengeluaran = 0;
    public $totalSaldoAkhir = 0;
    public $allKategori;
    public function mount($id)
    {
        $this->allKategori = kategoriRab::all()->pluck('kategori')->toArray();
   
        if ($id === 'all') {
            $this->selectedSubKategori = 'all';
            $get_uraians = uraianKegiatan::with("subKategoriRab.kategori")->get();
            $this->uraians =  $get_uraians->groupBy(function ($item) {
                return $item->subKategoriRab->sub_kategori ?? 'Tanpa SubKategori';
            })->all();
        } else {
            $this->selectedSubKategori = $id;
            $get_uraians = uraianKegiatan::with("subKategoriRab.kategori")
                ->when($id !== 'all', function ($query) use ($id) {
                    $query->whereHas('subKategoriRab.kategori', function ($q) use ($id) {
                        $q->where('kategori', $id);
                    });
                })
                ->get();

            $this->uraians = $get_uraians->groupBy(function ($item) {
                return $item->subKategoriRab->sub_kategori ?? 'Tanpa SubKategori';
            })->all();
        }
       
        $this->totalSaldoAwal = collect($this->uraians)->flatMap(function ($group) {
            return $group; // Flatten nested collections into a single one
        })->sum('batas_max');


        
 
        $this->pengeluarans = pengeluaran::all()->toArray();
        
        foreach ($this->uraians as $subKategori => $uraians) {
            foreach ($uraians as $uraian) {
            $uraianId = $uraian->id;
            $monthlySums[$uraianId] = array_fill(1, 12, 0); // Initialize months with 0

            foreach ($this->pengeluarans as $pengeluaran) {
                if ($pengeluaran['uraian_kegiatan_id'] == $uraianId) {
                $month = (int) date('n', strtotime($pengeluaran['created_at']));
                $monthlySums[$uraianId][$month] += $pengeluaran['jumlah'];
                }
            }
            }
        }

        $this->monthlySums = $monthlySums;
     

        foreach ($this->monthlySums as $uraianId => $sums) {
            $this->monthlyTotal[$uraianId] = 0; // Initialize monthly totals for each uraian
            foreach ($sums as $month => $sum) {
                $this->monthlyTotal[$uraianId] += $sum;
            }
        }

        $this->allMontlyTotal = array_fill(1, 12, 0); // Initialize all monthly totals
        foreach ($this->monthlySums as $uraianId => $sums) {
            foreach ($sums as $month => $sum) {
            $this->allMontlyTotal[$month] += $sum;
            }
        }

        $this->totalPengeluaran = array_sum($this->allMontlyTotal);
        $this->totalSaldoAkhir = $this->totalSaldoAwal - $this->totalPengeluaran;






    }

    public function updatedSelectedSubKategori($value)
    {
        return redirect()->route('rab.showRekap', ['id' => $value]);
    }




    public function render()
    {
        return view('livewire.rab.rekap-setahun');
    }
}
