@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="table_heading d-flex align--center justify--between">
                    <nav  aria-label="breadcrumb">
					  	<ol class="breadcrumb">
					    	<li class="breadcrumb-item"><a href="{{route('admin.gateway.sms.index')}}">{{ translate('Api Gateway')}}</a></li>
					    	<li class="breadcrumb-item" aria-current="page"> {{ucfirst($smsGateway->name)}}</li>
					  	</ol>
					</nav>
                </div>
				<div class="card">
					<div class="card-header bg--lite--violet">
						<h6 class="card-title text-center text-light"> {{ucfirst($smsGateway->name)}} {{ translate('Gateway Update')}}</h6>
					</div>
					<div class="card-body">
						<form action="{{route('admin.sms.gateway.update', $smsGateway->id)}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="shadow-lg p-3 mb-5 bg-body rounded">
								<div class="row">
									@foreach($smsGateway->credential as $key => $parameter)
										<div class="mb-3 col-md-12">
											<label for="{{$key}}" class="form-label">{{ucwords(str_replace('_', ' ', $key))}} <sup class="text--danger">*</sup></label>
											<input type="text" name="sms_method[{{$key}}]" id="{{$key}}" value="{{$parameter}}" class="form-control" placeholder="{{ translate('Enter Valid API Data')}}" required>
										</div>
									@endforeach


									<div class="mb-3 col-lg-12 col-md-12">
										<label for="status" class="form-label">{{ translate('Status')}} <sup class="text--danger">*</sup></label>
										<select class="form-control" name="status" id="status" required>
											<option value="1" @if($smsGateway->status == 1) selected @endif>{{ translate('Active')}}</option>
											<option value="2" @if($smsGateway->status == 2) selected @endif>{{ translate('Inactive')}}</option>
										</select>
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

