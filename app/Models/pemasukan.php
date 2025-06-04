<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;

class pemasukan extends Model
{
    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->belongsTo(siswa::class);
    }
}
