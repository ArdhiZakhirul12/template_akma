<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class kelas extends Model
{
    //
    protected $guarded = ['id'];

    public function siswa()
    {
        return $this->hasMany(User::class);
    }
}
