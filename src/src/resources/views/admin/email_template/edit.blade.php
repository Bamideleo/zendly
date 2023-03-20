@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="table_heading d-flex align--center justify--between">
                    <nav  aria-label="breadcrumb">
					  	<ol class="breadcrumb">
					    	<li class="breadcrumb-item"><a href="{{route('admin.mail.templates.index')}}"> {{ translate('Mail Templates')}}</a></li>
					    	<li class="breadcrumb-item" aria-current="page">  {{ translate('Update Template')}}</li>
					  	</ol>
					</nav>
                </div>

				<div class="card">
					<div class="card-header bg--lite--violet">
						<h6 class="card-title text-light"> {{ translate('Update mail template for mail notification')}}</h6>
					</div>

					<div class="p-3 rounded_box">
	                    <div class="work_list">
	                       	<h5> {{ translate('Email Tempalte Short Code')}}</h5>
	                        <div class="work_list_body">
	                        	@forelse($emailTemplate->codes as $key => $value)
		                            <div class="d--flex align--center justify--between single_work_item complete_item">
		                                <div>
		                                    <h6>{{$value}}</h6>
		                                </div>
		                                <p>@php echo "{{". $key ."}}"  @endphp</p>
		                            </div>
		                        @empty

		                        @endforelse
	                        </div>
	                    </div>
	                </div>

					<div class="card-body">
						<form action="{{route('admin.mail.templates.update', $emailTemplate->id)}}" method="POST" enctype="multipart/form-data" novalidate="">
							@csrf
							<div class="row">
								<div class="mb-3 col-lg-6">
									<label for="subject" class="form-label"> {{ translate('Subject')}}<sup class="text--danger">*</sup></label>
									<input type="text" name="subject" class="form-control" value="{{$emailTemplate->subject}}" placeholder=" {{ translate('Enter Subject')}}" required>
								</div>

								<div class="mb-3 col-lg-6">
									<label for="subject" class="form-label"> {{ translate('Status')}}<sup class="text--danger">*</sup></label>
									<select class="form-control" name="status" id="status" required>
										<option value="1" @if($emailTemplate->status == 1) selected @endif> {{ translate('Active')}}</option>
										<option value="2" @if($emailTemplate->status == 2) selected @endif> {{ translate('Inactive')}}</option>
									</select>
								</div>

								<div class="mb-3 col-lg-12">
									<label for="body" class="form-label"> {{ translate('Description')}}<sup class="text--danger">*</sup></label>
									<textarea class="form-control" name="body" rows="5" id="body" required>{{ $emailTemplate->body }}</textarea>
								</div>
							</div>

							<button type="submit" class="btn btn--primary w-100 text-light"> {{ translate('Submit')}}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection

@push('scriptpush')
<script>
	'use strict';
	$(document).ready(function() {
        $('#body').summernote({
	        placeholder: '{{ translate('Write Here Email Content &  For Mention Name Use ')}}'+'{'+'{name}'+"}",
	        tabsize: 2,
	        width:'100%',
	        height: 200,
	        toolbar: [
		        ['fontname', ['fontname']],
		        ['style', ['style']],
		        ['fontsize', ['fontsizeunit']],
		        ['font', ['bold', 'underline', 'clear']],
		        ['height', ['height']],
		        ['color', ['color']],
		        ['para', ['ul', 'ol', 'paragraph']],
		        ['table', ['table']],
		        ['insert', ['link', 'picture', 'video']],
		        ['view', ['codeview']],
	        ],
	        codeviewFilterRegex: 'custom-regex'
	    });
    });
</script>
@endpush
