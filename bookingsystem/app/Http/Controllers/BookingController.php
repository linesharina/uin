<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Room;
use App\Booking;
use App\BookingRoom;

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
            return redirect()->back()->withErrors(['Utsjekksdato må være etter innsjekksdato']);
        }

        foreach($request->all() as $key => $value) {  
            session([$key => $value]);
        } 

        return redirect()->route('booking.show-step2');
    }
    
    public function show2()
    {

        } 

        return view('booking.create-step2');
    }

    protected function booking_step_2_validator(array $data)
    {
        return Validator::make($data, [
            'room' => 'required',
        ]);
    }

    public function create3(Request $request)
    {
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

    public function create4()
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

    
    public function show4()
    {
        return view('booking.create-step4');
    }

    protected function booking_step_4_validator(array $data)
    {
        return Validator::make($data, [
            'user_firstname' => ['required', 'string'],
            'user_surname' => ['required', 'string'],
        ]);
    }
    
    public function show5()
    {
        return view('booking.create-step5');
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
            "email" => $request->email,
            "password" => $request->password
        ]);

        if ($login_attempt) {
            $request->session()->flash('success', 'Du ble logget inn.');
            return view('booking.create-step5');
        }

        $request->session()->flash('error', 'Feil e-post eller passord.');
        return redirect()->route('booking.show-step4')->withInput();
    }
}