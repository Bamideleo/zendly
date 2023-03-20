@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	    	<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="card-body">
	                    <form action="{{route('admin.user.search', $scope ?? str_replace('admin.user.','',request()->route()->getName()))}}" method="GET">
	                        <div class="row align-items-center">
	                            <div class="col-lg-5">
	                                <label>{{ translate('By User Or Email') }}</label>
	                                <input type="text" autocomplete="off" name="search" value="" placeholder="@lang('Search with User, Email or To Recipient number')" class="form-control" id="search" value="{{@$search}}">
	                            </div>
	                            <div class="col-lg-5">
	                                <label>{{ translate('By Date')}}</label>
	                                <input type="text" class="form-control datepicker-here" name="date" value="{{@$searchDate}}" data-range="true" data-multiple-dates-separator=" - " data-language="en" data-position="bottom right" autocomplete="off" placeholder="@lang('From Date-To Date')" id="date">
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
		                            <th>{{ translate('Customer')}}</th>
		                            <th>{{ translate('Email - Phone')}}</th>
		                            <th>{{ translate('Status')}}</th>
		                            <th>{{ translate('Joined At')}}</th>
		                            <th>{{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($customers as $customer)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label="{{ translate('Customer')}}">
				                    	{{$customer->name ?? 'N/A'}}
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

				                    <td data-label={{ translate('Action')}}>
			                    		<a href="{{route('admin.user.details', $customer->id)}}" class="btn--primary text--light brand" data-bs-toggle="tooltip" data-bs-placement="top" title="Details"><i class="las la-desktop"></i></a>
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
						{{$customers->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection
