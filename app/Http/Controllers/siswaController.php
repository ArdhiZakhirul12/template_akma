<?php

namespace App\Http\Controllers;

use App\Livewire\siswa\Siswa as SiswaSiswa;
use App\Models\kelas;
use App\Models\siswa;
use Illuminate\Http\Request;
use App\Models\pemasukan;
use PhpOffice\PhpSpreadsheet\IOFactory;

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
        try {
            $validated = $request->validate([
                'nis' => 'required|unique:siswas',
                'nama' => 'required',
                'tingkat' => 'required',
                'kode_kelas' => 'required',
                'nama_ibu' => 'required',
                'nama_ayah' => 'required',
                'no_hp_wali' => 'required',
                'no_hp' => 'required',
                'alamat' => 'required',
                'anak_mahad' => 'required',
                'tanggal_masuk' => 'required|date',
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
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'no_hp' => $validated['no_hp'],
                'alamat' => $validated['alamat'],
                'anak_mahad' => $validated['anak_mahad'] == "true" ? true : false,
                'status' => 'aktif',
                'image' => $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null,
            ]);


            return redirect()->route('pages.siswa.index')->with([
                'success' => 'Siswa created successfully.',
                'action' => 'create',
            ]);
        } catch (\Exception $e) {
            // return redirect()->back()->withErrors([
            //     'error' => 'An error occurred while creating the siswa: ' . $e->getMessage()
            // ]);
            return redirect()->route('pages.siswa.index')->with([
                'error' => $e->getMessage()
            ]);
        }
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
                'alamat' => 'required',
                'tanggal_masuk' => 'required|date',
                'anak_mahad' => 'required',
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
                'alamat' => $validated['alamat'],
                'tanggal_masuk' => $validated['tanggal_masuk'],
                'anak_mahad' => $validated['anak_mahad'] == "true" ? true : false,
                'image' => $imagePath,
            ]);

            return redirect()->route('pages.siswa.show', $id)->with([
                'success' => 'Siswa updated successfully.',
                'action' => 'update'
            ]);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
    public function show($id)
    {
        $dataSiswa = siswa::find($id);
        $kelas = kelas::all();
        $pemasukan = pemasukan::with('siswa.kelas')->where('siswa_id', $id)->firstOrFail();
        $totalDpp = 0;
        foreach ($pemasukan as $item) {
            $totalDpp += $item->dpp;
        }
        dd($totalDpp);
        return view('pages.siswa.show', compact('dataSiswa', 'kelas'));
    }
    public function destroy($id)
    {
        // Logic to delete the siswa with the given ID
        // Redirect or return a response after deletion
        return redirect()->route('pages.siswa.index')->with('success', 'Siswa deleted successfully.');
    }


    public function importSiswasData(Request $request)
    {
        try {
            $file = $request->file('file');

            // Pastikan file valid
            if (!$file || !$file->isValid()) {
                return back()->with('error', 'File tidak valid');
            }

            // Load Excel
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray();
            $data = array_filter($data, function ($row) {
                foreach ($row as $cell) {
                    if (!is_null($cell) && trim($cell) !== '') {
                        return true;
                    }
                }
                return false;
            });
       
            // Contoh: simpan ke database
            foreach ($data as $index => $row) {
                // Lewati baris pertama jika header
                if ($index === 0) continue;

                // Validasi setiap kolom
                if (empty($row[0]) || !is_numeric($row[0])) {
                    return back()->with('error', "NIS tidak valid pada baris " . ($index + 1));
                }
                if (empty($row[1])) {
                    return back()->with('error', "Nama tidak valid pada baris " . ($index + 1));
                }
                if (empty($row[2]) || !is_numeric($row[2])) {
                    return back()->with('error', "Kelas ID tidak valid pada baris " . ($index + 1));
                }
                if (empty($row[3])) {
                    return back()->with('error', "Nama Ibu tidak valid pada baris " . ($index + 1));
                }
                if (empty($row[4])) {
                    return back()->with('error', "Nama Ayah tidak valid pada baris " . ($index + 1));
                }
                if (empty($row[5]) || !is_numeric($row[5])) {
                    return back()->with('error', "No HP Wali tidak valid pada baris " . ($index + 1));
                }
                if (empty($row[6]) || !strtotime($row[6])) {
                    return back()->with('error', "Tanggal Masuk tidak valid pada baris " . ($index + 1));
                }
                if (empty($row[7]) || !is_numeric($row[7])) {
                    return back()->with('error', "No HP tidak valid pada baris " . ($index + 1));
                }
                if (empty($row[8])) {
                    return back()->with('error', "Alamat tidak valid pada baris " . ($index + 1));
                }
                if (!isset($row[9]) || ($row[9] !== '1' && $row[9] !== '0')) {
                    return back()->with('error', "Anak Mahad tidak valid pada baris " . ($index + 1));
                }
                if (empty($row[10]) || !in_array($row[10], ['aktif', 'lulus', 'tidak-aktif'])) {
                    return back()->with('error', "Status tidak valid pada baris " . ($index + 1));
                }

                siswa::create([
                    'nis' => $row[0],
                    'nama' => $row[1],
                    'kelas_id' => $row[2],
                    'nama_ibu' => $row[3],
                    'nama_ayah' => $row[4],
                    'no_hp_wali' => $row[5],
                    'tanggal_masuk' => $row[6],
                    'no_hp' => $row[7],
                    'alamat' => $row[8],
                    'anak_mahad' => $row[9] == "true" ? true : false,
                    'status' => $row[10]
                ]);
            }

            return back()->with('success', 'Import berhasil');
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
