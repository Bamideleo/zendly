@extends('user.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="wrapper">
					@foreach($plans as $plan)
				        <div class="pricing-table gprice-single @if($plan->recommended_status == 1) focused-plan @endif">
				        	@if($plan->recommended_status == 1)
					        	<div class="recommanded">
					     			<span class="p-2 text-light m-0 p-0">{{ translate('Recommanded')}}</span>
					     		</div>
					     	@endif
				            <div class="head">
				                 <h4 class="title">{{ucfirst($plan->name)}}</h4>
				            </div>
				            <div class="content">
				                <div class="price">
				                    <h1>{{$general->currency_symbol}}{{shortAmount($plan->amount)}}</h1>
				                </div>
				                <ul>
				                    <li>{{ translate('Total SMS')}} {{__($plan->credit)}} {{ translate('Credit')}}</li>
				                    <li>{{ translate('Total Email')}} {{__($plan->email_credit)}} {{ translate('Credit')}}</li>
				                    <li>{{ translate('Total Whatsapp')}} {{__($plan->whatsapp_credit)?? 'N/A'}} {{ translate('Credit')}}</li>
				                    <li>{{ translate('1 Credit for 160 word')}}</li>
				                    <li>{{ translate('Duration')}} {{__($plan->duration)}} {{ translate('Days')}}</li>
				                </ul>
				                <div class="sign-up">
				                    <a href="javascript:void(0)" class="btn bordered radius subscription" data-bs-toggle="modal" data-bs-target="#purchase" data-id="{{$plan->id}}">
				                    	@if($subscription)
				                    		@if($plan->id == $subscription->plan_id)
            									@if(Carbon\Carbon::now()->toDateTimeString() > $subscription->expired_date)
                                                {{ translate("Renew") }}
            									@else
                                                {{ translate('Current Plan')}}
            									@endif
				                    		@else
                                              {{ translate('Upgrade Plan')}}
				                    		@endif
				                    	@else
                                        {{ translate('Purchase Now')}}
				                    	@endif
				                	</a>
				                </div>
				            </div>
				        </div>
				    @endforeach
			    </div>
			</div>
		</div>
	</div>
</section>

<div class="modal fade" id="purchase" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<div class="modal-header">
		        <h5 class="modal-title">{{ translate('Payment Method')}}</h5>
		        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		     </div>
        	<form action="{{route('user.plan.store')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id">
        		<input type="hidden" name="payment_gateway">
	            <div class="modal_body">
	            	<div class="container">
	            		<div class="col-lg-12">
	            			<h6 class="payment-gateway-modal-title">{{ translate('Automatic Payment Method')}}</h6>
	            		</div>
	            		<div class="col-lg-12">
	            			<div class="modal_text2 mt-3">
			                    <div class="mb-3">
									<div class="payment-items">
		            					@foreach($paymentMethods as $paymentMethod)
											@if(strpos($paymentMethod->unique_code, 'MANUAL') === false)
								            <div class="payment-item" data-payment_gateway="{{$paymentMethod->id}}">
								            	<div class="payment-item-img">
								                	<img src="{{showImage(filePath()['payment_method']['path'].'/'.$paymentMethod->image,filePath()['payment_method']['size'])}}" alt="{{__($paymentMethod->name)}}">
								              	</div>
								              	<h4 class="payment-item-title">
								                	{{__($paymentMethod->name)}}
								              	</h4>
								              	<div class="payment-overlay">
								                	<button type="submit" class="btn">{{ translate('Process')}}</button>
								              	</div>
								            </div>
								        	@endif
					            		@endforeach
	            					</div>
	            				</div>
	            			</div>
	            		</div>
	            		<div class="col-lg-12">
	            			<h6 class="payment-gateway-modal-title">{{ translate('Manual Payment Method')}}</h6>
	            		</div>
	            		<div class="col-lg-12">
	            			<div class="modal_text2 mt-3">
			                    <div class="mb-3">
									<div class="payment-items">
		            					@foreach($paymentMethods as $paymentMethod)
										@if(strpos($paymentMethod->unique_code, 'MANUAL') !== false)
							            <div class="payment-item" data-payment_gateway="{{__($paymentMethod->id)}}">
							            	<div class="payment-item-img">
							                	<img src="{{showImage(filePath()['payment_method']['path'].'/'.$paymentMethod->image,filePath()['payment_method']['size'])}}" alt="{{__($paymentMethod->name)}}">
							              	</div>
							              	<h4 class="payment-item-title">
							                	{{__($paymentMethod->name)}}
							              	</h4>
							              	<div class="payment-overlay">
							                	<button type="submit" class="btn">{{ translate('Process')}}</button>
							              	</div>
							            </div>
							        	@endif
					            		@endforeach
	            					</div>
	            				</div>
	            			</div>
	            		</div>
	                </div>
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
		$(".subscription").on('click', function(){
			var modal = $('#purchase');
			modal.find('input[name=id]').val($(this).data("id"));
			modal.modal('show');
		});

		$(".payment-item").on('click', function(){
			var modal = $('#purchase');
			modal.find('input[name=payment_gateway]').val($(this).data("payment_gateway"));
		});
	})(jQuery);
</script>
@endpush


@push('stylepush')
<style type="text/css">
	.focused-plan {
	    border: 1px solid #102078;
	}
	.recommanded{
		position: absolute;
		top: 0;
		left: 0;
		height: 10%;
		width: 100%;
		text-align: right;
	}
	.recommanded span {
		background-color: #102078;
	    border-bottom-left-radius: 15px;
	}
</style>
@endpush
