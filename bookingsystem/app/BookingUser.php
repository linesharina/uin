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
        $booking_facility_ids = $booking_user_facilities->pluck('id')->toArray();
        $facility_ids = $booking_user_facilities->pluck('facility_id')->toArray();

        foreach ($facility_ids as $facility_id) {
            $facility = Facility::find($facility_id);

            if (isset($facilities[$facility->name])) {
                $facilities[$facility->name]['count']++;
            } else {
                $facilities[$facility->name] = [
                    'ids' => $booking_facility_ids,
                    'price' => $facility->price,
                    'count' => 1
                ];
            }
        }

        return $facilities;
    }
}
