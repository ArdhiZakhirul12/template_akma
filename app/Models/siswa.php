<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class siswa extends Model
{
    //
    protected $guarded = ['id'];

    public function kelas()
    {
        return $this->belongsTo(kelas::class);
    }
    public function pemasukan()
    {
        return $this->hasMany(pemasukan::class);
    }
}
