<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SavedPassenger extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',

        'first_name',
        'last_name',

        'birth_date',

        'nationality',

        'document_number',

        'passenger_type',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
