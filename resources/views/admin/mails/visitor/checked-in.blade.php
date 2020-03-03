Hello <i>{{ $visitor->first_name .' '. $visitor->last_name  }}</i>,<br>
{!! setting('notify_templates')  !!}
Visitor Details:<br>
<hr>
<strong>Name:</strong> {{$visitor->first_name .' '. $visitor->last_name}}<br>
<strong>Email:</strong>    {{$visitor->email}}<br>
<strong>Company  Name:</strong> {{$visitor->company_name}}<br>
<strong>Phone:</strong> {{$visitor->phone}}<br>
<strong>Host:</strong> {{$visitor->host_name}}<br>
<strong>Visitor ID:</strong> {{$visitor->visitorID}}<br>
<strong>Date:</strong> {{$visitor->date}}<br>
Thank You,
<br/>