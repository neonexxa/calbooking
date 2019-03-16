<?php

namespace App\Http\Controllers;

use App\Service;
use App\Equipment;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    /**
    *
    *   Changes for api_getequipmentservices
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function api_getequipmentservices (Request $request,Equipment $equipment){
        $parameters = $request->all();
        $data = $equipment->services;
        return response()->json([
            'success' => 200,
            'data' => $data
        ]);
    }
    /**
    *
    *   Changes for api_getserviceprice
    *   Description :   
    *   Last edited by : Firdausneonexxa
    *
    */
        
    public function api_getserviceprice (Request $request,Service $service){
        $parameters = $request->all();
        return response()->json([
            'success' => 200,
            'data' => $service
        ]);
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
    public function create(Equipment $equipment)
    {
        // show create service page
        return view('services.create',compact('equipment'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,Equipment $equipment)
    {
        //
        $params                 = $request->all();
        $service                = new Service;
        $service->name          = $params["name"];
        $service->max_sample    = $params["max_sample"];
        $service->fast_track    = $params["fast_track"];
        $service->normal        = $params["normal"];
        $service->equipment_id  = $equipment->id;
        $service->user_id       = $params["pic"];
        $service->save();
        return redirect()->route('equipment.show',['equipment'=>$equipment->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function show(Equipment $equipment, Service $service)
    {
        return view('services.show',compact('equipment','service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function edit(Equipment $equipment, Service $service)
    {
        //
        return view('services.edit',compact('equipment','service'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Equipment $equipment, Service $service)
    {
        $params                 = $request->all();
        $service->name          = $params["name"];
        $service->max_sample    = $params["max_sample"];
        $service->fast_track    = $params["fast_track"];
        $service->normal        = $params["normal"];
        $service->equipment_id  = $equipment->id;
        $service->user_id       = $params["pic"];
        $service->save();
        return redirect()->route('service.show',['equipment'=>$equipment->id,'service'=>$service->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Service  $service
     * @return \Illuminate\Http\Response
     */
    public function destroy(Service $service)
    {
        //
    }
}
