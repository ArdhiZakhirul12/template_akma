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
    public $saldoAwal;
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
    public $totalJumlahSaldoAwal;
    public $totalSaldoAwalPemasukanDpp;
    public $totalSaldoAwalPemasukanSpp;
    public $totalSaldoAwalPemasukanTabungan;
    public $totalSaldoAwalPemasukanMahad;
    public $totalAwalPemasukanDpp;
    public $totalAwalPemasukanSpp;
    public $totalAwalPemasukanTabungan;
    public $totalAwalPemasukanMahad;
    public $totalJumlahPemasukanDpp;
    public $totalJumlahPemasukanSpp;
    public $totalJumlahPemasukanTabungan;
    public $totalJumlahPemasukanMahad;
    public $totalJumlahPengeluaranDpp;
    public $totalJumlahPengeluaranSpp;
    public $totalJumlahPengeluaranMahad;
    public $totalJumlahPengeluaran;
    public $totalSemuaPengeluaran;
    public $totalSemuaPemasukan;

    public $totalDpp;


    public function mount($id, $inputYear, $inputMonth)
    {
        $this->banks = bank::all();

        $this->year = $inputYear;

        $this->selectedYear = $inputYear;

        $this->selectedMonth = $inputMonth;

        $this->getPemasukans();

        $this->getTotalSaldoAwal();

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
        $monthlySums = [];
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
        if ($id === 'all' || $id === 'semua bank') {
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
            $item->month_name = Carbon::parse($item->tanggal_pengeluaran)->format('F');
            return $item;
        });


        $this->pengeluarans = pengeluaran::with('uraianKegiatan.subKategoriRab.kategori', 'bank')->get();

        $this->totalJumlahPengeluaran = $this->pengeluaranPerBank->groupBy('jenis_id')->mapWithKeys(function ($items, $jenisId) {
            return [$jenisId => $items->sum('jumlah')];
        });
        // dd($this->pengeluarans, $this->pengeluaranPerBank, $this->totalJumlahPengeluaran);
        $this->totalSemuaPengeluaran = $this->totalJumlahPengeluaran->sum();
    }

    function getPemasukans()
    {
        $defaultMonths = collect(range(1, 12))->map(function ($month) {
            return [
                'year' => $this->selectedYear,
                'month' => $month,
                'month_name' => \Carbon\Carbon::create()->month($month)->format('F'),
                'total' => 0.0,
                'totalSpp' => 0.0,
                'totalDpp' => 0.0,
                'totalTabungan' => 0.0,
                'totalMahad' => 0.0,
            ];
        });

        $query = pemasukan::selectRaw('YEAR(pembayaran_bulan) as year, MONTH(pembayaran_bulan) as month, SUM(jumlah) as total,SUM(spp) as totalSpp , SUM(dpp) as totalDpp, SUM(tabungan) as totalTabungan, SUM(mahad) as totalMahad')
            ->whereYear('pembayaran_bulan', $this->selectedYear)
            ->groupBy(Db::raw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)'))
            ->orderByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)');

        $dataPemasukanTahunLalu = pemasukan::selectRaw('SUM(jumlah) as total, SUM(spp) as totalSpp, SUM(dpp) as totalDpp, SUM(tabungan) as totalTabungan, SUM(mahad) as totalMahad');

        if ($this->selectedMonth !== 'semua bulan') {
       
            $query->whereMonth('pembayaran_bulan', $this->selectedMonth)->whereYear('pembayaran_bulan', $this->selectedYear);
            $dataPemasukanTahunLalu->whereYear('pembayaran_bulan', '>=', $this->selectedYear)->whereYear('pembayaran_bulan', '<=', now()->year)->whereMonth('pembayaran_bulan', '>=', $this->selectedMonth)->whereMonth('pembayaran_bulan', '<=', now()->month)
                ->groupBy(Db::raw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)'))
                ->orderByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)');
        } else {
            $dataPemasukanTahunLalu->whereYear('pembayaran_bulan', '>=', $this->selectedYear)
                ->whereYear('pembayaran_bulan', '<=', now()->year)
                ->groupBy(Db::raw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)'))
                ->orderByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)');
        }


        $dataPemasukanTahunLalu = $dataPemasukanTahunLalu->get()->map(function ($item) {

            // $item->month_name = Carbon::parse($item->pembayaran_bulan)->format('F');
            return $item;
        });

        $this->pemasukans = $query->get()->map(function ($item) {
            $item->month_name = Carbon::createFromDate($item->year, $item->month, 1)->format('F');
            return $item;
        });


        if ($this->selectedMonth === 'semua bulan') {
            // dd($this->pemasukans, $dataPemasukanTahunLalu);

            $finalData = $defaultMonths->map(function ($item) {
                $matched = $this->pemasukans->firstWhere('month', $item['month']);
                return $matched ? $matched->toArray() : $item;
            });

            $this->pemasukans = $finalData;

           
        }


        $this->totalJumlahPemasukan = $this->pemasukans->sum('total');
        $this->totalJumlahPemasukanDpp = $this->pemasukans->sum('totalDpp');
        $this->totalJumlahPemasukanSpp = $this->pemasukans->sum('totalSpp');
        $this->totalJumlahPemasukanTabungan = $this->pemasukans->sum('totalTabungan');
        $this->totalJumlahPemasukanMahad = $this->pemasukans->sum('totalMahad');




        $this->totalAwalPemasukanDpp = $dataPemasukanTahunLalu->sum('totalDpp');
        $this->totalAwalPemasukanSpp = $dataPemasukanTahunLalu->sum('totalSpp');
        $this->totalAwalPemasukanTabungan = $dataPemasukanTahunLalu->sum('totalTabungan');
        $this->totalAwalPemasukanMahad = $dataPemasukanTahunLalu->sum('totalMahad');



        // dd($this->pemasukans);

        $this->totalSemuaPemasukan = $this->totalJumlahPemasukanDpp + $this->totalJumlahPemasukanSpp + $this->totalJumlahPemasukanTabungan + $this->totalJumlahPemasukanMahad;
    }

    public function getTotalSaldoAwal()
    {
        $banks = bank::all();
        $this->totalSaldoAwalPemasukanDpp = 0;
        $this->totalSaldoAwalPemasukanSpp = 0;
        $this->totalSaldoAwalPemasukanTabungan = 0;
        $this->totalSaldoAwalPemasukanMahad = 0;



        $pengeluaranAwal = pengeluaran::with('uraianKegiatan.subKategoriRab.kategori', 'bank');
        if ($this->selectedMonth !== 'semua bulan') {
          
            $pengeluaranAwal->whereYear('tanggal_pengeluaran', '>=', $this->selectedYear)->whereYear('tanggal_pengeluaran', '<=', now()->year)->whereMonth('tanggal_pengeluaran', '>=', $this->selectedMonth)->whereMonth('tanggal_pengeluaran', '<=', now()->month)
                ->orderByRaw('YEAR(tanggal_pengeluaran), MONTH(tanggal_pengeluaran)');

            // $pengeluaranAwal->pengeluaran::with('uraianKegiatan.subKategoriRab.kategori', 'bank')->get();
        } else {

            $pengeluaranAwal->whereYear('tanggal_pengeluaran', '>=', $this->selectedYear)
                ->whereYear('tanggal_pengeluaran', '<=', now()->year)
                ->orderByRaw('YEAR(tanggal_pengeluaran), MONTH(tanggal_pengeluaran)');
        }

        $pengeluaranAwal = $pengeluaranAwal->get();
        // dd($pengeluaranAwal);

        foreach ($banks as $bank) {

            if ($bank->jenis == 'DPP') {

                $this->totalSaldoAwalPemasukanDpp += $bank->saldo - $this->totalAwalPemasukanDpp + $pengeluaranAwal->where('jenis_id', $bank->id)->sum('jumlah');
            } elseif ($bank->jenis == 'SPP') {

                $this->totalSaldoAwalPemasukanSpp += $bank->saldo - $this->totalAwalPemasukanSpp + $pengeluaranAwal->where('jenis_id', $bank->id)->sum('jumlah');
            } elseif ($bank->jenis == 'Tabungan') {

                $this->totalSaldoAwalPemasukanTabungan += $bank->saldo - $this->totalAwalPemasukanTabungan + $pengeluaranAwal->where('jenis_id', $bank->id)->sum('jumlah');
            } elseif ($bank->jenis == 'MAHAD') {

                $this->totalSaldoAwalPemasukanMahad += $bank->saldo - $this->totalAwalPemasukanMahad + $pengeluaranAwal->where('jenis_id', $bank->id)->sum('jumlah');
            }
        }

        $this->totalJumlahSaldoAwal = $this->totalSaldoAwalPemasukanDpp + $this->totalSaldoAwalPemasukanSpp + $this->totalSaldoAwalPemasukanTabungan + $this->totalSaldoAwalPemasukanMahad;
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
