@extends('layouts.mail')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Approval</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Supervisor review required, an application has been made!
                    <div class="container">
                        <table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                            <thead style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <tr>
                            <th style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-bottom: 1px solid #EDEFF2; padding-bottom: 8px; margin: 0;">User Detail</th>
                            <th style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-bottom: 1px solid #EDEFF2; padding-bottom: 8px; margin: 0; text-align: right;">Table</th>
                            </tr>
                            </thead>
                            <tbody style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Applicant Name</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: right;">{{$booking->user->name}}</td>
                            </tr>
                            <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Contact</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: right;">{{$booking->user->contact}}</td>
                            </tr>
                            <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Status</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: right;">{{$booking->user->name}}</td>
                            </tr>
                            <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Department</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: right;">X</td>
                            </tr>
                            <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Project</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: right;">{{$booking->title}}</td>
                            </tr>
                            <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Cost Center</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: right;">{{$booking->name}}</td>
                            </tr>
                            <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">Supervisor</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: right;">{{$booking->supervisor->name }}</td>
                            </tr>
                            </tbody>
                        </table>
                        <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Equipment : {{$booking->service->equipment->name }}</p>
                        <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Requirement Analysis : {{$booking->service->name }}</p>
                        <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Sample : </p>
                        <table style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; margin: 30px auto; width: 100%; -premailer-cellpadding: 0; -premailer-cellspacing: 0; -premailer-width: 100%;">
                        <thead style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                        <tr>
                        <th style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-bottom: 1px solid #EDEFF2; padding-bottom: 8px; margin: 0;">#</th>
                        <th style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-bottom: 1px solid #EDEFF2; padding-bottom: 8px; margin: 0; text-align: center;">Sample Type (Solid/Liquid/Gas)</th>
                        <th style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-bottom: 1px solid #EDEFF2; padding-bottom: 8px; margin: 0; text-align: center;">Sample Name/Description</th>
                        <th style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-bottom: 1px solid #EDEFF2; padding-bottom: 8px; margin: 0; text-align: center;">Method</th>
                        </tr>
                        </thead>
                            <tbody style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box;">
                            @foreach($booking->samples as $key => $sample)
                            <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;">{{$key+1}}</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: center;">{{$sample->type}}</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: center;">{{$sample->name}}</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: center;">{{$sample->method}}</td>
                            </tr>
                            @endforeach
                            <tr>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0;"></td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: center;">Total</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: center;">Rm</td>
                            <td style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 15px; line-height: 18px; padding: 10px 0; margin: 0; text-align: center;">{{$booking->samples->count()*$booking->service->normal}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <div class="row">
                            <a href="{{route('booking.updatebyemail',['booking'=>$booking->id,'token'=>$token,'status'=>2])}}" class="button button-success col" target="_blank" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #2ab27b; border-top: 10px solid #2ab27b; border-right: 18px solid #2ab27b; border-bottom: 10px solid #2ab27b; border-left: 18px solid #2ab27b;">Approve</a>
                            <a href="{{route('booking.updatebyemail',['booking'=>$booking->id,'token'=>$token,'status'=>0])}}" class="button button-error col" target="_blank" style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; border-radius: 3px; box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16); color: #FFF; display: inline-block; text-decoration: none; -webkit-text-size-adjust: none; background-color: #bf5329; border-top: 10px solid #bf5329; border-right: 18px solid #bf5329; border-bottom: 10px solid #bf5329; border-left: 18px solid #bf5329;">Reject</a>
                        </div>
                        <br>
                        <p style="font-family: Avenir, Helvetica, sans-serif; box-sizing: border-box; color: #74787E; font-size: 16px; line-height: 1.5em; margin-top: 0; text-align: left;">Thanks,<br>
                            Lab Management System</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
