<?php

namespace App\Livewire\pemasukan;

use App\Models\hargaKelas;
use App\Models\kelas;
use App\Models\pemasukan as ModelsPemasukan;
use App\Models\siswa;
use Livewire\Component;
use Carbon\Carbon;

class CalenderPemasukan extends Component
{

    public $data_siswas;
    public $kelas;
    public $daftarKelas;
    public $selectedKelas = 'null';
    public $nowKelas = 'all'; 
    public $pemasukans;
    public $siswas;
    public $openModal;
    public $openDropdown;
    public $search;
    public $selectedSiswaInfo;
    public $siswaId;
    public $dataPemasukan;
    public $id;

    public function mount($id)
    {
        $this->selectedKelas = $id;
        $this->daftarKelas = kelas::all();
        // $this->pemasukans = ModelsPemasukan::with(['siswa', 'siswa.kelas'])->whereHas('siswa.kelas')->get();
        $value = $id;
        if ($value === 'all') {
            $this->pemasukans = ModelsPemasukan::with(['siswa', 'siswa.kelas'])->whereHas('siswa.kelas')->get();
        } else {
            // dd('tes');
            $this->pemasukans = ModelsPemasukan::whereHas('siswa', function ($query) use ($value) {
                $query->where('kelas_id', $value);
            })->with(['siswa', 'siswa.kelas'])->whereHas('siswa.kelas')->get();
        }

        $hargaKelas = hargaKelas::all();
        $data = [];

        foreach ($this->pemasukans as $pemasukan) {
            $siswaId = $pemasukan->siswa_id;
            $kelas = $pemasukan->siswa->kelas?->tingkatan;
            $nama = $pemasukan->siswa->nama ?? 'Tanpa Nama';
            $bulan = (int)Carbon::parse($pemasukan->pembayaran_bulan)->format('n'); // 1–12
            $harga = $hargaKelas->where('tingkatan', $kelas)->first()->jumlah;

            if (!isset($data[$siswaId])) {
                $data[$siswaId] = [
                    'nama' => $nama,
                    'tingkatan' => $kelas,
                    'kelas' => $kelas . $pemasukan->siswa->kelas->kelas,
                    'no_ortu' => $pemasukan->siswa->no_hp_wali,
                    'bulan' => array_fill(1, 12, []), // isi bulan 1–12 dengan array kosong
                ];
            }
            if (!isset($data[$siswaId]['bulan'][$bulan]['total'])) {
                $data[$siswaId]['bulan'][$bulan] = [
                    'bayar' => [],
                    'total' => 0,
                    'status' => '',
                ];
            }
            $jumlah = (int)$pemasukan->jumlah;
            $data[$siswaId]['bulan'][$bulan]['bayar'][] = $jumlah;
            $data[$siswaId]['bulan'][$bulan]['total'] += $jumlah;
            if ($data[$siswaId]['bulan'][$bulan]['total'] == $harga) {
                $data[$siswaId]['bulan'][$bulan]['status'] = 'lunas';
            } elseif ($data[$siswaId]['bulan'][$bulan]['total'] == 0) {
                $data[$siswaId]['bulan'][$bulan]['status'] = 'belum bayar';
            } elseif ($data[$siswaId]['bulan'][$bulan]['total'] < $harga) {
                $kurang = $harga - $data[$siswaId]['bulan'][$bulan]['total'];
                $data[$siswaId]['bulan'][$bulan]['status'] = "kurang Rp" . number_format($kurang, 0, ',', '.') . ",-";
            }
        }

        $this->dataPemasukan = $data;
    }

    public function updatedSelectedKelas($value) {
        return redirect()->route('pemasukan.calender', ['id'=>$value]);
    }


    public function updatedSearch()
    {

        $this->data_siswas = Siswa::with('kelas')
            ->where(function ($query) {
                $query->where('nama', 'like', '%' . $this->search . '%')
                    ->orWhere('nis', 'like', '%' . $this->search . '%')
                    ->orWhereHas('kelas', function ($kelasQuery) {
                        $kelasQuery->whereRaw("CONCAT(tingkatan, kelas) like ?", ['%' . $this->search . '%']);
                    });
            })
            ->whereHas('kelas', function ($query) {
                $query->where('tingkatan', $this->kelas);
            })
            ->get();
    }


    public function selectSiswa($id)
    {
        $siswa = Siswa::with('kelas')->findOrFail($id);
        $this->siswaId = $siswa->id;
        $this->selectedSiswaInfo = "{$siswa->nama} - {$siswa->nis} - {$siswa->kelas->tingkatan}{$siswa->kelas->kelas}";
        $this->openDropdown = $this->openDropdown ? false : true;
    }



    public function filterDataSiswa($tingkatan)
    {

        $this->data_siswas = siswa::whereHas('kelas', function ($query) use ($tingkatan) {
            $query->where('tingkatan', $tingkatan);
        })
            ->with('kelas') // load related kelas normally
            ->get();
        $this->kelas = $tingkatan;
    }



    public function render()
    {

        return view('livewire.pemasukan.calender-pemasukan');
    }
}
