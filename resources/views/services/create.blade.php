@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$equipment->name}} - New Services</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!! Form::open(['route' => ['service.store',$equipment->id], 'id' => 'form_newservices']) !!}
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    Name : 
                                </div>
                                <div class="col-md-10">
                                    <input type="text" class="form-control" placeholder="name" name="name" required>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    Maximum Sample : 
                                </div>
                                <div class="col-md-10">
                                    <input type="number" class="form-control" placeholder="max_sample" name="max_sample" required>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    Fees : 
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" placeholder="fast_track $0 " name="fast_track" required>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control" placeholder="normal $0" name="normal" required>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col">
                                    PIC : 
                                </div>
                                <div class="col-md-10">
                                    {{Form::select('pic', \App\User::where('role_id',4)->pluck('name','id'))}}
                                </div>
                                
                            </div>

                                
                            <br>
                            <button type="submit" class="btn btn-block btn-primary">+ Add Services</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
