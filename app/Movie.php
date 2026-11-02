<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    protected $fillable = [
        'tmdb_id',
        'title',
        'description',
        'genre',
        'duration',
        'release_date',
        'poster',
        'status',
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}
