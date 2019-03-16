@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{route('equipment.index')}}">All Equipment</a> > {{$equipment->name}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                        {{ Form::model($equipment, ['route' => ['equipment.update', $equipment->id], 'method' => 'put']) }}
                            <div class="row">
                                {{-- description --}}
                                <div class="col">
                                    Name : 
                                </div>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" value="{{$equipment->name}}" name="equipment_name" id="equipment_name" disabled>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    Location : 
                                </div>
                                <div class="col-md-9">
                                    {{Form::select('location_id', \App\Location::all()->pluck('name','id'), $equipment->location->id, ["disabled"=>true,"id"=>"location_id"])}}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-secondary edit_equipment_button" data-equipment_id="{{$equipment->id}}"><i class="az-edit"></i></button>
                                    <button type="submit" class="btn btn-secondary"><i class="az-save"></i></button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="row">
                            <p><u>Services List</u> <a href="{{route('service.create',['equipment'=>$equipment->id])}}">+ New Services</a></p>

                        </div>
                        @foreach($equipment->services as $service)
                        <div class="row">
                            
                            <div class="col">
                                ~ {{$service->name}} &nbsp; <a href="{{route('service.edit',['equipment'=>$equipment->id,'service'=>$service->id])}}"><i class="az-edit"></i></a> &nbsp; <a href="{{route('service.destroy',['equipment'=>$equipment->id,'service'=>$service->id])}}"><i class="az-trash"></i></a>
                                <br>
                            </div>
                        </div>
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
    $('.edit_equipment_button').click(function (event) {
        $("#equipment_name").prop('disabled', false);
        $("#location_id").prop('disabled', false);
    });
</script>
@endpush