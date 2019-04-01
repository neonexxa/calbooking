@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{route('department.index')}}">All</a> > New Department </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {!! Form::open(['route' => ['department.store'], 'id' => 'formnewdepartment']) !!}
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    Label : 
                                </div>

                                <div class="col-md-9">
                                    <input type="text" class="form-control" placeholder="Label" name="label" required>
                                </div>
                                
                            </div>
                            <br>
                            <button type="submit" class="btn btn-block btn-primary">+ Add Department</button>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
