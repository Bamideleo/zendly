@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="table_heading d-flex align--center justify--between">
                    <nav  aria-label="breadcrumb">
					  	<ol class="breadcrumb">
					    	<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ translate('Dashboard')}}</a></li>
					    	<li class="breadcrumb-item" aria-current="page"> {{ translate('Social Auth Credentials Setup')}}</li>
					  	</ol>
					</nav>
                </div>

				<div class="card">
					<div class="card-body">
						<form action="{{route('admin.social.login.update')}}" method="POST">
							@csrf
							<div class="shadow-lg p-3 mb-5 bg-body rounded">
								<h6>{{ translate('Google Auth Credentials Setup')}}<sup class="pointer" title="{{ translate('To setup google auth')}}">  <a href="https://console.cloud.google.com/"><i class="fa fa-info-circle"></i></a> </sup></h6>
								<div class="row">
									<div class="mb-3 col-lg-6">
										<label for="g_client_id" class="form-label">{{ translate('Client Id')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="g_client_id" id="g_client_id" class="form-control" value="{{@$general->s_login_google_info->g_client_id}}" placeholder="{{ translate('Enter Google Client Id')}}" required>
									</div>

									<div class="mb-3 col-lg-6">
										<label for="g_client_secret" class="form-label">{{ translate('Client Secret')}}<sup class="text--danger">*</sup></label>
										<input type="text" name="g_client_secret" id="g_client_secret" class="form-control" value="{{@$general->s_login_google_info->g_client_secret}}" placeholder="{{ translate('Enter Google Secret Key')}}" required>
									</div>


									<div class="mb-3 col-lg-12 col-md-12">
										<label for="callback_google_url" class="form-label">{{ translate('Authorized redirect URIs')}} </label>
										<div class="input-group">
										  	<input type="text" id="callback_google_url" class="form-control" value="{{url('auth/google/callback')}}" readonly="" aria-label="Recipient's username" aria-describedby="basic-addon2">
										  	<span class="input-group-text bg--success pointer text-light" onclick="myFunction1()" id="basic-addon2">{{ translate('Copy URL')}}</span>
										</div>
									</div>
								</div>
							</div>
							<button type="submit" class="btn btn--primary w-100 text-light">{{ translate('Submit')}}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection


@push('scriptpush')
<script>
	"use strict";
	function myFunction() {
        var copyText = document.getElementById("callback_facebook_url");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        notify('success', 'Copied the text : ' + copyText.value);
    }

    function myFunction1() {
        var copyText = document.getElementById("callback_google_url");
        copyText.select();
        copyText.setSelectionRange(0, 99999)
        document.execCommand("copy");
        notify('success', 'Copied the text : ' + copyText.value);
    }
</script>
@endpush
