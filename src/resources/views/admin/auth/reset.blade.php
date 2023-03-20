@extends('admin.layouts.auth')
@section('content')
<form action="{{route('admin.password.reset.update')}}" method="POST">
    @csrf
     <input type="hidden" name="token" value="{{$passwordToken}}">
    <div class="logo">
        <img src="{{showImage(filePath()['site_logo']['path'].'/site_logo.png')}}" alt="logo">
        <h3>{{ translate('Admin Password Reset')}}</h3>
    </div>
    <div class="input-field password">
         <i class="fas fa-lock"></i>
        <input type="password"  name="password" id="login-email" placeholder="{{ translate('Enter Password')}}">
    </div>
    <div class="input-field password">
         <i class="fas fa-lock"></i>
        <input type="password"  name="password_confirmation" id="login-email" placeholder="{{ translate('Enter Confirm Password')}}">
    </div>
    <button type="submit" class="btn-login">{{ translate('Reset Password')}}</button>
</form>
@endsection
