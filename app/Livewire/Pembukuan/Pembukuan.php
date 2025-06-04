<?php

namespace App\Livewire\Pembukuan;

use App\Models\bank;
use App\Models\pemasukan;
use App\Models\pengeluaran;
use App\Models\uraianKegiatan;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Pembukuan extends Component
{
    public $banks;
    public $pengeluarans;
    public $pemasukans;
    public $formatedPengeluaran;
    public $monthlyTotal = [];
    public $monthlySums = [];
    public $uraians;

    public function mount()
    {
        $this->banks = bank::all();
        $this->pengeluarans = pengeluaran::with('uraianKegiatan.subKategoriRab.kategori', 'bank')->get();
        $get_uraians = uraianKegiatan::with("subKategoriRab.kategori")->get();
        $this->uraians =  $get_uraians->groupBy(function ($item) {
            return $item->subKategoriRab->sub_kategori ?? 'Tanpa SubKategori';
        })->all();
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


        $this->pemasukans = pemasukan::selectRaw('YEAR(pembayaran_bulan) as year, MONTH(pembayaran_bulan) as month, SUM(jumlah) as total')->groupBy(Db::raw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)'))
            ->orderByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)')
            ->get()
            ->map(function ($item) {
                $item->month_name = Carbon::createFromDate($item->year, $item->month, 1)->format('F');
                return $item;
            });

        $this->formatedPengeluaran = $this->pengeluarans->map(function ($item) {
            $item->month_name = Carbon::parse($item->created_at)->format('F');
            return $item;
        });
        // dd($this->pengeluarans,$this->pemasukans,$this->formatedPengeluaran);




        // dd($this->allMontlyTotal, $this->monthlySums, $this->uraians);
    }


    public function render()
    {
        return view('livewire.pembukuan.pembukuan');
    }
}
