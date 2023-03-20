@extends('admin.layouts.auth')
@section('content')
    <form action="{{route('admin.email.password.verify.code')}}" method="POST">
        @csrf
        <div class="logo">
            <img src="{{showImage(filePath()['site_logo']['path'].'/site_logo.png')}}" alt="logo">
            <h3>{{ translate('Account Verification Code')}}</h3>
        </div>
        <div class="input-field email">
              <i class="fas fa-lock"></i>
            <input type="text" id="login-email" name="code" placeholder="{{ translate('Enter Verify Code')}}">
        </div>
        <button type="submit" class="btn-login">{{ translate('Submit')}}</button>
    </form>
@endsection
