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
        'jenis_kelamin',
        'tanggal_lahir',
        'tempat_lahir',
        'rt_id',
        'rw_id',
        'agama_id',
        'pekerjaan_id',
        'status_perkawinan_id',
        'status_kependudukan_id',
    ];

    public function rw()
    {
        return $this->belongsTo(\App\Models\Rw::class);
    }

    public function rt()
    {
        return $this->belongsTo(\App\Models\Rt::class);
    }

    public function agama()
    {
        return $this->belongsTo(\App\Models\Agama::class);
    }

    public function pekerjaan()
    {
        return $this->belongsTo(\App\Models\Pekerjaan::class);
    }

    public function statusPerkawinan()
    {
        return $this->belongsTo(\App\Models\StatusPerkawinan::class);
    }

    public function statusKependudukan()
    {
        return $this->belongsTo(\App\Models\StatusKependudukan::class);
    }

    public function pendidikan()
    {
        return $this->belongsTo(Pendidikan::class);
    }
}
