<?php

namespace App\Http\Controllers;

use App\Models\pemasukan;
use App\Models\Setoran;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class setorTunaiController extends Controller
{
    public function index()
    {
        $setorTunai = Setoran::with('user')->get();
        $totalSetorTunai = $setorTunai->sum('jumlah');
        $dataPenerimaan = pemasukan::where("metode_pembayaran", "tunai")->get();
        $totalSpp = $dataPenerimaan->sum('spp');
        $totalDpp = $dataPenerimaan->sum('dpp');
        $totalMahad = $dataPenerimaan->sum('mahad');
        $totalTabungan = $dataPenerimaan->sum('tabungan');
        $totalPenerimaan = $totalSpp + $totalDpp + $totalMahad + $totalTabungan - $totalSetorTunai;

        

        return view('pages.setor.index', compact('setorTunai', 'totalPenerimaan', 'totalSetorTunai'));
    
    }

    public function show($id)
    {
        $setorTunai = Setoran::findOrFail($id);
        return view('pages.setor.show', compact('setorTunai'));
    }


    public function store(Request $request)
    {

        try {
            $request->merge([
                'jumlah' => preg_replace('/\D/', '', $request->jumlah),
            ]);

            $validated = $request->validate([
                'user_id' => 'required',
                'nama_setoran' => 'string|max:255',
                'tanggal_setoran' => 'date',
                'jumlah' => 'numeric',
                'keterangan' => 'nullable|string|max:255',
                'image' => 'required|image|max:2048',
            ]);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('image', 'public');
            }

            Setoran::create($validated);
        } catch (ValidationException $e) {
           
        }

        return redirect()->route('setor.index')->with('success', 'Setoran berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        try {

            $request->merge([
                'jumlah' => preg_replace('/\D/', '', $request->jumlah),
            ]);
            $validated = $request->validate([
                'nama_setoran' => 'required',
                'jumlah' => 'required|numeric',
                'tanggal_setoran' => 'required|date',
                'keterangan' => 'nullable|string|max:255',
                'image' => 'nullable|image|max:2048',
            ]);

            $setoran = Setoran::findOrFail($id);

            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('image', 'public');
            } else {
                $validated['image'] = $setoran->image; // Keep the previous image if no new image is uploaded
            }

            Setoran::where('id', $id)->update($validated);
            return redirect()->back()->with([
                'success' => 'Data saved successfully!',
                'action' => 'update'
            ]);
        } catch (ValidationException $e) {
            
        }
    }
}
