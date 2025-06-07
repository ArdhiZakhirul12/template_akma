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
    public $selectedBank;
    public $bankName = "";
    public $pengeluaranPerBank;
    public $selectedYear;
    public $selectedMonth;
    public $year;
    public $totalJumlahPemasukan;
    public $totalJumlahPengeluaran;
    public $totalSemuaPengeluaran;


    public function mount($id, $inputYear, $inputMonth)
    {
        $this->banks = bank::all();

        $this->year = $inputYear;

        $this->selectedYear = $inputYear;

        $this->selectedMonth = $inputMonth;

        $this->getPemasukans();

        $this->bankName = $id;

        $this->getBankAndPengeluarans($id);
        
        $this->getUraianAndMontlySum();

        $this->getMontlyTotalAndFormated();
        
    }

    function getMontlyTotalAndFormated()
    {
        foreach ($this->monthlySums as $uraianId => $sums) {
            $this->monthlyTotal[$uraianId] = 0; // Initialize monthly totals for each uraian
            foreach ($sums as $month => $sum) {
                $this->monthlyTotal[$uraianId] += $sum;
            }
        }

        $this->formatedPengeluaran = $this->pengeluarans->map(function ($item) {
            $item->month_name = Carbon::parse($item->created_at)->format('F');
            return $item;
        });
    }

    function getUraianAndMontlySum()
    {
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
    }

    function getBankAndPengeluarans($id)
    {
        $bank = bank::where('jenis', $id)->first();
        $query = pengeluaran::with('uraianKegiatan.subKategoriRab.kategori', 'bank')->whereYear('created_at', $this->selectedYear);
        if ($id === 'all' || $id === 'semua bank' ) {
            $this->selectedBank = null;
        } else {
            $this->selectedBank = $id;

            if ($bank != null) {
                $query->where('jenis_id', $bank->id);
            }
        }
        if ($this->selectedMonth !== 'semua bulan') {
            $query->whereMonth('created_at', $this->selectedMonth);
        }

        $this->pengeluaranPerBank = $query->get()->map(function ($item) {
            $item->month_name = Carbon::parse($item->created_at)->format('F');
            return $item;
        });


        $this->pengeluarans = pengeluaran::with('uraianKegiatan.subKategoriRab.kategori', 'bank')->get();

        $this->totalJumlahPengeluaran = $this->pengeluaranPerBank->groupBy('jenis_id')->mapWithKeys(function ($items, $jenisId) {
            return [$jenisId => $items->sum('jumlah')];
        });
        $this->totalSemuaPengeluaran = $this->pengeluaranPerBank->sum('jumlah');
    }

    function getPemasukans()
    {
        $query = pemasukan::selectRaw('YEAR(pembayaran_bulan) as year, MONTH(pembayaran_bulan) as month, SUM(jumlah) as total')
            ->whereYear('pembayaran_bulan', $this->selectedYear)
            ->groupBy(Db::raw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)'))
            ->orderByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)');

        if ($this->selectedMonth !== 'semua bulan') {
            $query->whereMonth('pembayaran_bulan', $this->selectedMonth);
        }

        $this->pemasukans = $query->get()->map(function ($item) {
            $item->month_name = Carbon::createFromDate($item->year, $item->month, 1)->format('F');
            return $item;
        });

        $this->totalJumlahPemasukan = $this->pemasukans->sum('total');
   
   
       
       
    }

    public function pembukuanList()
    {
        return redirect()->route('pembukuan.listPembukuan', ['id' => 'all', 'inputYear' => $this->selectedYear, 'inputMonth' => $this->selectedMonth]);
    }

    public function updatedselectedYear($value)
    {


        return redirect()->route('pembukuan.listPembukuan', ['id' => $this->bankName, 'inputYear' => $value, 'inputMonth' => $this->selectedMonth]);
    }

    public function updatedSelectedMonth($value)
    {

        return redirect()->route('pembukuan.listPembukuan', ['id' => $this->bankName, 'inputYear' => $this->selectedYear, 'inputMonth' => $value]);
    }

    public function updatedSelectedBank($value)
    {

        return redirect()->route('pembukuan.listPembukuan', ['id' => $value, 'inputYear' => $this->selectedYear, 'inputMonth' => $this->selectedMonth]);
    }

    public function render()
    {
        return view('livewire.pembukuan.pembukuan');
    }
}
