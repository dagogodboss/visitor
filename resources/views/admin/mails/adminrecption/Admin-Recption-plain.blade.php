Hello <i>{{ $user->name}}</i>,<br>
New Pre-Register Add Host By {{$pre_register->host_name}},<br>
New Pre-register:<br>
<hr>
<strong>Name:</strong> {{$pre_register->first_name .' '. $pre_register->last_name}}<br>
<strong>Email:</strong>    {{$pre_register->email}}<br>
<strong>Company  Name:</strong> {{$pre_register->company_name}}<br>
<strong>Phone:</strong> {{$pre_register->phone}}<br>
<strong>Host:</strong> {{$pre_register->host_name}}<br>
<strong>Visitor ID:</strong> {{$pre_register->visitorID}}<br>
<strong>Date:</strong> {{$pre_register->date}}<br>
Thank You,
<br/>