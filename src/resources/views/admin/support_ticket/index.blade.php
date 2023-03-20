@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	    	<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="card-body">
	                    <form action="{{route('admin.support.ticket.search',$scope ?? str_replace('admin.support.ticket.', '', request()->route()->getName()))}}" method="GET">
	                        <div class="row align-items-center">
	                            <div class="col-lg-3">
	                                <label>{{ translate('By Subject')}}</label>
	                                <input type="text" autocomplete="off" name="search" value="" placeholder="{{ translate('Search by subject')}}" class="form-control" id="search" value="{{@$search}}">
	                            </div>
	                            <div class="col-lg-2">
	                                <label>{{ translate('By Priority')}}</label>
	                                <select class="form-control" name="priority" id="priority">
	                                    <option value="" selected="" disabled="">{{ translate('Select One')}}</option>
										<option value="1">{{ translate('Running')}}</option>
										<option value="2">{{ translate('Answered')}}</option>
										<option value="3">{{ translate('Replied')}}</option>
										<option value="4">{{ translate('Closed')}}</option>
	                                </select>
	                            </div>
	                            <div class="col-lg-2">
	                                <label>{{ translate('By Status')}}</label>
	                                <select class="form-control" name="status" id="status">
	                                    <option value="" selected="" disabled="">{{ translate('Select One')}}</option>
										<option value="1">{{ translate('Low')}}</option>
										<option value="2">{{ translate('Medium')}}</option>
										<option value="3">{{ translate('High')}}</option>
	                                </select>
	                            </div>
	                            <div class="col-lg-3">
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
		                           	<th>{{ translate('Subject')}}</th>
	                                <th>{{ translate('Submitted By')}}</th>
	                                <th>{{ translate('Priority')}}</th>
	                                <th>{{ translate('Status')}}</th>
	                                <th>{{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($supportTickets as $supportTicket)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label="{{ translate('Date')}}">
				                    	<span>{{diffForHumans($supportTicket->created_at)}}</span><br>
				                    	{{getDateTime($supportTicket->created_at)}}
				                    </td>

				                    <td data-label="{{ translate('Subject')}}">
				                    	<span class="fw-bold"><a href="{{route('admin.support.ticket.details', $supportTicket->id)}}">{{$supportTicket->subject}}</a></span>
				                    </td>

				                    <td data-label="{{ translate('Submitted By')}}">
					                   	<a href="{{route('admin.user.details',$supportTicket->user_id)}}" class="fw-bold text-dark">{{__($supportTicket->user->email)}}</a>
				                    </td>

				                    <td data-label="{{ translate('Priority')}}">
				                    	@if($supportTicket->priority == 1)
				                    		<span class="badge badge--info">{{ translate('Low')}}</span>
				                    	@elseif($supportTicket->priority == 2)
				                    		<span class="badge badge--primary">{{ translate('Medium ')}}</span>
				                    	@elseif($supportTicket->priority == 3)
				                    		<span class="badge badge--success">{{ translate('High')}}</span>
				                    	@endif
				                    </td>

				                    <td data-label="{{ translate('Status')}}">
				                    	@if($supportTicket->status == 1)
				                    		<span class="badge badge--info">{{ translate('Running')}}</span>
				                    	@elseif($supportTicket->status == 2)
				                    		<span class="badge badge--primary">{{ translate('Answered')}}</span>
				                    	@elseif($supportTicket->status == 3)
				                    		<span class="badge badge--warning">{{ translate('Replied')}}</span>
				                    	@elseif($supportTicket->status == 4)
				                    		<span class="badge badge--danger">{{ translate('Closed')}}</span>
				                    	@endif
				                    </td>

				                    <td data-label="{{ translate("Action")}}">
				                    	<a href="{{route('admin.support.ticket.details', $supportTicket->id)}}" class="btn--primary text--light"><i class="las la-desktop"></i></a>
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
	                	{{$supportTickets->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection




