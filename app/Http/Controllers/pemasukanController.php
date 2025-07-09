<?php

namespace App\Http\Controllers;

use App\Models\bank;
use App\Models\pemasukan;
use App\Models\siswa;
use \Carbon\Carbon;
use Illuminate\Http\Request;
use \DateTime;
use App\Services\WaService;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\updated;

class pemasukanController extends Controller
{
    //
    public function index()
    {

        // $pemasukans = pemasukan::with('siswa')->get();
        // $siswas = siswa::with('kelas')->get();
        return view('pages.pemasukan.index');
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

        try {
            $request->merge([
                'jumlah' => preg_replace('/\D/', '', $request->jumlah),
                'spp' => preg_replace('/\D/', '', $request->spp),
                'tabungan' => preg_replace('/\D/', '', $request->tabungan),
                'dpp' => preg_replace('/\D/', '', $request->dpp),
            ]);

            $validated = $request->validate([
                'siswa_id' => 'required',
                'user_id' => 'required',
                'kategori' => 'required',
                'jumlah' => 'nullable|numeric',
                'dpp' => 'nullable|numeric',
                'spp' => 'nullable|numeric',
                'tabungan' => 'nullable|numeric',
                'mahad' => 'nullable|numeric',
                'metode_pembayaran' => 'required',
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


            $validated['dpp'] = $request->dpp !== "" ? $request->dpp : 0;
            $validated['spp'] = $request->spp !== "" ? $request->spp : 0;
            $validated['tabungan'] = $request->tabungan !== "" ? $request->tabungan : 0;
            $validated['mahad'] = $request->mahad !== "" ? $request->mahad : 0;

            // dd($validated);
            $paymentTypes = ['spp' => 'spp', 'dpp' => 'dpp', 'tabungan' => 'tabungan'];

            foreach ($paymentTypes as $key => $type) {
                $newSaldo = 0;
                if ($request->$key !== null) {

                    $current = bank::where('jenis', $type)->first();
                    $newSaldo = (int)$validated[$key] + (int)$current->saldo;
                    bank::where('jenis', $type)->update(['saldo' => $newSaldo]);
                }
            }
            // dd($pembayaran);
            $validated['pembayaranKe'] = $pembayaran + 1;
            pemasukan::create($validated);
            $no_hp = siswa::where('id', $request->siswa_id)->first();
            $message = "*📌 Konfirmasi Pembayaran Siswa*\n\n"
                . "👨‍👩‍👧 *Wali Murid*.\n"
                . "Assalamu'alaikum Warahmatullahi Wabarakatuh,\n\n"

                . "Telah dilakukan pembayaran oleh putra/putri Bapak/Ibu dengan detail sebagai berikut:\n\n"

                . "👤 *Nama Siswa:* {$no_hp->nama}.\n"
                . "🏫 *Kelas:* {$no_hp->kelas->tingkatan} {$no_hp->kelas->kelas}.\n\n"

                . "💳 *Rincian Pembayaran:*\n"
                . "- DPP       : Rp. " . number_format($validated['dpp'], 0, ',', '.') . ".\n"
                . "- SPP       : Rp. " . number_format($validated['spp'], 0, ',', '.') . ".\n"
                . "- Tabungan  : Rp. " . number_format($validated['tabungan'], 0, ',', '.') . ".\n"
                

                . "🙏 *Terima kasih* atas pembayarannya.\n"
                . "Silakan hubungi pihak madrasah jika ada pertanyaan lebih lanjut.\n\n"
                . "Wassalamu'alaikum Warahmatullahi Wabarakatuh.";

            $wa = new WaService();
            $wa->sendMessage($no_hp->no_hp_wali, $message);
        } catch (ValidationException $e) {
            
        }


        return redirect()->route('pemasukan.index')->with([
            'success' => 'Pemasukan berhasil ditambahkan.',
            'action' => 'create',
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->merge([
                'jumlah' => preg_replace('/\D/', '', $request->jumlah),
                'spp' => preg_replace('/\D/', '', $request->spp),
                'tabungan' => preg_replace('/\D/', '', $request->tabungan),
                'dpp' => preg_replace('/\D/', '', $request->dpp),
            ]);

            $validated = $request->validate([
                'siswa_id' => 'required',
                'jumlah' => 'nullable|numeric',
                'dpp' => 'nullable|numeric',
                'spp' => 'nullable|numeric',
                'tabungan' => 'nullable|numeric',
                'metode_pembayaran' => 'required',
                'pembayaranKe' => 'required|numeric',
                'pembayaran_bulan' => 'required|date_format:Y-m'
            ]);


            $existingPemasukan = pemasukan::findOrFail($id);
            $validated['dpp'] = $request->dpp ?? 0;
            $validated['spp'] = $request->spp ?? 0;
            $validated['tabungan'] = $request->tabungan ?? 0;

            if ($request->jumlah != $existingPemasukan->jumlah) {

                $banks = bank::all();
                foreach ($banks as $bank) {
                    if ($bank->jenis === 'DPP' && $request->dpp !== null) {
                        $adjustment = $request->dpp;
                    } elseif ($bank->jenis === 'SPP' && $request->spp !== null) {
                        $adjustment = $request->spp;
                    } elseif ($bank->jenis === 'Tabungan' && $request->tabungan !== null) {
                        $adjustment = $request->tabungan;
                    }
                    $newSaldo = $bank->saldo + $adjustment;
                    bank::where('id', $bank->id)->update(['saldo' => $newSaldo]);
                }
            }

            $date = DateTime::createFromFormat('Y-m', $validated['pembayaran_bulan']);
            $validated['pembayaran_bulan'] = $date->format('Y-m-01');
        } catch (ValidationException $e) {
            
        }

        pemasukan::where('id', $id)->update($validated);

        return redirect()->route('pemasukan.show', $id)->with([
            'success' => 'Pemasukan berhasil diperbarui.',
            'action' => 'update'
        ]);
    }

    public function calender(String $id, String $jenis)
    {
        return view('pages.pemasukan.calender.index', compact('id', 'jenis'));
    }
}
