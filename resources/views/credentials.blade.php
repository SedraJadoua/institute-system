@component('mail::message')
<h1>We are happy to have you join our family</h1>
<p> you can login to our application with </p>

@component('mail::panel')
userName: {{ $userName }} and password: {{ $password}}
@endcomponent

<p>do not share this information with anybody</p>
@endcomponent