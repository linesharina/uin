<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Booking;
use App\Facility;
use App\BookingUserFacility;


class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function admin(Request $request)
    {
        $bookings = Booking::all();
        return view('admin.admin-bookings', compact('bookings'));
    }

    public function edit(Request $request, Booking $booking)
    {
        return view('admin.admin-edit', compact('booking'));
    }

    protected function update_validator(array $data)
    {
        return Validator::make($data, [
            'check_in' => ['required', 'date', 'before:check_out', 'after:today'],
            'check_out' => ['required', 'date', 'after:check_in'],
            'lunch' => ['required', 'integer', 'min:0', 'max:100'],
            'dinner' => ['required', 'integer', 'min:0', 'max:100'],
            'parking' => ['required', 'integer', 'min:0', 'max:14'],
            'firstname' => ['required'],
            'surname' => ['required'],
            'phone' => ['required'],
        ]);
    }

    public function update(Request $request, Booking $booking)
    {
        $this->update_validator($request->all())->validate();

        // Booking
        $booking->check_in = $request->check_in;
        $booking->check_out = $request->check_out;
        $booking->people = $request->people;
        
        // Booking user
        $booking_user = $booking->users->first();

        // Bruker
        $user = $booking_user->user;
        $user->firstname = $request->firstname;
        $user->surname = $request->surname;
        $user->phone = $request->phone;
        $user->save();

        // Slett alle tilkoblede fasiliteter
        foreach ($booking_user->facilities as $facility) {
            $booking_user_facilities = BookingUserFacility::whereIn('id', $facility['ids'])->get();
            
            foreach ($booking_user_facilities as $booking_user_facility) {
                $booking_user_facility->delete();
            }
        }

        // Opprett lunsj fasiliteter
        $lunch_facility = Facility::where('name', 'lunch')->first();
        for ($i=0; $i < $request->lunch; $i++) { 
            $booking_user_facility = new BookingUserFacility;
            $booking_user_facility->booking_user_id = $booking_user->id;
            $booking_user_facility->facility_id = $lunch_facility->id;
            $booking_user_facility->save();
        }

        // Opprett middag fasiliteter
        $dinner_facility = Facility::where('name', 'dinner')->first();
        for ($i=0; $i < $request->dinner; $i++) { 
            $booking_user_facility = new BookingUserFacility;
            $booking_user_facility->booking_user_id = $booking_user->id;
            $booking_user_facility->facility_id = $dinner_facility->id;
            $booking_user_facility->save();
        }

        // Opprett parkering fasiliteter
        $parking_facility = Facility::where('name', 'parking')->first();
        for ($i=0; $i < $request->parking; $i++) { 
            $booking_user_facility = new BookingUserFacility;
            $booking_user_facility->booking_user_id = $booking_user->id;
            $booking_user_facility->facility_id = $parking_facility->id;
            $booking_user_facility->save();
        }

        return redirect()->back()->with('success', 'Booking ble oppdatert!');
    }

    public function delete(Request $request, Booking $booking)
    {
        $booking->delete();

        return redirect()->back()->with('success', 'Booking ble slettet');
    }
}
