@extends('user.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
    <div class="container-fluid p-0 mb-3 pb-2">
        <div class="row d-flex align--center rounded">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg--lite--violet">
                        <h6 class="card-title text-center text-light">{{__($title)}}</h6>
                    </div>
                    <div class="card-body text-center">
                      	<h6>{{shortAmount($paymentLog->final_amount)}} {{$paymentLog->paymentGateway->currency->name}}</h6>
                      	<form id="paymentForm">
					  		<div class="form-submit">
					    		<button type="submit" class="mt-3 btn btn--primary text-light payment-btn" onclick="payWithPaystack(event)">{{ translate('Pay With Paystack')}}</button>
					  		</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('script-include')
<script src="https://js.paystack.co/v2/inline.js"></script>
@endpush
@push('scriptpush')
<script>
	'use strict';
	var paymentForm = document.getElementById('paymentForm');
	paymentForm.addEventListener('submit', payWithPaystack, false);
	function payWithPaystack(e){
		e.preventDefault();
	 	var handler = PaystackPop.setup({
	    	key: '{{$paymentMethod->payment_parameter->public_key}}',
	    	email: '{{$paymentLog->user->email}}',
	    	amount: '{{round($paymentLog->final_amount, 2)*100}}',
	    	currency: '{{$paymentMethod->currency->name}}',
			ref: '{{trxNumber()}}',
	    	callback: function(response){
	    		$.ajax({
				    url: "{{route('user.payment.with.paystack')}}",
				    data: {reference : response.reference},
				    type: "GET",
				    success: function(response){
				    	// console.log(response);
				    	notify('success',response.message);
				    	window.location.href = "{{route('user.dashboard')}}";
				    }
				});
	    	},
	    	onClose: function() {
	      		notify('error','Transaction was not completed, window closed.');
	    	},
	  	});
	  handler.openIframe();
	}
</script>
@endpush
