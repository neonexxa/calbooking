@extends('layouts.app')

@section('content')
<div class="container">
    
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Filter Query (Beta - in development)</div>

                <div class="card-body">
                    <div style="container">
                        <div class="row">
                            @if(Auth::user()->role->id == 2)
                            <div class="col-md-3">
                                <strong>Staff ID:</strong>
                                <select name="staff_id" id="select_staff_id" onchange="search_with_filter_for_labadmin()" class="form-control">
                                    <option value="">Select Staff</option>
                                    @foreach(\App\Role::find(3)->users as $user)
                                    <option value="{{$user->id}}" @if(!empty($parameters['staff_id']) && $parameters['staff_id'] == $user->id) selected @endif>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            @endif
                            <div class="col-md-3">
                                <strong>Select date:</strong>
                                <?php
                                    if (empty($parameters['date'])) {
                                        $has_date = \Carbon\Carbon::now();//->year.'-'.\Carbon\Carbon::now()->month.'-'. \Carbon\Carbon::now()->day;
                                    }else{
                                        $has_date = $parameters['date'];

                                    }
                                ?>
                                {{Form::date('labadmin_selected_date', $has_date, ['min'=>\Carbon\Carbon::now()->format('Y-m-d'),'id'=> 'labadmin_selected_date','class' => 'form-control','onchange'=>'search_with_filter_for_labadmin()'])}}
                            </div>
                            <div class="col-md-3">
                                <strong>Service:</strong>
                                <select name="service_id" id="select_service_id" onchange="search_with_filter_for_labadmin()" class="form-control">
                                    @if(Auth::user()->role->id == 2)
                                        @if(!empty($parameters['staff_id']))
                                            <option value="">Select Service</option>
                                            @foreach(\App\User::find($parameters['staff_id'])->services as $service)
                                            <option value="{{$service->id}}" @if(!empty($parameters['service_id']) && $parameters['service_id'] == $service->id) selected @endif>{{$service->name}}</option>
                                            @endforeach
                                        @endif
                                    @else
                                        <option value="">Select Service</option>
                                        @foreach(Auth::user()->services as $service)
                                        <option value="{{$service->id}}" @if(!empty($parameters['service_id']) && $parameters['service_id'] == $service->id) selected @endif>{{$service->name}}</option>
                                        @endforeach
                                    @endif
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
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if(!empty($parameters['staff_id']))
                        <div class="row">
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        <strong>Week &nbsp;{{$parameters['dategenerated']->weekOfMonth}}</strong>
                                    </div>
                                </div>
                            </div>
                            @for ($i = 0; $i < 5; $i++)
                            <?php 
                                $dayname = $parameters['dategenerated']->startOfWeek()->addDays($i)->englishDayOfWeek;
                                $daynum = $parameters['dategenerated']->startOfWeek()->addDays($i)->day;
                            ?>
                            <div class="col-md-2 p-0">
                                <div class="col card @if($parameters['dategenerated']->toDateString() == $parameters['date']) bg-warning @endif">
                                    <div class="card-body" style="padding:0.25rem">
                                        {{$dayname}}
                                        &nbsp;
                                        {{$daynum}}
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                        @foreach(\App\Slot::all() as $slot)
                        <div class="row">
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        {{$slot->start}} - {{$slot->end}}
                                    </div>
                                </div>
                            </div>
                            @for ($i = 0; $i < 5; $i++)
                            <?php
                                $parameters['dategenerated']->startOfWeek()->addDays($i)->year.'-'.$parameters['dategenerated']->startOfWeek()->addDays($i)->month.'-'.$parameters['dategenerated']->startOfWeek()->addDays($i)->day;
                                $appofthisdateandcol = \App\Application::whereDate('start',$parameters['dategenerated']->toDateString())->where('slot_id',$slot->id);
                            ?>
                            <div class="col-md-2 p-0">
                                <div class="col card @if($parameters['dategenerated']->toDateString() == $parameters['date']) bg-warning @endif">
                                    <div class="card-body" style="padding:0.25rem">
                                        @if(Auth::user()->role->id == 2)
                                            @if(!empty($parameters['staff_id']))
                                                @if(!empty($parameters['service_id']) && in_array($parameters['service_id'],\App\User::find($parameters['staff_id'])->services->pluck('id')->toArray()))
                                                    <?php
                                                        $appbyservice = $appofthisdateandcol->whereHas('booking', function ($query) use ($parameters) {
                                                            $query->whereHas('service', function ($query2) use ($parameters) {
                                                                $query2->where('id', '=', $parameters['service_id']);
                                                            });
                                                        });
                                                    ?>
                                                    @if($appbyservice->count()==1)
                                                        {{$appbyservice->first()->booking->user->name}} 
                                                        <br>
                                                        {{$appbyservice->first()->booking->user->contact}} 
                                                    @else
                                                        <span class="badge badge-success"> 
                                                            Still Available 
                                                        </span>
                                                    @endif
                                                    
                                                @else
                                                    <?php
                                                        $appbystaff = $appofthisdateandcol->whereHas('booking', function ($query) use ($parameters) {
                                                            $query->whereHas('service', function ($query2) use ($parameters) {
                                                                $query2->where('user_id', '=', $parameters['staff_id']);
                                                            });
                                                        });
                                                    ?>
                                                    Services Available
                                                    <span class="badge badge-success"> 
                                                        {{\App\User::find($parameters['staff_id'])->services->count() - $appbystaff->count()}}
                                                    </span>
                                                @endif
                                            @endif
                                        @else
                                            @if(!empty($parameters['service_id']))
                                                <?php
                                                    $appbyservice = $appofthisdateandcol->whereHas('booking', function ($query) use ($parameters) {
                                                        $query->whereHas('service', function ($query2) use ($parameters) {
                                                            $query2->where('id', '=', $parameters['service_id']);
                                                        });
                                                    });
                                                ?>
                                                    @if($appbyservice->count()==1)
                                                        {{$appbyservice->first()->booking->user->name}} 
                                                        <br>
                                                        {{$appbyservice->first()->booking->user->contact}} 
                                                    @else
                                                        <span class="badge badge-success"> 
                                                            Still Available
                                                        </span>
                                                    @endif
                                                    
                                            @else
                                                Services Available
                                                <span class="badge badge-success"> 
                                                    {{Auth::user()->services->count() - $appofthisdateandcol->count()}}  
                                                </span>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endfor
                        </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning" role="alert">
                            Attention, Require Staff ID!!
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function search_with_filter_for_labadmin() {
        let date_filter = ($('#labadmin_selected_date').val() != 0)?'date='+$('#labadmin_selected_date').val()+'&':'';
        let service_filter = ($('#select_service_id').val() != 0)?'service_id='+$('#select_service_id').val()+'&':'';
        location.href = '/calender?'+date_filter + service_filter @if(Auth::user()->role->id == 2) +'staff_id='+$('#select_staff_id').val() @endif;
    }
</script>
@endpush
