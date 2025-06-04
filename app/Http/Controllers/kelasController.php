<?php

namespace App\Http\Controllers;

use App\Models\hargaKelas;
use App\Models\kelas;
use App\Models\siswa;
use Illuminate\Http\Request;

class kelasController extends Controller
{
    //
    public function index()
    {

        $kelas = kelas::all();
        $hargas = hargaKelas::all();
        return view('pages.kelas.index',compact('kelas','hargas'));
    }

    public function siswa_kelas_list($id)
    {
        $siswas = siswa::where('kelas_id', $id)->get();
        $kelasName = kelas::where('id', $id)->selectRaw("CONCAT(tingkatan, ' ', kelas) as kelasName")->first()->kelasName;
        return view('pages.kelas.siswa',compact('siswas','kelasName'));
    }


    public function store(Request $request){
        $validated = $request->validate([
            'tingkatan' => 'required',
            'kelas' => 'required',
        ]);

        kelas::create($validated);

        return redirect()->route('kelas.index')->with([
            'success' => 'Kelas created successfully.',
            'action' => 'create',
        ]);
    }


    public function update(Request $request, $id){
        $validated = $request->validate([
            'tingkatan' => 'required',
            'kelas' => 'required',
        ]);

        kelas::where('id', $id)->update($validated);

        return redirect()->route('kelas.index')->with([
            'success' => 'Kelas updated successfully.',
            'action' => 'update',

        ]);
    }

    public function updateSpp(Request $request){
        $validated = $request->validate([
            'jumlah' => 'required',
            'jumlah*' => 'required|number'
        ]);

        foreach($request->tingkatan as $index => $item)
        {
            hargaKelas::where('id',$request->id[$index])->update(['jumlah' => $request->jumlah[$index]]);
        }

        return redirect()->back();
    }
}
