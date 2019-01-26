<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch (Auth::user()->role->id) {
            case 1:
                # code...super admin
                return view('super_admin.main');
                break;
            case 2:
                # code...lab admin
                return view('lab_admin.main');
                break;
            case 3:
                # code...staff
                return view('staff.main');
                break;
            
            case 4:
                # code...student
                $bookings = Auth::user()->bookings;
                return view('student.main',compact('bookings'));
                break;
            default:
                return view('home');
                break;
        }
        
    }
}
