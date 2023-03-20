@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12 p-1">
	            <div class="rounded_box">
                	<div class="row align--center px-3">
                		<div class="col-12 col-md-4 col-lg-4 col-xl-5">
                    		<h6 class="my-3">{{ translate('Set Default Sending Gateway')}}</h6>
                    	</div>

	                    <div class="col-12 col-md-8 col-lg-8 col-xl-7">
	                		<div class="row justify-content-end">
			                    <div class="col-12 col-lg-6 col-xl-6 px-2 py-1 ">
				                    <form action="{{route('admin.sms.default.gateway')}}" method="POST" class="form-inline float-sm-right text-end">
				                    	@csrf
				                     	<div class="input-group mb-3 w-100">
										  	<select class="form-control" name="sms_gateway" required="">
										  		@foreach($smsGateways as $gateway)
										  			<option value="{{$gateway->id}}" @if($general->sms_gateway_id == $gateway->id) selected @endif>{{strtoupper($gateway->name)}}</option>
										  		@endforeach
										  	</select>
										  	<button class="btn--primary input-group-text input-group-text" id="basic-addon2" type="submit">{{ translate('Send SMS Method')}}</button>
										</div>
							        </form>
							    </div>
							</div>
	                	</div>
	                </div>

	                <div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th>{{ translate('Gateway Name')}}</th>
		                            <th>{{ translate('Status')}}</th>
		                            <th>{{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($smsGateways as $smsGateway)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label="{{ translate('Gateway Name')}}">
				                    	{{ucfirst($smsGateway->name)}}
				                    	@if($general->sms_gateway_id == $smsGateway->id)
					                    	<span class="text--success fs-5">
					                    		<i class="las la-check-double"></i>
					                    	</span>
					                    @endif
				                    </td>

				                    <td data-label="{{ translate('Status')}}">
				                    	@if($smsGateway->status == 1)
				                    		<span class="badge badge--success">{{ translate('Active')}}</span>
				                    	@else
				                    		<span class="badge badge--danger">{{ translate('Inactive')}}</span>
				                    	@endif
				                    </td>

				                    <td data-label={{ translate('Action')}}>
			                    		<a href="{{route('admin.gateway.sms.edit', $smsGateway->id)}}" class="btn--primary text--light brand" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit"><i class="las la-pen"></i></a>
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%">{{ translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
		            </div>
	                <div class="m-3">
						{{$smsGateways->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection
