<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    protected $fillable = [
        'movie_id',
        'starts_at',
        'price',
        'total_seats',
        'status',
    ];

    protected $casts = [
        'starts_at' => 'datetime',
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}

