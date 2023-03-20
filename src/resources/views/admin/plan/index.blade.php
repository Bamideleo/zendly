@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12">
	            <div class="card mb-4">
		            <div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th>{{ translate('Name')}}</th>
		                            <th>{{ translate('Amount')}}</th>
		                            <th>{{ translate('SMS Credit')}}</th>
		                            <th>{{ translate('Email Credit')}}</th>
		                            <th>{{ translate('Whatsapp Credit')}}</th>
		                            <th>{{ translate('Duration')}}</th>
		                            <th>{{ translate('Status')}}</th>
		                            <th>{{ translate('Recommended Status')}}</th>
		                            <th>{{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($plans as $plan)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label="{{ translate('Name')}}">
				                    	{{__($plan->name)}}
				                    </td>

				                    <td data-label="{{ translate('Amount')}}">
				                    	{{shortAmount($plan->amount)}} {{$general->currency_name}}
				                    </td>

				                    <td data-label="{{ translate('SMS Credit')}}">
				                    	{{__($plan->credit)}} {{ translate('Sending Credit')}}
				                    </td>

				                     <td data-label="{{ translate('Email Credit')}}">
				                    	{{__($plan->email_credit)}} {{ translate('Credit')}}
				                    </td>

				                     <td data-label="{{ translate('Whatsapp Credit')}}">
				                    	{{__($plan->whatsapp_credit)?? 'N/A '}} {{ translate('Credit')}}
				                    </td>

				                     <td data-label="{{ translate('Duration')}}">
				                    	{{__($plan->duration)}} {{ translate('Days')}}
				                    </td>

				                    <td data-label="{{ translate('Status')}}">
				                    	@if($plan->status == 1)
				                    		<span class="badge badge--success">{{ translate('Active')}}</span>
				                    	@else
				                    		<span class="badge badge--danger">{{ translate('Inactive')}}</span>
				                    	@endif
				                    </td>

				                     <td data-label="{{ translate('Recommended')}}">
				                    	@if($plan->recommended_status == 1)
				                    		<span class="badge badge--success">{{ translate('ON')}}</span>
				                    	@else
				                    		<span class="badge badge--danger">{{ translate('OFF')}}</span>
				                    	@endif
				                    </td>

				                    <td data-label={{ translate('Action')}}>
			                    		<a class="btn--primary text--light brand" data-bs-toggle="modal" data-bs-target="#updatebrand" href="javascript:void(0)"
			                    			data-id="{{$plan->id}}"
			                    			data-name="{{$plan->name}}"
			                    			data-amount="{{shortAmount($plan->amount)}}"
			                    			data-credit="{{$plan->credit}}"
			                    			data-email_credit="{{$plan->email_credit}}"
			                    			data-whatsapp_credit="{{$plan->whatsapp_credit}}"
			                    			data-duration="{{$plan->duration}}"
			                    			data-status="{{$plan->status}}"
			                    			data-recommended_status="{{$plan->recommended_status}}"><i class="las la-pen"></i></a>

			                    			<a href="javascript:void(0)" class="btn--danger text--light planDelete"
				                    		data-bs-toggle="modal"
				                    		data-bs-target="#delete"
				                    		data-delete_id="{{$plan->id}}"
				                    		><i class="las la-trash"></i></a>
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
	                	{{$plans->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
	<a href="javascript:void(0);" class="support-ticket-float-btn" data-bs-toggle="modal" data-bs-target="#createPlan" title="{{ translate('Create New Plan')}}">
		<i class="fa fa-plus ticket-float"></i>
	</a>
</section>


<div class="modal fade" id="createPlan" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.plan.store')}}" method="POST">
				@csrf
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{ translate('Add New Pricing Plan')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="name" class="form-label">{{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{ translate('Enter Name')}}" required>
							</div>

							<div class="mb-3">
								<label for="amount" class="form-label">{{ translate('Amount')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="amount" name="amount" placeholder="{{ translate('Enter Amount')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{__($general->currency_name)}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="credit" class="form-label">{{ translate('Credit')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="credit" name="credit" placeholder="{{ translate('Enter Credit')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{ translate('SMS')}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="email_credit" class="form-label">{{ translate('Email Credit')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="email_credit" name="email_credit" placeholder="{{ translate('Enter Email Credit')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{ translate('Email')}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="whatsapp_credit" class="form-label">{{ translate('Whatsapp Credit')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="whatsapp_credit" name="whatsapp_credit" placeholder="{{ translate('Enter Whatsapp Credit')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{ translate('Whatsapp')}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="duration" class="form-label">{{ translate('Duration')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="duration" name="duration" placeholder="{{ translate('Enter Duration')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{ translate('Days')}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="status" class="form-label">{{ translate('Status')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="status" id="status" required>
									<option value="1">{{ translate('Active')}}</option>
									<option value="2">{{ translate('Inactive')}}</option>
								</select>
							</div>


							<div class="mb-3">
								<div class="form-check form-switch">
								  	<input class="form-check-input" value="1" name="recommended_status" type="checkbox" id="recommended_status">
								  	<label class="form-check-label" for="recommended_status">{{ translate('Recommended Plan')}}</label>
								</div>
							</div>

						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{ translate('Submit')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>


<div class="modal fade" id="updatebrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.plan.update')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{ translate('Update Pricing Plan')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="name" class="form-label"{{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{ translate('Enter Name')}}" required>
							</div>

							<div class="mb-3">
								<label for="amount" class="form-label">{{ translate('Amount')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="amount" name="amount" placeholder="{{ translate('Enter Amount')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{__($general->currency_name)}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="credit" class="form-label">{{ translate('Credit')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="credit" name="credit" placeholder="{{ translate('Enter Credit')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{ translate('SMS')}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="email_credit" class="form-label">{{ translate('Email Credit')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="email_credit" name="email_credit" placeholder="{{ translate('Enter Email Credit')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{ translate('Email')}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="whatsapp_credit" class="form-label">{{ translate('Whatsapp Credit')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="whatsapp_credit" name="whatsapp_credit" placeholder="{{ translate('Enter Whatsapp Credit')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{ translate('Whatsapp')}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="duration" class="form-label">{{ translate('Duration')}} <sup class="text--danger">*</sup></label>
								<div class="input-group mb-3">
								  	<input type="text" class="form-control" id="duration" name="duration" placeholder="{{ translate('Enter Duration')}}" aria-label="Recipient's username" aria-describedby="basic-addon2">
								  	<span class="input-group-text" id="basic-addon2">{{ translate('Days')}}</span>
								</div>
							</div>

							<div class="mb-3">
								<label for="status" class="form-label">{{ translate('Status')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="status" id="status" required>
									<option value="1">{{ translate('Active')}}</option>
									<option value="2">{{ translate('Inactive')}}</option>
								</select>
							</div>

							<div class="mb-3">
								<div class="form-check form-switch">
								  	<input class="form-check-input" value="1" name="recommended_status" type="checkbox" id="recommended_status">
								  	<label class="form-check-label" for="recommended_status">{{ translate('Recommended Plan')}}</label>
								</div>
							</div>

						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{ translate('Submit')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('admin.plan.delete')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id" value="">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash-alt"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6>{{ translate('Are you sure to delete this plan')}}</h6>
	                </div>
	            </div>
	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--danger">{{ translate('Delete')}}</button>
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
		$('.brand').on('click', function(){
			var modal = $('#updatebrand');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.find('input[name=name]').val($(this).data('name'));
			modal.find('input[name=amount]').val($(this).data('amount'));
			modal.find('input[name=credit]').val($(this).data('credit'));
			modal.find('input[name=email_credit]').val($(this).data('email_credit'));
			modal.find('input[name=whatsapp_credit]').val($(this).data('whatsapp_credit'));
			modal.find('input[name=duration]').val($(this).data('duration'));
			modal.find('select[name=status]').val($(this).data('status'));
			modal.find('input[name=recommended_status]').val($(this).data('recommended_status'));
			var recommendedstatus = $(this).data('recommended_status');
			if(recommendedstatus == 1){
				modal.find('input[name=recommended_status]').attr('checked', true);
			}else{
				modal.find('input[name=recommended_status]').attr('checked', false);
			}
			modal.modal('show');
		});

		$('.planDelete').on('click', function(){
			var modal = $('#delete');
			modal.find('input[name=id]').val($(this).data('delete_id'));
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush
