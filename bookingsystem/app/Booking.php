<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Booking extends Model
{
    public static function getActiveBookings(Carbon $from, Carbon $to) {
        return self::whereBetween('check_in', [$from, $to])->whereBetween('check_out', [$from, $to])->get();
    }

    public function booking_rooms()
    {
        return $this->hasMany('App\BookingRoom');
    }
}
