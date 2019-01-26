@component('mail::message')
# Notice [Status:REJECTED]

An application has been rejected!

@component('mail::table')
| User Detail   | Table        |
| ------------- |-------------:|
| Applicant Name| {{$application->booking->user->name}} |
| Contact       | {{$application->booking->user->contact}} |
| Status        | {{$application->booking->user->name}} |
| Department    | X |
| Project       | {{$application->booking->title}} |
| Cost          | X |
| Supervisor    | {{$application->booking->supervisor->name }} |
@endcomponent

Equipment : {{$application->booking->service->equipment->name }}

Requirement Analysis : {{$application->booking->service->name }}

Sample : 
@component('mail::table')
| # | Sample Type (Solid/Liquid/Gas) | Sample Name/Description | Method |
| ------------- |:-------------:| :-------------:|:-------------:|
@foreach($application->booking->samples as $key => $sample)
| {{$key+1}}| {{$sample->type}} | {{$sample->name}} | {{$sample->method}} |
@endforeach
| | Total | Rm | |
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent