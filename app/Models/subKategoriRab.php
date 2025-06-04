<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class subKategoriRab extends Model
{
    protected $guarded = ['id'];

    public function kategori()
    {
        return $this->belongsTo(kategoriRab::class,'kategori_rabs_id');
    }
    public function uraianKegiatan()
    {
        return $this->hasMany(uraianKegiatan::class); 
    }
}
