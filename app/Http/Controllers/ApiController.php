<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use App\Application;
use App\Slot;
use App\Block;
use App\Module;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Mail\NotifySupervisor;
use Illuminate\Support\Facades\Mail;

class ApiController extends Controller
{
    /**
    *
    *   Changes for getavailableslotbyservice
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function getavailableslotbyservice (Request $request,Service $service){
        $parameters = $request->all();
        dd($service->id,$parameters);
    }
    /**
    *
    *   Changes for getavailableslotbyapplication
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function getavailableslotbyapplication (Request $request,Application $application){
        $parameters = $request->all();
        $slots = Slot::all()->groupBy('id');
        // GET BOOKED SLOT
        $selected_date = explode('-', $parameters['date']);
        $holiday = \Carbon\Carbon::createFromDate($selected_date[0], $selected_date[1], $selected_date[2])->isWeekend();
        if ($holiday) {
        	return response()->json([
	            'status' => 500 // holiday
	        ]);
        }
        $applications = Application::latest();
        $applications = $applications->whereDate('start', '=', $parameters['date']);
        $applications = $applications->whereHas('booking', function ($query) use ($application) {
	                        $query->whereHas('service', function ($query2) use ($application) {
	                            $query2->where('id', '=', $application->booking->service->id);
	                        });
	                    })->get()->groupBy('slot_id');
        // GET BLOCK SLOT
        $allblocks = Block::where('module_id',1)->get();
        // dd($allblacks);
        $allblocks = $allblocks->map(function ($block) use($parameters,$application) {
            $curdata = explode(",", $block->data);
            // filter for slot and date
            if ($curdata[1]==$application->booking->service->id && $curdata[2]==$parameters['date']) {
                return [
                    'id'            => $block->id,
                    'data'          => $curdata,
                    'created_at'    => $block->created_at,
                    'updated_at'    => $block->updated_at,
                    'module_id'     => $block->module_id,
                    'user_id'       => $block->user_id
                ];
            }else{
                return null;
            }
            
        });
        // remove the null values
        $allblocks = $allblocks->filter();
        
        // ok begin filter
        // mapkan utk dpt service id je
        $allblocks = $allblocks->mapWithKeys(function ($block) {
            return [$block['data'][0] => ['serviceid'=>$block['data'][1],'blockid'=>$block['id'],'slot_id'=>$block['data'][0]]];
        });
        // dd($slots,$applications->toArray(),$allblocks->toArray());
        // return slots in json
        foreach ($slots as $key => $value) {
        	// first foreget if booked
        	if (array_key_exists($key, $applications->toArray())) {
			    $slots->forget($key);
			}
			if (array_key_exists($key, $allblocks->toArray())) {
			    $slots->forget($key);
			}
			// forget if blocked
        }

        return response()->json([
            'success' => 200,
            'data' => $slots
        ]);
        // dd($applications,$slots,$application->booking->service->id,$parameters);
    }
    /**
    *
    *   Changes for testapi
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function testapi (Request $request){
        $parameters = $request->all();
        $this->sentmailv2();
    }
   	/**
   	*
   	*   Changes for sentmailv2
   	*   Description :   
   	*   Last edited by : Firdausneonexxa
   	*
   	*/
   	    
   	public function sentmailv2()
    {
    	$supervisor = 1;
        // Mail::to('firdaushishamuddin@gmail.com')->send(new NotifySupervisor);
        $supervisor = \App\Supervisor::find($supervisor);
        # code...
        // Mail::to('firdaushishamuddin@gmail.com')->send(new NotifySupervisor);
        Mail::to($supervisor->email)->send(new NotifySupervisor($supervisor));
    }
   		
    /**
    *
    *   Changes for sentmail
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    protected function sentmail (){
        $mail = new \PHPMailer(true); // notice the \  you have to use root namespace here
	    try {
	    	$mail->Host = '192.168.1.94';  
		    $mail->SMTPAuth = false;  
		    $mail->Port = 25;     
		    $mail->SMTPSecure = "none"; 

	        $mail->isSMTP(); // tell to use smtp
	        $mail->CharSet = "utf-8"; // set charset to utf8
	        // $mail->SMTPAuth = true;  // use smpt auth
	        // $mail->SMTPSecure = "tls"; // or ssl
	        // $mail->Host = "yourmailhost";
	        // $mail->Port = 2525; // most likely something different for you. This is the mailtrap.io port i use for testing. 
	        $mail->Username = "username";
	        $mail->Password = "password";
	        $mail->setFrom("no-reply@kofixlabs.co", "Neo Admin");
	        $mail->Subject = "Changes";
	        $mail->MsgHTML("This is a test");
	        $mail->addAddress("firdaushishamuddin@gmail.com", "firdaushishamuddin");
	        $mail->send();
	    } catch (phpmailerException $e) {
	        dd($e);
	    } catch (Exception $e) {
	        dd($e);
	    }
	    die('success');
    }
    	
}
