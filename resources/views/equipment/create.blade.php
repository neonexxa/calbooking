@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Equipment List <a href="{{route('equipment.index')}}">All</a></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!! Form::open(['route' => ['equipment.store'], 'id' => 'formnewsheet']) !!}
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    Name : 
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="name" name="name" required>
                                </div>
                                
                            </div>
                            <br>
                            <button type="submit" class="btn btn-block btn-primary">+ Add Equipment</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
