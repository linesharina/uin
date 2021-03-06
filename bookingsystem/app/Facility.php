<?php

namespace App;

use DB;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Facility;
use App\BookingUser;
use App\BookingUserFasility;

class Facility extends Model
{
    public static function getAvailableParking(Carbon $from, Carbon $to)
    {
        // Antall parkeringsplasser
        $parking_spots = 14;

        // Parking facility
        $parking_facility = Facility::where('name', 'parking')->firstOrFail();

        // Finn opptatte parkeringsplasser
        $parkings_unavailable = BookingUserFacility::select(
            'booking_user_facilities.id', 
            'booking_user_facilities.facility_id'
        )->join('booking_users', 'booking_users.id', '=', 'booking_user_facilities.booking_user_id')
        ->join('facilities', 'facilities.id', '=', 'booking_user_facilities.facility_id')
        ->join('bookings', 'bookings.id', '=', 'booking_users.id')
        ->where('booking_user_facilities.facility_id', $parking_facility->id)
        ->where('bookings.check_in', '<', $to)
        ->where('bookings.check_out', '>', $from)
        ->groupBy('booking_user_facilities.facility_id')
        ->select('booking_user_facilities.facility_id', DB::raw('count(*) as total'))
        ->get();

        $parkings_unavailable = $parkings_unavailable->pluck('total')->toArray();
        
        // Regn ut hvor mange parkeringsplasser som er tilgjengelige
        $parkings_available = $parking_spots;
        foreach($parkings_unavailable as $parkings_unavailable) {
            $parkings_available = $parking_spots-$parkings_unavailable;
        }

        return $parkings_available;
    }
}
