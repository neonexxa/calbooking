@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Location</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">
                            <div class="row">
                                <div class="col-md-3">Name</div>
                                <div class="col-md-8">Address</div>                                
                                <div class="col-md-1"></div>
                            </div>
                        @foreach($locations as $location)
                        {{ Form::model($location, ['route' => ['location.update', $location->id], 'method' => 'put']) }}
                            <div class="row">
                                <div class="col-md-3"><input class="form-control" type="text" value="{{$location->name}}" name="location_name" id="location_name_{{$location->id}}"   disabled></div>
                                <div class="col-md-7"><input class="form-control" type="text" value="{{$location->address}}" name="location_address" id="location_address_{{$location->id}}" disabled></div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-secondary edit_location_button" data-location_id="{{$location->id}}"><i class="az-edit"></i></button>
                                    <button type="submit" class="btn btn-secondary"><i class="az-save"></i></button>
                                </div>
                            </div>
                        </form>
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
    $('.edit_location_button').click(function (event) {
        $("#location_name_"+$(this).data('location_id')).prop('disabled', false);
        $("#location_address_"+$(this).data('location_id')).prop('disabled', false);
    });
</script>
@endpush