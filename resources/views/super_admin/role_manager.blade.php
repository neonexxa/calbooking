@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">admin panel</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                Name 
                            </div>
                            <div class="col-md-4">
                                Email 
                            </div>
                            <div class="col-md-4">
                                Role 
                            </div>
                        </div>
                        @foreach($users as $user)
                            {{ Form::model($user, ['route' => ['role.update', $user->id], 'method' => 'put']) }}
                                <div class="row">
                                    <div class="col-md-4">
                                        {{$user->name}} 
                                    </div>
                                    <div class="col-md-4">
                                        {{$user->email}}
                                    </div>
                                    <div class="col-md-2">
                                         {{Form::select('role_id', \App\Role::all()->pluck('label','id'), $user->role_id,["id"=>"role_select_".$user->id,"disabled"=>true])}} 
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-secondary edit_role_button" data-user_id="{{$user->id}}"><i class="az-edit"></i></button>
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
    $('.edit_role_button').click(function (event) {
        $("#role_select_"+$(this).data('user_id')).prop('disabled', false);
    });
</script>
@endpush
