<?php

use App\User;
use App\Room;
use App\Booking;
use App\Facility;
use Carbon\Carbon;
use App\BookingRoom;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

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
            'single' => [
                'price' => 990,
                'count' => 10
            ],
            'double' => [
                'price' => 1290,
                'count' => 8
            ],
            'suite' => [
                'price' => 1990,
                'count' => 2
            ],
            'wedding' => [
                'price' => 2490,
                'count' => 1
            ]
        ];

        $rooms = [];
        foreach ($room_types as $name => $roomtype) {
            for($i = 0; $i < $roomtype['count']; $i++) {
                $room = Room::create([
                    'room_type' => $name,
                    'room_price' => $roomtype['price'],
                ]);
    
                array_push($rooms, $room);
            }

            // $booking = Booking::create([
            //     'people' => 2,
            //     'check_in' => Carbon::now(),
            //     'check_out' => Carbon::now()->addDays(3)
            // ]);

            // BookingRoom::create([
            //     'room_id' => $room->id,
            //     'booking_id' => $booking->id
            // ]);
        }

        $facilities = [
            'lunch' => 100,
            'dinner' => 250,
            'parking' => 0,
        ];

        $f = [];
        foreach ($facilities as $name => $price) {
            $facility = Facility::create([
                'name' => $name,
                'price' => $price,
            ]);

            array_push($f, $facility);
        }

        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
        $admin_role = Role::create(['name' => 'admin']);

        $user = User::create([
            'firstname' => 'Sensor',
            'surname' => 'Sensor',
            'phone' => '12345678',
            'email' => 'sensor@sensor.com',
            'password' => Hash::make('sensor')
        ]);

        $user->assignRole($admin_role);
    }
}
