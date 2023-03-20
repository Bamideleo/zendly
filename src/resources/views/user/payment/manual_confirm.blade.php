@extends('user.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
    <div class="container-fluid p-0 mb-3 pb-2">
        <div class="row d-flex align--center rounded">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-header bg--lite--violet">
                        <h6 class="card-title text-center text-light">{{ translate('Payment with ') }} {{$paymentLog->paymentGateway->name}} -- {{shortAmount($paymentLog->final_amount)}} {{$paymentLog->paymentGateway->currency->name}}</h6>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{{route('user.manual.payment.update')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @if($paymentLog->paymentGateway->payment_parameter != null)
                                    @foreach($paymentLog->paymentGateway->payment_parameter as $key => $value)
                                        @if($key=="0")
                                        <p class="card-title text-center fs-3">{{ translate($value->payment_gw_info)}}</p>
                                        @endif
                                    @endforeach
                                @endif
                                @if($paymentLog->paymentGateway->payment_parameter != null)
                                    @foreach($paymentLog->paymentGateway->payment_parameter as $key => $value)
                                        @if($key!="0")
                                        <div class="row">
                                            @if($value->field_type == "text")
                                                <div class="mb-3 col-lg-12 col-md-12">
                                                    <label for="{{$value->field_name}}" class="form-label">{{ucfirst($value->field_label)}}</label>
                                                    <input type="text" name="{{$value->field_name}}" id="{{$value->field_name}}" class="form-control" placeholder="Enter {{ucfirst($value->field_label)}}">
                                                </div>
                                            @elseif($value->field_type == "file")
                                                <div class="mb-3 col-lg-12 col-md-12">
                                                    <label for="{{$value->field_name}}" class="form-label">{{ucfirst($value->field_label)}}</label>
                                                    <input type="file" name="{{$value->field_name}}" id="{{$value->field_name}}" class="form-control" placeholder="Enter {{ucfirst($value->field_label)}}">
                                                </div>

                                            @elseif($value->field_type == "textarea")
                                                <div class="mb-3 col-lg-12 col-md-12">
                                                    <label for="{{$value->field_name}}" class="form-label">{{ucfirst($value->field_label)}}</label>
                                                    <textarea type="text" name="{{$value->field_name}}" id="{{$value->field_name}}" class="form-control" placeholder="Enter {{ucfirst($value->field_label)}}"></textarea>
                                                </div>
                                            @endif
                                        </div>
                                        @endif
                                    @endforeach
                                @endif
                            </div>
                            <button type="submit" class="mt-3 btn btn--primary w-100 text-light">{{ translate('Confirm')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
