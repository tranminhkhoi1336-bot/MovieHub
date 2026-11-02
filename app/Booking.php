<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'showtime_id',
        'quantity',
        'total_price',
        'status',
        'seat_codes',
        'expires_at',
    ];

protected $casts = [
    'seat_codes' => 'array',
    'expires_at' => 'datetime',
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }
}
