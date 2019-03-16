@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h4><a href="{{route('booking.index')}}"><i class="az-arrow-left"></i></a>&nbsp;{{$booking->title}}</h4>
            <div class="card">
                <div class="card-header">
                    @switch($booking->status)
                    @case(3)
                        Pending for lab review
                        <a href="#" class="float-right btn btn-danger" onclick="event.preventDefault(); document.getElementById('reject-form').submit();">Reject</a> 
                        <a href="#" class="float-right btn btn-warning" data-toggle="modal" data-target="#commetncorrection">Correction</a>
                        <a href="#" class="float-right btn btn-success" onclick="event.preventDefault(); document.getElementById('approve-form').submit();">Accept</a> 
                        {!! Form::open(['route' => ['booking.update',$booking->id], 'method' => 'put', 'style'=>'display: none;', 'id' => 'approve-form']) !!}
                            <input type="hidden" name="status" value="4">
                            @csrf
                        </form>
                        {!! Form::open(['route' => ['booking.update',$booking->id], 'method' => 'put', 'style'=>'display: none;', 'id' => 'reject-form']) !!}
                            <input type="hidden" name="status" value="0">
                            @csrf
                        </form>
                        {!! Form::open(['route' => ['booking.update',$booking->id], 'method' => 'put', 'style'=>'display: none;', 'id' => 'correction-form']) !!}
                            <input type="hidden" name="status" value="5">
                            @csrf
                        </form>
                        @break
                    @default
                        @switch ($booking->status)
                            @case(4)
                                <span class="text-success">Approved</span>
                                @break
                            @case(5)
                                <span class="text-warning">Correction</span>
                                @break
                            @case(0)
                                <span class="text-danger">Rejected</span>
                                @break
                            
                            @default
                        @endswitch
                    @endswitch

                    
                </div>

                <div class="card-body">
                    @if (session('status'))
                        @switch($booking->status)
                            @case(3)
                            <div class="alert alert-info" role="alert">
                                {{ session('status') }}
                            </div>
                            @break
                            @case(4)
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                            @break
                            @case(5)
                            <div class="alert alert-warning" role="alert">
                                {{ session('status') }}
                            </div>
                            @break
                            @case(0)
                            <div class="alert alert-danger" role="alert">
                                {{ session('status') }}
                            </div>
                            @break
                            @default
                            <div class="alert alert-danger" role="alert">
                                {{ session('status') }}
                            </div>
                        @endswitch
                    @endif
                    <div class="row">
                        <div class="col-md-3">
                          Name :   
                        </div>
                        <div class="col-md-9">
                            {{ $booking->user->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                          ID :   
                        </div>
                        <div class="col-md-0">
                            {{ $booking->user->matric_id }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                          Contact :   
                        </div>
                        <div class="col-md-9">
                            {{ $booking->user->contact }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                          Project title :   
                        </div>
                        <div class="col-md-9">
                            {{ $booking->title }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                          Cost Center :   
                        </div>
                        <div class="col-md-9">
                            {{ $booking->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                          Supervisor :   
                        </div>
                        <div class="col-md-9">
                            {{ $booking->supervisor->name }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                          Supervisor email :   
                        </div>
                        <div class="col-md-9">
                            {{ $booking->supervisor->email }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                          Required Analysis :   
                        </div>
                        <div class="col-md-9">
                            {{ $booking->service->name }}
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        @foreach($booking->samples as $sample)
                            <div class="col-md-4">
                                <div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">
                                    <div class="card-header" style="padding: 0.1rem 1.25rem;">{{$sample->name}}</div>
                                    <div class="card-body" style="padding: 0.1rem 1.25rem;">
                                        <p style="margin-bottom:0.2rem">{{$sample->type}}</p>
                                        <p style="margin-bottom:0.2rem">{{$sample->method}}</p>
                                        <p style="margin-bottom:0.2rem">{{$sample->remark}}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.comment')
@endsection
@push('styles')
<style>
    
</style>
@endpush
@push('scripts')
<script>
    $('#commetncorrection_confirm').click(function (event) {
        
        $('<input />').attr('type', 'hidden')
            .attr('name', "comment")
            .attr('value', $('#remark').val())
            .appendTo('#correction-form');
            $('#correction-form').submit();
    })
    
</script>
@endpush
