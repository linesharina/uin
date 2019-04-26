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

        return view('booking.create-step2');
    }

        return view('booking.create-step1');
    }

    public function create4()
    {
        // $linepus = "jeg er pus";
        // return view('booking.create', compact('linepus'));

        return view('booking.create-step4');
    }
}
