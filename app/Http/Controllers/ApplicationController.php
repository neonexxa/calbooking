<?php

namespace App\Http\Controllers;

use App\Application;
use App\Booking;
use App\Supervisor;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use App\Mail\NoticeGeneral;
use Illuminate\Support\Facades\Mail;

class ApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        // dd($params);
        switch (Auth::user()->role->id) {
            case 2:
                $applications = Application::latest();
                // if got filter

                if (!empty($params['equipment'])) {
                    $applications = $applications->whereHas('booking', function ($query) use ($params) {
                        $query->whereHas('service', function ($query2) use ($params) {
                            $query2->whereHas('equipment', function ($query3) use ($params) {
                                $query3->where('id', '=', $params['equipment']);
                            });
                        });
                    });
                }
                if (!empty($params['services'])) {
                    $applications = $applications->whereHas('booking', function ($query) use ($params) {
                        $query->whereHas('service', function ($query2) use ($params) {
                            $query2->where('id', '=', $params['services']);
                        });
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
                    $applications = $applications->where('status',$params['status']);
                }
                
                // end filter groupBy('browser')
                $applications = $applications->paginate(5);
                
                return view("lab_admin.application",compact('applications','params'));
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Booking $booking)
    {
        $params = $request->all();
        $all_booked_slot = json_decode($params['all_slots_booked']);
        $appsave = 0;
        foreach ($all_booked_slot as $key => $value) {
            $startslot = Carbon::createFromDate($value->slot_year, $value->slot_month, $value->slot_date);
            $application = new Application;
            $application->slot_id = $value->slot_id;
            $application->status = 1;
            $application->start = $startslot;
            $application->booking_id = $booking->id;
            if ($application->save()) {
                $appsave += 1;
            }
        }
        # update status booking
        if ($appsave) {
            $booking->status = 3; // dah book time 
            $booking->save();
        }
        return redirect()->route('home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function show(Application $application)
    {
        //
        return view("lab_admin.each_application",compact('application'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function edit(Application $application)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Application $application)
    {
        $params = $request->all();
        $all_application_under_this_booking = $application->booking->applications;
        // dd($all_application_under_this_booking,$application->booking);
        $appsave = 0;
        foreach ($all_application_under_this_booking as $key => $value) {
            $value->status = $params['status'];
            if($value->save()) {
                $appsave += 1;
            }
        }
        if ($appsave == $all_application_under_this_booking->count()) {
            $booking = Booking::find($application->booking->id);
            switch ($params['status']) {
                case 2:
                    $booking->status = 4; // approve
                    break;
                case 3:
                    $booking->status = 5; // correction
                    $booking->comment = (empty($params['comment']))? NULL : $params['comment']; // correction
                    break;
                case 4:
                    $booking->status = 0; // reject
                    break;
                
                default:
                    # code...
                    break;
            }
            
            $booking->save();
            return redirect()->back()->with('status', $application->booking->title.' status has been updated to '. $this->getApplicationStatusName($application) ) ;
        }else{
            return redirect()->back()->with('status', 'Opps something wrong') ;
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Application  $application
     * @return \Illuminate\Http\Response
     */
    public function destroy(Application $application)
    {
        //
    }
    protected function getApplicationStatusName($application)
    {
        switch ($application->status) {
            case '1':
                $status_label = 'review';
                break;
            case '2':
                $status_label = 'approved';
                break;
            case '3':
                $status_label = 'correction';
                break;
            case '4':
                $status_label = 'rejected';
                $this->sentmailnotice($application);
                // sent email to student and sv
                break;
            
            default:
                $status_label = 'unknown';
                break;
        }
        return $status_label;
    }
    protected function sentmailnotice($application)
    {
        $supervisor = Supervisor::find($application->booking->supervisor->id);
        # code...
        // Mail::to('firdaushishamuddin@gmail.com')->send(new NotifySupervisor);
        Mail::to($application->booking->user->email)->cc($supervisor->email)->send(new NoticeGeneral($supervisor,$application));
    }
}
