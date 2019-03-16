@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{route('equipment.show',['equipment'=>$equipment->id])}}">{{$equipment->name}}</a> > {{$service->name}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!! Form::open(['route' => ['service.update',$equipment->id,$service->id],'method' => 'put', 'id' => 'form_editservices']) !!}
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    Name : 
                                </div>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" placeholder="name" name="name" value="{{$service->name}}" required>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    Maximum Sample : 
                                </div>
                                <div class="col-md-8">
                                    <input type="number" class="form-control" placeholder="max_sample" name="max_sample" value="{{$service->max_sample}}" required>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    Fees : 
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="fast_track $0 " name="fast_track" value="{{$service->fast_track}}" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" placeholder="normal $0" name="normal" value="{{$service->normal}}" required>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    PIC : 
                                </div>
                                <div class="col-md-8">
                                    {{Form::select('pic', \App\User::where('role_id',3)->pluck('name','id'), $service->user_id)}}
                                </div>
                                
                            </div>

                                
                            <br>
                            <button type="submit" class="btn btn-block btn-primary">Update Services</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
