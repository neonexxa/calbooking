@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">System Setting</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-2 text-center">
                            <a href="{{route('system.setting',['system'=>'sch_maintenance'])}}">
                                <p><i class="az-cog system_option"></i></p>
                                <p>Schedule Maintenance</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="{{route('system.setting',['system'=>'ed_slot'])}}">
                                <p><i class="az-sliders system_option"></i></p>
                                <p>Managing slot</p>
                            </a>
                        </div>
                        <div class="col-md-2 text-center">
                            <a href="{{route('supervisor.index')}}">
                                <p><i class="az-sliders system_option"></i></p>
                                <p>SV Directory</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    .system_option{
        font-size: -webkit-xxx-large;
    }
</style>
@endpush
