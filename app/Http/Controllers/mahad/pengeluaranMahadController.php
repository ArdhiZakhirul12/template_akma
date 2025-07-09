<?php

namespace App\Http\Controllers\mahad;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\pengeluaran;
use App\Models\bank;
use Illuminate\Validation\ValidationException;

class pengeluaranMahadController extends Controller
{
 
    //
    public function index(){
     
        $pengeluarans = pengeluaran::with('uraianKegiatan.subKategoriRab.kategori','bank')->get();
        $pengeluarans = $pengeluarans->where('jenis_id', function ($query) {
            $query->select('id')
                  ->from('bank')
                  ->where('jenis', 'MAHAD');
        });

        return view('pages.mahad.pengeluaran.index', compact('pengeluarans'));
    }

    public function show($id){
        $pengeluaran = pengeluaran::with('uraianKegiatan.subKategoriRab.kategori','bank')->findOrFail($id);
        // dd($pengeluaran);
        return view('pages.pengeluaran.show', compact('pengeluaran'));
    }
    

    public function store(Request $request)
    {
        
        try {
            $request->merge([
                'jumlah' => preg_replace('/\D/', '', $request->jumlah),
            ]);
            $validated = $request->validate([
                'user_id' => 'required',
                'uraian_kegiatan_id' => 'required',
                'kategori' => 'required',
                'jenis_id' => 'required',
                'dokumen' => 'required|image|max:2048',
                'tanggal_pengeluaran' => 'required|date',
                'jumlah' => 'required',
                'keterangan' => 'nullable',
            ]);

            $bank = bank::findOrFail($request->jenis_id);
            $newSaldo =  $bank->saldo - $request->jumlah;
            bank::where('id', $request->jenis_id)->update(['saldo' => $newSaldo]);
    
            if ($request->hasFile('dokumen')) {
                $validated['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
            }
    
            // dd($validated);
    
        } catch (ValidationException $e) {
            dd($e->errors()); // This will show you what failed in validation
        }
        pengeluaran::create($validated);
        return redirect()->route('mahad.pengeluaran.index')->with([
            'success' => 'Data pengeluaran berhasil ditambahkan',
            'action' => 'create',
        ]);
    }


    public function update(Request $request,$id)
    {
        $pengeluaran = pengeluaran::findOrFail($id);
        // dd($pengeluaran);
        try {
            $request->merge([
                'jumlah' => preg_replace('/\D/', '', $request->jumlah),
            ]);
            $validated = $request->validate([
                'uraian_kegiatan_id' => 'required',
                'jenis_id' => 'required',
                'dokumen' => 'nullable|image|max:2048',
                'tanggal_pengeluaran' => 'required|date',
                'jumlah' => 'required',
                'keterangan' => 'nullable',
            ]);

            if ($request->jumlah != $pengeluaran->jumlah) {
                $bank = bank::findOrFail($request->jenis_id);
                $total = $pengeluaran->jumlah - $request->jumlah;
                $newSaldo = $bank->saldo - $total;
                bank::where('id', $request->jenis_id)->update(['saldo' => $newSaldo]);
            }
    
    
            if ($request->hasFile('dokumen')) {
                $validated['dokumen'] = $request->file('dokumen')->store('dokumen', 'public');
            }
    
            // dd($validated);
    
        } catch (ValidationException $e) {
            dd($e->errors()); // This will show you what failed in validation
        }
        $pengeluaran->update($validated);
        return redirect()->route('pengeluaran.show',$id)->with([
            'success'=> 'Data pengeluaran berhasil diubah',
            'action' => 'update'
        ]);
    }
}
