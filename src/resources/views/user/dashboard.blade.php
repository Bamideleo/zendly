@extends('user.layouts.app')
@section('panel')
<section class="mt-3">
        <!-- <div class="rounded_box">
            <div class="parent_pinned_project">
                <a href="javascript:void(0);" class="single_pinned_project">
                    <div class="pinned_icon">
                        <i class="las la-sms"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Remaining SMS Credit')}}</h6>
                            <p>{{auth()->user()->credit}}</p>
                        </div>
                    </div>
                </a>
                <a href="javascript:void(0);" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="las la-envelope"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Remaining Email Credit')}}</h6>
                            <p>{{auth()->user()->email_credit}}</p>
                        </div>
                    </div>
                </a>
                <a href="javascript:void(0);" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                       <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Remaining WhatsApp Credit')}}</h6>
                            <p>{{auth()->user()->whatsapp_credit}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.sms.index')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="las la-comment"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total SMS')}}</h6>
                            <p>{{$smslog['all']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.sms.pending')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="las la-comment-dots"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Pending SMS')}}</h6>
                            <p>{{$smslog['pending']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.sms.delivered')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="las la-comment-alt"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Delivered SMS')}}</h6>
                            <p>{{$smslog['success']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.sms.failed')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="las la-comment-dots"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Failed SMS')}}</h6>
                            <p>{{$smslog['fail']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.manage.email.index')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="las la-envelope"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Email')}}</h6>
                            <p>{{$emailLog['all']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.manage.email.pending')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="las la-envelope-open"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Pending Email')}}</h6>
                            <p>{{$emailLog['pending']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.manage.email.delivered')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                       <i class="las la-envelope-square"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Delivered Email')}}</h6>
                            <p>{{$emailLog['success']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.manage.email.failed')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="las la-envelope-square"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Failed Email')}}</h6>
                            <p>{{$emailLog['fail']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.whatsapp.index')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total WhatsApp Message')}}</h6>
                            <p>{{$whatsappLog['all']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.whatsapp.pending')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Pending WhatsApp Message')}}</h6>
                            <p>{{$whatsappLog['pending']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.whatsapp.delivered')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Delivered WhatsApp Message')}}</h6>
                            <p>{{$whatsappLog['success']}}</p>
                        </div>
                    </div>
                </a>

                <a href="{{route('user.whatsapp.failed')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6>{{ translate('Total Failed WhatsApp')}}</h6>
                            <p>{{$whatsappLog['fail']}}</p>
                        </div>
                    </div>
                </a>
            </div>
        </div> -->
    <div class="row row-cols-1 row-cols-md-2 g-4">
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Email Messages</h5>
       <div class="row">
       <div class="col-lg-6">
       <a href="javascript:void(0);" class="single_pinned_project">
                    <div class="pinned_icon">
                        <i class="fs-2 las la-envelope linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Remaining Email Credit')}}</h6>
                            <h4 class="fw-bold text-success">{{auth()->user()->email_credit}}</h4>
                        </div>
                    </div>
             </a>
       </div>

    <div class="col-lg-6">
    <a href="{{route('user.manage.email.index')}}" class="single_pinned_project">
                    <div class="pinned_icon">
                    <i class="fs-2 las la-envelope-open-text linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total Email')}}</h6>
                            <h4 class="fw-bold text-success">{{$emailLog['all']}}</h4>
                        </div>
                    </div>
                </a>
    </div>

    <div class="col-lg-6">
    <a href="{{route('user.manage.email.pending')}}" class="single_pinned_project">
                    <div class="pinned_icon">
                    <i class="fs-2 las la-envelope linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total Pending Email')}}</h6>
                            <h4 class="fw-bold text-success">{{$emailLog['pending']}}</h4>
                        </div>
                    </div>
                </a>
    </div>

    <div class="col-lg-6">
    <a href="{{route('user.manage.email.delivered')}}" class="single_pinned_project">
                    <div class="pinned_icon">
                    <i class="fs-2 las la-envelope-open linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total Delivered Email')}}</h6>
                            <h4 class="fw-bold text-success">{{$emailLog['success']}}</h4>
                        </div>
                    </div>
                </a>
    </div>

        <div class="col-lg-6">
        <a href="{{route('user.manage.email.failed')}}" class="single_pinned_project">
                            <div class="pinned_icon">
                                <i class="fs-2 las la-envelope-square facebook p-2 rounded"></i>
                            </div>
                            <div class="pinned_text">
                                <div>
                                    <h6 class="text-secondary">{{ translate('Total Failed Email')}}</h6>
                                    <h4 class="fw-bold text-danger">{{$emailLog['fail']}}</h4>
                                </div>
                            </div>
                        </a>
        </div>
        
        <div>&nbsp;</div>
        <div>&nbsp;</div>
       </div>
      </div>
    </div>
  </div>
  
  <div class="col">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Whatsapp Messages</h5>
        <div class="row">
        <div class="col-lg-6">
        <a href="javascript:void(0);" class="single_pinned_project">
                    <div class="pinned_icon">
                       <i class="fs-2 las fab fa-whatsapp linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Remaining WhatsApp Credit')}}</h6>
                            <h4 class="fw-bold text-success">{{auth()->user()->whatsapp_credit}}</h4>
                        </div>
                    </div>
                </a>
        </div>
        <div class="col-lg-6">
        <a href="{{route('user.whatsapp.index')}}" class="single_pinned_project">
                    <div class="pinned_icon">
                    <i class="fs-2 las fab fa-whatsapp linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total WhatsApp Message')}}</h6>
                            <h4 class="fw-bold text-success">{{$whatsappLog['all']}}</h4>
                        </div>
                    </div>
                </a>
        </div>
        <div class="col-lg-6">
        <a href="{{route('user.whatsapp.pending')}}" class="single_pinned_project">
                    <div class="pinned_icon">
                    <i class="fs-2 las fab fa-whatsapp linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total Pending WhatsApp Message')}}</h6>
                            <h4 class="fw-bold text-success">{{$whatsappLog['pending']}}</h4>
                        </div>
                    </div>
                </a>

        </div>
        <div class="col-lg-6">
        <a href="{{route('user.whatsapp.delivered')}}" class="single_pinned_project">
                    <div class="pinned_icon">
                    <i class="fs-2 las fab fa-whatsapp linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total Delivered WhatsApp Message')}}</h6>
                            <h4 class="fw-bold text-success">{{$whatsappLog['success']}}</h4>
                        </div>
                    </div>
                </a>
        </div>
        <div class="col-lg-6">
        <a href="{{route('user.whatsapp.failed')}}" class="single_pinned_project">
                    <div class="pinned_icon">
                    <i class="fs-2 las fab fa-whatsapp facebook p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total Failed WhatsApp')}}</h6>
                            <h4 class="fw-bold text-danger">{{$whatsappLog['fail']}}</h4>
                        </div>
                    </div>
                </a>
        </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col">
    <div class="card">
      <div class="card-body">
      <h5 class="card-title">SMS Messages</h5>
      <div class="row">
      <div class="col-lg-6">
      <a href="javascript:void(0);" class="single_pinned_project">
                    <div class="pinned_icon">
                        <i class="fs-2 las la-sms linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Remaining SMS Credit')}}</h6>
                            <h4 class="fw-bold text-success">{{auth()->user()->credit}}</h4>
                        </div>
                    </div>
                </a>
              
      </div>

      <div class="col-lg-6">
      <a href="{{route('user.sms.index')}}" class="single_pinned_project">
                    <div class="pinned_icon">
                        <i class="fs-2 las la-comment linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total SMS')}}</h6>
                            <h4 class="fw-bold text-success">{{$smslog['all']}}</h4>
                        </div>
                    </div>
                </a>        
      </div>

      <div class="col-lg-6">
      <a href="{{route('user.sms.pending')}}" class="single_pinned_project shadow">
                    <div class="pinned_icon">
                        <i class="fs-2 las la-comment-dots linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total Pending SMS')}}</h6>
                            <h4 class="fw-bold text-success">{{$smslog['pending']}}</h4>
                        </div>
                    </div>
                </a>
 
      </div>

      <div class="col-lg-6">
      <a href="{{route('user.sms.delivered')}}" class="single_pinned_project">
                    <div class="pinned_icon"> 
                        <i class="fs-2 las la-comment-alt linkedin p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total Delivered SMS')}}</h6>
                            <h4 class="fw-bold text-success">{{$smslog['success']}}</h4>
                        </div>
                    </div>
                </a>     
      </div>

     <div class="col-lg-6">
      <a href="{{route('user.sms.failed')}}" class="single_pinned_project">
                    <div class="pinned_icon">
                        <i class="fs-2 las la-comment-dots facebook p-2 rounded"></i>
                    </div>
                    <div class="pinned_text">
                        <div>
                            <h6 class="text-secondary">{{ translate('Total Failed SMS')}}</h6>
                            <h4 class="fw-bold text-danger">{{$smslog['fail']}}</h4>
                        </div>
                    </div>
                </a>
      </div>

     </div>
      </div>
      <div>&nbsp;</div>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
        <div>&nbsp;</div>
        <!-- <div>&nbsp;</div> -->
    </div>
  </div>

  <div class="col">
    <div class="card">
      <div class="card-body">
        <iframe width="500" height="400" src="https://www.youtube.com/embed/IXT1mxPGGTo"  allowfullscreen></iframe>
      </div>
    </div>
  </div>
