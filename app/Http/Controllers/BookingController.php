<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Sample;
use App\Supervisor;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Mail\NotifySupervisor;
use Illuminate\Support\Facades\Mail;
class BookingController extends Controller
{
    /**
    *
    *   Changes for regslot
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function regslot (Request $request, Booking $booking){
        $params = $request->all();
        $now = Carbon::now();
        $calender = [];
        $craftedcarbon = $now;
        if (empty($params['view']) || $params['view']=='all' || $params['view']=='month') {
            $calender['month']  = empty($params['month'])? $now->month: $params['month'];
            $calender['year']   = empty($params['year'])? $now->year: $params['year'];
            $calender['view']   = 'month';
            $craftedcarbon = Carbon::createFromDate($calender['year'], $calender['month'], $now->day);
        }elseif ($params['view'] == 'week'){
            $calender['date']   = empty($params['date'])? $now->day: $params['date'];
            $calender['week']   = empty($params['week'])? $now->weekOfMonth: $params['week'];
            $calender['month']  = empty($params['month'])? $now->month: $params['month'];
            $calender['year']   = empty($params['year'])? $now->year: $params['year'];
            $calender['view']   = $params['view'];
            $craftedcarbon = Carbon::createFromDate($calender['year'], $calender['month'], $calender['date']);
        }elseif ($params['view'] == 'date') {
            $calender['date']   = empty($params['date'])? $now->day: $params['date'];
            $calender['month']  = empty($params['month'])? $now->month: $params['month'];
            $calender['year']   = empty($params['year'])? $now->year: $params['year'];
            $calender['view']   = $params['view'];
            $craftedcarbon = Carbon::createFromDate($calender['year'], $calender['month'], $calender['date']);
        }
        
        return view('booking.bookdate',compact('booking','calender','craftedcarbon'));
    }
        
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('booking.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $params = $request->all();
        // dd($params);
  //       "equipment_id" => "1"
  // "title" => "lol"
  // "name" => "lol"
  // "service_id" => "1"
  // "all_samples" => "{"0":{"sample_type":"a","sample_name":"a","sample_method":"a","sample_remark":"a"},"1":{"sample_type":"v","sample_name":"v","sample_method":"v","sample_remark":"v"}}"
        $booking = new Booking;
        if(empty($params["user_id"])){
            $booking->user_id = Auth::user()->id;
        }else{
            $booking->user_id = $params["user_id"];
        }
        $booking->title             = $params["title"];
        $booking->name              = $params["name"];
        $booking->service_id        = $params["service_id"];
        $booking->supervisor_id     = $params["supervisor_id"];
        $booking->status            = 1; // sebab skip email to sv
        
        if ($booking->save()) {
            if (!empty($params["all_samples"])) {
                $retrieved_sample = json_decode($params["all_samples"]);
                foreach ($retrieved_sample as $value) {
                    $sample = new Sample;
                    $sample->type = $value->sample_type;
                    $sample->name = $value->sample_name;
                    $sample->method = $value->sample_method;
                    $sample->remark = $value->sample_remark;
                    $sample->booking_id = $booking->id;
                    $sample->save();
                }
            }
        }
        if ($booking->status == 1) {
            // sent email to sv
            // dd($booking->supervisor_id);
            $this->sentmailtosv($booking);
        }
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Booking $booking)
    {
        //if correction/change of content booking status must set to 3
        // $params = $request->all();
        // $booking->status = $params['status'];
        // $booking->save();
        // return redirect()->back();
    }
    /**
    *
    *   Changes for Index
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function updatebyemail (Request $request, Booking $booking){
        $parameters = $request->all();
        $original_plaintext = base64_decode($parameters['token']);
        $orig_ex = explode("/", $original_plaintext);
        if ($orig_ex[1] == "UTP" && $orig_ex[0] == $booking->supervisor->email) {
            $params = $request->all();
            $booking->status = $parameters['status'];
            $booking->save();
            dd("done update"); // redirect ke thank you page
        }else{
            dd("not a valid supervisor"); // redirect ke 404
        }
        
    }
        

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking)
    {
        //
    }
    protected function sentmailtosv($booking)
    {
        $supervisor = Supervisor::find($booking->supervisor->id);
        # code...
        // Mail::to('firdaushishamuddin@gmail.com')->send(new NotifySupervisor);
        Mail::to($supervisor->email)->send(new NotifySupervisor($supervisor,$booking));
    }
    protected function getBookingStatusName($status)
    {
        switch ($status) {
            case '0':
                $status_label = 'reject';
                break;
            case '1':
                $status_label = 'applied';
                break;
            case '2':
                $status_label = 'approved';
                break;
            case '3':
                $status_label = 'correction';
                break;
            case '4':
                $status_label = 'done review';
                break;
            
            default:
                $status_label = 'unknown';
                break;
        }
        return $status_label;
    }
}
