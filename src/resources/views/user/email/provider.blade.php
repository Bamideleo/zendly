@extends('user.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12 p-1">
	            <div class="rounded_box">
                	<div class="row align--center px-3">
                		<div class="col-12 col-md-4 col-lg-4 col-xl-5">
                    		<h6 class="my-3"> {{ translate('Set Mail Default Options')}}</h6>
                    	</div>
	                    <div class="col-12 col-md-8 col-lg-8 col-xl-7">
	                		<div class="row justify-content-end">
			                    <div class="col-12 col-lg-6 col-xl-6 px-2 py-1 ">
				                    <form action="{{route('user.manage.email.mailmethod')}}" method="POST" class="form-inline float-sm-right text-end">
				                    	@csrf
				                     	<div class="input-group mb-3 w-100">
										  	<select class="form-control" name="id" required="">
                                              <option selected disabled>Select Method</option>
										  		@foreach($mails as $mail)
							                    	<option value="{{$mail->id}}">{{strtoupper($mail->name)}}</option>
							                    @endforeach
										  	</select>
										  	<button class="btn--primary input-group-text input-group-text" id="basic-addon2" type="submit"> {{ translate('Email Send Method')}}</button>
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
		                            <th> {{ translate('Name')}}</th>
		                            <th> {{ translate('Status')}}</th>
		                            <th> {{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($emailp as $mail)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label=" {{ translate('Name')}}">
				                    	{{__($mail->name)}}
				                    	@if($setting->email_gateway_id == $mail->id)
					                    	<span class="text--success fs-5">
					                    		<i class="las la-check-double"></i>
					                    	</span>
					                    @endif
				                    </td>
				                    <td data-label=" {{ translate('Status')}}">
				                    	@if($mail->status == 1)
				                    		<span class="badge badge--success"> {{ translate('Active')}}</span>
				                    	@else
				                    		<span class="badge badge--danger"> {{ translate('Inactive')}}</span>
				                    	@endif
				                    </td>
				                    <td data-label= {{ translate('Action')}}>
                                        @if($mail->driver_information)
			                    			<a class="btn--primary text--light" href="{{route('user.manage.email.edit', $mail->id)}}"><i class="las la-pen"></i></a>
			                    		@else
			                    			<span> {{ translate('N/A')}}</span>
			                    		@endif
                                        @if($setting->email_gateway_id == $mail->id)
										<a class="btn--danger text--light group-api" data-bs-toggle="modal" data-bs-target="#update-api" href="javascript:void(0)"
											title="Disable" 
											data-id="{{$mail->id}}"
											data-status="2"
											><i class="las la-eye"></i></a>
										@else
											<a class="btn--primary text--light group" data-bs-toggle="modal" data-bs-target="#updatebrand" href="javascript:void(0)"
			                    			data-id="{{$mail->id}}"
											 data-status="1"
											title="Enable" ><i class="las la-eye-slash"></i></a>
										@endif
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%"> {{ translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
		            </div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
<div class="modal fade" id="updatebrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('user.manage.email.activate-method')}}" method="POST">
				@csrf
				
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{ translate('You Really Want to Enable This Method')}}</div>
	            		</div>
		                <div class="card-body">
						<input type="hidden" name="id">
						<input type="hidden" name="status">
							<!-- <div class="mb-3">
								<label for="name" class="form-label">{{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{ translate('Enter Name')}}" required>
							</div> -->

							<!-- <div class="mb-3">
								<label for="status" class="form-label">{{ translate('Status')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="status" id="status" required>
									<option value="1">{{ translate('Active')}}</option>
									<option value="2">{{ translate('Inactive')}}</option>
								</select>
							</div> -->
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{ translate('Enable')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="updateapi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('user.manage.email.activate-method')}}" method="POST">
				@csrf
				
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{ translate('You Really Want to Disable This Method')}}</div>
	            		</div>
		                <div class="card-body">
						<input type="hidden" name="id">
						<input type="hidden" name="status">
							<!-- <div class="mb-3">
								<label for="name" class="form-label">{{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{ translate('Enter Name')}}" required>
							</div> -->

							<!-- <div class="mb-3">
								<label for="status" class="form-label">{{ translate('Status')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="status" id="status" required>
									<option value="1">{{ translate('Active')}}</option>
									<option value="2">{{ translate('Inactive')}}</option>
								</select>
							</div> -->
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{ translate('Disable')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
@endsection
@push('scriptpush')
<script>
	(function($){
		"use strict";
		$('.group').on('click', function(){
			var modal = $('#updatebrand');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.find('input[name=status]').val($(this).data('status'));
			modal.modal('show');
		});

		$('.group-api').on('click', function(){
			var modal = $('#updateapi');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.find('input[name=status]').val($(this).data('status'));
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush

