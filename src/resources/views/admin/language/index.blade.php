@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12 p-1">
	            <div class="rounded_box">
	                <div class="row align--center px-3">
                		<div class="col-12 col-md-4 col-lg-4 col-xl-5">
                    		<h6 class="my-3">{{ translate('Manage Language') }}</h6>
                    	</div>

	                    <div class="col-12 col-md-8 col-lg-8 col-xl-7">
	                		<div class="row justify-content-end">
			                    <div class="col-12 col-lg-6 col-xl-6 px-2 py-1 ">
				                    <form action="{{route('admin.language.default')}}" method="POST" class="form-inline float-sm-right text-end">
				                    	@csrf
				                     	<div class="input-group mb-3 w-100">
										  	<select class="form-control" name="id" required="">
										  		@foreach($languages as $language)
										  			<option value="{{$language->id}}" @if($language->is_default == 1) selected @endif>{{strtoupper($language->name)}}</option>
										  		@endforeach
										  	</select>
										  	<button class="btn--primary input-group-text input-group-text" id="basic-addon2" type="submit">@lang('Set Default Language')</button>
										</div>
							        </form>
							    </div>
							</div>
	                	</div>
	                </div>
 					<div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th> {{ translate('Name')}}</th>
		                            <th> {{ translate('Code')}}</th>
		                            <th> {{ translate('Status')}}</th>
		                            <th> {{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($languages as $language)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label=" {{ translate('Name')}}">
				                    	<i class="flag-icon flag-icon-{{$language->flag}} flag-icon-squared rounded-circle fs-4 me-1"></i>{{__($language->name)}}
				                    </td>
				                    <td data-label=" {{ translate('Code')}}">
				                    	{{__($language->code)}}
				                    </td>

				                    <td data-label=" {{ translate('Status')}}">
				                    	@if($language->is_default == 1)
				                    		<span class="badge badge--success"> {{ translate('Default')}}</span>
				                    	@else
				                    		<span> {{ translate('N/A')}}</span>
				                    	@endif
				                    </td>
				                    <td data-label= {{ translate('Action')}}>
			                    		<a class="btn--primary text--light language" data-bs-toggle="modal" data-bs-target="#updatebrand" href="javascript:void(0)" data-id="{{$language->id}}" data-name="{{$language->name}}" data-code="{{$language->code}}"><i class="las la-pen"></i></a>
			                    		<a class="btn--success text--light" href="{{route('admin.language.translate', $language->code)}}"><i class="las la-language"></i></a>
			                    		@if($language->is_default != 1 && $language->id != 1)
				                    		<a href="javascript:void(0)" class="btn--danger text--light languagedelete"
				                    		data-bs-toggle="modal"
				                    		data-bs-target="#delete"
				                    		data-delete_id="{{$language->id}}"
				                    		><i class="las la-trash"></i></a>
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
	            </div>
	        </div>
	    </div>
	</div>
	<a href="javascript:void(0);" class="support-ticket-float-btn" data-bs-toggle="modal" data-bs-target="#createlanguage" title=" {{ translate('Create New Language')}}">
		<i class="fa fa-plus ticket-float"></i>
	</a>
</section>


<div class="modal fade" id="createlanguage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.language.store')}}" method="POST" enctype="multipart/form-data">
				@csrf
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light"> {{ translate('Add New Language')}}</div>
	            		</div>
		                <div class="card-body">
		                	<div class="mb-3">
								<label for="name" class="form-label"> {{ translate('Country Flag')}} <sup class="text--danger">*</sup></label>
								<span id="flag-icon"></span>
								<select name="flag" class="form-select flag" id="flag">
										<option value=""> {{ translate('Select Country Flag')}}</option>
								    @foreach($countries as $key=>$countryData)
										<option value="{{$key}}" @if(session('flag') == $key) selected="" @endif>{{__($countryData->country)}}</option>
									@endforeach
								</select>
							</div>

							<div class="mb-3">
								<label for="name" class="form-label"> {{ translate('Language Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder=" {{ translate('Language Name Here')}}" required>
							</div>

							<div class="mb-3">
								<label for="code" class="form-label"> {{ translate('Code')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="code" name="code" placeholder=" {{ translate('Enter Language Code [i.g: en, bn, in]')}}" required>
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


<div class="modal fade" id="updatelanguage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('admin.language.update')}}" method="POST" enctype="multipart/form-data">
				@csrf
				<input type="hidden" name="id">
	            <div class="modal-body">
	            	<div class="card">
	            		<div class="card-header bg--lite--violet">
	            			<div class="card-title text-center text--light"> {{ translate('Update Language')}}</div>
	            		</div>
		                <div class="card-body">
		                	<div class="mb-3">
								<label for="name" class="form-label"> {{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" class="form-control" id="name" name="name" placeholder=" {{ translate('Enter Name')}}" required>
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

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('admin.language.delete')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id" value="">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash-alt"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6> {{ translate('Are you sure to delete this language')}}</h6>
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
		$('.language').on('click', function(){
			var modal = $('#updatelanguage');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.find('input[name=name]').val($(this).data('name'));
			modal.modal('show');
		});

		$('.languagedelete').on('click', function(){
			var modal = $('#delete');
			modal.find('input[name=id]').val($(this).data('delete_id'));
			modal.modal('show');
		});

		$('#flag').on('change', function() {
			var countryCode = this.value.toLowerCase();
			$('#flag-icon').html('').html('<i class="flag-icon flag-icon-squared rounded-circle fs-4 me-1 flag-icon-'+countryCode+'"></i>');
		});
	})(jQuery);
</script>
@endpush
