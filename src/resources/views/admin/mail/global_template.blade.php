@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">

				<div class="card">
					<div class="card-header bg--lite--violet">
						<h6 class="card-title text-light"> {{ translate('Set up mail template for mail notification')}}</h6>
					</div>

					<div class="p-3 rounded_box">
	                    <div class="work_list">
	                       	<h5> {{ translate('Email Tempalte Short Code')}}</h5>
	                        <div class="work_list_body">
	                            <div class="d--flex align--center justify--between single_work_item complete_item">
	                                <div>
	                                    <h6> {{ translate('Username')}}</h6>
	                                </div>
	                                <p>@{{username}}</p>
	                            </div>
	                            <div class="d--flex align--center justify--between single_work_item complete_item">
	                                <div>
	                                    <h6> {{ translate('Mail Body')}}</h6>
	                                </div>
	                                <p>@{{message}}</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>


					<div class="card-body">
						<form action="{{route('admin.global.template.update')}}" method="POST" enctype="multipart/form-data" novalidate="">
							@csrf
							<div class="row">
								<div class="mb-3 col-lg-12">
									<label for="mail_from" class="form-label"> {{ translate('Sent From Email')}}<sup class="text--danger">*</sup></label>
									<input type="text" name="mail_from" class="form-control" value="{{$general->mail_from}}" placeholder=" {{ translate('Enter Subject')}}" required>
								</div>


								<div class="mb-3 col-lg-12">
									<label for="body" class="form-label"> {{ translate('Email Tempalte')}}<sup class="text--danger">*</sup></label>
									<textarea class="form-control" name="body" rows="5" id="body" required>@php echo $general->email_template @endphp</textarea>
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
	        placeholder: '{{ translate('Write Here Email Content &  For Mention Name Use ')}}'+'{'+'{message}'+"}",
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
