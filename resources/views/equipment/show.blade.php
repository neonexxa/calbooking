@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{route('equipment.index')}}">All E</a> > {{$equipment->name}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                        <div class="row">
                            {{-- description --}}
                            <div class="col">
                                Name : 
                            </div>
                            <div class="col-md-9">
                                {{$equipment->name}}
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <p><u>Services List</u> <a href="{{route('service.create',['equipment'=>$equipment->id])}}">+ New Services</a></p>

                        </div>
                        <div class="row">
                            
                            @foreach($equipment->services as $service)
                                ~ {{$service->name}} &nbsp; <a href="{{route('service.edit',['equipment'=>$equipment->id,'service'=>$service->id])}}">E</a> &nbsp; <a href="{{route('service.destroy',['equipment'=>$equipment->id,'service'=>$service->id])}}">X</a>
                                <br>
                            @endforeach
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
