<?php

namespace App;

use DB;
use App\Booking;
use App\BookingRoom;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public static function getActiveRooms(Carbon $from, Carbon $to) {
        $rooms = BookingRoom::select(
            'booking_id',
            'bookings.check_in',
            'bookings.check_out',
            'room_id'
        )->join('bookings', 'booking_rooms.booking_id', '=', 'bookings.id')
        ->where('bookings.check_in', '<', $to)
        ->where('bookings.check_out', '>', $from)
        ->get();

        return $rooms;
    }

    public static function getAvailableRoomTypes(Carbon $from, Carbon $to)
    {
        // List opp alle romtyper
        $room_types = DB::select('select distinct room_type as name, room_price as price from `rooms`');
        // Finn ut hvor mange det er av de forskjellige romtypene
        $available_rooms_count = self::groupBy('room_type')->select('room_type', DB::raw('count(*) as total'))->get();
        $available_rooms_count = $available_rooms_count->toArray();

        // Finner alle bookinger i den perioden brukeren er interessert i
        $bookings = Booking::getActiveBookings($from, $to);
        $bookings = $bookings->pluck('id')->toArray();
        
        $booking_rooms = BookingRoom::whereIn('booking_id', $bookings)->get();
        $booking_rooms = $booking_rooms->pluck('room_id')->toArray();
        
        // Finner alle reserverte rom
        $unavailable_rooms_count = self::whereIn('id', $booking_rooms)->groupBy('room_type')->select('room_type', DB::raw('count(*) as total'))->get();
        $unavailable_rooms_count = $unavailable_rooms_count->toArray();
        
        // Trekk fra de ledige rommene
        foreach($available_rooms_count as $key => $a) {
            foreach($unavailable_rooms_count as $u) {
                if($a['room_type'] === $u['room_type']) {
                    $available_rooms_count[$key]['total']--;
                }
            }
        }
        
        // Fjern de som er 0
        foreach($room_types as $key => $room_type) {
            foreach($available_rooms_count as $a) {
                if($room_type->name === $a['room_type']) {
                    if ($a['total'] === 0) {
                        unset($room_types[$key]);
                    }
                }
            }
        }

        return $room_types;
    }
}
