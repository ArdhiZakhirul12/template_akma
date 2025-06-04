<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kategoriRab extends Model
{
    //
    protected $guarded = ['id'];

    public function subKategori()
    {
        return $this->hasMany(subKategoriRab::class);
    }
}
