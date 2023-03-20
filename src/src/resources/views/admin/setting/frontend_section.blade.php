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
					    	<li class="breadcrumb-item" aria-current="page"> {{ translate('Frontend Section')}}</li>
					  	</ol>
					</nav>
                </div>

				<div class="card">
					<div class="card-header bg--lite--violet">
						<h6 class="card-title text-center text-light">{{ translate('User Login Page Content')}}</h6>
					</div>
					<div class="card-body">
						<form action="{{route('admin.general.setting.frontend.section.store')}}" method="POST">
							@csrf
							<div class="shadow-lg p-3 mb-3 bg-body rounded">
								<div class="row">
									<div class="mb-3 col-lg-12">
										<label for="heading" class="form-label">{{ translate('Heading')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="heading" id="heading" class="form-control" value="{{@$general->frontend_section->heading}}" placeholder="{{ translate('Enter Heading')}}" required>
									</div>

									<div class="mb-3 col-lg-12">
										<label for="sub_heading" class="form-label">{{ translate('Sub Heading')}} <sup class="text--danger">*</sup></label>
										<textarea class="form-control" id="sub_heading" name="sub_heading" rows="5" placeholder="{{ translate('Enter Sub Heading')}}" required="">{{@$general->frontend_section->sub_heading}}</textarea>
									</div>

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
