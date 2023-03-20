@extends('user.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="responsive-table">
		                <table class="w-100 m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                           	<th> {{ translate('Date')}}</th>
	                                <th> {{ translate('Plan')}}</th>
	                                <th> {{ translate('Amount')}}</th>
	                                <th> {{ translate('SMS Credit')}}</th>
	                                <th> {{ translate('Remaing SMS Cr')}}</th>
	                                <th> {{ translate('Email Credit')}}</th>
	                                <th> {{ translate('Remaing Email Cr')}}</th>
									<th> {{ translate('Whatsapp Credit')}}</th>
	                                <th> {{ translate('Remaing Whatsapp Cr')}}</th>
	                                <th> {{ translate('Expired Date')}}</th>
	                                <th> {{ translate('Status')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($subscriptions as $subscription)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label=" {{ translate('Date')}}">
				                    	<span>{{diffForHumans($subscription->created_at)}}</span><br>
				                    	{{getDateTime($subscription->created_at)}}
				                    </td>

				                    <td data-label=" {{ translate('Plan')}}">
				                    	{{__($subscription->plan->name)}}
				                    </td>

				                    <td data-label=" {{ translate('Amount')}}">
				                    	{{$general->currency_symbol}}{{shortAmount($subscription->amount)}}
				                    </td>

				                    <td data-label=" {{ translate('SMS Credit')}}">
				                    	{{__($subscription->plan->credit)}}  {{ translate('Credit')}}
				                    </td>

				                    <td data-label=" {{ translate('Remaing SMS Credit')}}">
				                    	{{__(auth()->user()->credit)}}  {{ translate('Credit')}}
				                    </td>

				                    <td data-label=" {{ translate('Email Credit')}}">
				                    	{{__($subscription->plan->email_credit)}}  {{ translate('Credit')}}
				                    </td>

				                    <td data-label=" {{ translate('Remaing Email Credit')}}">
				                    	{{__(auth()->user()->email_credit)}}  {{ translate('Credit')}}
				                    </td>

									<td data-label=" {{ translate('Whatsapp Credit')}}">
				                    	{{__($subscription->plan->whatsapp_credit)}}  {{ translate('Credit')}}
				                    </td>

				                    <td data-label=" {{ translate('Remaing Whatsapp Credit')}}">
				                    	{{__(auth()->user()->whatsapp_credit)}}  {{ translate('Credit')}}
				                    </td>


				                    <td data-label=" {{ translate('Expired')}}">
				                    	{{getDateTime($subscription->expired_date)}}
				                    </td>

				                    <td data-label=" {{ translate('Status')}}">
				                    	@if($subscription->status == 1)
				                    		<span class="badge badge--success"> {{ translate('Active')}}</span>
				                    	@elseif($subscription->status == 2)
				                    		<span class="badge badge--warning"> {{ translate('Expired')}}</span>
				                    	@elseif($subscription->status == 3)
				                    		<span class="badge badge--primary"> {{ translate('Requested')}}</span>
				                    	@elseif($subscription->status == 4)
				                    		<span class="badge badge--danger"> {{ translate('Inactive')}}</span>
				                    	@endif
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%"> {{ translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
		            </div>
		            <div class="m-3">
						{{$subscriptions->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection







