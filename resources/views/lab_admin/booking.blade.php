@extends('layouts.app')

@section('content')
<div style="padding-right: 30px;padding-left: 30px">
    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-primary" id="adv_filter_button" data-toggle="collapse" data-target="#filter_dom"  aria-pressed="false" autocomplete="off">
              Advance Filter <i class="az-filter"></i>
            </button>
        </div>
    </div>
    <br>
    <div class="row justify-content-center collapse" id="filter_dom" style="margin-bottom: 10px">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Filter Query (Beta - in development)</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div style="container">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Equipment:</strong>
                                <select name="filter_select_equipment" id="filter_select_equipment" class="form-control" onchange="search_with_filter()">
                                    <option value="0">Filter by Equipments</option>
                                    @foreach(\App\Equipment::all() as $equipment)
                                    <option value="{{$equipment->id}}" @if(!empty($params['equipment']) && $equipment->id == $params['equipment']) selected @endif>{{$equipment->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <strong>Services:</strong>
                                <select name="filter_select_services" id="filter_select_services" class="form-control" onchange="search_with_filter()">
                                    <option value="0">Filter by Services</option>
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
                            <div class="col-md-3">
                                <strong>Status:</strong>
                                <select name="filter_select_status" id="filter_select_status" class="form-control" onchange="search_with_filter()">
                                    <option value="9">Filter by status</option>
            
                                    <option value="3" @if(!empty($params['status']) && $params['status'] == 1) selected @endif>Need Review</option>
                                    <option value="5" @if(!empty($params['status']) && $params['status'] == 2) selected @endif>Correction</option>
                                    <option value="4" @if(!empty($params['status']) && $params['status'] == 3) selected @endif>Approved</option>
                                    <option value="0" @if(!empty($params['status']) && $params['status'] == 4) selected @endif>Rejected</option>
                                </select>
                            </div>
                        </div>
                        <br>
                    </div>
                    

                    
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Applications List</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-info" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div style="container">
                        <div class="row">
                            <div class="col-md-3"><strong>Project Title</strong></div>
                            <div class="col-md-2"><strong>Booking Date / Slot</strong></div>
                            <div class="col-md-2"><strong>Application Date</strong></div>
                            <div class="col-md-1"><strong>Applicant</strong></div>
                            <div class="col-md-2"><strong>Contact</strong></div>
                            <div class="col-md-2"><strong>Quick Action (Warning!)</strong></div>
                        </div>
                        @foreach($bookings as $key =>  $booking)
                        {{-- @foreach ($applications as $key => $application) --}}
                        {{-- {{dd($booking[0],$key)}} --}}
                            <div class="row a_project_application">
                                <div class="col-md-3"><a href="{{route('booking.show',['booking'=>$booking->id])}}">{{ $booking->title }}</a></div>
                                <div class="col-md-2">{{ $booking->applications->first()->start }}</div>
                                <div class="col-md-2">{{ $booking->created_at }}</div>
                                <div class="col-md-1">{{ $booking->user->name }}</div>
                                <div class="col-md-2">@if(empty($booking->user->contact)){{ $booking->user->email }}@else {{ $booking->user->contact }} @endif</div>
                                <div class="col-md-2">
                                    @switch($booking->status)
                                        @case(3)
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('approve-form').submit();"><i class="az-check-circle"></i></a> 
                                            <a href="#" onclick="event.preventDefault(); document.getElementById('reject-form').submit();"><i class="az-times-circle"></i></a> 
                                            <a href="#" onclick="event.preventDefault();document.getElementById('correction-form').submit();"><i class="az-question-circle"></i></a>
                                            {!! Form::open(['route' => ['booking.update',$booking->id], 'method' => 'put', 'style'=>'display: none;', 'id' => 'approve-form']) !!}
                                                {{-- <input type="hidden" name="status" value="2"> val for app --}} 
                                                <input type="hidden" name="status" value="4">
                                                @csrf
                                            </form>
                                            {!! Form::open(['route' => ['booking.update',$booking->id], 'method' => 'put', 'style'=>'display: none;', 'id' => 'reject-form']) !!}
                                                {{-- <input type="hidden" name="status" value="4"> val for app --}}
                                                <input type="hidden" name="status" value="0">
                                                @csrf
                                            </form>
                                            {!! Form::open(['route' => ['booking.update',$booking->id], 'method' => 'put', 'style'=>'display: none;', 'id' => 'correction-form']) !!}
                                                {{-- <input type="hidden" name="status" value="3"> --}}
                                                    <input type="hidden" name="status" value="5">
                                                @csrf
                                            </form>
                                        @break
                                        @default
                                            @switch ($booking->status)
                                                @case(4)
                                                    <span class="badge badge-success">Approved</span>
                                                    @break
                                                @case(5)
                                                    <span class="badge badge-warning">Correction</span>
                                                    @break
                                                @case(0)
                                                    <span class="badge badge-danger">Rejected</span>
                                                    @break
                                                
                                                @default
                                            @endswitch
                                            
                                    @endswitch
                                    
                                </div>
                            </div>
                            
                        @endforeach
                        <br>
                        <div class="row justify-content-center">
                            
                                {{ $bookings->links() }}        
                            
                        </div>
                    </div>
                    

                    
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('styles')
<style>
    .a_project_application:hover{
        background-color: #F6F6F6;
        border-radius: 15px;
        border:solid #F7F7F7 1px;
    }
</style>
@endpush
@push('scripts')
<script>
    $( document ).ready(function() {
        @if(!empty($params['status']) || !empty($params['equipment'])|| !empty($params['services'])|| !empty($params['staff']))
            $('#filter_dom').collapse('toggle');
        @endif
    });
    function search_with_filter() {
        let equipment_filter = ($('#filter_select_equipment').val() != 0)?'equipment='+$('#filter_select_equipment').val()+'&':'';
        let service_filter = ($('#filter_select_services').val() != 0)?'services='+$('#filter_select_services').val()+'&':'';
        let status_filter = ($('#filter_select_status').val() != 9)?'status='+$('#filter_select_status').val()+'&':'';
        console.log(equipment_filter,service_filter,status_filter);
        location.href = '{{config('app.ajaxurl')}}/booking?'+ @if(!empty($params['page']))'page={{$params['page']}}&'+@endif equipment_filter+service_filter+status_filter;
    }
</script>
@endpush
