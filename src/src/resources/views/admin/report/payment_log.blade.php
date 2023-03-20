@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	    	<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="card-body">
	                    <form action="{{route('admin.report.payment.search')}}" method="GET">
	                        <div class="row align-items-center">
	                            <div class="col-lg-3">
	                                <label>{{ translate('By Customer Email/TrxID')}}</label>
	                                <input type="text" autocomplete="off" name="search" value="" placeholder="{{ translate('Search by cusotmer email or trxid')}}" class="form-control" id="search" value="{{@$search}}">
	                            </div>
								<div class="col-lg-3">
	                                <label>{{ translate('By Payment Method')}}</label>
	                                <select class="form-control" name="paymentMethod" id="paymentMethod">
	                                    <option value="" selected="" disabled="">{{ translate('Select One')}}</option>
	                                    @foreach($paymentMethods as $paymentMethod)
											<option value="{{__($paymentMethod->id)}}">{{__($paymentMethod->name)}}</option>
										@endforeach
	                                </select>
	                            </div>
	                            <div class="col-lg-3">
	                                <label>{{ translate('By Date')}}</label>
	                                <input type="text" class="form-control datepicker-here" name="date" value="{{@$searchDate}}" data-range="true" data-multiple-dates-separator=" - " data-language="en" data-position="bottom right" autocomplete="off" placeholder="{{ translate('From Date-To Date')}}" id="date">
	                            </div>
	                            <div class="col-lg-3">
	                                <button class="btn btn--primary w-100 h-45 mt-4" type="submit">
	                                    <i class="fas fa-search"></i> {{ translate('Search')}}
	                                </button>
	                            </div>
	                        </div>
	                    </form>
	                </div>
	            </div>
	        </div>

	 		<div class="col-lg-12">
	            <div class="card mb-4">
					<div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                           	<th>{{ translate('Time')}}</th>
		                           	<th>{{ translate('User')}}</th>
	                                <th>{{ translate('Method')}}</th>
	                                <th>{{ translate('Amount')}}</th>
	                                <th>{{ translate('Final Amount')}}</th>
	                                <th>{{ translate('Transaction Number')}}</th>
	                                <th>{{ translate('Status')}}</th>
	                                <th>{{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($paymentLogs as $paymentLog)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label="{{ translate('Time')}}">
				                    	<span>{{diffForHumans($paymentLog->created_at)}}</span><br>
				                    	{{getDateTime($paymentLog->created_at)}}
				                    </td>

				                    <td data-label="{{ translate('User')}}">
				                    	<a href="{{route('admin.user.details', $paymentLog->user_id)}}" class="fw-bold text-dark">{{__(@$paymentLog->user->email)}}</a>
				                    </td>

				                    <td data-label="{{ translate('Method')}}">
				                    	{{__($paymentLog->paymentGateway->name)}}
				                    </td>

				                    <td data-label="{{ translate('Amount')}}">
				                    	{{shortAmount($paymentLog->amount)}} {{__($general->currency_name)}}
				                    </td>

				                    <td data-label="{{ translate('Final Amount')}}">
				                    	<span class="text--success fw-bold">{{shortAmount($paymentLog->final_amount)}} {{__($paymentLog->paymentGateway->currency->name)}}</span>
				                    </td>

				                     <td data-label="{{ translate('Trx Number')}}">
				                    	{{__($paymentLog->trx_number)}}
				                    </td>

				                    <td data-label="{{ translate('Status')}}">
				                    	@if($paymentLog->status == 1)
				                    		<span class="badge badge--primary">{{ translate('Pending')}}</span>
				                    	@elseif($paymentLog->status == 2)
				                    		<span class="badge badge--success">{{ translate('Received')}}</span>
				                    	@elseif($paymentLog->status == 3)
				                    		<span class="badge badge--danger">{{ translate('Rejected')}}</span>
				                    	@endif
				                    </td>

				                    <td data-label="{{ translate('Action')}}">
				                    	<a href="{{route('admin.report.payment.detail', $paymentLog->id)}}" class="s_btn--primary text-light"><i class="las la-desktop"></i></a>
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%">{{ translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
		            </div>
	                <div class="m-3">
	                	{{$paymentLogs->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection



