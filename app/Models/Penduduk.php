<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penduduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'nama',
        'alamat',
        'rw',
        'rt',
        'jenis_kelamin',
        'status_kependudukan',
        'tanggal_lahir',
    ];
}
