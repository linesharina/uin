<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Booking;        

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

    public function createAdmin(Request $request)
    {

        $bookings = Booking::all();

        return view('admin.admin-bookings', compact('bookings'));
    }
}
