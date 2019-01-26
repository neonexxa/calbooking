@component('mail::message')
# Approval

Supervisor review required, an application has been made!

@component('mail::table')
| User Detail   | Table        |
| ------------- |-------------:|
| Applicant Name| {{$booking->user->name}} |
| Contact       | {{$booking->user->contact}} |
| Status        | {{$booking->user->name}} |
| Department    | X |
| Project       | {{$booking->title}} |
| Cost          | X |
| Supervisor    | {{$booking->supervisor->name }} |
@endcomponent

Equipment : {{$booking->service->equipment->name }}

Requirement Analysis : {{$booking->service->name }}

Sample : 
@component('mail::table')
| # | Sample Type (Solid/Liquid/Gas) | Sample Name/Description | Method |
| ------------- |:-------------:| :-------------:|:-------------:|
@foreach($booking->samples as $key => $sample)
| {{$key+1}}| {{$sample->type}} | {{$sample->name}} | {{$sample->method}} |
@endforeach
| | Total | Rm | |
@endcomponent

@component('mail::button', ['url' => route('booking.updatebyemail',['booking'=>$booking->id,'token'=>$token,'status'=>2]), 'color' => 'success'])
Approve
@endcomponent
@component('mail::button', ['url' => route('booking.updatebyemail',['booking'=>$booking->id,'token'=>$token,'status'=>0]), 'color' => 'error'])
Reject
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent