@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Notice</div>

                <div class="card-body">
                    <div class="alert alert-{{$status}}" role="alert">
                        {{ $msg }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
