@extends('layouts.frontend')
@section('content')
 <div class="col-12 col-md-12 col-lg-6 col-xl-6 px-0">
        <div class="login-left-section d-flex align-items-center justify-content-center">
            <div class="form-container">
                <div>
                    <div class="mb-3">
                        <h4>{{ translate('Sign In With')}} <span class="site--title">{{ucfirst($general->site_name)}}</span></h4>
                    </div>
                    <div class="my-3">
                        <a class="shadow-sm d-flex text-decoration-none text-dark p-2 rounded align-items-center justify-content-center google--login"
                        href="{{url('auth/google')}}">
                            <div class="d-flex align-items-center justify-content-center google--login--text">
                                <div class="google-img me-2">
                                    <img src="{{showImage('assets/frontend/img/google.png')}}" alt="" class="w-100">
                                </div>{{ translate('Continue with google')}}
                            </div>
                        </a>
                    </div>
                    <div class="or text-center"><p class="m-0">{{ translate('Or')}}</p></div>
                </div>

                <form action="{{route('login.store')}}" method="POST">
                    @csrf
                    <div class="my-3">
                        <label for="user" class="form-label d-block">{{ translate('Email address')}}</label>
                        <div class="d-flex align-items-center border-bottom">
                            <i class="las la-envelope fs-3 text-primary"></i>
                            <input type="email" name="email" value="{{old('email')}}" placeholder="{{ translate('Give your login mail')}}" class="border-0 w-100 p-2" id="user"aria-describedby="emailHelp"/>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label d-block">{{ translate('Password')}}</label>
                        <div class="d-flex align-items-center">
                            <i class="las la-lock fs-3 text-primary"></i>
                            <input type="password" name="password" placeholder="{{ translate('Give Valid password')}}" class="border-0 border-bottom w-100 p-2" id="password"/>
                        </div>
                    </div>
                    <div class="mb-3 form-check d-flex align-items-center justify-content-between">
                        <a href="{{route('password.request')}}">{{ translate('Forget password')}}?</a>
                    </div>
                    <button type="submit" class="shadow btn btn--info w-100 mt-2 text-light">{{ translate('Submit')}}</button>
                </form>
                <p class="text-center mt-3">
                    {{ translate('New To')}} {{ucfirst($general->site_name)}}? <a href="{{route('register')}}">{{ translate('Sign Up!')}}</a>
                </p>
        </div>
    </div>
</div>
@endsection
