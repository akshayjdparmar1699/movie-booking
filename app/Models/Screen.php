<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{

    protected $guarded = [];

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }
}
