@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th>@lang('Name')</th>
									@if($view == 'user_view')
		                            	<th>@lang('User Name')</th>
									@endif
		                            <th>@lang('Message')</th>
									@if($view == 'user_view')
		                            	<th>@lang('Status')</th>
									@endif
		                            <th>@lang('Action')</th>
		                        </tr>
		                    </thead>
		                    @forelse($templates as $template)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label="@lang('Name')">
				                    	{{__($template->name)}}
				                    </td>
									@if($view == 'user_view')
										<td data-label="@lang('User Name')">
											{{__($template->user->name ?? ' ')}}
										</td>
									@endif
									<td data-label="@lang('Message')">
				                    	{{__($template->message)}}
				                    </td>

									@if($template->user_id)
										<td data-label="@lang('Status')">
											@if($template->status ==1)
												<div class="badge bg-primary">@lang('Pendding')</div>
											@elseif($template->status ==2)
												<div class="badge bg-success">@lang('Approved')</div>
											@elseif($template->status ==3)
												<div class="badge bg-danger">@lang('Rejected')</div>
											@endif
										</td>
									@endif

				                    <td data-label=@lang('Action')>
										@if ($view == 'admin_view')
											<a class="btn--primary text--light template" data-bs-toggle="modal" 		data-bs-target="#updatebrand" href="javascript:void(0)"
											data-id="{{$template->id}}"
											data-name="{{$template->name}}"
											data-message="{{$template->message}}">
												<i class="las la-pen"></i>
											</a>
										@elseif($view == 'user_view')
											<a class="btn--primary text--light statusUpdate" data-bs-toggle="modal" 		data-bs-target="#updateStatus" href="javascript:void(0)"
											data-id="{{$template->id}}" data-status="{{$template->status}}">
											<i class="las la-pen"></i>
										</a>
										@endif
			                    		<a class="btn--danger text--light delete" data-bs-toggle="modal" data-bs-target="#deletetemplate" href="javascript:void(0)"data-id="{{$template->id}}"><i class="las la-trash"></i></a>
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%">@lang('No Data Found')</td>
			                	</tr>
			                @endforelse
		                </table>
		            </div>
	                <div class="m-3">
	                	{{$templates->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
	@if($view == 'admin_view')
		<a href="javascript:void(0);" class="support-ticket-float-btn" data-bs-toggle="modal" data-bs-target="#createTemplate" title="@lang('Create New Message Template')">
			<i class="fa fa-plus ticket-float"></i>
		</a>
	@endif
</section>


<div class="modal fade" id="createTemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.template.store')}}" method="POST">
				@csrf
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">@lang('Add New Template')</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="name" class="form-label">@lang('Name') <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="@lang('Enter Name')" required>
							</div>

							<div class="mb-3">
								<label for="message" class="form-label">@lang('Message') <sup class="text--danger">*</sup></label>
								<textarea rows="5"  class="form-control" id="message" name="message" placeholder="@lang('Enter Message')" required=""></textarea>
							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">@lang('Cancel')</button>
	                <button type="submit" class="bg--success">@lang('Submit')</button>
	            </div>
	        </form>
        </div>
    </div>
</div>


<div class="modal fade" id="updatetemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.template.update')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">@lang('Update Group')</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="name" class="form-label">@lang('Name') <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="@lang('Enter Name')" required>
							</div>

							<div class="mb-3">
								<label for="message" class="form-label">@lang('Message') <sup class="text--danger">*</sup></label>
								<textarea rows="5"  class="form-control" id="message" name="message" placeholder="@lang('Enter Message')" required=""></textarea>
							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">@lang('Cancel')</button>
	                <button type="submit" class="bg--success">@lang('Submit')</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
<div class="modal fade" id="updateStatus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.template.userStatus.update')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">@lang('Status Update')</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3" id="statusAppend">

							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">@lang('Cancel')</button>
	                <button type="submit" class="bg--success">@lang('Update')</button>
	            </div>
	        </form>
        </div>
    </div>
</div>



<div class="modal fade" id="deletetemplate" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{route('admin.template.delete')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal_body2">
					<div class="modal_icon2">
						<i class="las la-trash-alt"></i>
					</div>
					<div class="modal_text2 mt-3">
						<h6>@lang('Are you sure to want delete this group?')</h6>
					</div>
				</div>
				<div class="modal_button2">
					<button type="button" class="" data-bs-dismiss="modal">@lang('Cancel')</button>
					<button type="submit" class="bg--danger">@lang('Delete')</button>
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
		$('.template').on('click', function(){
			var modal = $('#updatetemplate');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.find('input[name=name]').val($(this).data('name'));
			modal.find('textarea[name=message]').val($(this).data('message'));
			modal.modal('show');
		});
		$('.statusUpdate').on('click', function(){
			var modal = $('#updateStatus');
			modal.find('input[name=id]').val($(this).data('id'));
			var value = $(this).data('status');
			$('#statusAppend').html('')
			$('#statusAppend').html(`
				<label for="status" class="form-label">@lang('Status') <sup class="text--danger">*</sup></label>
				<select name="status" id="status" class="form-control" >
					<option  ${value == 1 ? 'selected' : ''} value="1">@lang('Pendding')</option>
					<option  ${value == 2 ? 'selected' : ''} value="2">@lang('Approve')</option>
					<option  ${value == 3 ? 'selected' : ''} value="3">@lang('Reject')</option>
				</select>
			`)
			modal.modal('show');
		});

		$('.delete').on('click', function(){
			var modal = $('#deletetemplate');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush
