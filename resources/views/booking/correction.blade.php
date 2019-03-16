@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Correction 
                  {{ Form::model($booking, ['route' => ['booking.update', $booking->id], 'method' => 'PUT']) }}
                    <span class="flex" style="float:right">
                      <input type="hidden" name="status" value="3">
                      <input type="hidden" name="from_correction" value="resubmit_correction">
                      <button class="btn btn-success" type="submit">Resubmit </button>
                    </span>
                  </form>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                      <div class="row">
                        <div class="col">Applicant Name</div>
                        <div class="col-md-8">{{$booking->user->name}}</div>
                      </div>
                      <div class="row">
                        <div class="col">Contact       </div>
                        <div class="col-md-8">{{$booking->user->contact}}</div>
                      </div>
                      <div class="row">
                        <div class="col">Status        </div>
                        <div class="col-md-8">{{$booking->user->status}}</div>
                      </div>
                      <div class="row">
                        <div class="col">Department    </div>
                        <div class="col-md-8">{{$booking->user->dept}}</div>
                      </div>
                      <div class="row">
                        <div class="col">Project    </div>
                        <div class="col-md-8">{{$booking->title}}</div>
                      </div>
                      {{ Form::model($booking, ['route' => ['booking.update', $booking->id], 'method' => 'PUT']) }}
                      <div class="row">
                        <div class="col">Cost Center</div>
                        <div class="col-md-6">
                          <input type="text" value="{{$booking->name}}" name="cost_center_correction" id="cost_center_correction" class="form-control" disabled>
                          <input type="hidden" name="from_correction" value="cost_center_correction">
                        </div>
                        <div class="col-md-2">
                          <button type="button" class="btn btn-secondary edit_costcenter_button"><i class="az-edit"></i></button>
                          <button type="submit" class="btn btn-secondary"><i class="az-save"></i></button>
                        </div>
                      </div>
                      </form>
                      <div class="row">
                        <div class="col">Supervisor</div>
                        <div class="col-md-8">{{$booking->supervisor->name}}</div>
                      </div>
                      <div class="row">
                        <div class="col">Equipment</div>
                        <div class="col-md-8">{{$booking->service->equipment->name}}</div>
                      </div>
                      {{ Form::model($booking, ['route' => ['booking.update', $booking->id], 'method' => 'PUT']) }}
                      <div class="row">
                        
                          <div class="col">Requirement Analysis</div>
                          
                          <div class="col-md-6">

                            {{Form::select('service_id', \App\Service::all()->pluck('name','id'), $booking->service->id,["id"=>"service_select","disabled"=>true,"class"=>"form-control"])}}
                              <input type="hidden" name="from_correction" value="service_correction">
                          </div>
                          <div class="col-md-2">
                            <button type="button" class="btn btn-secondary edit_service_button"><i class="az-edit"></i></button>
                            <button type="submit" class="btn btn-secondary"><i class="az-save"></i></button>
                          </div>
                      </div>
                      </form>
                      <p>Sample:</p>
                      <hr>
                      <div class="row">
                        <div class="col-md-1">#</div>
                        <div class="col-md-2">Type</div>
                        <div class="col-md-3">Name</div>
                        <div class="col-md-2">Method</div>
                        <div class="col-md-3">Remark</div>
                        <div class="col-md-1"><button class="btn btn-primary" id="button_to_add_new_sample" data-toggle="modal" data-target="#addsample" style="display: none">+</button></div>
                      </div>
                      <div id="all_sample">
                        @foreach($booking->samples as $key => $sample)
                        <div class="row">
                          <div class="col-md-1">{{$key+1}}</div>
                          <div class="col-md-2"><input type="text" class="form-control" id="sample_type_{{$key}}" name="sample_type_{{$key}}" value="{{$sample->type}}"></div>
                          <div class="col-md-3"><input type="text" class="form-control" id="sample_name_{{$key}}" name="sample_name_{{$key}}" value="{{$sample->name}}"></div>
                          <div class="col-md-2"><input type="text" class="form-control" id="sample_method_{{$key}}" name="sample_method_{{$key}}" value="{{$sample->method}}"></div>
                          <div class="col-md-3"><input type="text" class="form-control" id="sample_remark_{{$key}}" name="sample_remark_{{$key}}" value="{{$sample->remark}}"></div>
                          <div class="col-md-1">
                            {{ Form::model($sample, ['route' => ['sample.destroy', $booking->id , $sample->id], 'method' => 'DELETE']) }}
                              <button type="submit" class="btn btn-danger sample_delete_button" data-sample_id="{{$sample->id}}"><i class="az-trash"></i></button>
                            </form>
                          </div>
                        </div>
                        @endforeach
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('modal.corr_addsample', ['booking_id' => $booking->id])
@include('modal.editsample')
@endsection
@push('scripts')
<script>
    window.sample_count = {{$booking->samples->count()}};
    if (sample_count >= {{$booking->service->max_sample}}) {
      $("#button_to_add_new_sample").hide();
    }else{
      $("#button_to_add_new_sample").show();
    }
    $(".edit_costcenter_button").click(function (event) {
      $("#cost_center_correction").attr("disabled",false);
    });
    $(".edit_service_button").click(function (event) {
      $("#service_select").attr("disabled",false);
    });
    // $('#add_sample_form').submit(function( event ) {
    //     event.preventDefault();
    //     let a_sample = {};
    //     a_sample["sample_type"] = $('#add_sample_type').val();
    //     a_sample["sample_name"] = $('#add_sample_name').val();
    //     a_sample["sample_method"] = $('#add_sample_method').val();
    //     a_sample["sample_remark"] = $('#add_sample_remark').val();
    //     samples[sample_count] = a_sample;
    //     sample_count +=1;
    //     console.log(samples);
    //     $('#addsample').modal('hide');
    //     write_sample_to_dom(samples);
    //     $('#add_sample_form')[0].reset();
    //     console.log("sample count after add form",sample_count);
    //     if(sample_count >=parseInt($('#service_id option:selected').attr('smmax')) ){
    //         $("#button_new_sample").hide();
    //     }
    // });
    // function write_sample_to_dom(samples) {
    //     let dom_samples = '';
    //     Object.keys(samples).forEach(function(item){
    //         console.log(item, samples[item]);
    //         dom_samples +='<div class="col-md-4">';
    //         dom_samples +=  '<div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">';
    //         dom_samples +=      '<div class="card-header" style="padding: 0.1rem 1.25rem;"><i class="az-multi-window"></i>&nbsp;'+samples[item]['sample_name']+'</div>';
    //         dom_samples +=          '<div class="card-body" style="padding: 0.1rem 1.25rem;">';
    //         dom_samples +=              '<p style="margin-bottom:0.2rem">'+samples[item]['sample_type']+'</p>';
    //         dom_samples +=              '<p style="margin-bottom:0.2rem">'+samples[item]['sample_method']+'</p>';
    //         dom_samples +=              '<p style="margin-bottom:0.2rem">'+samples[item]['sample_remark']+'</p>';
    //         dom_samples +=          '</div>';
    //         dom_samples +=      '<div class="card-footer" style="padding: 0.1rem 1.25rem">';
    //         dom_samples +=          '<button type="button" class="btn btn-link" style="color:grey;padding: 0rem 0.5rem;" data-toggle="modal" data-target="#editsample" data-sample_name="'+samples[item]['sample_name'] +'"  data-sample_type="'+samples[item]['sample_type'] +'" data-sample_method="'+samples[item]['sample_method'] +'" data-sample_remark="'+samples[item]['sample_remark'] +'" data-sample_id="'+item+'"><i class="az-edit"></i></button>';
    //         dom_samples +=          '<button type="button" class="btn btn-link" style="color:grey;padding: 0rem 0.5rem;" onclick="delete_sample('+item+')"><i class="az-trash"></i></button>';
    //         dom_samples +=      '</div>';
    //         dom_samples +=  '</div>';
    //         dom_samples +='</div>';
    //     });
    //     $('#sample_dom_location').empty();
    //     $('#sample_dom_location').append(dom_samples);
    // }
</script>
@endpush
