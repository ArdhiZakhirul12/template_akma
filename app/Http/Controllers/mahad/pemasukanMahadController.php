<?php

namespace App\Http\Controllers\mahad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DateTime;
use App\Models\pemasukan;
use App\Models\bank;
use App\Models\siswa;
use App\Services\WaService;
use Illuminate\Validation\ValidationException;

class pemasukanMahadController extends Controller
{
    public function index()
    {
        return view('pages.mahad.pemasukan.index');
    }

    public function store(Request $request)
    {
try{
        $request->merge([
            'mahad' => preg_replace('/\D/', '', $request->mahad),
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
            'pembayaran_bulan' => 'required|date_format:Y-m'
        ]);


        // Set the date to the first day of the month
        $date = DateTime::createFromFormat('Y-m', $validated['pembayaran_bulan']);
        $validated['pembayaran_bulan'] = $date->format('Y-m-01');

        // Ambil bulan dan tahun dari tanggal input
        $bulan = $date->format('m');
        $tahun = $date->format('Y');

        $validated['jumlah'] = 0;
        $validated['dpp'] = 0;
        $validated['spp'] = 0;
        $validated['tabungan'] =  0;

        $pembayaran = pemasukan::where('siswa_id', $request->siswa_id)->where('kategori', 'mahad')
            ->whereMonth('pembayaran_bulan', $bulan)
            ->whereYear('pembayaran_bulan', $tahun)
            ->count();

        $bankMahad = bank::where('jenis', 'MAHAD')->first();
        $totalDana = $bankMahad->jumlah + $request->mahad;
        bank::where('jenis', 'MAHAD')->update(['saldo' => $totalDana]);
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
                . "- Ma'had    : Rp. " . number_format($validated['mahad'], 0, ',', '.') . ".\n\n"

                . "🙏 *Terima kasih* atas pembayarannya.\n"
                . "Silakan hubungi pihak madrasah jika ada pertanyaan lebih lanjut.\n\n"
                . "Wassalamu'alaikum Warahmatullahi Wabarakatuh.";

            $wa = new WaService();
            $wa->sendMessage($no_hp->no_hp_wali, $message);

        return redirect()->route('mahad.pemasukan.index')->with([
            'success' => 'Pemasukan berhasil ditambahkan.',
            'action' => 'create',
        ]);
    } catch (ValidationException $e) {
        dd($e->errors()); // This will show you what failed in validation
    }
    }

    public function show($id)
    {
        // Logic to show pemasukan details
        // ...
        return view('mahad.pemasukan.show', compact('id'));
    }
}
