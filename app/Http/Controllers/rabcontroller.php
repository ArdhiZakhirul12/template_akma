<?php

namespace App\Http\Controllers;

use App\Models\bank;
use App\Models\kategoriRab;
use App\Models\pengeluaran;
use App\Models\subKategoriRab;
use App\Models\uraianKegiatan;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Impor facade Log untuk logging
use Exception;

class rabcontroller extends Controller
{
    //
    public function index()
    {
        $kategoris = kategoriRab::all();
        $uraians =  uraianKegiatan::with("subKategoriRab.kategori")->get();
        $notifikasi = [];
        foreach ($uraians as $uraian){
            $total =  pengeluaran::where('uraian_kegiatan_id', $uraian->id)
                                ->whereYear('created_at', now()->year)
                                ->sum('jumlah');
            $selisih = $uraian->batas_max - $total;
            $status = "Normal";
            if ($uraian->batas_max < $total) {
                $status = "Melebihi batas sebanyak " . toRupiah(abs($selisih));
             
            }
            elseif($total == $uraian->batas_max){
                $status = "Mencapai batas maksimal";
            }
            
            elseif( $total >= $uraian->batas_max - ($uraian->batas_max * 0.1) ){
                $status = "Mendekati batas maksimal";
          
            }
            // else{
            //     dd($total,$uraian->batas_max,$selisih,$total * 0.1);
            // }

            if($status != "Normal"){
                $notifikasi[] = [
                    'id' => $uraian->id,
                    'uraian' => $uraian->uraian_kegiatan,
                    'total' => toRupiah($total),
                    'kategori' => $uraian->subKategoriRab->kategori->kategori,
                    'sub_kategori' => $uraian->subKategoriRab->sub_kategori,
                    'batas_max' => toRupiah($uraian->batas_max),
                    'selisih' => toRupiah($selisih),
                    'status' => $status,
                ];
            }
           
        }

        $banks = bank::all();
        $sumBank = $banks->sum('presentase');
      
        
        return view('pages.rab.index', compact('kategoris','notifikasi','banks','sumBank'));
    }
    public function create()
    {
        return view('rab.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required'
        ]);
        kategoriRab::create($validated);
        return redirect()->back()->with([
            'success'=> 'Data saved successfully!',
            'action' => 'create',
        ]);
    }
    public function show(string $id)
    {
        $subs = subKategoriRab::where('kategori_rabs_id', $id)->get();
        return view('pages.rab.show', compact('subs','id'));
        
    }
    public function uraianShow(string $id)
    {
        
        $uraians = uraianKegiatan::where('sub_kategori_id', $id)->with('pengeluaran')->get();
        return view('pages.rab.uraian', compact('uraians','id'));

    }
    public function subStore(Request $request)
    {
        $validated = $request->validate([
            'sub_kategori' => 'required',
            'kategori_rabs_id' => 'required'
        ]);
        subKategoriRab::create($validated);
        return redirect()->back()->with([
            'success'=> 'Data saved successfully!',
            'action' => 'create'
        ]);
    }
    public function uraianStore(Request $request)
    {

        try {
            $request->merge([
                'biaya_satuan' => preg_replace('/\D/', '', $request->biaya_satuan),
                'batas_max' => preg_replace('/\D/', '', $request->batas_max),
            ]);
        
            $validated = $request->validate([
                'uraian_kegiatan' => 'required',
                'keterangan' => 'required',
                'batas_max' => 'required',
                'sub_kategori_id' => 'required',
                'biaya_satuan' => 'required',
                'satuan' => 'required',
                'volume' => 'required'
            ]);
            uraianKegiatan::create($validated);

        }catch (ValidationException $e) {
            dd($e->errors()); // This will show you what failed in validation
        }


      
        return redirect()->back()->with([
            'success'=> 'Data saved successfully!',
            'action' => 'create'
        ]);
    }
    public function edit($id)
    {
        // Retrieve and display a form for editing a specific resource by ID
        // return view('rab.edit', compact('id'));
    }
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kategori' => 'required'
        ]);
        kategoriRab::where('id', $id)->update($validated);
        return redirect()->back()->with([
            'success' => 'Data saved successfully!',
            'action' => 'update'
        ]);

    }

    public function updateBank(Request $request)
    {
        try {
            // Validasi data
            $validated = $request->validate([
                'id' => 'required|numeric', // Pastikan Anda mengirimkan 'id' dari form
                'presentase' => 'required|numeric|min:0|max:100' // Tambahkan validasi min/max jika perlu
            ]);

            // Lakukan update
            $bank = bank::where('id', $request->id)->update([
                'presentase' => $validated['presentase']
            ]);

            // Jika update berhasil (biasanya mengembalikan 1 jika ada baris yang diupdate)
            if ($bank) {
                return redirect()->back()->with('success', 'Presentase bank berhasil diperbarui!');
            } else {
                // Jika tidak ada baris yang diupdate (misalnya ID tidak ditemukan)
                return redirect()->back()->with('error', 'Gagal memperbarui presentase bank. ID tidak ditemukan atau tidak ada perubahan.');
            }

        } catch (Exception $e) {
            // Log error untuk debugging
            Log::error('Error updating bank percentage: ' . $e->getMessage(), [
                'request_id' => $request->id ?? 'N/A', // Log ID yang dicoba diupdate
                'request_presentase' => $request->presentase ?? 'N/A', // Log presentase yang dicoba diupdate
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);

            // Redirect kembali dengan pesan error
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui presentase bank. Silakan coba lagi atau hubungi administrator.');
        }
    }

    public function showUraian($id)
    {
        
        $uraian =  uraianKegiatan::with("subKategoriRab.kategori")->find($id);
        $total =  pengeluaran::where('uraian_kegiatan_id', $uraian->id)
        ->whereYear('created_at', now()->year)
        ->sum('jumlah');
        $selisih = $uraian->batas_max - $total;
        $status = "Normal";
        if ($uraian->batas_max < $total) {
            $status = "Melebihi batas sebanyak " . toRupiah(abs($selisih));
        }
        elseif($total == $uraian->batas_max){
            $status = "Mencapai batas maksimal";
        }
        
        elseif( $total >= $uraian->batas_max - ($uraian->batas_max * 0.1) ){
            $status = "Mendekati batas maksimal";
      
        }
      

        return view('pages.rab.show-uraian', compact('uraian','selisih', 'status', 'total'));

    }



    public function subUpdate(Request $request, $id)
    {
        $validated = $request->validate([
            'sub_kategori' => 'required'
        ]);
        subKategoriRab::where('id', $id)->update($validated);
        return redirect()->back()->with([
            'success'=> 'Data saved successfully!',
            'action' => 'update'
        ]);
    }


    public function uraianUpdate(Request $request, $id)
    {

        $request->merge([
            'biaya_satuan' => preg_replace('/\D/', '', $request->biaya_satuan),
            'batas_max' => preg_replace('/\D/', '', $request->batas_max),
        ]);
        $validated = $request->validate([
            'uraian_kegiatan' => 'required',
            'keterangan' => 'required',
            'batas_max' => 'required',
            'volume' => 'required',
            'biaya_satuan' => 'required',
            'satuan' => 'required',
        ]);
        uraianKegiatan::where('id', $id)->update($validated);
        return redirect()->back()->with([
            'success'=> 'Data saved successfully!',
            'action' => 'update'
        ]);
    }

    public function showRekap($id)
    {
    
        return view('pages.rab.show-rekap', compact('id'));
    }

    public function destroy($id)
    {
        // Delete the resource by ID
        // Redirect or return a response after processing
        // return redirect()->route('rab.index')->with('success', 'Data deleted successfully!');
    }
    
}
