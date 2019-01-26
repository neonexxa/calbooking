@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{route('system.index')}}"><i class="az-arrow-left"></i></a>&nbsp;Manage Slot Slot</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-4">
                            <strong>Equipment:</strong>
                            <select name="filter_select_equipment" id="filter_select_equipment" class="form-control" onchange="search_with_filter()">
                                <option value="0">Select Equipments</option>
                                @foreach(\App\Equipment::all() as $equipment)
                                <option value="{{$equipment->id}}" @if(!empty($params['equipment']) && $equipment->id == $params['equipment']) selected @endif>{{$equipment->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <strong>Services:</strong>
                            <select name="filter_select_services" id="filter_select_services" class="form-control" onchange="search_with_filter()">
                                <option value="0">Select Services</option>
                                @if(!empty($params['equipment']))
                                    @foreach(\App\Service::where('equipment_id',$params['equipment'])->get() as $service)
                                    <option value="{{$service->id}}" @if(!empty($params['services']) && $service->id == $params['services']) selected @endif>{{$service->name}}</option>
                                    @endforeach
                                @else
                                    @foreach(\App\Service::all() as $service)
                                    <option value="{{$service->id}}" @if(!empty($params['services']) && $service->id == $params['services']) selected @endif>{{$service->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <strong>Select date:</strong>
                            <?php
                                if (empty($params['date'])) {
                                    $has_date = \Carbon\Carbon::now()->addDay();
                                }else{
                                    $has_date = $params['date'];

                                }
                            ?>
                            {{Form::date('selected_date', $has_date, ['min'=>\Carbon\Carbon::now()->format('Y-m-d'),'id'=> 'selected_date','class' => 'form-control','onchange'=>'search_with_filter()'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @if(!empty($params['date']))
                
                <?php
                $calender = explode('-', $params['date']);
                ?>

                    @if(\Carbon\Carbon::createFromDate($calender[0], $calender[1], $calender[2])->isWeekday())
                        <div class="row">
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        Slot
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        Total Slot <span class="badge badge-light" data-toggle="tooltip" data-placement="top" title="Total Manageble Slot"><i class="az-info"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        Open Slot <span class="badge badge-light" data-toggle="tooltip" data-placement="top" title="Non Blocked Slot"><i class="az-info"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        Status
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        Booked Slot <span class="badge badge-light" data-toggle="tooltip" data-placement="top" title="Slot Booked"><i class="az-info"></i></span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        Action
                                    </div>
                                </div>
                            </div>
                        </div>

                        @foreach(\App\Slot::all() as $slot)
                        {{-- tunjuk je sume slot, klo ade block kite gray kan row --}}
                            <div class="row">
                                <div class="col-md-2 p-0">
                                    <div class="col card">
                                        <div class="card-body" style="padding:0.25rem">
                                            {{$slot->start}} - {{$slot->end}}
                                        </div>
                                    </div>
                                </div>
                                <?php
                                    if(!empty($params['equipment'])){
                                        if(!empty($params['services'])){
                                            if(in_array($params['services'], \App\Equipment::find($params['equipment'])->services->pluck('id')->toArray())){
                                                $total_slot = 1;
                                                $applications = \App\Application::where('slot_id',$slot->id)->whereDate('start', '=', $params['date'])->whereHas('booking', function ($query) use ($params) {
                                                    $query->whereHas('service', function ($query2) use ($params) {
                                                        $query2->where('id', '=', $params['services']);
                                                    });
                                                });
                                                $hasbooked = $applications->count();
                                                $slot_block_by = 'service';
                                            }else{
                                                $total_slot = \App\Equipment::find($params['equipment'])->services->count();
                                                $applications = \App\Application::where('slot_id',$slot->id)->whereDate('start', '=', $params['date'])->whereHas('booking', function ($query) use ($params) {
                                                    $query->whereHas('service', function ($query2) use ($params) {
                                                        $query2->whereHas('equipment', function ($query3) use ($params) {
                                                            $query3->where('id', '=', $params['equipment']);
                                                        });
                                                    });
                                                });
                                                $hasbooked = $applications->count();
                                                $slot_block_by = 'equipment';
                                            }
                                        }else{
                                            $total_slot = \App\Equipment::find($params['equipment'])->services->count();
                                            $applications = \App\Application::where('slot_id',$slot->id)->whereDate('start', '=', $params['date'])->whereHas('booking', function ($query) use ($params) {
                                                $query->whereHas('service', function ($query2) use ($params) {
                                                    $query2->whereHas('equipment', function ($query3) use ($params) {
                                                        $query3->where('id', '=', $params['equipment']);
                                                    });
                                                });
                                            });
                                            $hasbooked = $applications->count();
                                            $slot_block_by = 'equipment';
                                        }
                                    }else{
                                        if(!empty($params['services'])){
                                            $total_slot = 1;
                                            $application = \App\Application::where('slot_id',$slot->id)->whereDate('start', '=', $params['date'])->whereHas('booking', function ($query) use ($params) {
                                                $query->whereHas('service', function ($query2) use ($params) {
                                                    $query2->where('id', '=', $params['services']);
                                                });
                                            });
                                            $hasbooked = $application->count();
                                            $slot_block_by = 'service';
                                        }else{
                                            $total_slot = \App\Service::all()->count();
                                            $applications = \App\Application::where('slot_id',$slot->id)->whereDate('start', '=', $params['date']);
                                            $hasbooked = $applications->count();
                                            $slot_block_by = 'slot';
                                        }
                                    }
                                    if(!empty($fkbs[$slot->id])){
                                        $blocked_slot = $fkbs[$slot->id]->count();
                                        $total_minus_blocked_slot = $total_slot-$blocked_slot;
                                    }else{
                                        $blocked_slot = 0;
                                        $total_minus_blocked_slot = $total_slot-$blocked_slot;
                                    }
                                ?>
                                <div class="col-md-2 p-0">
                                    <div class="col card">
                                        <div class="card-body" style="padding:0.25rem">
                                            {{$total_slot}}
                                            {{-- @if(!empty($params['equipment'])) --}}
                                                {{-- @if(!empty($params['services'])) --}}
                                                    {{-- check services tu ade x dlm equipment ni --}}
                                                    {{-- @if(in_array($params['services'], \App\Equipment::find($params['equipment'])->services->pluck('id')->toArray())) --}}
                                                        {{-- {{1}} --}}
                                                    {{-- @else --}}
                                                        {{-- {{\App\Equipment::find($params['equipment'])->services->count()}}   --}}
                                                    {{-- @endif
                                                @else --}}
                                                    {{-- {{\App\Equipment::find($params['equipment'])->services->count()}}     --}}
                                                {{-- @endif
                                            @else --}}
                                                {{-- @if(!empty($params['services'])) --}}
                                                    {{-- {{1}} --}}
                                                {{-- @else --}}
                                                    {{-- {{\App\Service::all()->count()}} --}}
                                                {{-- @endif
                                            @endif --}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 p-0">
                                    <div class="col card">
                                        <div class="card-body" style="padding:0.25rem">
                                            {{$total_minus_blocked_slot}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 p-0">
                                    <div class="col card" data-toggle="modal" data-target="#selectslotmodal" data-slot_id="{{$slot->id}}" style="cursor: pointer;">
                                        <div class="card-body" style="padding:0.25rem">   

                                            @if(!$hasbooked)
                                                @if($total_minus_blocked_slot)
                                                    <input type="checkbox" checked class="inputtogglestatus" id="inputtogglestatus{{$slot->id}}" data-onstyle="success" data-offstyle="danger" data-slot_id="{{$slot->id}}" data-slot_date="{{$params['date']}}" data-slot_blockby="{{$slot_block_by}}" style="padding:0px"> <span class="badge badge-light" data-toggle="tooltip" data-placement="top" title="Toogle to block/open slot"><i class="az-info"></i></span>
                                                @else
                                                    <input type="checkbox" @if(!$blocked_slot) checked @endif class="inputtogglestatus" id="inputtogglestatus{{$slot->id}}" data-onstyle="success" data-offstyle="danger" data-slot_id="{{$slot->id}}" data-slot_date="{{$params['date']}}" data-slot_blockby="{{$slot_block_by}}" style="padding:0px"> <span class="badge badge-light" data-toggle="tooltip" data-placement="top" title="Toogle to block/open slot"><i class="az-info"></i></span>
                                                @endif
                                            @else
                                                <span style="font-style: italic;color: grey">
                                                    N/A 
                                                </span>
                                                <span class="badge badge-light" data-toggle="tooltip" data-placement="top" title="Transfer booked slot first prior before any blocking"><i class="az-info"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 p-0">
                                    {{-- booked slot --}}
                                    <div class="col card">
                                        <div class="card-body" style="padding:0.25rem">
                                            {{$hasbooked}}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 p-0">
                                    <div class="col card">
                                        <div class="card-body" style="padding:0.25rem">
                                            <span style="font-style: italic;color: grey">
                                                @if(!$hasbooked)
                                                    N/A
                                                @else
                                                    @if($hasbooked == 1)
                                                        <button type="button" class="btn btn-primary transferslot" data-toggle="modal" data-target="#transferslotmodal" data-application_id="{{$applications->first()->id}}">
                                                            Transfer booking to other slot
                                                        </button>
                                                    @elseif($hasbooked > 1)
                                                        <span class="badge badge-light" data-toggle="tooltip" data-placement="top" title="Too many application, filter to specific service before making transfer"><i class="az-info"></i></span>
                                                    @else
                                                        N/A
                                                    @endif
                                                @endif
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-info" role="alert">
                            Too bad we dont work today !!
                        </div>
                    @endif
            @else
                <div class="alert alert-info" role="alert">
                    Please choose a date !!
                </div>
                
            @endif
            
        </div>
    </div>
</div>
<div class="modal fade" id="transferslotmodal" tabindex="-1" role="dialog" aria-labelledby="transferslotmodalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="transferslotmodalLabel">Move booking to other slot</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Choose date:</p>
        {{Form::date('transfer_selected_date', $has_date, ['min'=>\Carbon\Carbon::now()->addDay()->format('Y-m-d'),'id'=> 'transfer_selected_date','class' => 'form-control','onchange'=>'modalgetavailableslot()'])}}
        <input type="hidden" id="transfer_application_id">
        <br>

        <div class="available_slot">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="transfer_booking" onclick="transfer_booking()">Transfer</button>
      </div>
    </div>
  </div>
</div>
@endsection
@push('styles')
<style>
    .toggle.btn{
        min-height: 15px !important;
        height: 15px !important;
        width: 80% !important;
        padding: 0;
    }
    .toggle-off.btn {
        padding: 0 24px 0 24px;
        font-size: 0.3rem;
    }
    .toggle-on.btn {
        padding: 0 24px 0 24px;
        font-size: 0.3rem;
    }
    .transferslot{
        padding:1px 5px;
        font-size: 0.3rem;
    }
    .btn-secondary-transfer-slot-active{
        color: #fff;
        background-color: #6c757d;
        border-color: #6c757d;    
    }
    
</style>
@endpush
@push('scripts')
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>


<script>
    $( document ).ready(function() {
        @if(!empty($params['status']) || !empty($params['equipment'])|| !empty($params['services'])|| !empty($params['staff']))
            $('#filter_dom').collapse('toggle');
        @endif
        $('.inputtogglestatus').bootstrapToggle({
          on: 'Open',
          off: 'Closed'
        });
        $('.inputtogglestatus').change(function() {
            if ($(this).prop('checked')) {
                blockslot_byid($(this).data('slot_id'),$(this).data('slot_date'),$(this).data('slot_blockby'),true)
                console.log("bukak",$(this).data('slot_id'))
            }else{
                blockslot_byid($(this).data('slot_id'),$(this).data('slot_date'),$(this).data('slot_blockby'),false)
                console.log("tutup",$(this).data('slot_id'))
            }
        })
    });

    $('#transferslotmodal').on('show.bs.modal', function (event) {
      let button = $(event.relatedTarget) // Button that triggered the modal
      
      var modal = $(this)
      modal.find('#transfer_application_id').val(button.data('application_id'))
    });
    function search_with_filter() {
        let equipment_filter = ($('#filter_select_equipment').val() != 0)?'equipment='+$('#filter_select_equipment').val()+'&':'';
        let service_filter = ($('#filter_select_services').val() != 0)?'services='+$('#filter_select_services').val()+'&':'';
        let date_filter = ($('#selected_date').val() != 0)?'date='+$('#selected_date').val()+'&':'';
        console.log(equipment_filter,service_filter,date_filter);

        location.href = '/admin/system/ed_slot?'+equipment_filter+service_filter+date_filter;
    }
    function modalgetavailableslot() {
        let modal_date_filter = ($('#transfer_selected_date').val() != 0)?'date='+$('#transfer_selected_date').val()+'&':'';
        
        $.ajax({
          type: 'GET',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: '/api/getavailableslotbyapplication/'+$('#transfer_application_id').val()+'?'+modal_date_filter,
          // data: ajaxdata,
          processData : false,
          contentType  : false,
          success: (data)=>{
            let slots = '';
            slots += '<p>Available Slots : </p>';
            if (data.status == 500) {
                // holiday
                slots += '<p>Ops not a working day!!</p>';
            }else{
                Object.keys(data.data).forEach(function(key) {
                  console.log(key, data.data[key][0].name);
                  slots += '<button type="button" class="btn btn-outline-secondary col-md-3 btn-secondary-transfer-slot" id="button_transfer_slot_'+key+'" style="font-size:0.3rem" onclick="transferslottoggleattr('+key+')" key="'+key+'">'+data.data[key][0].name+' ('+data.data[key][0].start+'-'+data.data[key][0].end +')</button>';
                });
            }
            
            $('.available_slot').empty();
            $('.available_slot').append(slots);
          }
        }); 
    }
    function transferslottoggleattr(key) {
        // body...
        $('.btn-secondary-transfer-slot').removeClass( 'btn-secondary-transfer-slot-active' );
        $('#button_transfer_slot_'+key).addClass('btn-secondary-transfer-slot-active');
    }
    function transfer_booking() {
        let slot_id = $('.btn-secondary-transfer-slot-active').attr('key');
        let new_transfer_date = $('#transfer_selected_date').val();
        let application_id = $('#transfer_application_id').val();
        console.log(slot_id,new_transfer_date,application_id);
        let ajaxdata = new FormData();
        ajaxdata.append('slot_id', slot_id);
        ajaxdata.append('date', new_transfer_date);
        ajaxdata.append('application_id', application_id);
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/admin/system/ed_slot/application/'+application_id,
            data: ajaxdata,
            processData : false,
            contentType  : false,
            success: (data)=>{
              alert(data.msj);
              if(data.status == 200){
                window.location.reload();  
              }
              
            }
        }); 
    }
    function blockslot_byid(slot_id,bloking_date,block_by,eod) {
        // body...
        let ajaxdata = new FormData();
        console.log(block_by);
        ajaxdata.append('date', bloking_date);
        ajaxdata.append('block_by', block_by);
        ajaxdata.append('slot_id', slot_id);
        @if(!empty($params['equipment']))
            @if(!empty($params['services']))
                @if(in_array($params['services'], \App\Equipment::find($params['equipment'])->services->pluck('id')->toArray()))
                    ajaxdata.append('service_id', {{$params['services']}});
                @else
                    ajaxdata.append('equipment_id', {{$params['equipment']}});
                @endif
            @else
                ajaxdata.append('equipment_id', {{$params['equipment']}});
            @endif
        @else
            @if(!empty($params['services']))
                ajaxdata.append('service_id', {{$params['services']}});
            @else
                
            @endif
        @endif
        
        $.ajax({
            type: 'POST',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            url: '/admin/system/ed_slot/block/1?enable='+eod,
            data: ajaxdata,
            processData : false,
            contentType  : false,
            success: (data)=>{
              if(data.status == 200){
                window.location.reload();  
              }
              
            }
        }); 
    }
</script>
@endpush
