@extends('user.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	    	<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="card-body">
	                    <form action="{{route('user.transaction.search')}}" method="GET">
	                        <div class="row align-items-center">
	                            <div class="col-lg-3">
	                                <label> {{ translate('By TrxID')}}</label>
	                                <input type="text" autocomplete="off" name="search" value="" placeholder=" {{ translate('Search by trxid')}}" class="form-control" id="search" value="{{@$search}}">
	                            </div>
								<div class="col-lg-3">
	                                <label> {{ translate('By Payment Method')}}</label>
	                                <select class="form-control" name="paymentMethod" id="paymentMethod">
	                                    <option value="" selected="" disabled=""> {{ translate('Select One')}}</option>
	                                    @foreach($paymentMethods as $paymentMethod)
											<option value="{{__($paymentMethod->id)}}">{{__($paymentMethod->name)}}</option>
										@endforeach
	                                </select>
	                            </div>
	                            <div class="col-lg-3">
	                                <label> {{ translate('By Date')}}</label>
	                                <input type="text" class="form-control datepicker-here" name="date" value="{{@$searchDate}}" data-range="true" data-multiple-dates-separator=" - " data-language="en" data-position="bottom right" autocomplete="off" placeholder=" {{ translate('From Date-To Date')}}" id="date">
	                            </div>
	                            <div class="col-lg-3">
	                                <button class="btn btn--primary w-100 h-45 mt-4" type="submit">
	                                    <i class="fas fa-search"></i>  {{ translate('Search')}}
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
		                           	<th> {{ translate('Date')}}</th>
	                                <th> {{ translate('Trx Number')}}</th>
	                                <th> {{ translate('Amount')}}</th>
	                                <th> {{ translate('Detail')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($transactions as $transaction)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label=" {{ translate('Date')}}">
				                    	<span>{{diffForHumans($transaction->created_at)}}</span><br>
				                    	{{getDateTime($transaction->created_at)}}
				                    </td>

				                    <td data-label=" {{ translate('Trx Number')}}">
				                    	{{__($transaction->transaction_number)}}
				                    </td>

				                    <td data-label=" {{ translate('Amount')}}">
				                    	<span class="@if($transaction->transaction_type == '+')text--success @else text--danger @endif">{{ $transaction->transaction_type }} {{shortAmount($transaction->amount)}} {{$general->currency_name}}
	                                    </span>
				                    </td>

				                    <td data-label=" {{ translate('Details')}}">
				                    	{{__($transaction->details) }}
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
						{{$transactions->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection









