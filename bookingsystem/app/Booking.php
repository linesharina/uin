<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    public function booking_rooms()
    {
        return $this->hasMany('App\BookingRoom');
    }
}
