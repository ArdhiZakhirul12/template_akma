<?php

namespace App\Http\Controllers;

use App\Models\bank;
use App\Models\pemasukan;
use App\Models\pengeluaran;
use Carbon\Carbon;
use Illuminate\Http\Request;

class dashboardController extends Controller
{
    //
    public function index(Request $request)
    {

        if ($request->has('pembayaran_bulan') && $request->input('pembayaran_bulan') != null) {
            $monthdate = Carbon::parse($request->input('pembayaran_bulan'))->subMonth()->translatedFormat('F Y');
            $monthNow = Carbon::parse($request->input('pembayaran_bulan'))->translatedFormat('F Y');
        } else {
            $monthdate = Carbon::now()->subMonth()->translatedFormat('F Y');
            $monthNow = Carbon::now()->translatedFormat('F Y');
        }

        $picked_year = $request->has('pembayaran_bulan') ? Carbon::parse($request->input('pembayaran_bulan'))->year : Carbon::now()->year;

        $exMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];


        $banks = bank::all();

        $bank_data_list = [
            $banks->pluck('jenis')->toArray(),
            $banks->pluck('presentase')->toArray()
        ];

        $now = Carbon::now();

        //SALDO AWAL

        $saldoAwal = pemasukan::query();


        //PENERIMAAN BERJALAN
        $penerimaan = pemasukan::query();



