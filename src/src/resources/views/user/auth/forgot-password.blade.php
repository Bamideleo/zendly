@extends('layouts.frontend')
@section('content')
 <div class="col-12 col-md-12 col-lg-6 col-xl-6 px-0">
    <div class="login-left-section d-flex align-items-center justify-content-center">
        <div class="form-container">
            <div class="mb-3">
                <h3> {{ translate('Forgot your password')}}</h3>
            </div>
            <form action="{{route('password.email')}}" method="POST">
                @csrf
                <div class="my-3">
                    <label for="exampleInputEmail1" class="form-label d-block">{{ translate('Email address')}}</label>
                    <div class="d-flex align-items-center border-bottom">
                        <i class="las la-envelope fs-3 text-primary"></i>
                        <input type="email" name="email" value="{{old('email')}}" placeholder="{{ translate('example@gmail.com')}}" class="border-0 w-100 p-2" id="exampleInputEmail1"aria-describedby="emailHelp"/>
                    </div>
                </div>
                <button type="submit" class="shadow btn btn--info w-100 mt-2 text-light">{{ translate('Submit')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection
