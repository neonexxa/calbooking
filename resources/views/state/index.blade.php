@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Status List <a href="{{route('state.create')}}">New</a></div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @foreach($states as $state)
                        {{ Form::model($state, ['route' => ['state.update', $state->id], 'method' => 'put']) }}
                        <div class="row">

                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Label" name="label" required value="{{$state->label}}">
                            </div>
                            <div class="col"></div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-primary"><i class="az-edit"></i></button>
                                <button type="button" class="btn btn-danger" onclick="del_state('delete_state_'+{{$state->id}})"><i class="az-trash"></i></button>
                            </div>
                        </div>
                        {!! Form::close() !!}
                        {{ Form::model($state, ['route' => ['state.destroy', $state->id], 'method' => 'delete', 'id'=>'delete_state_'.$state->id]) }}
                        {!! Form::close() !!}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function del_state(argument) {
        $('#'+argument).submit();
    }
</script>
@endpush