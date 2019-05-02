<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;
use App\Facility;
use App\Room;
use App\Booking;
use App\BookingRoom;
use App\BookingUser;
use App\BookingUserFacility;

class BookingController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function create1(Request $request)
    {
        return view('booking.create-step1');
    }

    
    protected function booking_step_1_validator(array $data)
    {
        return Validator::make($data, [
            'when_checkin-day' => ['required', 'numeric', 'min:1', 'max:31'],
            'when_checkin-month' => ['required', 'numeric', 'min:1', 'max:12'],
            'when_checkin-year' => ['required', 'integer', 'min:' . date('Y'), 'max:' . (date('Y') + 1)],
            'when_checkout-day' => ['required', 'numeric', 'min:1', 'max:31'],
            'when_checkout-month' => ['required', 'numeric', 'min:1', 'max:12'],
            'when_checkout-year' => ['required', 'integer', 'min:' . date('Y'), 'max:' . (date('Y') + 1)],
            'when_number' => ['required', 'integer', 'min:1', 'max:10'],
        ]);
    }
    
    
    public function create2(Request $request)
    {
        $this->booking_step_1_validator($request->all())->validate();


        $date_checkin = $request->get('when_checkin-year') . '-' . $request->get('when_checkin-month') . '-' . $request->get('when_checkin-day');
        $date_checkin = Carbon::parse($date_checkin);
        
        $date_checkout = $request->get('when_checkout-year') . '-' . $request->get('when_checkout-month') . '-' . $request->get('when_checkout-day');
        $date_checkout = Carbon::parse($date_checkout);

        // Sjekk om innsjekksdato er større eller lik utsjekksdato
        if($date_checkin->gte($date_checkout)) {
            return redirect()->back()->withInput()->withErrors(['Utsjekksdato må være etter innsjekksdato']);
        }
        
        // Sjekk om bruker prøver å booke for dato i fortiden
        if(!$date_checkin->isToday() && $date_checkin->isPast()) {
            return redirect()->back()->withInput()->withErrors(['Dato må være fremover i tid.']);
        }

        session([
            'date_checkin' => $date_checkin,
            'date_checkout' => $date_checkout
        ]);

        foreach($request->all() as $key => $value) {  
            session([$key => $value]);
        } 

        return redirect()->route('booking.show-step2');
    }
    
    public function show2()
    {
        $from = session('date_checkin');
        $to = session('date_checkout');

        $room_types = Room::getAvailableRoomTypes($from, $to);

        return view('booking.create-step2', compact('room_types'));
    }

    protected function booking_step_2_validator(array $data)
    {   
        $from = session('date_checkin');
        $to = session('date_checkout');

        $room_array = Room::getAvailableRoomTypes($from, $to);

        $room_types_array = [];
        foreach($room_array as $r) {
            array_push($room_types_array, $r->name);
        }

        return Validator::make($data, [
            'rooms' => ['required', 'array'],
            'rooms.*' => ['required', 'string', Rule::in($room_types_array)],
        ]);


    }

    public function create3(Request $request)
    {
        $this->booking_step_2_validator($request->all())->validate();
        
        session(['rooms' => $request->rooms]);

        return redirect()->route('booking.show-step3');
    }

    public function show3()
    {
        return view('booking.create-step3');
    }

    protected function booking_step_3_validator(array $data)
    {
        $from = session('date_checkin');
        $to = session('date_checkout');

        $available_parking_spots = Facility::getAvailableParking($from, $to);

        return Validator::make($data, [
            'facility_lunch' => ['required', 'integer', 'min:0', 'max:10'],
            'facility_dinner' => ['required', 'integer', 'min:0', 'max:10'],
            'facility_parking' => ['required', 'integer', 'min:0', 'max:' . $available_parking_spots]
        ]);
    }

    public function create4(Request $request)
    {
        $this->booking_step_3_validator($request->all())->validate();

        foreach($request->all() as $key => $value) {  
            session([$key => $value]);
        } 
        
        // Hvis brukeren blir logget inn, send til neste steg
        if (Auth::check()) {
            return redirect()->route('booking.show-step5');
        }

        // Om brukeren ikke ble logget inn, send tilbake
        return redirect()->route('booking.show-step4');
    }
    
    public function show4()
    {
        if (Auth::check()) {
            return redirect()->route('booking.show-step3');
        }

        return view('booking.create-step4');
    }

    protected function booking_step_4_validator(array $data)
    {
        return Validator::make($data, [
            'user_firstname' => ['required', 'string'],
            'user_surname' => ['required', 'string'],
        ]);
    }

    public function create5(Request $request)
    {
        $this->booking_step_4_validator($request->all())->validate();

        foreach($request->all() as $key => $value) {  
            session([$key => $value]);
        } 
    
        return redirect()->route('booking.show-step5');
    }
    
    public function show5()
    {
        $check_in = session('date_checkin');
        $check_out = session('date_checkout');

        $facilities = Facility::all();
        $facilities = $facilities->toArray();
        
        // Beregner pris til fasilitetene
        $price = 0;
        $price_fac = 0;
        foreach($facilities as $f) {
            if(session('facility_' . $f['name']) > 0) { 
                $price_fac += ($f['price'] * session('facility_' . $f['name']));
            }
        }
        $price = $price_fac; 

        $rooms = Room::all();
        $rooms = $rooms->toArray();

        $stored_rooms = session('rooms');

        // Finner ut romtype og pris
        $price_rooms = 0;
        for ($i=0; $i < count($stored_rooms); $i++) {
            foreach ($rooms as $room) {
                if ($stored_rooms[$i] === $room['room_type']) {
                    $price_rooms += $room['room_price'];

                    $stored_rooms[$i] = [
                        'room_type' => $room['room_type'],
                        'room_price' => $room['room_price']
                    ];

                    continue;
                }
            }
        }
        
        $rooms = $stored_rooms;
        
        // Antall netter
        $days_count = $check_in->diffInDays($check_out);
        
        // Totalpris
        $price += $price_rooms * $days_count;        

        return view('booking.create-step5', compact('price', 'rooms', 'price_fac', 'days_count'));
    }


    public function create6(Request $request)
    {
        
        $booking = new Booking;
        $booking->check_in = session('date_checkin');
        $booking->check_out = session('date_checkout');
        $booking->people = session('when_number');
        $booking->save();
        
        $rooms_s = session('rooms');
        
        $active_rooms = Room::getActiveRooms($booking->check_in, $booking->check_out);
        $active_rooms = $active_rooms->pluck('room_id');

        foreach($rooms_s as $room_s) {
            $room = Room::where('room_type', $room_s)->whereNotIn('id', $active_rooms)->first();
            $booking_rooms = new BookingRoom;
            $booking_rooms->booking_id = $booking->id;
            $booking_rooms->room_id = $room->id;
            $booking_rooms->save();
        }

        // Opprett en bruker i databasen om man ikke er logget inn
        if(Auth::check()) {
            $user = Auth::user();
        } else {
            // Lag en bruker kun om den ikke finnes fra før
            $user = User::where('email', session('user_mail'))->first();
    
            if($user === null) {
                $user = new User;
                $user->firstname = session('user_firstname');
                $user->surname = session('user_surname');
                $user->email = session('user_mail');
                $user->phone = session('user_phone');
                $user->save();
            }
        }

        $booking_user = new BookingUser;
        $booking_user->booking_id = $booking->id;
        $booking_user->user_id = $user->id;
        $booking_user->save();

        if(session('facility_lunch') > 0) {
            $facility= Facility::where('name', 'lunch')->first();

            for($i = 0; $i < session('facility_lunch'); $i++) {
                $booking_user_facility = new BookingUserFacility;
                $booking_user_facility->booking_user_id = $booking_user->id;
                $booking_user_facility->facility_id = $facility->id;
                $booking_user_facility->save();
            }
        }

        if(session('facility_dinner') > 0) {
            $facility= Facility::where('name', 'dinner')->first();

            for($i = 0; $i < session('facility_dinner'); $i++) {
                $booking_user_facility = new BookingUserFacility;
                $booking_user_facility->booking_user_id = $booking_user->id;
                $booking_user_facility->facility_id = $facility->id;
                $booking_user_facility->save();
            }
        }

        if(session('facility_parking') > 0) {
            $facility= Facility::where('name', 'parking')->first();

            for($i = 0; $i < session('facility_parking'); $i++) {
                $booking_user_facility = new BookingUserFacility;
                $booking_user_facility->booking_user_id = $booking_user->id;
                $booking_user_facility->facility_id = $facility->id;
                $booking_user_facility->save();
            }
        }
        
        return redirect()->route('booking.show-step6');
    }
    
    public function show6(Request $request)
    {
        // Tøm session data etter bekreftet booking
        $request->session()->flush();
        return view('booking.create-step6');
    }

    protected function booking_login_validator(array $data)
    {
        return Validator::make($data, [
            'user_email' => ['required'],
            'password' => ['required', 'string']
        ]);
    }

    public function login(Request $request)
    {
        // LAG EN VALIDATOR HER
        $this->booking_login_validator($request->all())->validate();

        $login_attempt = Auth::attempt([
            "email" => $request->user_email,
            "password" => $request->password
        ]);

        if ($login_attempt) {
            $request->session()->flash('success', 'Du ble logget inn.');
            return redirect()->route('booking.show-step5');
        }

        $request->session()->flash('error', 'Feil e-post eller passord.');
        return redirect()->route('booking.show-step4')->withInput();
    }
}
