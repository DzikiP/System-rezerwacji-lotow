<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'booking_id',
        'amount',
        'currency',
        'status',
        'transaction_id'
    ];

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
