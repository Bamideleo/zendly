@extends('layouts.frontend')
@section('content')
 <div class="col-12 col-md-12 col-lg-6 col-xl-6 px-0">
        <div class="login-left-section d-flex align-items-center justify-content-center">
            <div class="form-container">
                <div>
                    <div class="mb-3">
                        <h4>{{ translate('Sign Up With')}} <span class="site--title">{{ucfirst($general->site_name)}}</span></h4>
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

                <form action="{{route('registration.verify')}}" method="POST">
                    @csrf
                    <div class="my-3">
                        <label for="name" class="form-label d-block">{{ translate('Name')}}</label>
                        <div class="d-flex align-items-center border-bottom">
                            <i class="las la-envelope-open-text fs-3 text-primary"></i>
                            <input type="text" name="name" value="{{old('name')}}" placeholder="{{ translate('Enter Name')}}" class="border-0 w-100 p-2" id="name"aria-describedby="emailHelp"/>
                        </div>
                    </div>

                    <div class="my-3">
                        <label for="inputEmail1" class="form-label d-block">{{ translate('Email address')}}</label>
                        <div class="d-flex align-items-center border-bottom">
                            <i class="las la-envelope fs-3 text-primary"></i>
                            <input type="email" name="email" value="{{old('email')}}" placeholder="{{ translate('Put here valid mail address')}}" class="border-0 w-100 p-2" id="inputEmail1"aria-describedby="emailHelp"/>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="inputPassword1" class="form-label d-block">{{ translate('Password')}}</label>
                        <div class="d-flex align-items-center">
                            <i class="las la-lock fs-3 text-primary"></i>
                            <input type="password" name="password" placeholder="{{ translate('Enter Password')}}" class="border-0 border-bottom w-100 p-2" id="inputPassword1"/>
                        </div>
                    </div>

                     <div class="mb-3">
                        <label for="inputCPassword1" class="form-label d-block">{{ translate('Password')}}</label>
                        <div class="d-flex align-items-center">
                            <i class="las la-lock fs-3 text-primary"></i>
                            <input type="password" name="password_confirmation" placeholder="{{ translate('Enter Confirm Password')}}" class="border-0 border-bottom w-100 p-2" id="inputCPassword1"/>
                        </div>
                    </div>
                    <button type="submit" class="shadow btn btn--info w-100 mt-2 text-light">{{ translate('Submit')}}</button>
                </form>
                <p class="text-center mt-3">
                    {{ translate('Already have an account')}}? <a href="{{route('login')}}">{{ translate('Sign In')}}</a>
                </p>
        </div>
    </div>
</div>
@endsection
