@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                        @foreach($bookings as $booking)
                            @switch($booking->status)
                                @case(0)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col">
                                            <div class="card border-danger">
                                              <div class="card-header text-danger" style="padding:5px">Booking for {{$booking->title}}</div>
                                              <div class="card-body text-danger" style="padding:5px">
                                                <p class="card-text m-0">Application has been rejected. </p>
                                                <span class="badge badge-danger float-left">(Rejected)</span>
                                                <span class="float-right">Processing time : 2 days left</span>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case(1)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col">
                                            <div class="card border-primary">
                                              <div class="card-header text-primary" style="padding:5px">Booking for {{$booking->title}}</div>
                                              <div class="card-body text-primary" style="padding:5px">
                                                <p class="card-text m-0">New application submited. 
                                                </p>
                                                <span class="badge badge-primary float-left">(new application)</span>
                                                <span class="float-right">Processing time : 2 days left</span>
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case(2)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col">
                                            <div class="card border-success">
                                              <div class="card-header text-success" style="padding:5px">Booking for {{$booking->title}}</div>
                                              <div class="card-body text-success" style="padding:5px">
                                                <p class="card-text m-0">Application has been approve. 
                                                    <a href="{{route('booking.regslot',['booking'=>$booking->id])}}" class=" pt-0 pb-0">Book your slot</a>
                                                </p>
                                                <span class="badge badge-success float-left">(Approved)</span>
                                                <span class="float-right">Processing time : 2 days left</span>
                                                
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case(3)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col">
                                            <div class="card border-info">
                                              <div class="card-header text-info" style="padding:5px">Booking for {{$booking->title}}</div>
                                              <div class="card-body text-info" style="padding:5px">
                                                <p class="card-text m-0">Booking for slot in progress. 
                                                    
                                                </p>
                                                <span class="badge badge-info float-left text-white">(Applied Date)</span>
                                                <span class="float-right">Processing time : 2 days left</span>
                                                
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case(4)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col">
                                            <div class="card border-success">
                                              <div class="card-header text-success" style="padding:5px">Booking for {{$booking->title}}</div>
                                              <div class="card-body text-success" style="padding:5px">
                                                <p class="card-text m-0">Slot has been approve. 
                                                </p>
                                                <span class="badge badge-success float-left">(Completed)</span>
                                                {{-- <span class="float-right">Processing time : 2 days left</span> --}}
                                                
                                              </div>
                                            </div>
                                        </div>
                                    </div>
                                    @break
                                @case(5)
                                    <div class="row" style="margin-bottom: 5px">
                                        <div class="col">
                                            <div class="card border-warning">
                                              <div class="card-header text-warning" style="padding:5px">Booking for {{$booking->title}}</div>
                                              <div class="card-body text-warning" style="padding:5px">
                                                <p class="card-text m-0">Correction Needed!!. 
                                                    <a href="{{route('booking.edit',['booking'=>$booking->id])}}" class=" pt-0 pb-0">Edit</a>
                                                </p>
                                                <span class="badge badge-warning float-left">(Important)</span>
                                                {{-- <span class="float-right">Processing time : 2 days left</span> --}}
                                                
                                              </div>
                                            </div>
                                        </div>
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
