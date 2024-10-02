<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forecast extends Model
{
    protected $fillable = ['location_id', 'date', 'min_temp', 'max_temp', 'condition', 'icon'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }
}
