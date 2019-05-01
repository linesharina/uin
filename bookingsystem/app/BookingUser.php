<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Facility;
use App\BookingUserFacility;

class BookingUser extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getFacilitiesAttribute() {
        $facilities = [];

        $booking_user_facilities = BookingUserFacility::where('booking_user_id', $this->id)->get();
        $booking_user_facilities = $booking_user_facilities->pluck('facility_id')->toArray();

        foreach ($booking_user_facilities as $facility_id) {
            $facility = Facility::find($facility_id);

            if (isset($facilities[$facility->name])) {
                $facilities[$facility->name]['count']++;
            } else {
                $facilities[$facility->name] = [
                    'price' => $facility->price,
                    'count' => 1
                ];
            }
        }

        return $facilities;
    }
}
