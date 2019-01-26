@extends('layouts.app')

@section('content')
<div class="container">
    @if(Auth::user()->role->id == 2)
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Filter Query (Beta - in development)</div>

                <div class="card-body">
                    <div style="container">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Staff ID:</strong>
                                <select name="staff_id" id="select_staff_id" onchange="search_with_filter_for_labadmin()" class="form-control">
                                    @foreach(\App\Role::find(3)->users as $user)
                                    <option value="{{$user->id}}" @if(!empty($parameters['staff_id']) && $parameters['staff_id'] == $user->id) selected @endif>{{$user->name}}</option>
                                    @endforeach
                                </select>
                            </div>
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
                        </div>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
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
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        {{$parameters['dategenerated']->startOfWeek()->addDays($i)->englishDayOfWeek}}
                                        &nbsp;
                                        {{$parameters['dategenerated']->startOfWeek()->addDays($i)->day}}
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
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        {{$slot->start}} - {{$slot->end}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        {{$slot->start}} - {{$slot->end}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        {{$slot->start}} - {{$slot->end}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        {{$slot->start}} - {{$slot->end}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        {{$slot->start}} - {{$slot->end}}
                                    </div>
                                </div>
                            </div>
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
        location.href = '/admin/calender?'+date_filter+'staff_id='+$('#select_staff_id').val();
    }
</script>
@endpush
