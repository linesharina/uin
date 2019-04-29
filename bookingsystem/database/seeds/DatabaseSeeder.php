<?php

use App\Room;
use App\Booking;
use Carbon\Carbon;
use App\BookingRoom;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        $room_types = [
            'single' => 990,
            'double' => 1290,
            'suite' => 1990,
            'wedding' => 2490,
        ];

        $rooms = [];
        foreach ($room_types as $name => $price) {
            $room = Room::create([
                'room_type' => $name,
                'room_price' => $price,
            ]);

            array_push($rooms, $room);

            $booking = Booking::create([
                'people' => 2,
                'check_in' => Carbon::now(),
                'check_out' => Carbon::now()->addDays(3)
            ]);

            BookingRoom::create([
                'room_id' => $room->id,
                'booking_id' => $booking->id
            ]);
        }
    }
}
