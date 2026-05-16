@extends('mail.hrMailHeader')
@section('content')
    <p>Hello,</p>
    <p>A new Career Form has been submitted through the website. Following are the details:</p>
    <p>Name : {{ $name }}</strong></p>
    <p>Email : {{ $email }}</strong></p>
    <p>Mobile : {{ $mobile }}</strong></p>
    <p>Kindly check the portal for more information.</p>
@endsection