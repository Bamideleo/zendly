@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-3 col-lg-4 mb-30">
	            <div class="card b-radius-5 overflow-hidden profile-card">
	                <div class="card-body p-0">
	                    <div class="d-flex p-2 bg--lite--violet align-items-center">
	                        <div class="avatar avatar--lg">
	                            <img src="{{showImage(filePath()['profile']['admin']['path'].'/'.$admin->image)}}" alt="Image">
	                        </div>
	                        <div class="pl-3">
	                            <h5 class="text--light m-0 p-0">{{__($admin->name)}}</h5>
	                        </div>
	                    </div>
	                    <ul class="list-group">
	                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ translate('Name')}}<span class="font-weight-bold">{{__($admin->name)}}</span>
	                        </li>

	                        <li class="list-group-item d-flex justify-content-between align-items-center">
	                            {{ translate('Username')}}<span class="font-weight-bold">{{__($admin->username)}}</span>
	                        </li>

	                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ translate('Email')}}<span class="font-weight-bold">{{__($admin->email)}}</span>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </div>

			<div class="col-xl-9 col-lg-8">
				<div class="card">
					<div class="card-body">
						<form action="{{route('admin.profile.update')}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="mb-3">
								<label for="name" class="form-label">{{ translate('Name')}}</label>
								<input type="text" class="form-control" id="name" value="{{__($admin->name)}}" placeholder="{{ translate('Enter Name')}}" name="name">
							</div>

							<div class="mb-3">
								<label for="username" class="form-label">{{ translate('Username')}}</label>
								<input type="text" class="form-control" id="username" value="{{$admin->username}}" name="username">
							</div>

							<div class="mb-3">
								<label for="email" class="form-label">{{ translate('Email')}}</label>
								<input type="email" class="form-control" id="email" value="{{$admin->email}}" name="email">
							</div>

							<div class="mb-3">
								<label for="image" class="form-label">{{ translate('Image')}}</label>
								<input type="file" class="form-control" id="image" name="image">
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
