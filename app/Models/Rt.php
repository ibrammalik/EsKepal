<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }
}
