@extends('user.layouts.app')
@section('panel')
@push('script-include')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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
                        <div class="form-submit">
                            <button type="submit" class="mt-3 btn btn--primary text-light payment-btn" id="JsCheckoutPayment">{{ translate('Pay with Razorpay')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scriptpush')
<script type="text/javascript">
        "use strict";
        var options = {
                "key": "{{$paymentMethod->payment_parameter->key_id}}",
                "amount": "{{$paymentLog->final_amount}}",
                "currency": "{{$paymentMethod->currency->name}}",
                "name": "{{__($general->site_name)}}",
                "description": "Test Transaction",
                "image": "{{showImage(filePath()['site_logo']['path'].'/site_logo.png')}}",
                "order_id": "{{$order->id}}",
                "callback_url": "{{route('user.razorpay')}}",
                "prefill": {
                    "name": "{{Auth::user()->name}}",
                    "email": "{{Auth::user()->email}}",
                    "contact": ""
                },
                "notes": {
                    "address": "{{Auth::user()->address}}"
                },
                "theme": {
                    "color": "#3399cc"
                }
            };

        var rzp1 = new Razorpay(options);
        $("#JsCheckoutPayment").on("click",function(e){
            console.log('dfd')
            rzp1.open();
            e.preventDefault();
        });
</script>
@endpush
