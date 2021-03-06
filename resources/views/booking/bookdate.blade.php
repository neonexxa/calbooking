

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center" style="margin-bottom: 10px">
        <div class="col-md-2">
            @if(!empty($calender['date']) && $calender['view'] != 'week'){{$craftedcarbon->day}} - @endif {{$craftedcarbon->englishMonth}} - {{$craftedcarbon->year}}
        </div>
        <div class="col-md-4">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" onclick="gotodate('month',1,{{$craftedcarbon->month}},{{$craftedcarbon->year}})" class="btn btn-secondary @if($calender['view'] == 'month') active @endif" id="group_btn_month_view">Month</button>
                <button type="button" onclick="gotodate('week',@if($calender['view'] == 'date') {{$craftedcarbon->day}} @elseif($calender['view'] == 'month') {{$craftedcarbon->day}} @else 1 @endif,{{$craftedcarbon->month}},{{$craftedcarbon->year}})" class="btn btn-secondary @if($calender['view'] == 'week') active @endif" id="group_btn_week_view">Week</button>
                <button type="button" onclick="gotodate('date',{{$craftedcarbon->day}},{{$craftedcarbon->month}},{{$craftedcarbon->year}})" class="btn btn-secondary @if($calender['view'] == 'date') active @endif" id="group_btn_day_view">Day</button>
            </div>
        </div>
        <div class="col-md-1">
            <button class="btn btn-primary" id="apply_button_after_pick_slot" style="display: none">Apply</button>
        </div>
        <div class="col-md-1">
            @if($craftedcarbon->month < \Carbon\Carbon::now()->month+1)
                @if(\Carbon\Carbon::now()->day >= 15)
                <a href="{{config('app.ajaxurl')}}/booking/regslot/{{$booking->id}}?view=month&month={{$craftedcarbon->month+1}}&year=2019" class="btn btn-primary">Next Month</a>
                @endif
            @else
            <a href="{{config('app.ajaxurl')}}/booking/regslot/{{$booking->id}}?view=month&month={{\Carbon\Carbon::now()->month}}&year=2019" class="btn btn-primary">Prev Month</a>
            @endif
        </div>
        <div class="col-md-4">
            You can only book for maximum of {{$booking->samples->count()}} slot(s).
        </div>
        {{-- <div class="col-md-6">
            Go To : 
            <select name="" id="">
                <option value="">year</option>
            </select>
            <select name="" id="">
                <option value="">month</option>
            </select>
        </div> --}}
        {{-- second featurs --}}
    </div>

    {{-- list all time , date, month year --}}
    @switch($calender['view'])
        @case('month')
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="row">
                    @for ($i = 1; $i <= \Carbon\Carbon::createFromDate($calender['year'], $calender['month'], 1)->daysInMonth; $i++)
                        @if($i != 1 && ($i-1)%5 == 0)
                    </div>
                    <div class="row">
                        @endif
                        <div class="col card daysinmonth_card" onclick="gotodate('date',{{$i}},{{$calender['month']}},{{$calender['year']}})">
                            <div class="card-body">
                                <div class="row m-0 p-0">
                                    <div class="col-md-6 m-0 p-0">
                                        <p class="m-0">{{$i}}</p>
                                        <p class="m-0" style="font-size: 0.1rem;">
                                            {{\Carbon\Carbon::createFromDate($calender['year'], $calender['month'], $i)->englishDayOfWeek}}
                                        </p>
                                    </div>
                                    <div class="col-md-6 m-0 p-0">
                                        <?php
                                         $remainingslots = count(\App\Slot::all())-count(\App\Application::whereDate('start', '=', \Carbon\Carbon::createFromDate($calender['year'], $calender['month'], $i)->toDateString())->get());
                                        ?>
                                        @if($remainingslots < 1)
                                        {{-- black --}}
                                        <span class="badge badge-dark float-right text-white">({{$remainingslots}} slot left)</span>
                                        @elseif($remainingslots < 3)
                                        {{-- danger --}}
                                        <span class="badge badge-danger float-right text-white">({{$remainingslots}} slot left)</span>
                                        @elseif($remainingslots < 5)
                                        {{-- warning --}}
                                        <span class="badge badge-warning float-right text-white">({{$remainingslots}} slot left)</span>
                                        @elseif($remainingslots < 7)
                                        {{-- info --}}
                                        <span class="badge badge-info float-right text-white">({{$remainingslots}} slot left)</span>
                                        @else
                                            <span class="badge badge-success float-right text-white">({{$remainingslots}} slot left)</span>
                                        @endif
                                        
                                    </div>
                                </div>
                                  
                            </div>
                        </div>
                    @endfor
                    </div>
                </div>
            </div>
            @break
        @case('week')
            <div class="row justify-content-center">
                <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        <strong>Week &nbsp;{{$craftedcarbon->weekOfMonth}}</strong>
                                    </div>
                                </div>
                            </div>
                            @for ($i = 0; $i < 5; $i++)
                            <div class="col-md-2 p-0">
                                <div class="col card">
                                    <div class="card-body" style="padding:0.25rem">
                                        {{$craftedcarbon->startOfWeek()->addDays($i)->englishDayOfWeek}}
                                        &nbsp;
                                        {{$craftedcarbon->startOfWeek()->addDays($i)->day}}
                                    </div>
                                </div>
                            </div>
                            @endfor
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
                            {{-- 
                            {{dd($craftedcarbon->startOfWeek()->month,$craftedcarbon->startOfWeek()->addDays(29)->month,$craftedcarbon->month)}} --}}
                            @for ($i = 0; $i < 5; $i++)
                                <div class="col-md-2 p-0">
                                    <div class="col card">
                                        <div class="card-body" style="padding:0.25rem">
                                            <span class="text-info">Available</span>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                            <?php
                            //$craftedcarbon->subDays($i);
                            ?>
                        </div>
                    @endforeach
                    
                    {{-- <div class="row">
                    @for ($i = 1; $i <= \Carbon\Carbon::createFromDate($calender['year'], $calender['month'], 1)->daysInMonth; $i++)
                        @if($i != 1 && ($i-1)%5 == 0)
                    </div>
                    <div class="row">
                        @endif
                        <div class="col card">
                            <div class="card-body">
                                {{$i}}  <span class="badge badge-success float-right">(Approved)</span>
                            </div>
                        </div>
                    @endfor
                    </div> --}}
                </div>
            </div>
            @break
        @case('date')
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @if(\Carbon\Carbon::createFromDate($calender['year'], $calender['month'], $calender['date'])->isWeekday())
                        <?php $todaybookedslot = \App\Application::whereDate('start', '=', \Carbon\Carbon::createFromDate($calender['year'], $calender['month'], $calender['date'])->toDateString())->pluck('slot_id')->toArray();
                        ?>
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
                                <div class="col-md-10 p-0">
                                    @if(in_array($slot->id, $todaybookedslot))
                                        <div class="col card slot_day_row" data-slot_id="{{$slot->id}}" data-slot_label="{{$slot->name}} ({{$slot->start}} - {{$slot->end}})" data-slot_day="{{$craftedcarbon->englishDayOfWeek}}" data-slot_date="{{$craftedcarbon->day}}" data-slot_month="{{$craftedcarbon->month}}" data-slot_year="{{$craftedcarbon->year}}">
                                            <div class="card-body" style="padding:0.25rem">
                                                <span class="text-danger">Full ({{\App\Application::whereDate('start', '=', \Carbon\Carbon::createFromDate($calender['year'], $calender['month'], $calender['date']))->where('slot_id',$slot->id)->first()->booking->user->name}} - {{\App\Application::whereDate('start', '=', \Carbon\Carbon::createFromDate($calender['year'], $calender['month'], $calender['date']))->where('slot_id',$slot->id)->first()->booking->user->email}})</span>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col card slot_day_row" id="slot_day_row_{{$slot->id}}"{{--  data-toggle="modal" data-target="#selectslotmodal"  --}}data-slot_id="{{$slot->id}}" data-slot_label="{{$slot->name}} ({{$slot->start}} - {{$slot->end}})" data-slot_day="{{$craftedcarbon->englishDayOfWeek}}" data-slot_date="{{$craftedcarbon->day}}" data-slot_month="{{$craftedcarbon->month}}" data-slot_year="{{$craftedcarbon->year}}" style="cursor: pointer;">
                                            <div class="card-body" style="padding:0.25rem">
                                                <span class="text-info">Available</span>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    @else
                        Too bad we dont work today !!
                    @endif
                    {{-- <div class="row">
                    @for ($i = 1; $i <= \Carbon\Carbon::createFromDate($calender['year'], $calender['month'], 1)->daysInMonth; $i++)
                        @if($i != 1 && ($i-1)%5 == 0)
                    </div>
                    <div class="row">
                        @endif
                        <div class="col card">
                            <div class="card-body">
                                {{$i}}  <span class="badge badge-success float-right">(Approved)</span>
                            </div>
                        </div>
                    @endfor
                    </div> --}}
                </div>
            </div>
            @break
        @default
            <span>Something went wrong, please try again</span>
    @endswitch
    
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Get Your Slot</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    (Notice)
                </div>
            </div>
        </div>
    </div>
</div>
{!! Form::open(['route' => ['application.store',$booking->id], 'id' => 'select_slot_form']) !!}
{!! Form::close() !!}
@include('modal.selectslot')
@endsection
@push('styles')
<style>
    .daysinmonth_card:hover{
        background-color: #31333D;
        color:white;
        cursor: pointer;
    }
</style>
@endpush
@push('scripts')
<script>
    function gotodate(view,date,month,year) {
        console.log(view,date,month,year);
        switch(view) {
          case 'month':
            location.href = "{{route('booking.regslot',['booking'=>$booking->id])}}?view="+view+"&month="+month+"&year="+year;
            break;
          default:
            location.href = "{{route('booking.regslot',['booking'=>$booking->id])}}?view="+view+"&date="+date+"&month="+month+"&year="+year;
        }
        
    }
	// $('#selectslotmodal').on('show.bs.modal', function (event) {
 //        let button = $(event.relatedTarget) // Button that triggered the modal

 //        let slot_id         = button.data('slot_id');
 //        let slot_label      = button.data('slot_label');
 //        let slot_day        = button.data('slot_day');
 //        let slot_date       = button.data('slot_date');
 //        let slot_month      = button.data('slot_month');
 //        let slot_year       = button.data('slot_year');
 //        let slot_selected   = button.data('slot_selected');
 //        let slot_booked_key = button.data('slot_booked_key');
 //        console.log("slot_selected",slot_selected);
        
 //        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
 //        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
 //        let modal = $(this)
        
 //        modal.find('.modal-body #select_slot_day').val(slot_day);
 //        modal.find('.modal-body #select_slot_date').val(slot_date+"/"+slot_month+"/"+slot_year);
 //        modal.find('.modal-body #select_slot_date_hidden').val(slot_date+"/"+slot_month+"/"+slot_year);
 //        modal.find('.modal-body #select_slot_slot').val(slot_label);
 //        modal.find('.modal-body #select_slot_slot_id').val(slot_id);
 //        if (slot_selected) {
 //            console.log("yes");
 //            modal.find('.modal-header  #selectslotmodallabel').text("Cancel application for this slot?");
 //            modal.find('.modal-footer #select_slot_form_button').attr("data-value",'cancel');
 //            modal.find('.modal-footer #select_slot_form_button').attr("data-delete_key",slot_booked_key);
 //        }else{
 //            modal.find('.modal-header  #selectslotmodallabel').text("Apply for this slot?");
 //            modal.find('.modal-footer #select_slot_form_button').attr("data-value",'confirm');
 //        }
 //    });
    window.bookedslots = {};
    window.bookedslots_count = 0;
    // $('#select_slot_form_button').click(function (event) {
    //     console.log("booked slot",bookedslots_count);
    //     console.log("action",$('.modal-footer #select_slot_form_button').attr('data-value'));
    //     if ($('.modal-footer #select_slot_form_button').attr('data-value') == 'confirm') {
    //         if (bookedslots_count >= {{$booking->samples->count()}}) {
    //             alert("reached maximum number of slots booked");
    //         }else{
    //             let a_slot = {};
    //             console.log($('#select_slot_slot_id').val(), "slot_id");
    //             a_slot["slot_id"] = $('#select_slot_slot_id').val();
    //             bookedslots[bookedslots_count] = a_slot;
    //             bookedslots_count +=1;
    //             $('#slot_day_row_'+$('#select_slot_slot_id').val()).css("background-color", "yellow");
    //             $('#slot_day_row_'+$('#select_slot_slot_id').val()).attr("data-slot_selected", "true");
    //             $('#slot_day_row_'+$('#select_slot_slot_id').val()).attr("data-slot_booked_key", bookedslots_count);
    //             $('#selectslotmodal').modal('hide');
    //         }    
    //     }else{
    //         console.log("deleting slot");
    //         delete_slot($('#select_slot_form_button').data("delete_key"));
    //         $('#slot_day_row_'+$('#select_slot_slot_id').val()). removeAttr("data-slot_selected");
    //         $('#slot_day_row_'+$('#select_slot_slot_id').val()).css("background-color", "white");
    //     }
    //     console.log("bookedslots",bookedslots);
        
    // });
    // function delete_slot(key) {
    //     delete bookedslots[key];
    //     bookedslots_count -=1;
    //     // bookedslots = _.filter(bookedslots);
    // }
    

    $('.slot_day_row').click(function (event) {
        let button = $(this);
        console.log(button.data('slot_id'));

        if (button.hasClass('row_slot_selected')) {
            delete bookedslots[button.data('slot_id')];
            bookedslots_count -=1;
            button.css("background-color", "white");
            button.removeClass('row_slot_selected');
            toggle_apply_button();
        }else{
            if (bookedslots_count >= {{$booking->samples->count()}}) {
                alert("reached maximum number of slots booked");
                toggle_apply_button();
            }else{
                
                //$('#slot_day_row_'+button.data('slot_id')).css("background-color", "yellow");
                button.css("background-color", "yellow");
                // $('#slot_day_row_'+button.data('slot_id')).addClass("row_slot_selected");
                button.addClass("row_slot_selected");
                let a_slot = {};
                a_slot["slot_id"]    = button.data('slot_id');
                a_slot["slot_date"]  = button.data('slot_date');
                a_slot["slot_month"] = button.data('slot_month');
                a_slot["slot_year"]  = button.data('slot_year');
                bookedslots[button.data('slot_id')] = a_slot;
                bookedslots_count +=1;
                toggle_apply_button();
            }
        }
        console.log(bookedslots,bookedslots_count);
        
    });
    function toggle_apply_button() {
        if (bookedslots_count >= {{$booking->samples->count()}}) {
            $('#apply_button_after_pick_slot').show();
        }else{
            $('#apply_button_after_pick_slot').hide();
        }
    }

    $('#apply_button_after_pick_slot').click(function (event) {
        if (Object.keys(bookedslots).length != 0) {
            $('<input />').attr('type', 'hidden')
            .attr('name', "all_slots_booked")
            .attr('value', JSON.stringify(bookedslots))
            .appendTo('#select_slot_form');
        }
        $('#select_slot_form').submit();
    });
</script>
@endpush
