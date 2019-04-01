@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Supervisor List <a href="{{route('supervisor.create')}}">New</a></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    
                    
                    <div class="container">
                        @foreach($supervisors as $supervisor)
                        {{ Form::model($supervisor, ['route' => ['supervisor.update', $supervisor->id], 'method' => 'put']) }}
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="name" name="name" required value="{{$supervisor->name}}">
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Email" name="email" required value="{{$supervisor->email}}">
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-primary"><i class="az-edit"></i></button>
                                <button class="btn btn-danger" type="button" onclick="del_sv('delete_sv_'+{{$supervisor->id}})"><i class="az-trash"></i></button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        {{ Form::model($supervisor, ['route' => ['supervisor.destroy', $supervisor->id], 'method' => 'delete','id'=>'delete_sv_'.$supervisor->id]) }}
                        {!! Form::close() !!}
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function del_sv(argument) {
        $('#'+argument).submit();
    }
</script>
@endpush