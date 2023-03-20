@extends('user.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	    	<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="card-body">
	                    <form action="{{route('user.credit.email.search')}}" method="GET">
	                        <div class="row align-items-center">
	                            <div class="col-lg-5">
	                                <label>{{ translate('By TrxID')}}</label>
	                                <input type="text" autocomplete="off" name="search" value="" placeholder="{{ translate('Search by trxid')}}" class="form-control" id="search" value="{{@$search}}">
	                            </div>

	                            <div class="col-lg-5">
	                                <label>{{ translate('By Date')}}</label>
	                                <input type="text" class="form-control datepicker-here" name="date" value="{{@$searchDate}}" data-range="true" data-multiple-dates-separator=" - " data-language="en" data-position="bottom right" autocomplete="off" placeholder="{{ translate('From Date-To Date')}}" id="date">
	                            </div>
	                            <div class="col-lg-2">
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
		                           	<th>{{ translate('Date')}}</th>
	                                <th>{{ translate('Trx Number')}}</th>
	                                <th>{{ translate('Credit')}}</th>
	                                <th>{{ translate('Post Credit')}}</th>
	                                <th>{{ translate('Detail')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($emailCredits as $emailCredit)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label="{{ translate('Date')}}">
				                    	<span>{{diffForHumans($emailCredit->created_at)}}</span><br>
				                    	{{getDateTime($emailCredit->created_at)}}
				                    </td>

				                    <td data-label="{{ translate('Trx Number')}}">
				                    	{{__($emailCredit->trx_number)}}
				                    </td>

				                    <td data-label="{{ translate('Credit')}}">
				                    	<span class="@if($emailCredit->type == '+')text--success @else text--danger @endif">{{ $emailCredit->type }} {{shortAmount($emailCredit->credit)}}
	                                    </span>{{ translate('Credit')}}
				                    </td>

				                    <td data-label="{{ translate('Post Credit')}}">
				                    	{{__($emailCredit->post_credit)}} {{ translate('Credit')}}
				                    </td>


				                    <td data-label="{{ translate('Details')}}">
				                    	{{__($emailCredit->details) }}
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
						{{$emailCredits->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection









