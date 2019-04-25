<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $this->middleware('auth')->except('create');
        // $this->middleware('auth')->only('create');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function create1()
    {
        // $linepus = "jeg er pus";
        // return view('booking.create', compact('linepus'));

        return view('booking.create-step1');
    }

    public function create4()
    {
        // $linepus = "jeg er pus";
        // return view('booking.create', compact('linepus'));

        return view('booking.create-step4');
    }
}
