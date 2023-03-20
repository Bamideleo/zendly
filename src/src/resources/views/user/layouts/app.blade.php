@extends('user.layouts.master')
@section('content')
	@include('user.partials.sidebar')
    <div id="mainContent" class="main_content added">    
		@include('user.partials.topbar')
        <div class="dashboard_container">
           <div class="row align-items-center justify-content-between">
                <div class="col-lg-6 col-sm-6">
                    <h6 class="my-3">{{__($title)}}</h6>
                </div> 
            </div>
        	@yield('panel')
        </div>
    </div>
@endsection