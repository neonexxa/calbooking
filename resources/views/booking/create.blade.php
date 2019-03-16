

@extends('layouts.app')

@section('content')
<div class="container">
	{!! Form::open(['route' => ['booking.store'], 'id' => 'form_newbookings']) !!}
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Project details</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                    	
                        <div class="row">
                            <div class="col">
                                Equipment : 
                            </div>
                            <div class="col-md-8">
                                {{Form::select('equipment_id', \App\Equipment::all()->pluck('name','id'), 1, ['id'=>'equipment_id'])}}
                            </div>
                            
                        </div>
                        <div class="row">
                        	<div class="col">
                        		Supervisor :
                        	</div>
                        	<div class="col-md-8">
                        		{{Form::select('supervisor_id', \App\Supervisor::all()->pluck('name','id'), null, ['id'=>'supervisor_id'])}}
                        	</div>
                        </div>
                        <div class="row">
                            <div class="col">
                                Title : 
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" placeholder="title" name="title" id="project_title" required>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col">
                                Cost Center : 
                            </div>
                            <div class="col-md-8">
                                <input type="text" class="form-control" placeholder="name" name="name" id="project_cost_center" required>
                            </div>
                            
                        </div>
                        @if(Auth::user()->role->id != 4)  {{--  if not student--}}
                        {{-- request student id/ matric number --}}
                        <div class="row">
                            <div class="col">
                                Student (make sure the student registered an account first) : 
                            </div>
                            <div class="col-md-8">
								{{Form::select('pic', \App\User::where('role_id',4)->pluck('name','id'))}}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Analysis</div>

                <div class="card-body">
                    
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                Required Analysis Type : 
                            </div>
                            <div class="col-md-8">
                            	<select name="service_id" id="service_id">
                            		
                            	</select>
								
                            </div>
                        </div>
                        <button type="button" class="btn btn-info text-white" data-toggle="modal" data-target="#addsample" style="margin-bottom: 10px " id="button_new_sample">+ sample</button>
                        <br>
                        <div class="row" id="sample_dom_location">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-8">
        	<button type="button" class="btn btn-block btn-primary" id="addbookingbutton">+ Add Booking</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
{{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@fat">Open modal for @fat</button>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="@getbootstrap">Open modal for @getbootstrap</button> --}}
@include('modal.addsample')
@include('modal.editsample')
@include('modal.bookingsummary')
@endsection
@push('scripts')
<script>
	$.ajax({
      type: 'GET',
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      url: '/api/getequipmentservices/'+$("#equipment_id").val(),
      // data: ajaxdata,
      processData : false,
      contentType  : false,
      success: (data)=>{
      	console.log(data);

        let serviceoptions = '';
        data.data.forEach(function(item){
        	serviceoptions += '<option value="'+item.id+'"  smmax="'+item.max_sample+'" >'+item.name+' : (Max Sample '+item.max_sample+')</option>';
        });
        $('#service_id').empty();
        $('#service_id').append(serviceoptions);
        if(parseInt(_.find(data.data, ["id", parseInt($("#service_id").val())]).max_sample)){
            $("#button_new_sample").show()}
        else{
            $("#button_new_sample").hide();
        }

        // off preloader
      }
    });
	window.samples = {};
	window.sample_count = 0;

	$("#equipment_id").change(function () {
		// on preloader
		
		$.ajax({
	      type: 'GET',
	      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
	      url: '/api/getequipmentservices/'+$("#equipment_id").val(),
	      // data: ajaxdata,
	      processData : false,
	      contentType  : false,
	      success: (data)=>{
	      	console.log(data);

	        let serviceoptions = '';
	        data.data.forEach(function(item){
	        	serviceoptions += '<option value="'+item.id+'" smmax="'+item.max_sample+'" >'+item.name+' : (Max Sample '+item.max_sample+')</option>';
	        });
	        $('#service_id').empty();
	        $('#service_id').append(serviceoptions);
            if(parseInt(_.find(data.data, ["id", parseInt($("#service_id").val())]).max_sample)){
                $("#button_new_sample").show()}
            else{
                $("#button_new_sample").hide();
            }
            // if (item.max_sample == 0) {$("#button_new_sample").hide()}
	        // off preloader
	      }
	    }); 
	});

    // onchange analysis type
    $("#service_id").change(function () {
        console.log($('option:selected', this).attr('smmax'));
        if(parseInt($('option:selected', this).attr('smmax'))){
            $("#button_new_sample").show()}
        else{
            $("#button_new_sample").hide();
        }
        if(sample_count >= parseInt($('option:selected', this).attr('smmax'))){
            // delete yg lebih
            $("#button_new_sample").hide();
            console.log("lebih sample ", sample_count, parseInt($('option:selected', this).attr('smmax')))
            for (var i = parseInt($('option:selected', this).attr('smmax')); i < sample_count; i++) {
                delete_sample(i);
            }
        }
    });
	// show modal add
	$('#add_sample_form').submit(function( event ) {
		event.preventDefault();
		let a_sample = {};
		a_sample["sample_type"] = $('#add_sample_type').val();
		a_sample["sample_name"] = $('#add_sample_name').val();
		a_sample["sample_method"] = $('#add_sample_method').val();
		a_sample["sample_remark"] = $('#add_sample_remark').val();
		samples[sample_count] = a_sample;
		sample_count +=1;
		console.log(samples);
		$('#addsample').modal('hide');
		write_sample_to_dom(samples);
		$('#add_sample_form')[0].reset();
        console.log("sample count after add form",sample_count);
        if(sample_count >=parseInt($('#service_id option:selected').attr('smmax')) ){
            $("#button_new_sample").hide();
        }
	});

	// write sample ke dom
	function write_sample_to_dom(samples) {
		let dom_samples = '';
		Object.keys(samples).forEach(function(item){
        	console.log(item, samples[item]);
        	dom_samples +='<div class="col-md-4">';
			dom_samples +=	'<div class="card text-white bg-secondary mb-3" style="max-width: 18rem;">';
			dom_samples +=		'<div class="card-header" style="padding: 0.1rem 1.25rem;"><i class="az-multi-window"></i>&nbsp;'+samples[item]['sample_name']+'</div>';
			dom_samples +=			'<div class="card-body" style="padding: 0.1rem 1.25rem;">';
			dom_samples +=				'<p style="margin-bottom:0.2rem">'+samples[item]['sample_type']+'</p>';
			dom_samples +=				'<p style="margin-bottom:0.2rem">'+samples[item]['sample_method']+'</p>';
			dom_samples +=				'<p style="margin-bottom:0.2rem">'+samples[item]['sample_remark']+'</p>';
			dom_samples +=			'</div>';
			dom_samples +=		'<div class="card-footer" style="padding: 0.1rem 1.25rem">';
			dom_samples +=			'<button type="button" class="btn btn-link" style="color:grey;padding: 0rem 0.5rem;" data-toggle="modal" data-target="#editsample" data-sample_name="'+samples[item]['sample_name'] +'"  data-sample_type="'+samples[item]['sample_type'] +'" data-sample_method="'+samples[item]['sample_method'] +'" data-sample_remark="'+samples[item]['sample_remark'] +'" data-sample_id="'+item+'"><i class="az-edit"></i></button>';
			dom_samples +=			'<button type="button" class="btn btn-link" style="color:grey;padding: 0rem 0.5rem;" onclick="delete_sample('+item+')"><i class="az-trash"></i></button>';
			dom_samples +=		'</div>';
			dom_samples +=	'</div>';
	    	dom_samples +='</div>';
        });
        $('#sample_dom_location').empty();
        $('#sample_dom_location').append(dom_samples);
	}

    function write_sample_to_summary(samples) {
        // body...
        let dom_samples = '';
        dom_samples += '<table style="    width: -webkit-fill-available;">';
        dom_samples += "  <tr>";
        dom_samples += "    <th>#</th>";
        dom_samples += "    <th>Sample Type|</th>";
        dom_samples += "    <th>Sample Name|</th>";
        dom_samples += "    <th>Method|</th>";
        dom_samples += "  </tr>";
        Object.keys(samples).forEach(function(item){
          dom_samples += "<tr>";
          dom_samples += "  <td></td>";
          dom_samples += "  <td>"+samples[item]['sample_type']+"</td>";
          dom_samples += "  <td>"+samples[item]['sample_name']+"</td>";
          dom_samples += "  <td>"+samples[item]['sample_method']+"</td>";
          dom_samples += "</tr>";
        });
        dom_samples += "<tr>";
        dom_samples += "  <td></td>";
        dom_samples += "  <td>Total</td>";
        dom_samples += "  <td>RM</td>";
        dom_samples += '  <td id="sample_total_cost"></td>';
        dom_samples += "</tr>";
        dom_samples += "</table>";
        $('#summary_sample').empty();
        $('#summary_sample').append(dom_samples);
        GetBookingCost($("#service_id").val());
    }
    function GetBookingCost(serv_id) {
        // body...
        $.ajax({
          type: 'GET',
          headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
          url: '/api/getserviceprice/'+$("#service_id").val(),
          // data: ajaxdata,
          processData : false,
          contentType  : false,
          success: (data)=>{
            console.log("service",data.data);
            $("#sample_total_cost").append(data.data.normal*sample_count);
          }
        }); 
    }

	// show modal edit
	$('#editsample').on('show.bs.modal', function (event) {
		let button = $(event.relatedTarget) // Button that triggered the modal
		let edit_sample_name = button.data('sample_name');
		let edit_sample_type = button.data('sample_type');
		let edit_sample_method = button.data('sample_method');
		let edit_sample_remark = button.data('sample_remark');
		let edit_sample_id = button.data('sample_id');
		// If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		// Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		let modal = $(this)
		modal.find('.modal-title').text('Editing sample ' + edit_sample_name);
		modal.find('.modal-body #edit_sample_type').val(edit_sample_type);
		modal.find('.modal-body #edit_sample_name').val(edit_sample_name);
		modal.find('.modal-body #edit_sample_method').val(edit_sample_method);
		modal.find('.modal-body #edit_sample_remark').val(edit_sample_remark);
		modal.find('.modal-body #edit_sample_id').val(edit_sample_id);

	});

	// submit edited 
	$('#edit_sample_form').submit(function( event ) {
		event.preventDefault();
		console.log($('#edit_sample_id').val());
		let a_sample = {};
		a_sample["sample_type"] = $('#edit_sample_type').val();
		a_sample["sample_name"] = $('#edit_sample_name').val();
		a_sample["sample_method"] = $('#edit_sample_method').val();
		a_sample["sample_remark"] = $('#edit_sample_remark').val();
		samples[$('#edit_sample_id').val()] = a_sample;
		console.log("lol",samples,samples.length);
		$('#editsample').modal('hide');
		write_sample_to_dom(samples);
	});

	// delete plak
	function delete_sample(key) {
		delete samples[key];
        sample_count -=1;
        samples = _.filter(samples);
		console.log("sample count after delete",sample_count, samples);
		write_sample_to_dom(samples);
        if(sample_count >=parseInt($('#service_id option:selected').attr('smmax')) ){
            $("#button_new_sample").hide();
        }else{
            $("#button_new_sample").show();
        }
	}

	// pastu add booking all to booking masukan je object samples to form input yg ade
	$('#addbookingbutton').click(function( event ) {
		// event.preventDefault();
		console.log("im here");
		if (Object.keys(samples).length != 0) {
			$('<input />').attr('type', 'hidden')
		    .attr('name', "all_samples")
		    .attr('value', JSON.stringify(samples))
		    .appendTo('#form_newbookings');
		}

        $("#summary_user_name").empty();
        $("#summary_user_contact").empty();
        $("#summary_user_status").empty();
        $("#summary_dept").empty();
        $("#summary_title").empty();
        $("#summary_cost").empty();
        $("#summary_supervisor_name").empty();
        $("#summary_service_equipment_name").empty();
        $("#summary_service_name").empty();

        $("#summary_user_name").append("{{Auth::user()->name}}");
        $("#summary_user_contact").append("{{Auth::user()->contact}}");
        $("#summary_user_status").append("{{Auth::user()->name}}");
        $("#summary_dept").append("N/A");
        $("#summary_title").append($("#project_title").val());
        $("#summary_cost").append($("#project_cost_center").val());
        $("#summary_supervisor_name").append($("#supervisor_id option:selected").text());
        $("#summary_service_equipment_name").append($("#equipment_id option:selected").text());
        $("#summary_service_name").append($("#service_id option:selected").text());
        write_sample_to_summary(samples);

        $("#bookingsummary").modal('show');
		// return true;
	});
    $('#booking_confirm_button').click(function(event) {
        // body...
        $('#form_newbookings').submit();
    });
</script>
@endpush
