<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{__($general->site_name)}} - {{__($title)}}</title>
    <link rel="shortcut icon" href="{{showImage(filePath()['site_logo']['path'].'/site_favicon.png')}}" type="image/x-icon">
    <link rel="stylesheet" href="{{asset('assets/global/css/line-awesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/global/css/toastr.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/apexcharts.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/datepicker/datepicker.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/css/summernote-lite.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/dashboard/flag-icons/flag-icons.css')}}"> 
    @stack('style-include')
    @stack('stylepush')
</head>

<body>
    @yield('content')
    <script src="{{asset('assets/global/js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('assets/global/js/all.min.js')}}"></script>
    <script src="{{asset('assets/global/js/toastr.js')}}"></script>
    <script src="{{asset('assets/global/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/chart.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/apexcharts.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/select2.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/main.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/datepicker/datepicker.min.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/datepicker/datepicker.en.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/ckeditor.js')}}"></script>
    <script src="{{asset('assets/dashboard/js/summernote-lite.min.js')}}"></script>
    @include('partials.notify')
    @stack('script-include')
    @stack('scriptpush')
    <script type="text/javascript">
        'use strict';
        function changeLang(val){
            window.location.href = "{{route('login')}}/language/change/"+val;
        }
        $(".active").focus();
    </script>
</body>
</html>
