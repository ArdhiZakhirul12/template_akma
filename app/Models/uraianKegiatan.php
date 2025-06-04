<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class uraianKegiatan extends Model
{
    protected $guarded = ['id'];

    public function subKategoriRab()
    {
        return $this->belongsTo(subKategoriRab::class, 'sub_kategori_id');
    }
    public function pengeluaran()
    {
        return $this->hasMany(pengeluaran::class);
    }
}
