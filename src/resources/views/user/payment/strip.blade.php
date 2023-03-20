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
                    <div class="card-body">
                    	<form role="form" action="{{ route('user.payment.with.strip') }}" method="post" class="stripe-payment" data-cc-on-file="false" data-stripe-publishable-key="{{@$paymentMethod->payment_parameter->publishable_key}}" id="stripe-payment">
							@csrf
							<div class="row">
								<div class="mb-2 col-lg-12">
									<label for="name" class="form-label">{{ translate('Name on Card')}}</label>
									<input type="text" class="form-control" placeholder="{{ translate('Enter Card Name')}}">
								</div>

								<div class="mb-2 col-lg-6 col-md-6">
									<label for="number" class="form-label">{{ translate('Card Number')}}</label>
									<input type="text" id="number" class="form-control card-num" placeholder="{{ translate('Enter Card Number')}}">
								</div>

								<div class="mb-2 col-lg-6 col-md-6">
									<label for="cvc" class="form-label">{{ translate('CVC')}}</label>
									<input type="text" id="cvc" autocomplete='off' class="form-control card-cvc" placeholder="{{ translate('E.G 595')}}">
								</div>

								<div class="mb-2 col-lg-6 col-md-6">
									<label for="month" class="form-label">{{ translate('Expiration Month')}}</label>
									<input type="text" id="month" maxlength="2" autocomplete='off' class="form-control card-expiry-month" placeholder="{{ translate('MM')}}">
								</div>

								<div class="mb-2 col-lg-6 col-md-6">
									<label for="year" class="form-label">{{ translate('Expiration Year')}}</label>
									<input type="text" id="year" maxlength="4" autocomplete='off' class="form-control card-expiry-year" placeholder="{{ translate('YYYY')}}">
								</div>

								<button class="btn btn--primary w-100 text-light" type="submit">{{ translate('Pay Now')}}</button>
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
	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
@endpush

@push('scriptpush')
	<script>
		"use strict"
	    $(function () {
	        var $form = $(".stripe-payment");
	        $('form.stripe-payment').bind('submit', function (e) {
	            var $form = $(".stripe-payment"),
	            inputVal = ['input[type=email]', 'input[type=password]',
	                'input[type=text]', 'input[type=file]',
	                'textarea'
	            ].join(', '),
	            valid = true;

	            if (!$form.data('cc-on-file')) {
	                e.preventDefault();
	                Stripe.setPublishableKey($form.data('stripe-publishable-key'));
	                Stripe.createToken({
	                    number: $('.card-num').val(),
	                    cvc: $('.card-cvc').val(),
	                    exp_month: $('.card-expiry-month').val(),
	                    exp_year: $('.card-expiry-year').val()
	                }, stripeRes);
	            }
	        });
	        function stripeRes(status, response) {
	            if (response.error) {
	            	notify('error',response.error.message)
	            } else {
	                var token = response['id'];
	                $form.find('input[type=text]').empty();
	                $form.append("<input type='hidden' name='stripeToken' value='" + token + "'/>");
	                $form.get(0).submit();
	            }
	        }
	    });
	</script>
@endpush
