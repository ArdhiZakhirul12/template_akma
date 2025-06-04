<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class pengeluaran extends Model
{
    protected $guarded = ['id'];

    public function uraianKegiatan()
    {
        return $this->belongsTo(uraianKegiatan::class,'uraian_kegiatan_id');
    }
    public function bank()
    {
        return $this->belongsTo(bank::class,'jenis_id');
    }
}
