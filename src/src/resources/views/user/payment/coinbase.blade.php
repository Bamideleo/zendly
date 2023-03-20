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
                        <div class="form-submit">
                            <button type="submit" class="mt-3 btn btn--primary text-light payment-btn" id="JsCheckoutPayment">{{ translate('Pay with Coinbase')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scriptpush')
<script>
    'use strict';
    var paymentForm = document.getElementById('JsCheckoutPayment');
    paymentForm.addEventListener('submit', coinbaseCommerce, false);
    $('#JsCheckoutPayment').on('click',function(e){
        coinbaseCommerce(e);
    })
    function coinbaseCommerce(e){
        e.preventDefault();
        $("#JsCheckoutPayment").html('{{ translate("Please Wait")}}');
        $.ajax({
            url: "{{route('user.coinbase')}}",
            data: {"_token": "{{ csrf_token() }}"},
            type: 'get',
            dataType: 'JSON',
            success: function(response){
                $("#JsCheckoutPayment").html('{{ translate("Pay with Coinbase")}}');
                if (response.error) {
                    notify('error',response.message);
                    return;
                }
                window.location.href = response.redirect_url;
            }
        });
    }
</script>
@endpush
