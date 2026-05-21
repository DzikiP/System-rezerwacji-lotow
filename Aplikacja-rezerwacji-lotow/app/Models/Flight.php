<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Flight extends Model
{
    use HasFactory;
    protected $fillable = [
        'flight_number',
        'origin',
        'destination',
        'departure_time',
        'arrival_time',
        'price',
        'currency',
        'seats_total',
        'seats_available',
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
