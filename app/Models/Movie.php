<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'poster_url',
        'trailer_url',
        'duration',
        'rating',
        'release_date',
        'genre',
        'status'
    ];

    protected $casts = [
        'release_date' => 'date',
        'rating' => 'decimal:1',
        'duration' => 'integer'
    ];

    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