        //PENGELUARAN BERJALAN
        $pengeluaran = pengeluaran::query();



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
        }


        // dd(
        //     $saldoAwal->get(),
        //     $penerimaan->where('kategori','mahad')->get()->sum("mahad"),
        //     $pengeluaran->get()
        // );

        $saldoAwalUmum = (clone $saldoAwal)->where('kategori', 'umum')->orderBy('pembayaran_bulan', 'desc')->sum("dpp");
        $saldoAwalUmum += (clone $saldoAwal)->where('kategori', 'umum')->orderBy('pembayaran_bulan', 'desc')->sum("spp") + (clone $saldoAwal)->where('kategori', 'umum')->orderBy('pembayaran_bulan', 'desc')->sum("tabungan");

        $penerimaanUmum = (clone $penerimaan)->where('kategori', 'umum')->sum("dpp");
        $penerimaanUmum += (clone $penerimaan)->where('kategori', 'umum')->sum("spp") + (clone $penerimaan)->where('kategori', 'umum')->sum("tabungan");

        $pengeluaranUmum = (clone $pengeluaran)->where('kategori', 'umum')->sum("jumlah");

        // SALDO AKHIR
        $saldoAkhirUmum = $saldoAwalUmum + $penerimaanUmum - $pengeluaranUmum;

        $saldoAwalMahad = (clone $saldoAwal)->where('kategori', 'mahad')->orderBy('pembayaran_bulan', 'desc')->sum("mahad");

        $penerimaanMahad = (clone $penerimaan)->where('kategori', 'mahad')->sum("mahad");

        $pengeluaranMahad = (clone $pengeluaran)->where('kategori', 'mahad')->sum("jumlah");


        //SALDO AKHIR
        $saldoAkhirMahad = $saldoAwalMahad + $penerimaanMahad - $pengeluaranMahad;


        //DETAIL SALDO AKHIR
        $pengeluaran_perbulan = pengeluaran::query();

        $pemasukan_perbulan = pemasukan::query();

        $saldoawal_perbulan = pemasukan::query();

        $pengeluaran_perbulan_mahad = pengeluaran::query();

        $pemasukan_perbulan_mahad = pemasukan::query();

        $saldoawal_perbulan_mahad = pemasukan::query();

        if ($request->has('pembayaran_bulan') && $request->input('pembayaran_bulan') != null) {
            $pembayaran_bulan = $request->input('pembayaran_bulan');
            $selected_month = Carbon::createFromFormat('Y-m', $pembayaran_bulan);

            $pengeluaran_perbulan->selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, SUM(jumlah) as total_pengeluaran')
                ->whereYear('created_at', $selected_month->year);

            $pemasukan_perbulan->selectRaw('MONTH(pembayaran_bulan) as bulan, YEAR(pembayaran_bulan) as tahun, SUM(jumlah) as total_pemasukan')
                ->whereYear('created_at', $selected_month->year);


            $saldoawal_perbulan->whereYear('pembayaran_bulan', '<', $selected_month->year);

            $pengeluaran_perbulan_mahad->selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, SUM(jumlah) as total_pengeluaran')
                ->whereYear('created_at', $selected_month->year);

            $pemasukan_perbulan_mahad->selectRaw('MONTH(pembayaran_bulan) as bulan, YEAR(pembayaran_bulan) as tahun, SUM(jumlah) as total_pemasukan')
                ->whereYear('created_at', $selected_month->year);


            $saldoawal_perbulan_mahad->whereYear('pembayaran_bulan', '<', $selected_month->year);
        } else {
            $pengeluaran_perbulan->selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, SUM(jumlah) as total_pengeluaran')
                ->whereYear('created_at', date('Y'));

            $pemasukan_perbulan->selectRaw('MONTH(pembayaran_bulan) as bulan, YEAR(pembayaran_bulan) as tahun, SUM(dpp + spp + tabungan) as total_pemasukan')
                ->whereYear('created_at', date('Y'));

            $saldoawal_perbulan->whereYear('pembayaran_bulan', '<', date('Y'));

            $pengeluaran_perbulan_mahad->selectRaw('MONTH(created_at) as bulan, YEAR(created_at) as tahun, SUM(jumlah) as total_pengeluaran')
                ->whereYear('created_at', date('Y'));

            $pemasukan_perbulan_mahad->selectRaw('MONTH(pembayaran_bulan) as bulan, YEAR(pembayaran_bulan) as tahun, SUM(mahad) as total_pemasukan')
                ->whereYear('created_at', date('Y'));

            $saldoawal_perbulan_mahad->whereYear('pembayaran_bulan', '<', date('Y'));
        }

        $pengeluaran_perbulan = $pengeluaran_perbulan->where("kategori",'umum')->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('tahun, bulan')
            ->get();

        $pemasukan_perbulan =  $pemasukan_perbulan->where("kategori",'umum')->groupByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)')
            ->orderByRaw('tahun, bulan')
            ->get();


        $saldoawal_perbulan = $saldoawal_perbulan->where("kategori",'umum')->whereYear('pembayaran_bulan', date('Y'))
            ->whereMonth('pembayaran_bulan', 1)
            ->sum("jumlah");


        $pengeluaran_perbulan_Mahad = $pengeluaran_perbulan_mahad->where("kategori",'mahad')->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('tahun, bulan')
            ->get();

        $pemasukan_perbulan_Mahad =  $pemasukan_perbulan_mahad->where("kategori",'mahad')->groupByRaw('YEAR(pembayaran_bulan), MONTH(pembayaran_bulan)')
            ->orderByRaw('tahun, bulan')
            ->get();


        // $saldoawal_perbulan_Mahad = $saldoawal_perbulan_mahad->where("kategori",'mahad')->whereYear('pembayaran_bulan', date('Y'))
        //     ->whereMonth('pembayaran_bulan', 1)
        //     ->sum("mahad");

        $saldoawal_perbulan_Mahad = $saldoawal_perbulan_mahad ->where("kategori", "mahad")
                ->whereDate("pembayaran_bulan", "<=", date('Y') . "-01-01") // before or on January 1st this year
                ->sum("mahad");

        
        $pemasukan_bulan_list = [];
        $pengeluaran_bulan_list = [];
        $saldo_akhir_list = [];

        $pemasukan_bulan_list_mahad = [];
        $pengeluaran_bulan_list_mahad = [];
        $saldo_akhir_list_mahad = [];

        foreach ($exMonths as $key => $month) {
            $pengeluaran_bulan_list[$month] = $pengeluaran_perbulan->firstWhere('bulan', $key + 1)->total_pengeluaran ?? 0;
            $pemasukan_bulan_list[$month] = $pemasukan_perbulan->firstWhere('bulan', $key + 1)->total_pemasukan ?? 0;
            $pengeluaran_bulan_list_mahad[$month] = $pengeluaran_perbulan_Mahad->firstWhere('bulan', $key + 1)->total_pengeluaran ?? 0;
            $pemasukan_bulan_list_mahad[$month] = $pemasukan_perbulan_Mahad->firstWhere('bulan', $key + 1)->total_pemasukan ?? 0;
        }
        
        foreach ($exMonths as $key => $month) {
            $saldo_akhir_list[$month] = $saldoawal_perbulan + $pemasukan_bulan_list[$month] - $pengeluaran_bulan_list[$month];
            $saldoawal_perbulan = $saldo_akhir_list[$month];
            $saldo_akhir_list_mahad[$month] =$saldoawal_perbulan_Mahad + $pemasukan_bulan_list_mahad[$month] - $pengeluaran_bulan_list_mahad[$month];
            $saldoawal_perbulan_Mahad = $saldo_akhir_list_mahad[$month];
        }

        // dd($saldo_akhir_list_mahad,$pemasukan_bulan_list_mahad,$pengeluaran_bulan_list_mahad,$saldoawal_perbulan_Mahad);

       
    




        return view('dashboard', compact('picked_year', 'monthNow', 'monthdate', 'saldoAwalUmum', 'penerimaanUmum', 'pengeluaranUmum', 'saldoAkhirUmum', 'saldoAwalMahad', 'penerimaanMahad', 'pengeluaranMahad', 'saldoAkhirMahad', 'pemasukan_bulan_list', 'pengeluaran_bulan_list', 'saldo_akhir_list', 'bank_data_list','pemasukan_bulan_list_mahad', 'pengeluaran_bulan_list_mahad', 'saldo_akhir_list_mahad', 'bank_data_list', 'banks'));
    }
}
