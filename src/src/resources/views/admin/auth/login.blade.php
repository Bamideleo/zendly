@extends('admin.layouts.auth')
@section('content')
<form action="{{route('admin.authenticate')}}" method="POST">
    @csrf
    <div class="logo">
        <img src="{{showImage(filePath()['site_logo']['path'].'/site_logo.png')}}" alt="logo">
        <h3>{{ translate('Admin login')}}</h3>
    </div>
    <div class="input-field email">
          <i class="fas fa-envelope"></i>
        <input type="text" id="login-email" name="username" placeholder="{{ translate('Enter Username')}}">
    </div>
    <div class="input-field password">
         <i class="fas fa-lock"></i>
        <input type="password"  name="password" id="login-email" placeholder="{{ translate('Enter Password')}}">
    </div>
    <div class="forgot-pass">
        <a href="{{route('admin.password.request')}}">{{ translate('forgot password')}}?</a>
    </div>
    <button type="submit" class="btn-login">{{ translate('Sign In')}}</button>
</form>
@endsection
