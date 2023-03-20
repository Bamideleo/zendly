@extends('user.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	    	<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="card-body">
	                    <form action="{{route('user.sms.search',$scope ?? str_replace('user.sms.', '', request()->route()->getName()))}}" method="GET">
	                        <div class="row align-items-center">
	                            <div class="col-lg-5">
	                                <label>{{ translate('By Contacts')}}</label>
	                                <input type="text" autocomplete="off" name="search" value="" placeholder="{{ translate('Search with contacts number')}}" class="form-control" id="search" value="{{@$search}}">
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
		                            <th>{{ translate('#')}}</th>
		                            <th>{{ translate('To')}}</th>
		                            <th>{{ translate('Credit')}}</th>
		                            <th>{{ translate('Initiated') }}</th>
		                            <th>{{ translate('Status') }}</th>
		                            <th>{{ translate('Action') }}</th>
		                        </tr>
		                    </thead>
		                    @forelse($smslogs as $smsLog)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label="{{ translate('#')}}">
				                    	{{$loop->iteration}}
				                    </td>

				                    <td data-label="{{ translate('To')}}">
				                    	{{$smsLog->to}}
				                    </td>

				                     <td data-label="{{ translate('Credit')}}">
				                    	@php
									        $messages = str_split($smsLog->message,160);
									        $totalMessage = count($messages);
									    @endphp
									    {{$totalMessage}} {{ translate('Credit')}}
				                    </td>

				                    <td data-label="{{ translate('Initiated')}}">
				                    	{{getDateTime($smsLog->initiated_time)}}
				                    </td>

				                    <td data-label="{{ translate('Status')}}">
				                    	@if($smsLog->status == 1)
				                    		<span class="badge badge--primary">{{ translate('Pending ')}}</span>
				                    	@elseif($smsLog->status == 2)
				                    		<span class="badge badge--info">{{ translate('Schedule')}}</span>
				                    	@elseif($smsLog->status == 3)
				                    		<span class="badge badge--danger">{{ translate('Fail')}}</span>
				                    	@else
				                    		<span class="badge badge--success">{{ translate('Delivered')}}</span>
				                    	@endif
				                    </td>

				                    <td data-label={{ translate('Action')}}>
			                    		<a class="btn--primary text--light details"
			                    		data-message="{{$smsLog->message}}"
			                    		data-bs-toggle="tooltip"
			                    		data-bs-placement="top" title="Details"
			                    		data-bs-toggle="modal"
			                    		data-bs-target="#smsdetails"
				                    		><i class="las la-desktop"></i></a>
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
	                	{{$smslogs->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>


<div class="modal fade" id="smsdetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            	<div class="card">
            		<div class="card-header bg--lite--violet">
            			<div class="card-title text-center text--light">{{ translate('Message')}}</div>
            		</div>
        			<div class="card-body mb-3">
        				<p id="message--text"></p>
        			</div>
        		</div>
        	</div>

            <div class="modal_button2">
                <button type="button" class="w-100" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scriptpush')
<script>
	(function($){
		"use strict";
		$('.details').on('click', function(){
			var modal = $('#smsdetails');
			var message = $(this).data('message');
			$("#message--text").text(message);
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush
