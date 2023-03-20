@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12 p-1">
	            <div class="rounded_box">
	                <div class="row align--center px-3">
	                	<div class="col-12 col-md-4 col-lg-4 col-xl-5">
	                    	<h6 class="my-3"> {{ translate('Select Options')}}</h6>
	                    </div>
	                    <div class="col-12 col-md-8 col-lg-8 col-xl-7">
	                		<div class="row justify-content-end">
			                    <div class="col-12 col-md-6 col-lg-4 col-xl-4 px-2 py-1">
	                    			<button class="w-100 btn--coral text--light border-0 px-1 py-2 rounded ms-2" data-bs-toggle="modal" data-bs-target="#contactExport"><i class="las la-plus"></i> @lang('Export Contact')</button>
	                    		</div>
	                    	</div>
	                    </div>
	                </div>
	                <div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th> {{ translate('#')}}</th>
		                            <th> {{ translate('User')}}</th>
		                            <th> {{ translate('Group')}}</th>
		                            <th> {{ translate('Email')}}</th>
		                            <th> {{ translate('Name')}}</th>
		                            <th> {{ translate('Status')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($emailContacts as $emailContact)
			                    <tr class="@if($loop->even) table-light @endif">
			                    	<td data-label=" {{ translate('#')}}">
				                    	{{$loop->iteration}}
				                    </td>

				                     <td data-label=" {{ translate('User')}}">
				                    	<a href="{{route('admin.user.details', $emailContact->user_id)}}" class="fw-bold text-dark">{{__(@$emailContact->user->email)}}</a>
				                    </td>

				                    <td data-label=" {{ translate('Group')}}">
				                    	{{__($emailContact->emailGroup->name)}}
				                    </td>

				                     <td data-label=" {{ translate('Email')}}">
				                    	{{__($emailContact->email)}}
				                    </td>

				                     <td data-label=" {{ translate('Name')}}">
				                    	{{__($emailContact->name)}}
				                    </td>

				                    <td data-label=" {{ translate('Status')}}">
				                    	@if($emailContact->status == 1)
				                    		<span class="badge badge--success"> {{ translate('Active')}}</span>
				                    	@else
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
	                	{{$emailContacts->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>



<div class="modal fade" id="contactExport" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.contact.email.export')}}" method="GET">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light"> {{ translate('Export Contact')}}</div>
	            		</div>
		                <div class="card-body">
							<div class="mb-3">
								<label for="user_id" class="form-label"> {{ translate('User')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="user_id" id="user_id" required>
									<option value="all"> {{ translate('All')}}</option>
									@foreach($users as $user)
										<option value="{{$user->id}}">{{@$user->name}}</option>
									@endforeach
								</select>
							</div>
						</div>
	            	</div>
	            </div>

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal"> {{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success"> {{ translate('Export')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
@endsection

