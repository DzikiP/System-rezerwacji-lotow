<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    use HasFactory;
    protected $fillable = [
        'booking_id',
        'first_name',
        'last_name',
        'passport_number',
        'birth_date'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
