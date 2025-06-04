<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class bank extends Model
{
    protected $guarded = ['id'];

    public function pengeluaran()
    {
        return $this->hasMany(pengeluaran::class); 
    }
}
