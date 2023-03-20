@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="table_heading d-flex align--center justify--between">
                    <nav  aria-label="breadcrumb">
					  	<ol class="breadcrumb">
					    	<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">{{ translate('Dashboard')}}</a></li>
					    	<li class="breadcrumb-item" aria-current="page"> {{ translate('Seo Content')}}</li>
					  	</ol>
					</nav>
                    <a href="{{route('admin.seo.index')}}" class="btn--dark text--light border-0 px-3 py-1 rounded ms-3"><i class="las la-angle-double-left"></i> {{ translate('Go Back')}}</a>
                </div>

				<div class="card">
					<div class="card-header bg--lite--violet">
						<h6 class="card-title text-center text-light">{{__($title)}}</h6>
					</div>
					<div class="card-body">
						<form action="{{route('admin.seo.update')}}" method="POST" enctype="multipart/form-data" novalidate="">
							@csrf
							<div class="row">
								<div class="mb-3 col-lg-6 col-md-12">
									<label for="seo_image" class="form-label">{{ translate('Seo Image')}}</label>
									<input type="file" name="seo_image" id="seo_image" class="form-control">
									<div class="form-text">{{ translate('Supported File : jpg,png,jpeg and size')}} {{filePath()['seo_image']['size']}} {{ translate('pixels')}}</div>
								</div>


								<div class="mb-3 col-lg-6 col-md-12">
									<label for="meta_keyword" class="form-label">{{ translate('Meta Keywords')}} <sup class="text--danger">*</sup></label>
									<select name="meta_keywords[]" id="meta_keyword" class="form-control keywords" multiple=multiple>
										@if(@$seo->value->meta_keywords)
                                            @foreach($seo->value->meta_keywords as $data)
                                                <option value="{{$data}}" selected>{{__($data)}}</option>
                                            @endforeach
                                        @endif
									</select>
								</div>

								<div class="mb-3 col-lg-12 col-md-12">
									<label for="meta_description" class="form-label">{{ translate('Meta Description')}} <sup class="text--danger">*</sup></label>
									<textarea rows="3" name="meta_description" id="meta_description" class="form-control ckeditor" placeholder="{{ translate('Enter Meta Description')}}" required>@php echo @$seo->value->meta_description @endphp</textarea>
								</div>


								<div class="mb-3 col-lg-6 col-md-12">
									<label for="social_title" class="form-label">{{ translate('Social Title')}} <sup class="text--danger">*</sup></label>
									<input type="text" name="social_title" id="social_title"  value="{{@$seo->value->social_title}}" class="form-control" placeholder="{{ translate('Enter Meta Title')}}" required>
								</div>

								<div class="mb-3 col-lg-6 col-md-12">
									<label for="social_image" class="form-label">{{ translate('Social Image')}}</label>
									<input type="file" name="social_image" id="social_image" class="form-control">
									<div class="form-text">{{ translate('Supported File : jpg,png,jpeg and size')}} {{filePath()['seo_image']['size']}} {{ translate('pixels')}}</div>
								</div>


								<div class="mb-3 col-lg-12 col-md-12">
									<label for="social_description" class="form-label">{{ translate('Social Description')}} <sup class="text--danger">*</sup></label>
									<textarea rows="3" name="social_description" id="social_description" class="form-control" placeholder="{{ translate('Enter Social Description')}}" required>{{@$seo->value->social_description}}</textarea>
								</div>

							</div>
							<button type="submit" class="btn btn--primary w-100 text-light">{{ translate('Submit')}}</button>
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
	"use strict";
	ClassicEditor.create( document.querySelector('.ckeditor')).catch( error => {
    });

	$('.keywords').select2({
        tags: true,
        tokenSeparators: [',']
    });
</script>
@endpush
