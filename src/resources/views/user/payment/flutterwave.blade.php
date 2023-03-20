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
                            @csrf
                            <div class="form-submit">
                                <button type="button" class="mt-3 btn btn--primary text-light payment-btn" id="btn-confirm" onClick="payWithFlutterwave()">{{ translate('Pay Now')}}</button>
                                <script
                                    src="https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js"></script>
                                <script>
                                    "use strict";
                                    var btn = document.querySelector("#btn-confirm");
                                    btn.setAttribute("type", "button");
                                    const API_publicKey = "{{$paymentMethod->payment_parameter->public_key}}";

                                    function payWithFlutterwave() {
                                        var x = getpaidSetup({
                                            PBFPubKey: API_publicKey,
                                            customer_email: "{{$paymentLog->user->email}}",
                                            amount: "{{round($paymentLog->final_amount, 2)}}",
                                            customer_phone: "",
                                            currency: "{{$paymentMethod->currency->name}}",
                                            txref: "{{trxNumber()}}",
                                            onclose: function () {
                                                notify('error','Transaction was not completed, window closed.');
                                            },
                                            callback: function (response) {
                                                var txref = response.tx.txRef;
                                                var status = response.tx.status;
                                                var chargeResponse = response.tx.chargeResponseCode;
                                                if (chargeResponse == "00" || chargeResponse == "0") {
                                                    window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                                } else {
                                                    window.location = '{{ url('ipn/flutterwave') }}/' + txref + '/' + status;
                                                }
                                                // x.close(); // use this to close the modal immediately after payment.
                                            }
                                        });
                                    }
                                </script>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
