<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $guarded = [];

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }
}
