<?php

namespace App\Http\Controllers;

use App\Booking;
use App\Sample;
use App\Supervisor;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use App\Mail\NotifySupervisor;
use App\Mail\NotifySupervisorHtml;
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
    public function index(Request $request)
    {
        //
      $params = $request->all();
        switch (Auth::user()->role->id) {
            case 2:
                $bookings = Booking::latest();
                // if got filter
                // dd($bookings);
                if (!empty($params['equipment'])) {
                    $bookings = $bookings->whereHas('service', function ($query2) use ($params) {
                                    $query2->whereHas('equipment', function ($query3) use ($params) {
                                        $query3->where('id', '=', $params['equipment']);
                                    });
                                });
                }
                if (!empty($params['services'])) {
                    $bookings = $bookings->whereHas('service', function ($query2) use ($params) {
                                    $query2->where('id', '=', $params['services']);
                                });
                }
                // if (!empty($params['staff'])) {
                //     $applications = $applications->whereHas('booking', function ($query) use ($params) {
                //         $query->whereHas('service', function ($query2) use ($params) {
                //             $query2->whereHas('user', function ($query3) use ($params) {
                //                 $query3->where('id', '=', $params['staff']);
                //             });
                //         });
                //     });
                // }
                if (!empty($params['status'])) {
                    $bookings = $bookings->where('status',$params['status']);
                }
                
                // end filter groupBy('browser')
                $bookings = $bookings->paginate(5);
                
                return view("lab_admin.booking",compact('bookings','params'));
                break;
            
            default:
                dd("not ready");
                break;
        }
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
      return view("lab_admin.each_booking",compact('booking'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function edit(Booking $booking)
    {
        return view('booking.correction',compact('booking'));
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
        $params = $request->all();
        if (!empty($params['from_correction'])) {
            # code...
            
            switch ($params['from_correction']) {
                case 'service_correction':
                    $booking->samples()->delete();
                    $booking->service_id = $params['service_id'];
                    $booking->save();
                    return redirect()->back();
                    break;
                case 'cost_center_correction':
                    $booking->name = $params['costcenter'];
                    $booking->save();
                    return redirect()->back();
                    break;
                case 'resubmit_correction':
                    $booking->status = $params['status'];
                    $booking->save();
                    return redirect()->route('home');
                    break;
                
                default:
                    # code...
                    break;
            }
        }
        $all_application_under_this_booking = $booking->applications;
        // dd($all_application_under_this_booking,$application->booking);
        $appsave = 0;
        foreach ($all_application_under_this_booking as $key => $value) {
            
            switch ($params['status']) {
                case 4:
                  $value->status = 2;
                    break;
                case 5:
                  $value->status = 3;
                    break;
                case 0:
                  $value->status = 4; // reject
                  break;
                
                default:
                  # code...
                  break;
            }
            if($value->save()) {
                $appsave += 1;
            }
        }
        if ($appsave == $all_application_under_this_booking->count()) {
            $booking = Booking::find($booking->id);
            $booking->status = $params['status'];
            if ($params['status'] == 5) {
              $booking->comment = (empty($params['comment']))? NULL : $params['comment']; // correction
            }
            
            $booking->save();
            return redirect()->back()->with('status', $booking->title.' status has been updated to '. $this->getBookingStatusName($booking->status) ) ;
        }else{
            return redirect()->back()->with('status', 'Opps something wrong') ;
        }
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
        $result = Mail::to($supervisor->email)->send(new NotifySupervisorHtml($supervisor,$booking));
        $fail = Mail::failures();
        if(!empty($fail)) throw new \Exception('Could not send message to '.$fail[0]);

        if(empty($result)) throw new \Exception('Email could not be sent.');
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
                $status_label = 'Completed';
                break;
            case '5':
                $status_label = 'Need correction';
                break;
            
            default:
                $status_label = 'unknown';
                break;
        }
        return $status_label;
    }
}
