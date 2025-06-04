<?php

namespace App\Http\Controllers;

use App\Models\kelas;
use App\Models\siswa;
use Illuminate\Http\Request;

class siswaController extends Controller
{
    //
    public function index()
    {
        $siswas = siswa::all();
        $kelas = kelas::all();
        return view('Livewire.Siswa', compact('siswas', 'kelas'));

    }
    public function create()
    {
        return view('pages.siswa.create');
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'nis' => 'required|unique:siswas',
            'nama' => 'required',
            'tingkat' => 'required',
            'kode_kelas' => 'required',
            'nama_ibu' => 'required',
            'nama_ayah' => 'required',
            'no_hp_wali' => 'required',
            'no_hp' => 'required',
            'image' => 'nullable|image|max:2048',
        ]);

        // Get the kelas_id from kelas table based on tingkat and kode_kelas

        $kelas = kelas::where('tingkatan', $request->tingkat)
            ->where('kelas', $request->kode_kelas)
            ->first();



        siswa::create([
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'kelas_id' => $kelas->id,
            'nama_ibu' => $validated['nama_ibu'],
            'nama_ayah' => $validated['nama_ayah'],
            'no_hp_wali' => $validated['no_hp_wali'],
            'no_hp' => $validated['no_hp'],
            'status'=> 'aktif',
            'image' => $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null,
        ]);

        return redirect()->route('pages.siswa.index')->with([
            'success' => 'Siswa created successfully.',
            'action' => 'create',
        ]);

    }

    public function update(Request $request, $id)
    {

        try {
            $validated = $request->validate([
            'nis' => 'required',
            'nama' => 'required',
            'tingkat' => 'required',
            'kode_kelas' => 'required',
            'status' => 'required',
            'nama_ibu' => 'required',
            'nama_ayah' => 'required',
            'no_hp_wali' => 'required',
            'no_hp' => 'required',
            'image' => 'nullable|image|max:2048',
            ]);

            $data_siswa = siswa::find($id);
            $status_siswa = $data_siswa->status;
            $id_kelas = null;

            // Get the kelas_id from kelas table based on tingkat and kode_kelas
            if (($request->status == 'lulus' || $request->status == 'tidak-aktif') && $data_siswa->kelas_id != null) {
            $id_kelas = null;
            $status_siswa = $request->status; // Change $status_siswa to the value from the request
            } else {
            $kelas = kelas::where('tingkatan', $request->tingkat)
                ->where('kelas', $request->kode_kelas)
                ->first();
            $id_kelas = $kelas->id;
            $status_siswa = 'aktif'; // Change $status_siswa to 'aktif' in the else block
            }

            // Check if a new image file has been uploaded
            if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('image', 'public');
            } else {
            // No new image uploaded, retain the existing image path
            $imagePath = siswa::where('id', $id)->value('image');
            }

            siswa::where('id', $id)->update([
            'nis' => $validated['nis'],
            'nama' => $validated['nama'],
            'kelas_id' => $id_kelas,
            'status' => $status_siswa,
            'nama_ibu' => $validated['nama_ibu'],
            'nama_ayah' => $validated['nama_ayah'],
            'no_hp_wali' => $validated['no_hp_wali'],
            'no_hp' => $validated['no_hp'],
            'image' => $imagePath,
            ]);

            return redirect()->route('pages.siswa.show', $id)->with([
            'success' => 'Siswa updated successfully.',
            'action' => 'update'
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors([
            'error' => 'An error occurred while updating the siswa: ' . $e->getMessage()
            ]);
        }
    }
    public function show($id)
    {
        $dataSiswa = siswa::find($id);
        $kelas = kelas::all();
        return view('pages.siswa.show', compact('dataSiswa', 'kelas'));
    }
    public function destroy($id)
    {
        // Logic to delete the siswa with the given ID
        // Redirect or return a response after deletion
        return redirect()->route('pages.siswa.index')->with('success', 'Siswa deleted successfully.');
    }
}
