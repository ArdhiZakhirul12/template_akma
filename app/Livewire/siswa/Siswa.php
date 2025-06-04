<?php

namespace App\Livewire\siswa;

use App\Models\kelas;
use App\Models\siswa as ModelsSiswa;
use Livewire\Component;

class Siswa extends Component
{

    public $siswas;
    public $data_kelas;
    public $jenis_kelas;
    public $selectedkelas;
    public $openModal;
    public $showNextGradeModal = false;

    public function mount()
    {
        $this->siswas = ModelsSiswa::all();
        $this->data_kelas = kelas::select('tingkatan')->distinct()->pluck('tingkatan');;
        $this->jenis_kelas = [];
        $this->selectedkelas = '';
        $this->openModal = false;
    }

    public function updatedSelectedKelas($value)
    {
        $this->jenis_kelas = kelas::where('tingkatan', $value)->get();
    }

    public function openedModalForm()
    {
        $this->openModal = true;
    }

    public function nextGrade()
    {
        $this->showNextGradeModal = false;
        $siswas = ModelsSiswa::where('status', 'aktif')->get();
        $kelas = kelas::all();
        foreach ($siswas as $siswa) {
            if ($siswa->kelas_id) {
                if ($siswa->kelas->tingkatan == 12) {
                    ModelsSiswa::where('id', $siswa->id)->update([
                        'status' => 'lulus',
                        'kelas_id' => null
                    ]);
                } else {
                    $kelasBaru = $kelas->where('tingkatan', $siswa->kelas->tingkatan + 1)->where('kelas', $siswa->kelas->kelas)->first();
                    if (!$kelasBaru) {
                        $createKelas = kelas::create([
                            'tingkatan' => $siswa->kelas->tingkatan + 1,
                            'kelas'     => $siswa->kelas->kelas
                        ]);
                        $save = ModelsSiswa::where('id', $siswa->id)->update(['kelas_id' => $createKelas->id]);
                    } else {
                        $save = ModelsSiswa::where('id', $siswa->id)->update(['kelas_id' => $kelasBaru->id]);
                    }
                }
            }
        }
        

        $this->mount();
        return redirect()->to(request()->header('Referer'));

    }

    public function render()
    {
        return view('livewire.siswa.siswa');
    }
}
