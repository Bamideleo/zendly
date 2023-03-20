<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__(@$general->site_name)}} - {{__(@$title)}}</title>
    <link rel="shortcut icon" href="{{showImage(filePath()['site_logo']['path'].'/site_favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/dashboard/auth/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/toastr.css')}}">
</head>
<body>
    <section class="admin-form">
        <div class="form-container">
            @yield('content')
        </div>
    </section>
    <div class="squire-container">
        <ul class="squares"></ul>
    </div>
    <script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/auth/js/script.js')}}"></script>
    <script src="{{asset('assets/dashboard/auth/js/fontAwesome.js')}}"></script>
    <script src="{{asset('assets/global/js/toastr.js')}}"></script>
    @include('partials.notify')
</body>
</html>