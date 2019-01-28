<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
class CalenderController extends Controller
{
    /**
    *
    *   Changes for Index
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function index (Request $request){
        $parameters = $request->all();
        $now = Carbon::now();
        if (empty($parameters['date'])) {

            $parameters['dategenerated'] = Carbon::createFromDate($now->year, $now->month, $now->day);
            $parameters['date'] = $parameters['dategenerated']->toDateString();
        }else{
            $date = explode("-", $parameters['date']);
            $parameters['dategenerated'] = Carbon::createFromDate($date[0], $date[1], $date[2]);
        }
        if (Auth::user()->role->id == 3) {
            $parameters['staff_id'] = Auth::user()->id; 
        }
        return view('staff.calender_view',compact('parameters'));
    }
    	
}
