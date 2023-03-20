@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="rounded_box">
        <div class="row ">
            <div class="col-12 col-md-6 col-lg-6 col-xl-4 my-1 px-1">
                <div class="shadow p-3">
                    <div class="row">
                        <div class="col-2">
                            <i class="fs-2 las la-comment facebook p-2 rounded"></i>
                        </div>
                        <div class="col-7">
                            <h6 class="text-secondary">{{ translate('Total SMS')}}</h6>
                            <h4 class="fw-bold text-danger">{{$smslog['all']}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xl-4 my-1 px-1">
                <div class="shadow p-3">
                    <div class="row">
                        <div class="col-2">
                            <i class="fs-2 las la-comment-alt facebook p-2 rounded"></i>
                        </div>
                        <div class="col-7">
                            <h6 class="text-secondary">{{ translate('Total Success SMS')}}</h6>
                            <h4 class="fw-bold text-success">{{$smslog['success']}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6 col-xl-4 my-1 px-1">
                <div class="shadow p-3">
                    <div class="row">
                        <div class="col-2">
                            <i class="fs-2 las la-inbox facebook p-2 rounded"></i>
                        </div>
                        <div class="col-7">
                            <h6 class="text-secondary">{{ translate('Total SMS Contact')}}</h6>
                            <h4 class="fw-bold text-danger">{{$phonebook['contact']}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6 col-xl-4 my-1 px-1">
                <div class="shadow p-3">
                    <div class="row">
                        <div class="col-2">
                            <i class="fs-2 las la-envelope linkedin p-2 rounded"></i>
                        </div>
                        <div class="col-7">
                            <h6 class="text-secondary">{{ translate('Total Email')}}</h6>
                            <h4 class="fw-bold text-success">{{$emailLog['all']}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6 col-xl-4 my-1 px-1">
                <div class="shadow p-3">
                    <div class="row">
                        <div class="col-2">
                            <i class="fs-2 las la-envelope-open linkedin p-2 rounded"></i>
                        </div>
                        <div class="col-7">
                            <h6 class="text-secondary">{{ translate('Total Success Email')}}</h6>
                            <h4 class="fw-bold text-success">{{$emailLog['success']}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6 col-xl-4 my-1 px-1">
                <div class="shadow p-3">
                    <div class="row">
                        <div class="col-2">
                            <i class="fs-2 las la-envelope-open-text linkedin p-2 rounded"></i>
                        </div>
                        <div class="col-7">
                            <h6 class="text-secondary">{{ translate('Total Email Contact')}}</h6>
                            <h4 class="fw-bold text-success">{{$phonebook['email_contact']}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6 col-xl-4 my-1 px-1">
                <div class="shadow p-3">
                    <div class="row">
                        <div class="col-2">
                            <i class="fs-2 las fab fa-whatsapp facebook p-2 rounded"></i>
                        </div>
                        <div class="col-7">
                            <h6 class="text-secondary">{{ translate('Total Sent WhatsApp Message')}}</h6>
                            <h4 class="fw-bold text-danger">{{$whatsappLog['all']}}</h4>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6 col-xl-4 my-1 px-1">
                <div class="shadow p-3">
                    <div class="row">
                        <div class="col-2">
                            <i class="fs-2 las fab fa-whatsapp facebook p-2 rounded"></i>
                        </div>
                        <div class="col-7">
                            <h6 class="text-secondary">{{ translate('Total Success WhatsApp Message')}}</h6>
                            <h4 class="fw-bold text-success">{{$whatsappLog['success']}}</h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-md-6 col-lg-6 col-xl-4 my-1 px-1">
                <div class="shadow p-3">
                    <div class="row">
                        <div class="col-2">
                            <i class="fs-2 las fab fa-whatsapp facebook p-2 rounded"></i>
                        </div>
                        <div class="col-7">
                            <h6 class="text-secondary">{{ translate('Total Pending WhatsApp Message')}}</h6>
                            <h4 class="fw-bold text-danger">{{$whatsappLog['pending']}}</h4>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>


<section class="mt-3">
    <div class="rounded_box">
        <div class="parent_pinned_project">
            <a href="{{route('admin.user.index')}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="las la-user"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total User')}}</h6>
                        <p>{{$phonebook['user']}}{{ translate('User')}}</p>
                    </div>
                </div>
            </a>
            <a href="{{route('admin.plan.index')}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="lab la-telegram-plane"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Pricing Plan')}}</h6>
                        <p>{{$phonebook['plan']}} {{ translate('Plan')}}</p>
                    </div>
                </div>
            </a>

            <a href="{{route('admin.report.subscription.index')}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="las la-credit-card"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Subscription User')}}</h6>
                        <p>{{$phonebook['subscription']}}</p>
                    </div>
                </div>
            </a>

            <a href="{{route('admin.gateway.sms.index')}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="las la-angle-double-right"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total SMS Api Gateway')}}</h6>
                        <p>{{$phonebook['sms_gateway']}}</p>
                    </div>
                </div>
            </a>

            <a href="{{route('admin.gateway.sms.android.index')}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                   <i class="lab la-android"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Android Gateway')}}</h6>
                        <p>{{$phonebook['android_api']}} {{ translate('Android Gateway')}}</p>
                    </div>
                </div>
            </a>
            <a href="{{route('admin.report.credit.index')}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="las la-money-bill-wave-alt"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Credit Log')}}</h6>
                        <p>{{$phonebook['credit_log']}} {{ translate('Logs')}}</p>
                    </div>
                </div>
            </a>
            <a href="{{route('admin.report.payment.index')}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                   <i class="las la-credit-card"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Payment History')}}</h6>
                        <p>{{shortAmount($phonebook['payment_log'])}} {{ translate('Logs')}}</p>
                    </div>
                </div>
            </a>
            <a href="{{route('admin.report.transaction.index')}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="las la-wallet"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Transaction History')}}</h6>
                        <p>{{$phonebook['transaction']}} {{ translate('Log')}}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>


 <section class="mt-2">
    <div class="rounded_box">
        <div class="row">
            <div class="col-md-6">
                <div class="header-title">
                    <h6 class="text--dark">{{ translate('SMS Details Report')}}</h6>
                    <div id="chart30"></div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="new-card-container">
                    <div class="new-card">
                        <div class="new-card-icon-container icon-container-bg d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-credit-card"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{__($general->currency_symbol)}}{{shortAmount($phonebook['payment_amount'])}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Total Payment')}}</span>
                    </div>

                    <div class="new-card">
                        <div class="new-card-icon-container icon-container-bg3 d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-wallet"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{__($general->currency_symbol)}}{{shortAmount($phonebook['payment_amount_charge'])}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Payment Charge')}}</span>
                    </div>

                    <div class="new-card">
                        <div class="new-card-icon-container icon-container-bg2 d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-coins"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{__($general->currency_symbol)}}{{shortAmount($phonebook['subscription_amount'])}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Subscription Amount')}}</span>
                    </div>

                    <div class="new-card">
                        <div class="new-card-icon-container icon-container-bg4 d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-user"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{$phonebook['subscription']}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Subscription User')}}</span>
                    </div>

                    <div class="new-card">
                        <div class="new-card-icon-container icon-container-bg5 d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-sms"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{$smslog['pending']}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Pending SMS')}}</span>
                    </div>

                    <div class="new-card">
                        <div class="new-card-icon-container icon-container-bg6 d--flex align--center justify--between p-2">
                            <i class="fs-4 las la-envelope"></i>
                            <i class="fs-4 las la-ellipsis-h"></i>
                        </div>
                        <h4 class="my-3">{{$emailLog['pending']}}</h4>
                        <span class="mb-3 text-secondary">{{ translate('Pending Email')}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="mt-3">
    <div class="rounded_box">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12 col-xl-6 p-1">
                <h6 class="header-title">{{ translate('New User')}}</h6>
                <div class="responsive-table">
                    <table class="m-0 text-center table--light">
                        <thead>
                            <tr>
                                <th>{{ translate('Customer')}}</th>
                                <th>{{ translate('Email - Phone')}}</th>
                                <th>{{ translate('Status')}}</th>
                                <th>{{ translate('Joined At')}}</th>
                            </tr>
                        </thead>
                        @forelse($customers as $customer)
                            <tr class="@if($loop->even) table-light @endif">
                                <td data-label="{{ translate('Customer')}}">
                                    <a href="{{route('admin.user.details', $customer->id)}}" class="brand" data-bs-toggle="tooltip" data-bs-placement="top" title="{{ translate('Click For Details')}}">
                                        {{__($customer->name)}}<br>
                                    </a>
                                </td>
                                <td data-label="{{ translate('Email')}}">
                                    {{__($customer->email)}}<br>
                                    {{__($customer->phone)}}
                                </td>

                                <td data-label="{{ translate('Status')}}">
                                    @if($customer->status == 1)
                                        <span class="badge badge--success">{{ translate('Active')}}</span>
                                    @else
                                        <span class="badge badge--danger">{{ translate('Banned')}}</span>
                                    @endif
                                </td>

                                <td data-label="{{ translate('Joined At')}}">
                                    {{diffForHumans($customer->created_at)}}<br>
                                    {{getDateTime($customer->created_at)}}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ translate('No Data Found')}}</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>

            <div class="col-12 col-md-12 col-lg-12 col-xl-6 p-1">
                <h6 class="header-title">{{ translate('Latest Payment Log')}}</h6>
                <div class="responsive-table">
                    <table class="m-0 text-center table--light">
                        <thead>
                            <tr>
                                <th>{{ translate('Time')}}</th>
                                <th>{{ translate('User')}}</th>
                                <th>{{ translate('Amount')}}</th>
                                <th>{{ translate('Final Amount')}}</th>
                                <th>{{ translate('TrxID')}}</th>
                            </tr>
                        </thead>
                        @forelse($paymentLogs as $paymentLog)
                            <tr class="@if($loop->even) table-light @endif">
                                <td data-label="{{ translate('Time')}}">
                                    <span>{{diffForHumans($paymentLog->created_at)}}</span><br>
                                    {{getDateTime($paymentLog->created_at)}}
                                </td>

                                <td data-label="{{ translate('User')}}">
                                    <a href="{{route('admin.user.details', $paymentLog->user_id)}}" class="fw-bold text-dark">{{__(@$paymentLog->user->name)}}</a>
                                </td>

                                <td data-label="{{ translate('Amount')}}">
                                    {{shortAmount($paymentLog->amount)}} {{__($general->currency_name)}}
                                    <br>
                                    {{__($paymentLog->paymentGateway->name)}}
                                </td>

                                <td data-label="{{ translate('Final Amount')}}">
                                    <span class="text--success fw-bold">{{shortAmount($paymentLog->final_amount)}} {{__($paymentLog->paymentGateway->currency->name)}}</span>
                                </td>

                                 <td data-label="{{ translate('TrxID')}}">
                                    {{$paymentLog->trx_number}} <br>
                                    @if($paymentLog->status == 1)
                                        <span class="badge badge--primary">{{ translate('Pending')}}</span>
                                    @elseif($paymentLog->status == 2)
                                        <span class="badge badge--success">{{ translate('Received')}}</span>
                                    @elseif($paymentLog->status == 3)
                                        <span class="badge badge--danger">{{ translate('Rejected')}}</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-muted text-center" colspan="100%">{{ translate('No Data Found')}}</td>
                            </tr>
                        @endforelse
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scriptpush')
<script>
     var options = {
        series: [{
            name: 'Total SMS',
            type: 'column',
            data: [{{implode(",",$smsReport['month_sms']->toArray())}}]
        }],
        chart: {
            height: 400,
            type: 'line',
            stacked: false,
        },
        stroke:{
            width: [0, 2, 5],
            colors: ['#ffb800', '#cecece'],
            curve: 'smooth'
        },
        plotOptions:{
            bar:{
                columnWidth: '50%'
            }
        },
        fill:{
            opacity: [0.85, 0.25, 1],
            colors: ['#8b0dfd', '#c9b6ff'],
            gradient:{
                inverseColors: false,
                shade: 'light',
                type: "vertical",
                opacityFrom: 0.85,
                opacityTo: 1,
                stops: [0, 100, 100, 100]
            }
        },
        labels: @json($smsReport['month']->toArray()),
        markers: {
            size: 0
        },
        xaxis: {
            type: 'month'
        },
        yaxis: {
            title: {
                text: 'SMS',
            },
            min: 0
        },
        tooltip: {
            shared: true,
            intersect: false,
            y: {
                formatter: function (y) {
                    if(typeof y !== "undefined") {
                        return y.toFixed(0) + " sms";
                    }
                    return y;

                }
            }
        }
    };
    var chart = new ApexCharts(document.querySelector("#chart30"), options);
    chart.render();
</script>
@endpush
