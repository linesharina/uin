<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\User;
use App\Room;
use App\Booking;
use App\BookingRoom;
use App\Facility;

class BookingController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
        // $this->middleware('auth')->except('create');
        // $this->middleware('auth')->only('create');
    }

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
            'when_checkin-day' => ['required', 'integer', 'min:1', 'max:31'],
            'when_checkin-month' => ['required', 'integer', 'min:1', 'max:12'],
            'when_checkin-year' => ['required', 'integer', 'min:' . date('Y'), 'max:' . (date('Y') + 1)],
            'when_checkout-day' => ['required', 'integer', 'min:1', 'max:31'],
            'when_checkout-month' => ['required', 'integer', 'min:1', 'max:12'],
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

        // dump('available');
        // dump('unavailable');
        // dd($unavailable_rooms_count);

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
        return Validator::make($data, [
            'facility_lunch' => ['required', 'integer', 'min:0', 'max:10'],
            'facility_dinner' => ['required', 'integer', 'min:0', 'max:10'],
            'facility_parking' => 'required'
        ]);
    }

    public function create4(Request $request)
    {
        $this->booking_step_3_validator($request->all())->validate();

        foreach($request->all() as $key => $value) {  
            session([$key => $value]);
        } 

        
        // $linepus = "jeg er pus";
        // return view('booking.create', compact('linepus'));
        
        // $booking = new Booking;
        // $booking->check_in = '';
        // $booking->check_out = '';
        // $booking->save();

        // $booking_rooms = new BookingRoom;
        // $booking_rooms->booking_id = $booking->id;
        // $booking_rooms->room_id = $room->id;
        // $booking_rooms->save();
        
        if (Auth::check()) {
            return redirect()->route('booking.show-step5');
        }

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
        
        // dd($request->session()->all());
        return redirect()->route('booking.show-step5');
    }
    
    public function show5()
    {

        $facilities = Facility::all();
        $facilities = $facilities->toArray();
        
        $price = 0;
        foreach($facilities as $f) {
            if(session('facility_' . $f['name']) > 0) { 
                $price += ($f['price'] * session('facility_' . $f['name']));
            }
        }
        $price_fac = $price; 

        $rooms = Room::all();
        $rooms = $rooms->toArray();

        $stored_rooms = session('rooms');

        // Finner ut romtype og pris
        for ($i=0; $i < count($stored_rooms); $i++) {
            foreach ($rooms as $room) {
                if ($stored_rooms[$i] === $room['room_type']) {
                    $price += $room['room_price'];

                    $stored_rooms[$i] = [
                        'room_type' => $room['room_type'],
                        'room_price' => $room['room_price']
                    ];

                    continue;
                }
            }
        }

        $rooms = $stored_rooms;

        return view('booking.create-step5', compact('price', 'rooms', 'price_fac'));
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
