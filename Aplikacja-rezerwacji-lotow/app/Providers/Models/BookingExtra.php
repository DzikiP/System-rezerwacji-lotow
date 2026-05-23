<?php

namespace App\Providers\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingExtra extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_id',

        'type',
        'name',

        'price',
        'currency',
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
