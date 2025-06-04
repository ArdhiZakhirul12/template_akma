<?php

namespace App\Http\Controllers;

use App\Models\bank;
use App\Models\pemasukan;
use App\Models\siswa;
use \Carbon\Carbon;
use Illuminate\Http\Request;
use \DateTime;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\updated;

class pemasukanController extends Controller
{
    //
    public function index()
    {

        $pemasukans = pemasukan::with('siswa')->get();
        $siswas = siswa::with('kelas')->get();
        return view('pages.pemasukan.index', compact('pemasukans', 'siswas'));
    }

    public function show($id)
    {
        $pemasukan = pemasukan::with('siswa.kelas')->findOrFail($id);
        $siswas = siswa::with('kelas')->get();
        return view('pages.pemasukan.show', compact('pemasukan', 'siswas'));
    }

    public function create()
    {
        $siswas = siswa::with('kelas')->get();
        return view('pages.pemasukan.create', compact('siswas'));
    }
    public function store(Request $request)
    {

        $request->merge([
            'jumlah' => preg_replace('/\D/', '', $request->jumlah),
        ]);
        $validated = $request->validate([
            'siswa_id' => 'required',
            'jumlah' => 'required|numeric',
            'pembayaran_bulan' => 'required|date_format:Y-m'
        ]);

        // Set the date to the first day of the month
        $date = DateTime::createFromFormat('Y-m', $validated['pembayaran_bulan']);
        $validated['pembayaran_bulan'] = $date->format('Y-m-01');

        // Ambil bulan dan tahun dari tanggal input
        $bulan = $date->format('m');
        $tahun = $date->format('Y');

        $pembayaran = pemasukan::where('siswa_id', $request->siswa_id)
            ->whereMonth('pembayaran_bulan', $bulan)
            ->whereYear('pembayaran_bulan', $tahun)
            ->count();


        $banks = bank::all();
        foreach ($banks as $bank) {
            $masuk = $request->jumlah * ($bank->presentase / 100);
            $newSaldo = $masuk + $bank->saldo;
            bank::where('id', $bank->id)->update(['saldo' => $newSaldo]);
        }
        $validated['pembayaranKe'] = $pembayaran + 1;
        pemasukan::create($validated);

        return redirect()->route('pemasukan.index')->with([
            'success'=> 'Pemasukan berhasil ditambahkan.',
            'action' => 'create',
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->merge([
                'jumlah' => preg_replace('/\D/', '', $request->jumlah),
            ]);

            $validated = $request->validate([
                'siswa_id' => 'required',
                'jumlah' => 'required|numeric',
                'pembayaranKe' => 'required|numeric',
                'pembayaran_bulan' => 'required|date_format:Y-m'
            ]);


            $existingPemasukan = pemasukan::findOrFail($id);


            if ($request->jumlah != $existingPemasukan->jumlah) {
                $difference = $request->jumlah - $existingPemasukan->jumlah;

                // dd($request->jumlah, $existingPemasukan->jumlah, $difference);

                $banks = bank::all();
                foreach ($banks as $bank) {
                    $adjustment = $difference * ($bank->presentase / 100);
                    $newSaldo = $bank->saldo + $adjustment;
                    bank::where('id', $bank->id)->update(['saldo' => $newSaldo]);
                }
            }

            $date = DateTime::createFromFormat('Y-m', $validated['pembayaran_bulan']);
            $validated['pembayaran_bulan'] = $date->format('Y-m-01');
        } catch (ValidationException $e) {
            dd($e->errors()); // This will show you what failed in validation
        }

        pemasukan::where('id', $id)->update($validated);

        return redirect()->route('pemasukan.show', $id)->with([
            'success' => 'Pemasukan berhasil diperbarui.',
            'action' => 'update'
        ]);
    }

    public function calender(String $id)
    {
        return view('pages.pemasukan.calender.index', compact('id'));
    }
}
