@extends('user.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12 p-1">
	            <div class="rounded_box">
	                <div class="row align--center px-2">
	                	<div class="col-12 col-md-4 col-lg-4 col-xl-5">
						<form action="{{route('user.agency.search')}}" method="GET">
						<div class="input-group mb-3">
  <button class="btn btn-success" type="submit" id="button-addon1">Search</button>
  <input type="text" class="form-control" name="search" placeholder="Enter Email Or Name" aria-label="Example text with button addon" aria-describedby="button-addon1">
</div>
</form>
	                	</div>
	                	<div class="col-12 col-md-8 col-lg-8 col-xl-7">
	                		<div class="row justify-content-end">
							
			                    <div class="col-12 col-md-4 col-lg-4 col-xl-3 py-1">
			                    	<button class="btn--primary text--light border-0 w-100 px-1 py-2 rounded ms-2" data-bs-toggle="modal" data-bs-target="#creategroup"><i class="las la-plus"></i> {{ translate('Add User')}}</button>
			                    </div>
			                </div>
	                	</div>
	                </div>


	                <div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th>{{ translate('#')}}</th>
                                    <th>{{ translate('Name')}}</th>
		                            <th>{{ translate('Email')}}</th>
									<th>{{ translate('Status')}}</th>
		                            <th>{{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($users as $data)
			                    <tr class="@if($loop->even) table-light @endif">
			                    	<td data-label="{{ translate('#')}}">
				                    	{{$loop->iteration}}
				                    </td>

                                    <td data-label="{{translate('email')}}">
				                    	{{$data->name}}
				                    </td>
				                    
                                    <td data-label="{{translate('email')}}">
				                    	{{$data->email}}
				                    </td>
									<td data-label="{{ translate('Status')}}">
				                    	@if($data->status == 1)
				                    		<span class="badge badge--success">{{ translate('Active')}}</span>
				                    	@else
				                    		<span class="badge badge--danger">{{ translate('Inactive')}}</span>
				                    	@endif
				                    </td>
                                    <td data-label={{ translate('Action')}}>
			                    		<a class="btn--primary text--light contact" data-bs-toggle="modal" data-bs-target="#updatebrand" href="javascript:void(0)"
			                    			data-id="{{$data->id}}"
			                    			data-email="{{$data->email}}"
			                    			data-name="{{$data->name}}"
                                            data-oto1="{{$data->oto1}}"
			                    			data-status="{{$data->status}}"><i class="las la-pen"></i></a>
			                    		<a class="btn--danger text--light delete" data-bs-toggle="modal" data-bs-target="#delete" href="javascript:void(0)" data-id="{{$data->id}}"><i class="las la-trash"></i></a>
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
	                
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>


<div class="modal fade" id="creategroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('user.agency.save')}}" method="POST">
				@csrf
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{ translate('Add New Sub User')}}</div>
	            		</div>
		                <div class="card-body">

                        <div class="mb-3">
								<label for="name" class="form-label">{{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{ translate('Enter Name')}}" required>
							</div>

		                	<div class="mb-3">
								<label for="email" class="form-label">{{ translate('Email')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="email" name="email" placeholder="{{ translate('Enter Email')}}" required>
							</div>

							<div class="mb-3">
								<label for="email_group_id" class="form-label">{{ translate('Password')}} <sup class="text--danger">*</sup></label>
								<input type="password" class="form-control" id="password" name="password" placeholder="{{ translate('Enter Password')}}" required>
							</div>

							<div class="mb-3">
								<label for="status" class="form-label">{{ translate('Fe')}} <sup class="text--danger">*</sup></label>
                                <input class="form-check-input" type="checkbox" id="formCheck1" name="fe"  value="1" checked>
							</div>

                            <div class="mb-3">
								<label for="status" class="form-label">{{ translate('Unlimited')}} <sup class="text--danger">*</sup></label>
                                <input class="form-check-input" type="checkbox" id="formCheck1" name="oto1"  value="1" {{auth()->user()->oto1==1 ?'checked':''}}>
							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{ translate('Submit')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>


<div class="modal fade" id="updateContact" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('user.agency.upgrade')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{ translate('Update User')}}</div>
	            		</div>
		                <div class="card-body">
						<input type="hidden" name="id">
							<div class="mb-3">
								<label for="name" class="form-label">{{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder="{{ translate('Enter Name')}}" required>
							</div>

                            <div class="mb-3">
								<label for="email" class="form-label">{{ translate('Email')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="email" name="email" placeholder="{{ translate('Enter Email')}}" required>
							</div>

							<div class="mb-3">
								<label for="email_group_id" class="form-label">{{ translate('Password')}} <sup class="text--danger">*</sup></label>
								<input type="password" class="form-control" id="password" name="password" placeholder="{{ translate('Enter Password')}}">
							</div>
							<div class="mb-3">
								<label for="status" class="form-label">{{ translate('Fe')}} <sup class="text--danger">*</sup></label>
                                <input class="form-check-input" type="checkbox" id="formCheck1" name="fe"  value="1" checked>
							</div>

                            <div class="mb-3">
								<label for="status" class="form-label">{{ translate('Unlimited')}} <sup class="text--danger">*</sup></label>
                              
                                <input class="form-check-input" type="checkbox" id="oto1" name="oto1">
							</div>

							<div class="mb-3">
								<label for="status" class="form-label">{{ translate('Status')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="status" id="status" required>
									<option value="1">{{ translate('Active')}}</option>
									<option value="2">{{ translate('Inactive')}}</option>
								</select>
							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{ translate('Update')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>



<div class="modal fade" id="deletegroup" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<form action="{{route('user.agency.delete')}}" method="POST">
				@csrf
				<input type="hidden" name="id">
				<div class="modal_body2">
					<div class="modal_icon2">
						<i class="las la-trash-alt"></i>
					</div>
					<div class="modal_text2 mt-3">
						<h6>{{ translate('Are you sure to want delete this user?')}}</h6>
					</div>
				</div>
				<div class="modal_button2">
					<button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
					<button type="submit" class="bg--danger">{{ translate('Delete')}}</button>
				</div>
			</form>
		</div>
	</div>
</div>



<div class="modal fade" id="contactImport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('user.email.contact.import')}}" method="POST" enctype="multipart/form-data">
				@csrf
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light">{{ translate('Update Contact')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="email_group_id" class="form-label">{{ translate('Group')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="email_group_id" id="email_group_id" required>
									<option value="">{{ translate('Select Group')}}</option>
									
								</select>
							</div>

							<div class="mb-3">
								<label for="file" class="form-label">{{ translate('File')}} <sup class="text--danger">*</sup></label>
								<input type="file" name="file" id="file" class="form-control" required="">
								<div class="form-text">{{ translate('Supported files: excel,')}}</div>
								<div class="form-text">{{ translate('Download file format from here')}} <a href="{{route('email.contact.demo.import')}}">{{ translate('xlsx')}}</a></div>
							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{ translate('Submit')}}</button>
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
		$('.contact').on('click', function(){
			var modal = $('#updateContact');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.find('input[name=oto1]').val($(this).data('oto1'));
			modal.find('input[name=email]').val($(this).data('email'));
			modal.find('input[name=name]').val($(this).data('name'));
			modal.find('select[name=status]').val($(this).data('status'));
            var oto1 = $('#oto1').val()
			modal.modal('show');
			if(oto1 == 1){
                $('#oto1').prop('checked', true); 
            }
            else{
                $('#oto1').prop('checked', false);  
            }
		});

		$('.delete').on('click', function(){
			var modal = $('#deletegroup');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.modal('show');
		});
	})(jQuery);
</script>
@endpush
