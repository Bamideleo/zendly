@extends('admin.layouts.auth')
@section('content')
    <form action="{{route('admin.password.email')}}" method="POST">
        @csrf
        <div class="logo">
            <img src="{{showImage(filePath()['site_logo']['path'].'/site_logo.png')}}" alt="logo">
            <h3>{{ translate('Account Password Recovery')}}</h3>
        </div>
        <div class="input-field email">
              <i class="fas fa-envelope"></i>
            <input type="email" id="login-email" name="email" placeholder="{{ translate('Enter Email')}}">
        </div>
        <button type="submit" class="btn-login">{{ translate('Submit')}}</button>
    </form>
@endsection
