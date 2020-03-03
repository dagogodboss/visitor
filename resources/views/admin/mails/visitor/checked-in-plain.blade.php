Hello {{ $visitor->first_name .' '. $visitor->last_name  }},
{!! setting('notify_templates')  !!}
Visitor Details:
Name: {{$visitor->first_name .' '. $visitor->last_name}}
Email:    {{$visitor->email}}
Company  Name: {{$visitor->company_name}}
Phone: {{$visitor->phone}}
Host: {{$visitor->host_name}}
Visitor ID: {{$visitor->visitorID}}
Date: {{$visitor->date}}
Thank You,