<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Showtime extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'show_date',
        'show_time',
        'studio',
        'price',
        'available_seats',
        'total_seats'
    ];

    protected $casts = [
        'show_date' => 'date',
        'show_time' => 'datetime:H:i',
        'price' => 'decimal:2'
    ];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getAvailableSeatsAttribute()
    {
        $bookedSeats = $this->bookings()
            ->whereIn('status', ['pending', 'confirmed'])
            ->get()
            ->sum(function($booking) {
                return count(explode(',', $booking->seats));
            });

        return $this->total_seats - $bookedSeats;
    }
}