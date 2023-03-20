@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	    	<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="card-body">
	                    <form action="{{route('admin.email.search',$scope ?? str_replace('admin.email.', '', request()->route()->getName()))}}" method="GET">
	                        <div class="row align-items-center">
	                            <div class="col-lg-5">
	                                <label> {{ translate('By User/Email/To Recipient Email') }}</label>
	                                <input type="text" autocomplete="off" name="search" value="" placeholder="@lang('Search with User, Email or To Recipient Email')" class="form-control" id="search" value="{{@$search}}">
	                            </div>
	                            <div class="col-lg-5">
	                                <label>
                                        {{ translate('By Date') }}
                                    </label>
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
		                            <th> {{ translate('#')}}</th>
		                            <th> {{ translate('User')}}</th>
		                            <th> {{ translate('Sender')}}</th>
		                            <th> {{ translate('To')}}</th>
		                            <th> {{ translate('Subject')}}</th>
		                            <th> {{ translate('Initiated')}}</th>
		                            <th> {{ translate('Status')}}</th>
		                            <th> {{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($emailLogs as $emailLog)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label=" {{ translate('#')}}">
				                    	{{$loop->iteration}}
				                    </td>

				                     <td data-label=" {{ translate('User')}}">
				                     	@if($emailLog->user_id)
				                    		<a href="{{route('admin.user.details', $emailLog->user_id)}}" class="fw-bold text-dark">{{__($emailLog->user->email)}}</a>
				                    	@else
				                    		<span> {{ translate('Admin')}}</span>
				                    	@endif
				                    </td>

				                    <td data-label=" {{ translate('Sender')}}">
				                      	<span class="text--primary fw-bold">{{ucfirst(@$emailLog->sender->name)}}</span>
				                    </td>

				                    <td data-label=" {{ translate('To')}}">
				                    	{{$emailLog->to}}
				                    </td>

				                    <td data-label=" {{ translate('Subject')}}">
				                    	{{$emailLog->subject}}
				                    </td>

				                    <td data-label=" {{ translate('Initiated')}}">
				                    	{{getDateTime($emailLog->initiated_time)}}
				                    </td>

				                    <td data-label=" {{ translate('Status')}}">
				                    	@if($emailLog->status == 1)
				                    		<span class="badge badge--primary"> {{ translate('Pending ')}}</span>
				                    	@elseif($emailLog->status == 2)
				                    		<span class="badge badge--info"> {{ translate('Schedule')}}</span>
				                    	@elseif($emailLog->status == 3)
				                    		<span class="badge badge--danger"> {{ translate('Fail')}}</span>
				                    	@else
				                    		<span class="badge badge--success"> {{ translate('Delivered')}}</span>
				                    	@endif
				                    	<a class="s_btn--coral text--light statusupdate"
				                    		data-id="{{$emailLog->id}}"
				                    		data-bs-toggle="tooltip"
				                    		data-bs-placement="top" title="Status Update"
				                    		data-bs-toggle="modal"
				                    		data-bs-target="#smsstatusupdate"
			                    			><i class="las la-info-circle"></i></a>
				                    </td>

				                    <td data-label=" {{ translate('Action')}}">
				                    	@if($emailLog->status == 1)
				                    		<a href="{{route('admin.email.single.mail.send', $emailLog->id)}}" class="btn--warning text--light" data-bs-toggle="tooltip" data-bs-placement="top" title="Resend" ><i class="las la-paper-plane"></i></a>
				                    	@endif
			                    		<a class="btn--primary text--light" href="{{route('admin.email.view',$emailLog->id)}}" target="_blank"
				                    		><i class="las la-desktop"></i></a>

				                    	<a href="javascript:void(0)" class="btn--danger text--light emaildelete"
				                    		data-bs-toggle="modal"
				                    		data-bs-target="#delete"
				                    		data-delete_id="{{$emailLog->id}}"
				                    		><i class="las la-trash"></i>
				                    	</a>
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
	                	{{$emailLogs->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>


<div class="modal fade" id="smsstatusupdate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.email.status.update')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light"> {{ translate('Email Status Update')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="status" class="form-label"> {{ translate('Status')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="status" id="status" required>
									<option value="" selected disabled> {{ translate('Select Status')}}</option>
									<option value="1"> {{ translate('Pending')}}</option>
									<option value="3"> {{ translate('Failed')}}</option>
								</select>
							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal"> {{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success"> {{ translate('Submit')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>


<div class="modal fade" id="smsdetails" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            	<div class="card">
            		<div class="card-header bg--lite--violet">
            			<div class="card-title text-center text--light"> {{ translate('Message')}}</div>
            		</div>
        			<div class="card-body mb-3">
        				<p id="message--text"></p>
        			</div>
        		</div>
        	</div>

            <div class="modal_button2">
                <button type="button" class="w-100" data-bs-dismiss="modal"> {{ translate('Cancel')}}</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('admin.email.delete')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id" value="">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash-alt"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6> {{ translate('Are you sure to delete this email from log')}}</h6>
	                </div>
	            </div>
	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal"> {{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--danger"> {{ translate('Delete')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
@endsection


@push('scriptpush')
<script>
	(function($){
		"use strict";
		$('.statusupdate').on('click', function(){
			var modal = $('#smsstatusupdate');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.modal('show');
		});

		// $('.details').on('click', function(){
		// 	var modal = $('#smsdetails');
		// 	var message = $(this).data('message');
		// 	$("#message--text").empty();
		// 	$("#message--text").append(message);
		// 	modal.modal('show');
		// });

		$('.emaildelete').on('click', function(){
			var modal = $('#delete');
			modal.find('input[name=id]').val($(this).data('delete_id'));
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush
