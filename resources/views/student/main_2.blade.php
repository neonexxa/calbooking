@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboardll</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                            <div class="row" style="margin-bottom: 5px">
                                <div class="col-md-3"><strong>Title</strong></div>
                                <div class="col-md-2"><strong>Submitted</strong></div>
                                <div class="col-md-3"><strong>Description</strong></div>
                                <div class="col-md-2"><strong>Status</strong></div>
                                <div class="col-md-2"></div>
                            </div>
                        @foreach($bookings as $booking)
                            @switch($booking->status)
                                @case(0)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col-md-3">{{$booking->title}}</div>
                                        <div class="col-md-2">{{$booking->created_at->diffForHumans()}}</div>
                                        <div class="col-md-3">Application Rejected</div>
                                        <div class="col-md-2"><span class="badge badge-danger float-left">(Rejected)</span></div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    @break
                                @case(1)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col-md-3">{{$booking->title}}</div>
                                        <div class="col-md-2">{{$booking->created_at->diffForHumans()}}</div>
                                        <div class="col-md-3">New application submited. </div>
                                        <div class="col-md-2"><span class="badge badge-primary float-left">(new application)</span></div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    @break
                                @case(2)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col-md-3">{{$booking->title}}</div>
                                        <div class="col-md-2">{{$booking->created_at->diffForHumans()}}</div>
                                        <div class="col-md-3">Application has been approve. </div>
                                        <div class="col-md-2"><span class="badge badge-success float-left">(Approved)</span></div>
                                        <div class="col-md-2"><a href="{{route('booking.regslot',['booking'=>$booking->id])}}" class="btn btn-success pt-0 pb-0">Book slot</a></div>
                                    </div>
                                    @break
                                @case(3)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col-md-3">{{$booking->title}}</div>
                                        <div class="col-md-2">{{$booking->created_at->diffForHumans()}}</div>
                                        <div class="col-md-3">Booking for slot in progress. </div>
                                        <div class="col-md-2"><span class="badge badge-info float-left text-white">(Applied Date)</span></div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    @break
                                @case(4)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col-md-3">{{$booking->title}}</div>
                                        <div class="col-md-2">{{$booking->created_at->diffForHumans()}}</div>
                                        <div class="col-md-3">Slot has been approve. </div>
                                        <div class="col-md-2"><span class="badge badge-success float-left">(Completed)</span></div>
                                        <div class="col-md-2"></div>
                                    </div>
                                    @break
                                @case(5)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col-md-3">{{$booking->title}}</div>
                                        <div class="col-md-2">{{$booking->created_at->diffForHumans()}}</div>
                                        <div class="col-md-3">Correction Needed!!. </div>
                                        <div class="col-md-2"><span class="badge badge-warning float-left">(Important)</span></div>
                                        <div class="col-md-2"><a href="{{route('booking.edit',['booking'=>$booking->id])}}" class="btn btn-warning pt-0 pb-0">Edit</a></div>
                                    </div>
                                    @break
                                @default
                                    <span>Something went wrong, please try again</span>
                            @endswitch
                        @endforeach
                        
                            {{-- <p>No Pending Task, Do Something ...</p> --}}
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
