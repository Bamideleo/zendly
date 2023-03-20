@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="responsive-table">
		                <table class="w-100 m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th>{{ translate('Name')}}</th>
		                            <th>{{ translate('Symbol')}}</th>
		                            <th>{{ translate('Rate')}}</th>
		                            <th>{{ translate('Status')}}</th>
		                            <th>{{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($currencies as $currency)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label="{{ translate('Name')}}">
				                    	{{__($currency->name)}}
				                    </td>

				                    <td data-label="{{ translate('Symbol')}}">
				                    	{{__($currency->symbol)}}
				                    </td>

				                    <td data-label="{{ translate('Rate')}}">
				                    	1 {{__($general->currency_name)}} = {{shortAmount($currency->rate)}} {{__($currency->name)}}
				                    </td>

				                    <td data-label="{{ translate('Status')}}">
				                    	@if($currency->status == 1)
				                    		<span class="badge badge--primary">{{ translate('Active')}}</span>
				                    	@elseif($currency->status == 2)
				                    		<span class="badge badge--danger">{{ translate('Inactive')}}</span>
				                    	@endif
				                    </td>

				                    <td data-label={{ translate('Action')}}>
			                    		<a class="btn--primary text--light currencydata" data-bs-toggle="modal" data-bs-target="#updatecurrency" href="javascript:void(0)" data-id="{{$currency->id}}" data-name="{{$currency->name}}"  data-symbol="{{$currency->symbol}}"  data-status="{{$currency->status}}" data-rate="{{shortAmount($currency->rate)}}"><i class="las la-pen"></i></a>
			                    		<a href="javascript:void(0)" class="btn--danger text--light currencyDelete"
				                    		data-bs-toggle="modal"
				                    		data-bs-target="#delete"
				                    		data-delete_id="{{$currency->id}}"
				                    		><i class="las la-trash"></i>
				                    	</a>
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%">{{ translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
		            </div>
	            </div>
	        </div>
	    </div>
	</div>
	<a href="javascript:void(0);" class="support-ticket-float-btn" data-bs-toggle="modal" data-bs-target="#createNewCurrency" title="{{ translate('Create New Currency')}}">
		<i class="fa fa-plus ticket-float"></i>
	</a>
</section>


<div class="modal fade" id="createNewCurrency" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.general.setting.currency.store')}}" method="POST">
				@csrf
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{ translate('Add New Currency')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="name" class="form-label">{{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{ translate('Enter Name')}}" required>
							</div>

							<div class="mb-3">
								<label for="symbol" class="form-label">{{ translate('Symbol')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="symbol" name="symbol" placeholder="{{ translate('Enter Symbol')}}" required>
							</div>

							<div class="mb-3">
								<label for="rate" class="form-label">{{ translate('Exchange Rate')}} <sup class="text--danger">*</sup></label>
								<div class="input-group">
								  	<span class="input-group-text" id="basic-addon1">1 {{$general->currency_name}} = </span>
  									<input type="text" id="rate" name="rate" class="form-control" placeholder="0.00" aria-label="Username" aria-describedby="basic-addon1">
								</div>
							</div>

							<div class="mb-3">
								<label for="status" class="form-label">{{ translate('Status')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="status" id="status" required>
									<option value="1">{{ translate('Active')}}</option>
									<option value="2">{{ translate('Inactive')}}</option>
								</select>
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


<div class="modal fade" id="updatecurrency" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.general.setting.currency.update')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{ translate('Update Currency')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="name" class="form-label">{{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{ translate('Enter Name')}}" required>
							</div>

							<div class="mb-3">
								<label for="symbol" class="form-label">{{ translate('Symbol')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="symbol" name="symbol" placeholder="{{ translate('Enter Symbol')}}" required>
							</div>

							<div class="mb-3">
								<label for="rate" class="form-label">{{ translate('Exchange Rate')}} <sup class="text--danger">*</sup></label>
								<div class="input-group">
								  	<span class="input-group-text" id="basic-addon1">1 {{$general->currency_name}} = </span>
  									<input type="text" id="rate" name="rate" class="form-control" placeholder="0.00" aria-label="Username" aria-describedby="basic-addon1">
								</div>
							</div>

							<div class="mb-3">
								<label for="status" class="form-label">{{ translate('Status')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="status" id="status" required>
									<option value="1">{{ translate('Active')}}</option>
									<option value="2">{{ translate('Inactive')}}</option>
								</select>
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
        	<form action="{{route('admin.general.setting.currency.delete')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id" value="">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash-alt"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6>{{ translate('Are you sure to delete')}}</h6>
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
		$('.currencydata').on('click', function(){
			var modal = $('#updatecurrency');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.find('input[name=name]').val($(this).data('name'));
			modal.find('input[name=symbol]').val($(this).data('symbol'));
			modal.find('input[name=rate]').val($(this).data('rate'));
			modal.find('select[name=status]').val($(this).data('status'));
			modal.modal('show');
		});
		$('.currencyDelete').on('click', function(){
			var modal = $('#delete');
			modal.find('input[name=id]').val($(this).data('delete_id'));
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush


