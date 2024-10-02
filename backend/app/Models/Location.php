<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use HasFactory;

class Location extends Model
{
    protected $fillable = ['user_id', 'city', 'state'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function forecasts()
    {
        return $this->hasMany(Forecast::class);
    }
}
