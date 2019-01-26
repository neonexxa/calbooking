<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Application;
use App\Equipment;
use App\Service;
use App\Slot;
use App\Module;
use PHPMailer;
class SystemController extends Controller
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
        return view('lab_admin.system');
    }

    /**
    *
    *   Changes for Setting
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function setting (Request $request,$system){
        $params = $request->all();
        // dd($params);
        switch ($system) {
        	case 'sch_maintenance':
        		return view('lab_admin.sch_maintenance');
        		break;
        	case 'ed_slot':

        		if (!empty($params['date'])) {
        			$calender = explode('-', $params['date']);
	        		$applications = Application::latest();
	        		$allblockedslot = Module::find(1)->blocks;
	        		// filter by date blocked slot
	        		$abs = $allblockedslot->map(function ($blocks) use($params) {
					    $datas = explode(",", $blocks->data);
					    if ($datas[2] == $params['date']) {
					    	return ['slot_id' => $datas[0], 'service_id' => $datas[1]];
					    }
					    return false;
					})->filter();
					$kbs = $abs;
	                // if got filter

	                if (!empty($params['equipment'])) {
	                	$servicesinthisequipment = Equipment::find($params['equipment'])->services->pluck('id')->toArray();
	                    $applications = $applications->whereHas('booking', function ($query) use ($params) {
	                        $query->whereHas('service', function ($query2) use ($params) {
	                            $query2->whereHas('equipment', function ($query3) use ($params) {
	                                $query3->where('id', '=', $params['equipment']);
	                            });
	                        });
	                    });
	                    $kbs = $abs->map(function($item) use($params,$servicesinthisequipment){
                			if (in_array($item['service_id'],$servicesinthisequipment)) {
						    	return $item;
						    }
                		})->filter();
                		// dd($kbs);
	                    if (!empty($params['services'])) {
	                    	if(in_array($params['services'], $servicesinthisequipment)){
	                    		$applications = $applications->whereHas('booking', function ($query) use ($params) {
			                        $query->whereHas('service', function ($query2) use ($params) {
			                            $query2->where('id', '=', $params['services']);
			                        });
			                    });	
			                    $kbs = $abs->map(function($item) use($params){
	                    			if ($item['service_id'] == $params['services']) {
								    	return $item;
								    }
	                    		})->filter();
	                    		// dd($kbs);
	                    	}else{
	                    		// if has both equipment n services but services not match so ignore services 
	                    		$kbs = $abs->map(function($item) use($params,$servicesinthisequipment){
	                    			if (in_array($item['service_id'],$servicesinthisequipment)) {
								    	return $item;
								    }
	                    		})->filter();
	                    		// dd($kbs);
	                    	}
		                }

	                }else{
	                	if (!empty($params['services'])) {
                    		$applications = $applications->whereHas('booking', function ($query) use ($params) {
		                        $query->whereHas('service', function ($query2) use ($params) {
		                            $query2->where('id', '=', $params['services']);
		                        });
		                    });	
		                    // check for blocked slot
		                    // if services only exist
							$kbs = $abs->map(function($item) use($params){
                    			if ($item['service_id'] == $params['services']) {
							    	return $item;
							    }
                    		})->filter();
                    		// dd($kbs);
		                }
	                }

                    $applications = $applications->whereDate('start', '=', \Carbon\Carbon::createFromDate($calender[0], $calender[1], $calender[2])->toDateString());
                    $totalbookingperslot = $applications->get()->groupBy('slot_id');
                    $todaybookedslot = $applications->pluck('slot_id')->toArray();

                    $fkbs = $kbs->groupBy('slot_id');

                }else{
                	$todaybookedslot = [];
                	$totalbookingperslot = [];
                	$fkbs = [];
                }
                

        		return view('lab_admin.ed_slot',compact('totalbookingperslot','todaybookedslot','params','fkbs'));
        		break;
        	
        	default:
        		# code...
        		break;
        }
    }
    	
    /**
    *
    *   Changes for Index
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function transferapplicationbooking (Request $request,$system,Application $application){
        $parameters = $request->all();
        $application->start = $parameters['date'];
        $application->slot_id = $parameters['slot_id'];
        $application->save();
        return response()->json([
            'status' => 200,
            'msj' => 'successfully transfered!'
        ]);
    }
    /**
    *
    *   Changes for sentmail
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    protected function sentmail (){
        $mail = new PHPMailer(true); // notice the \  you have to use root namespace here
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
