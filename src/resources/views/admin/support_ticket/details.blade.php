@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="table_heading d-flex align--center justify--between">
                    <nav  aria-label="breadcrumb">
					  	<ol class="breadcrumb mt-3">
					    	<li class="breadcrumb-item">
					    		<a href="{{route('admin.support.ticket.index')}}">{{ translate('Support Ticket')}}</a>
					    	</li>
					    	<li class="breadcrumb-item" aria-current="page">
					    		@if($supportTicket->status == 1)
		                    		<span class="badge badge--info">{{ translate('Running')}}</span>
		                    	@elseif($supportTicket->status == 2)
		                    		<span class="badge badge--primary">{{ translate('Answered')}}</span>
		                    	@elseif($supportTicket->status == 3)
		                    		<span class="badge badge--warning">{{ translate('Replied')}}</span>
		                    	@elseif($supportTicket->status == 4)
		                    		<span class="badge badge--danger">{{ translate('Closed')}}</span>
		                    	@endif
					    		{{ translate('Ticket Number')}} - {{$supportTicket->ticket_number}}</li>
					  	</ol>
					</nav>
                    <a href="{{route('admin.support.ticket.index')}}" class="btn--dark text--light border-0 px-2 py-1 rounded ms-3"><i class="las la-angle-double-left"></i> @lang('Go Back')</a>
                </div>

				<div class="card">
					<div class="card-header bg--lite--violet">
						<div class="row">
                            <div class="col-lg-10 col-sm-10 col-md-6 mt-3">
					            <span class="card-title text-light">{{ translate('Reply to Customer')}}</span>
					        </div>
					        @if($supportTicket->status != 4)
					        <div class="text-end col-lg-2 col-sm-10 col-md-6 mt-2">
								<button class="btn btn--danger text--light" data-bs-toggle="modal" data-bs-target="#close"{{ translate('Close Ticket')}}</button>
							</div>
							@endif
					    </div>
					</div>
					<div class="card-body">
						@if($supportTicket->status != 4)
						<form action="{{route('admin.support.ticket.reply', $supportTicket->id)}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="row my-3">
								<div class="col-lg-12 mb-3">
									<textarea class="form-control" rows="5" name="message" placeholder=""{{ translate('Enter Message')}}" required></textarea>
								</div>
								<div class="col-lg-8 mb-3">
									<input type="file" name="file[]" class="form-control">
									<div class="addnewdata"></div>
									<div class="form-text">"{{ translate('Allowed File Extensions: .jpg, .jpeg, .png, .pdf, .doc, .docx')}}</div>
								</div>
								<div class="col-lg-2 mb-3">
									<button type="button" class="btn btn--primary text--light addnewfile">{{ translate('Add New')}}</button>
								</div>
								<div class="col-lg-2 mb-3">
									<button type="submit" class="btn btn--primary text--light w-100">{{ translate('Reply')}}</button>
								</div>
							</div>
						</form>
						@endif
						@foreach($supportTicket->messages as $meg)
	                        @if($meg->admin_id == 0)
	                            <div class="row shadow-lg p-3 mb-3 bg-light rounded">
	                                <div class="col-lg-3 text-end">
	                                	<p>{{ translate('Created at')}} {{getDateTime($meg->created_at) }}</p>
	                                    <h6><a href="{{route('admin.user.details',$supportTicket->user_id)}}" class="text-dark">{{$supportTicket->user->name}}</a></h6>
	                                </div>

	                                <div class="col-lg-9">
	                                    <p>{{$meg->message}}</p>
	                                    @if($meg->supportfiles()->count() > 0)
	                                        <div class="my-3">
	                                            @foreach($meg->supportfiles as $key=> $file)
	                                                <a href="{{route('admin.support.ticket.download',encrypt($file->id))}}" class="mr-3 text-dark"><i class="fa fa-file"></i>{{ translate('File')}} {{++$key}}</a>
	                                            @endforeach
	                                        </div>
	                                    @endif
	                                </div>
	                            </div>
	                        @else
	                            <div class="row shadow-lg p-2 mb-1 bg-dark rounded">
	                                <div class="col-lg-3 text-end">
	                                	<p class="text-light">{{ translate('Created at')}} {{getDateTime($meg->created_at)}}</p>
	                                    <h6 class="text-light">{{ translate('Admin')}}</h6>
	                                </div>

	                                <div class="col-lg-9">
	                                    <p class="text-light">{{$meg->message}}</p>
	                                    @if($meg->supportfiles()->count() > 0)
	                                        <div class="my-3">
	                                            @foreach($meg->supportfiles as $key=> $file)
	                                                <a href="{{route('admin.support.ticket.download',encrypt($file->id))}}" class="mr-3 text-light"><i class="fa fa-file"></i> {{ translate('File')}} {{++$key}} </a>
	                                            @endforeach
	                                        </div>
	                                    @endif
	                                </div>
	                            </div>
	                        @endif
	                    @endforeach
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


<div class="modal fade" id="close" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('admin.support.ticket.closeds', $supportTicket->id)}}" method="POST">
        		@csrf
        		<input type="hidden" name="id">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash-alt"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6>{{ translate('Are you sure to want close this ticket?')}}</h6>
	                </div>
	            </div>
	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--danger">{{ translate('Closed')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
@endsection


@push('scriptpush')
<script>
	(function($){
		"use strict"
		$('.addnewfile').on('click', function () {
	        var html = `
	        <div class="row newdata my-2">
	    		<div class="mb-3 col-lg-10">
	    			<input type="file" name="file[]" class="form-control" required>
				</div>

	    		<div class="col-lg-2 col-md-12 mt-md-0 mt-2 text-right">
	                <span class="input-group-btn">
	                    <button class="btn btn-danger btn-sm removeBtn w-100" type="button">
	                        <i class="fa fa-times"></i>
	                    </button>
	                </span>
	            </div>
	        </div>`;
	        $('.addnewdata').append(html);
		    $(".removeBtn").on('click', function(){
		        $(this).closest('.newdata').remove();
		    });
	    });
    })(jQuery);
</script>
@endpush
