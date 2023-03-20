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
		                            <th> {{ translate('Name')}}</th>
		                            <th> {{ translate('Image')}}</th>
		                            <th> {{ translate('Method Currency')}}</th>
		                            <th> {{ translate('Status')}}</th>
		                            <th> {{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($manulaPayments as $manulaPayment)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label=" {{ translate('Name')}}">
				                    	{{__($manulaPayment->name)}}
				                    </td>

				                    <td data-label=" {{ translate('Logo')}}">
				                    	<img src="{{showImage(filePath()['payment_method']['path'].'/'.$manulaPayment->image)}}" class="brandlogo">
				                    </td>

				                    <td data-label=" {{ translate('Currency')}}">
				                    	1 {{$general->currency_name}} = {{shortAmount($manulaPayment->rate)}} {{__($manulaPayment->currency->name)}}
				                    </td>
				                    <td data-label=" {{ translate('Status')}}">
				                    	@if($manulaPayment->status == 1)
				                    		<span class="badge badge--success"> {{ translate('Active')}}</span>
				                    	@else
				                    		<span class="badge badge--danger"> {{ translate('Inactive')}}</span>
				                    	@endif
				                    </td>
				                    <td data-label= {{ translate('Action')}}>
			                    		<a href="{{route('admin.manual.payment.edit',$manulaPayment->id)}}" class="btn--primary text--light"><i class="las la-pen"></i></a>

			                    		<a href="javascript:void(0)" class="btn--danger text--light gwdelete"
				                    		data-bs-toggle="modal"
				                    		data-bs-target="#delete"
				                    		data-delete_id="{{$manulaPayment->id}}"
				                    		><i class="las la-trash"></i>
				                    	</a>
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%"> {{ translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
	            	</div>
	                <div class="m-3">
	                	{{$manulaPayments->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
	<a href="{{route('admin.manual.payment.create')}}" class="support-ticket-float-btn">
		<i class="fa fa-plus ticket-float"></i>
	</a>
</section>

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('admin.manual.payment.delete')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id" value="">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash-alt"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6>@ {{ translate('Are you sure to delete this payment method')}}</h6>
	                </div>
	            </div>
	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal"> {{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--danger"> {{ translate('Delete')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>

@endsection



@push('stylepush')
	<style>
		.brandlogo{
			width: 50px;
		}
	</style>
@endpush

@push('scriptpush')
<script>
	(function($){
       	"use strict";

		$('.gwdelete').on('click', function(){
			var modal = $('#delete');
			modal.find('input[name=id]').val($(this).data('delete_id'));
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush


