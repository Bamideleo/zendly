<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{__($general->site_name)}} - {{__(@$title)}}</title>
    <link rel="shortcut icon" href="{{showImage(filePath()['site_logo']['path'].'/site_favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/frontend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/toastr.css')}}">
</head>
<body>
    <div class="login-page-container">
        <div class="container-fluid p-0">
            <div class="row responsive-shadow overflow-hidden">
            @yield('content')
            <div class="col-12 col-md-12 col-lg-6 col-xl-6 px-0">
                <div class="login-right-section responsive-padding bg-purple d-flex align-items-center justify-content-center">
                    <div> <h1>@lang('Welcome to') {{__($general->site_name)}}</h1>
                        <p>{{@$general->frontend_section->sub_heading}}</p>
                        @if(count($users)>5)
                        <div class="users">
                                @foreach($users as $user)
                                    <div class="user">
                                        <img src="{{showImage('assets/images/user/profile/'.$user->image)}}" alt="{{$user->name}}" class="w-100 h-100"/>
                                    </div>
                                @endforeach 
                            <i class="fas fa-arrow-right fs-1 ms-3 text-light"></i>
                        </div>
                        <span class="text-light">{{@$general->frontend_section->heading}}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{asset('assets/global/js/all.min.js')}}"></script>
<script src="{{asset('assets/global/js/toastr.js')}}"></script>
<script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
@include('partials.notify')
</body>
</html>