</div>
</section>


<!-- <section class="mt-3">
    <div class="rounded_box">
        <div class="row">
            <div class="col-12 col-lg-12 col-xl-6 p-1">
                 <h6 class="header-title">{{ translate('Latest Credit Log')}}</h6>
                <div class="responsive-table">
                    <table class="m-0 text-center table--light">
                        <thead>
                            <tr>
                                <th>{{ translate('Date')}}</th>
                                <th>{{ translate('Trx Number')}}</th>
                                <th>{{ translate('Credit')}}</th>
                                <th>{{ translate('Post Credit')}}</th>
                            </tr>
                        </thead>
                        @forelse($credits as $creditdata)
                            <tr class="@if($loop->even) table-light @endif">
                                <td data-label="{{ translate('Date')}}">
                                    <span>{{diffForHumans($creditdata->created_at)}}</span><br>
                                    {{getDateTime($creditdata->created_at)}}
                                </td>

                                <td data-label="{{ translate('Trx Number')}}">
                                    {{__($creditdata->trx_number)}}
                                </td>

                                <td data-label="{{ translate('Credit')}}">
                                    <span class="@if($creditdata->credit_type == '+')text--success @else text--danger @endif">{{ $creditdata->credit_type }} {{shortAmount($creditdata->credit)}}
                                    </span>{{ translate('Credit')}}
                                </td>

                                <td data-label="{{ translate('Post Credit')}}">
                                    {{__($creditdata->post_credit)}} {{ translate('Credit')}}
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
            <div class="col-12 col-lg-12 col-xl-6 p-1">
                <h6 class="header-title">{{ translate('Latest Transactions Log')}}</h6>
                <div class="responsive-table">
                    <table class="m-0 text-center table--light">
                        <thead>
                            <tr>
                                <th>{{ translate('Date')}}</th>
                                <th>{{ translate('Trx Number')}}</th>
                                <th>{{ translate('Amount')}}</th>
                                <th>{{ translate('Detail')}}</th>
                            </tr>
                        </thead>
                        @forelse($transactions as $transaction)
                            <tr class="@if($loop->even) table-light @endif">
                                <td data-label="{{ translate('Date')}}">
                                    <span>{{diffForHumans($transaction->created_at)}}</span><br>
                                    {{getDateTime($transaction->created_at)}}
                                </td>

                                <td data-label="{{ translate('Trx Number')}}">
                                    {{__($transaction->transaction_number)}}
                                </td>

                                <td data-label="{{ translate('Amount')}}">
                                    <span class="@if($transaction->transaction_type == '+')text--success @else text--danger @endif">{{ $transaction->transaction_type }} {{shortAmount($transaction->amount)}} {{__($general->currency_name)}}
                                    </span>
                                </td>

                                <td data-label="{{ translate('Details')}}">
                                    {{__($transaction->details)}}
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
</section> -->

<section class="mt-3">
    <div class="rounded_box">
        <div class="row">
            <div class="col-12 col-lg-12 p-1">
                <div class="rounded_box">
                    <h5 class="header-title">{{ translate('All sms report')}}</h5>
                    <canvas id="earning"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection


@push('scriptpush')
<script>
    "use strict";
    let earning = document.getElementById('earning').getContext('2d');
    const myChart2 = new Chart(earning, {
        type: 'bar',
        data: {
            labels: [@php echo "'".implode("', '", $smsReport['month']->toArray())."'" @endphp],
            datasets: [{
                label: '# {{ translate('Total SMS Send')}}',
                barThickness: 10,
                minBarLength: 2,
                data: [{{implode(",",$smsReport['month_sms']->toArray())}}],
                backgroundColor: [
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)',
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)',
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)',
                    'rgba(255, 99, 132)',
                    'rgba(54, 162, 235)',
                    'rgba(255, 206, 86)',
                    'rgba(75, 192, 192)',
                    'rgba(153, 102, 255)',
                    'rgba(255, 159, 64)'
                ]
            }]
        },
        options: {
            responsive: true,
    }
});
</script>
@endpush
