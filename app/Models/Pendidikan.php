<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pendidikan extends Model
{
    protected $fillable = ['nama', 'kategori'];

    public function penduduk()
    {
        return $this->hasMany(Penduduk::class, 'pendidikan_id');
    }
}
