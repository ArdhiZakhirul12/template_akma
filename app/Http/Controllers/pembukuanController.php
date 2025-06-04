<?php

namespace App\Http\Controllers;

use App\Models\bank;
use App\Models\pemasukan;
use App\Models\pengeluaran;
use Barryvdh\DomPDF\PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class pembukuanController extends Controller
{
    //
    public function index(Request $request)
    {


        if ($request->has('pembayaran_bulan')) {
            $monthdate = Carbon::parse($request->input('pembayaran_bulan'))->subMonth()->translatedFormat('F Y');
            $yearDate = Carbon::parse($request->input('pembayaran_bulan'))->translatedFormat('Y');
        } else {
            $monthdate = $request->input('pembayaran_bulan', Carbon::now()->subMonth()->translatedFormat('F Y'));
            $yearDate = Carbon::now()->translatedFormat('Y');
        }





        $exMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $exYears = [];
        for ($year = date('Y') - 5 + 1; $year <= date('Y'); $year++) {
            $exYears[] = $year;
        }
        //BANKS
        $banks = bank::all();

        $bank_data_list = [
            $banks->pluck('jenis')->toArray(),
            $banks->pluck('presentase')->toArray()
        ];

        //SALDO AWAL
        $saldoAwal = pemasukan::query();


        //PENERIMAAN BERJALAN
        $penerimaan = pemasukan::query();


        //PENGELUARAN BERJALAN
        $pengeluaran = pengeluaran::query();



        //TOTAL PENGELUARAN PERBULAN
        $pengeluaran_perbulan = pengeluaran::query();


        $pemasukan_perbulan = pemasukan::query();




        $now = Carbon::now();

        if ($request->has('pembayaran_bulan') && $request->input('pembayaran_bulan') != null) {
            $pembayaran_bulan = $request->input('pembayaran_bulan');

            $selected_month = Carbon::createFromFormat('Y-m', $pembayaran_bulan);

            $saldoAwal->whereYear('pembayaran_bulan', '<', $selected_month->year)
                ->orWhere(function ($query) use ($selected_month) {
                    $query->whereYear('pembayaran_bulan', '=', $selected_month->year)
                        ->whereMonth('pembayaran_bulan', '<', $selected_month->month);
                })->orWhere(function ($query) use ($selected_month) {
                    // Tahun sebelumnya
                    $query->whereYear('pembayaran_bulan', '<', $selected_month->year);
                });

            $penerimaan->whereYear('pembayaran_bulan', $selected_month->year)
                ->whereMonth('pembayaran_bulan', $selected_month->month);

            $pengeluaran->whereYear('created_at', $selected_month->year)
                ->whereMonth('created_at', $selected_month->month);

            $pengeluaran_perbulan->selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, SUM(jumlah) as total_pengeluaran')
                ->whereYear('created_at', $selected_month->year)
                ->groupByRaw('YEAR(created_at), MONTH(created_at)');

            $pemasukan_perbulan->selectRaw('MONTH(pembayaran_bulan) as bulan, YEAR(pembayaran_bulan) as tahun, SUM(jumlah) as total_pemasukan')
                ->whereYear('pembayaran_bulan', $selected_month->year)
                ->groupByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)');
        } else {
            $saldoAwal->whereYear('pembayaran_bulan', '<', date('Y'))
                ->orWhere(function ($query) {
                    $query->whereYear('pembayaran_bulan', '=', date('Y'))
                        ->whereMonth('pembayaran_bulan', '<', date('m'));
                })->orWhere(function ($query) use ($now) {
                    // Tahun sebelumnya
                    $query->whereYear('pembayaran_bulan', '<', $now->year);
                });

            $penerimaan->whereYear('pembayaran_bulan', date('Y'))
                ->whereMonth('pembayaran_bulan', date('m'));

            $pengeluaran->whereYear('created_at', date('Y'))
                ->whereMonth('created_at', date('m'));


            $pengeluaran_perbulan->selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, SUM(jumlah) as total_pengeluaran')
                ->whereYear('created_at', date('Y'))
                ->groupByRaw('YEAR(created_at), MONTH(created_at)');


            $pemasukan_perbulan->selectRaw('MONTH(pembayaran_bulan) as bulan, YEAR(pembayaran_bulan) as tahun, SUM(jumlah) as total_pemasukan')
                ->whereYear('pembayaran_bulan', date('Y'))
                ->groupByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)');
        }

        $saldoAwal = $saldoAwal->orderBy('pembayaran_bulan', 'desc')->sum("jumlah");

        $penerimaan = $penerimaan->sum("jumlah");
        // $pengeluaran = Pengeluaran::with('bank')->get();

        $pengeluaranPerBank = $pengeluaran->get()->groupBy('bank.jenis')->map(function ($items) {
            return $items->sum('jumlah');
        });

        // Total keseluruhan pengeluaran
        $totalPengeluaran = $pengeluaran->sum('jumlah');

        // Gabungkan menjadi satu array
        $pengeluaran = [
            'per_bank' => $pengeluaranPerBank,
            'total' => $totalPengeluaran,
        ];
        // dd($pengeluaran);

        // $pengeluaran = $pengeluaran->sum("jumlah");


        $pemasukan_perbulan = $pemasukan_perbulan->orderByRaw('tahun, bulan')
            ->get();

        $pengeluaran_perbulan = $pengeluaran_perbulan->orderByRaw('tahun, bulan')
            ->get();


        // //TOTAL SALDO PERBULAN
        // $pengeluaran_perbulan = pengeluaran::selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, SUM(jumlah) as total_pengeluaran')
        //     ->groupByRaw('YEAR(created_at), MONTH(created_at)')
        //     ->orderByRaw('tahun, bulan')
        //     ->get();


        // $pemasukan_perbulan = pemasukan::selectRaw('MONTH(pembayaran_bulan) as bulan, YEAR(pembayaran_bulan) as tahun, SUM(jumlah) as total_pemasukan')
        //     ->groupByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)')
        //     ->orderByRaw('tahun, bulan')
        //     ->get();


        // PENGELUARAN TAHUNAN
        $pengeluaran_tahunan = pengeluaran::selectRaw('YEAR(created_at) as tahun, SUM(jumlah) as total_pengeluaran')
            ->groupByRaw('YEAR(created_at)')
            ->orderByRaw('tahun')
            ->get();

        // PEMASUKAN TAHUNAN
        $pemasukan_tahunan = pemasukan::selectRaw('YEAR(pembayaran_bulan) as tahun, SUM(jumlah) as total_pemasukan')
            ->groupByRaw('YEAR(pembayaran_bulan)')
            ->orderByRaw('tahun')
            ->get();

        // dd($pengeluaran_tahunan, $pemasukan_tahunan);


        $pemasukan_bulan_list = [];
        $pengeluaran_bulan_list = [];
        $saldo_akhir_list = [];
        $pemasukan_tahun = [];
        $pengeluaran_tahun = [];
        $saldo_akhir_list_tahun = [];

        foreach ($exMonths as $key => $month) {
            $pengeluaran_bulan_list[$month] = $pengeluaran_perbulan->firstWhere('bulan', $key + 1)->total_pengeluaran ?? 0;
            $pemasukan_bulan_list[$month] = $pemasukan_perbulan->firstWhere('bulan', $key + 1)->total_pemasukan ?? 0;
        }

        foreach ($exYears as $key => $year) {
            $pengeluaran_tahun[$year] = $pengeluaran_tahunan->firstWhere('tahun', $year)->total_pengeluaran ?? 0;
            $pemasukan_tahun[$year] = $pemasukan_tahunan->firstWhere('tahun', $year)->total_pemasukan ?? 0;
        }

        $saldoawal_perbulan = pemasukan::whereYear('pembayaran_bulan', date('Y'))
            ->whereMonth('pembayaran_bulan', 1)
            ->sum("jumlah");
        $saldoawal_pertahun = [];
        foreach ($exYears as $year) {
            $saldoawal_pertahun[$year] = pemasukan::whereYear('pembayaran_bulan', $year)
                ->sum("jumlah");
        }


        foreach ($exMonths as $key => $month) {
            $saldo_akhir_list[] = $saldoawal_perbulan + $pemasukan_bulan_list[$month] - $pengeluaran_bulan_list[$month];
            // $saldoawal_perbulan= $saldo_akhir_list[$month];
        }

        foreach ($exYears as $key => $year) {
            $saldo_akhir_list_tahun[] = $saldoawal_pertahun[$year] + $pemasukan_tahun[$year] - $pengeluaran_tahun[$year] ?? 0;
        }

        // dd($saldoawal_perbulan,$saldoawal_pertahun,$pemasukan_tahun, $pengeluaran_tahun, $saldo_akhir_list_tahun);

        // dd($saldo_akhir_list_tahun);
        // dd($yearDate, $monthdate, $exYears, $saldo_akhir_list, $saldo_akhir_list_tahun, $banks, $bank_data_list, $penerimaan,$pengeluaran,$saldoAwal);
        // dd($bank_data_list);
        // dd($saldoAwal, $penerimaan, $pengeluaran);


        return view('pages.pembukuan.index', compact('yearDate', 'monthdate', 'exYears', 'saldo_akhir_list', 'saldo_akhir_list_tahun', 'banks', 'bank_data_list', 'penerimaan', 'pengeluaran', 'saldoAwal'));
    }

    public function listPembukuan()
    {
        return view('pages.pembukuan.list_printed');
    }


    public function cetak_pdf()
    {
        // dd("testingggg");
        // $data = pemasukan::findOrFail($id);

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pages.pembukuan.printed_pdf', compact('data'));

        return $pdf->stream('pembukuan_' . '.pdf');
    }
}
