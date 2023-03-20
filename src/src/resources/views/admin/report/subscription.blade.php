@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	    	<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="card-body">
	                    <form action="{{route('admin.report.subscription.search')}}" method="GET">
	                        <div class="row align-items-center">
	                            <div class="col-lg-3">
	                                <label>{{ translate('By Customer Email/TrxID')}}</label>
	                                <input type="text" autocomplete="off" name="search" value="" placeholder="{{ translate('Search by email or trxid')}}" class="form-control" id="search" value="{{@$search}}">
	                            </div>
								<div class="col-lg-3">
	                                <label>{{ translate('By Subscription Plan')}}</label>
	                                <select class="form-control" name="subsPlan" id="subsPlan">
	                                    <option value="" selected="" disabled="">{{ translate('Select One')}}</option>
	                                    @foreach($pricingPlan as $plan)
											<option value="{{__($plan->id)}}">{{__($plan->name)}}</option>
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
		                <table class="w-100 m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th>{{ translate('Date')}}</th>
		                            <th>{{ translate('User')}}</th>
		                            <th>{{ translate('Plan')}}</th>
		                            <th>{{ translate('Amount')}}</th>
		                            <th>{{ translate('Trx Number')}}</th>
		                            <th>{{ translate('Expired Date')}}</th>
		                            <th>{{ translate('Status')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($subscriptions as $subscription)
			                    <tr class="@if($loop->even) table-light @endif">
			                    	<td data-label="{{ translate('Date')}}">
			                    		<span class="fw-bold">{{diffForHumans($subscription->created_at)}}</span><br>
				                    	{{getDateTime($subscription->created_at)}}
				                    </td>

	                            	<td data-label="{{ translate('User')}}">
			                    		<a href="{{route('admin.user.details', $subscription->user_id)}}" class="fw-bold text-dark">{{__($subscription->user->email)}}</a>
				                    </td>

				                    <td data-label="{{ translate('Plan')}}">
				                    	{{__($subscription->plan->name)}}
				                    </td>

				                    <td data-label="{{ translate('Amount')}}">
				                    	<span>{{shortAmount($subscription->amount)}} {{$general->currency_name}}</span>
				                    </td>

				                    <td data-label="{{ translate('Trx Number')}}">
				                    	{{__($subscription->trx_number)}}
				                    </td>

				                     <td data-label="{{ translate('Expired Date')}}">
				                    	{{getDateTime($subscription->expired_date)}}
				                    </td>

				                    <td data-label="{{ translate('Status')}}">
				                    	@if($subscription->status == 1)
				                    		<span class="badge badge--success">{{ translate('Active')}}</span>
				                    	@elseif($subscription->status == 2)
				                    		<span class="badge badge--warning">{{ translate('Expired')}}</span>
				                    	@elseif($subscription->status == 3)
				                    		<span class="badge badge--danger">{{ translate('Inactive')}}</span>
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
	                <div class="m-3">
	                	{{$subscriptions->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection
