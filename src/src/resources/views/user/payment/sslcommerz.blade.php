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
                        <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('user.payment.with.ssl')}}" >
                            @csrf
                             <button type="submit" class="btn btn--primary text-light" id="sslczPayBtn">{{ translate('Pay Now')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
