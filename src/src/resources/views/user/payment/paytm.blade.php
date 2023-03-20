@extends('user.layouts.app')
@section('panel')
@push('script-include')
<script type="application/javascript" crossorigin="anonymous" src="{{$paymentMethod->payment_parameter->PAYTM_ENVIRONMENT}}/merchantpgpui/checkoutjs/merchants/{{$paymentMethod->payment_parameter->PAYTM_MID}}.js"></script>
@endpush
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
                      		@csrf
					  		<div class="form-submit">
					    		<button type="submit" class="mt-3 btn btn--primary text-light payment-btn" id="JsCheckoutPayment">{{ translate('Pay With Paytm')}}</button>
					  		</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scriptpush')
<script type="application/javascript">
	'use strict';
	$("#JsCheckoutPayment").on('click',function(e){
		e.preventDefault();
		$.ajax({
		    url: "{{route('user.paytm.process')}}",
		    data: {
		    	"_token": "{{ csrf_token() }}",
		    	paytm_mid:'{{$paymentMethod->payment_parameter->PAYTM_MID}}',
		    	paytm_website:'{{$paymentMethod->payment_parameter->PAYTM_WEBSITE}}',
		    	paytm_merchant_key:'{{$paymentMethod->payment_parameter->PAYTM_MERCHANT_KEY}}',
		    	paytm_environment:'{{$paymentMethod->payment_parameter->PAYTM_ENVIRONMENT}}'
		    },
		    type: "POST",
		    success: function(response){
		    	if (response.success) {
		    		openJsCheckoutPopup(response.orderId, response.txnToken, '1');
		    	}else{
		    		notify('error',response.message);
		    		// window.location.href = "{{route('user.dashboard')}}";
		    	}
		    	// openJsCheckoutPopup('{{trxNumber()}}','','');
		    	// notify('success',response.message);
		    	// window.location.href = "{{route('user.dashboard')}}";
		    }
		});

	});

	function openJsCheckoutPopup(orderId, txnToken, amount)
	{
		var config = {
			"root": "",
			"flow": "DEFAULT",
			"data": {
				"orderId": orderId,
				"token": txnToken,
				"tokenType": "TXN_TOKEN",
				"amount": amount
				},
				"merchant":{
				"redirect": true
			},
			"handler": {
			"notifyMerchant": function(eventName,data){
				console.log("notifyMerchant handler function called");
				console.log("eventName => ",eventName);
				console.log("data => ",data);
				}
			}
		};
		if(window.Paytm && window.Paytm.CheckoutJS){
			// initialze configuration using init method
			window.Paytm.CheckoutJS.init(config).then(function onSuccess() {
				// after successfully updating configuration, invoke checkoutjs
				window.Paytm.CheckoutJS.invoke();
			}).catch(function onError(error){
				console.log("error => ",error);
			});
		}
	}
</script>
@endpush
