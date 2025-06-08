<?php

namespace App\Http\Controllers;

use App\Models\bank;
use App\Models\pengeluaran;
use App\Models\subKategoriRab;
use App\Models\uraianKegiatan;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class pengeluaranController extends Controller
{
    //
    public function index(){
        // $pengeluarans = uraianKegiatan::with('subKategoriRab.kategori')->get();
        // $pengeluarans = pengeluaran::with('uraianKegiatan.subKategoriRab.kategori','bank')->get();
        // $subKategoriRabs= subKategoriRab::all();
        // dd($subKategoriRabs);
        // dd($pengeluarans);
        return view('pages.pengeluaran.index');
    }

    public function show($id){
        $pengeluaran = pengeluaran::with('uraianKegiatan.subKategoriRab.kategori','bank')->findOrFail($id);
        // dd($pengeluaran);
        return view('pages.pengeluaran.show', compact('pengeluaran'));
    }
    

    public function create(){
        // $uraianKegiatans = uraianKegiatan::with('subKategoriRab.kategori')->get();
        // dd($uraianKegiatans);
        return view('pages.pengeluaran.create');
    }


    public function store(Request $request)
    {
        
        try {
            $request->merge([
                'jumlah' => preg_replace('/\D/', '', $request->jumlah),
            ]);
            $validated = $request->validate([
                'uraian_kegiatan_id' => 'required',
                'jenis_id' => 'required',
                'dokumen' => 'required|image|max:2048',
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
        return redirect()->route('pengeluaran.index')->with([
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
