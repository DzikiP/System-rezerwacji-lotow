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
        'nationality',
        'document_number',
        'birth_date',
        'passenger_type',
    ];


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }

}
