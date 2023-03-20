@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="card">
		            <div class="card-body">
		            	<ol class="list-group list-group-numbered">
		            		<li class="list-group-item d-flex justify-content-between align-items-start">
							    <div class="ms-2 me-auto">{{ translate('Document Root Folder')}} </div>
						    	<span>{{$systemInfo['serverdetail']['DOCUMENT_ROOT']}}</span>
						  	</li>
						  	<li class="list-group-item d-flex justify-content-between align-items-start">
							    <div class="ms-2 me-auto">{{ translate('System Laravel Version')}}</div>
						    	<span>{{$systemInfo['laravelversion']}}</span>
						  	</li>
						  	<li class="list-group-item d-flex justify-content-between align-items-start">
							    <div class="ms-2 me-auto">{{ translate('PHP Version')}}</div>
						    	<span>{{$systemInfo['phpversion']}}</span>
						  	</li>
						  	<li class="list-group-item d-flex justify-content-between align-items-start">
							    <div class="ms-2 me-auto">{{ translate('IP Address')}}</div>
						    	<span>{{$systemInfo['serverdetail']['REMOTE_ADDR']}}</span>
						  	</li>
						  	<li class="list-group-item d-flex justify-content-between align-items-start">
							    <div class="ms-2 me-auto">{{ translate('System Server host')}}</div>
						    	<span>{{$systemInfo['serverdetail']['HTTP_HOST']}}</span>
						  	</li>
						</ol>
		            </div>
		        </div>
			</div>
		</div>
	</div>
</section>
@endsection
