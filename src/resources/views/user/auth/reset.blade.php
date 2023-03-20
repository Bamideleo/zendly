@extends('layouts.frontend')
@section('content')
<div class="col-12 col-md-12 col-lg-6 col-xl-6 px-0">
    <div class="login-left-section d-flex align-items-center justify-content-center">
        <div class="form-container">
            <div class="mb-3">
                <h3>{{ translate('Password Reset')}}</h3>
            </div>
            <form action="{{route('password.update')}}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{$passwordToken}}">
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label d-block">{{ translate('Password')}}</label>
                    <div class="d-flex align-items-center">
                        <i class="las la-lock fs-3 text-primary"></i>
                        <input type="password" name="password" placeholder="{{ translate('Enter Password')}}" class="border-0 border-bottom w-100 p-2" id="exampleInputPassword1"/>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label d-block">{{ translate('Confirm Password')}}</label>
                    <div class="d-flex align-items-center">
                        <i class="las la-lock fs-3 text-primary"></i>
                        <input type="password" name="password_confirmation" placeholder="{{ translate('Enter Confirm Password')}}" class="border-0 border-bottom w-100 p-2" id="exampleInputPassword1"/>
                    </div>
                </div>
                <button type="submit" class="shadow btn btn--info w-100 mt-2 text-light">{{ translate('Reset Password')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection
