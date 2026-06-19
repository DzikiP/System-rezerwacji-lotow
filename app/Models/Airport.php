<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Airport extends Model
{
    protected $fillable = [
        'iata',
        'icao',
        'name',
        'city',
        'country',
        'latitude',
        'longitude',
        'timezone'
    ];
}
