@component('mail::message')
<h1>We are happy to have you join our family</h1>
<p></p>

@component('mail::panel')
You have been accepted into the course {{ $courseName }}.

Welcome, Teacher {{ $userName }} 
@endcomponent

<p></p>
@endcomponent