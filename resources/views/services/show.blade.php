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
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                Name : 
                            </div>
                            <div class="col-md-8">
                                {{$service->name}}
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col">
                                Maximum Sample : 
                            </div>
                            <div class="col-md-8">
                                {{$service->max_sample}}
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    Fees : 
                                </div>
                                <div class="col-md-4">
                                    Fast Track - RM {{$service->fast_track}}
                                </div>
                                <div class="col-md-4">
                                    Normal - RM {{$service->normal}}
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    PIC : 
                                </div>
                                <div class="col-md-8">
                                    {{$service->user->name}} - ext : {{$service->user->ext}}
                                </div>
                                
                            </div>

                                
                            <br>
                            <a href="{{route('service.edit',['equipment'=>$equipment->id,'service'=>$service->id])}}" class="btn btn-block btn-primary">Edit Service</a>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
