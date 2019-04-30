<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Booking;
use App\BookingUserFasility;

class Facility extends Model
{
    public static function getAvailableParking(Carbon $from, Carbon $to)
    {
        // Antall parkeringsplasser
        $parking_spots = 14;

        // Finner alle bookinger i den perioden brukeren er interessert i
        $bookings = Booking::getActiveBookings($from, $to);
        $bookings = $bookings->pluck('id')->toArray();
        
        $booking_user_facility = BookingUserFacility::whereIn('booking_user_id', $bookings)->get();
        $booking_user_facility = $booking_user_facility->pluck('id')->toArray();
        dd($booking_user_facility);        
        
        // Finner alle reserverte parkeringer
        $unavailable_parkings_count = self::whereIn('name', 'parking')->get();
        $unavailable_parkings_count = $unavailable_parkings_count->toArray();
        
        // // Trekk fra de ledige rommene
        // foreach($available_rooms_count as $a) {
        //     foreach($unavailable_rooms_count as $u) {
        //         if($a['room_type'] === $u['room_type']) {
        //             $a['total'] = ($a['total'] - 1);
        //         }
        //     }
        // }

        // // Fjern de som er 0
        // foreach($room_types as $key => $room_type) {
        //     foreach($available_rooms_count as $a) {
        //         if($room_type->name === $a['room_type']) {
        //             if ($a['total'] === 0) {
        //                 unset($room_types[$key]);
        //             }
        //         }
        //     }
        // }

        return null;
    }
}
