@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="rounded_box">
        <div class="parent_pinned_project">
            <a href="{{route('admin.user.sms.contact', $user->id)}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="las la-comment-alt"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total SMS Contact')}}</h6>
                        <p>{{$log['contact']}} {{ translate('contact')}}</p>
                    </div>
                </div>
            </a>
            <a href="{{route('admin.user.sms', $user->id)}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="las la-sms"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total SMS')}}</h6>
                        <p>{{$log['sms']}} {{ translate('sms')}}</p>
                    </div>
                </div>
            </a>

            <a href="{{route('admin.user.email.contact',$user->id)}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="las la-envelope"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Email Contact')}}</h6>
                        <p>{{$log['email_contact']}} {{ translate('email contact')}}</p>
                    </div>
                </div>
            </a>

            <a href="{{route('admin.user.email',$user->id)}}" class="single_pinned_project shadow">
                <div class="pinned_icon">
                    <i class="las la-envelope-open-text"></i>
                </div>
                <div class="pinned_text">
                    <div>
                        <h6>{{ translate('Total Email')}}</h6>
                        <p>{{$log['email']}} {{ translate('email')}}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</section>

<section class="mt-3 rounded_box">
	<div class="row d-flex rounded">
		<div class="col-lg-12 col-xl-4">
			<div class="card shadow-sm p-3 mb-5 bg-body rounded">
                <div class="card-body p-0">
                    <div class="p-3 bg--white">
                        <div class="user--profile--image">
                            <img src="{{showImage(filePath()['profile']['user']['path'].'/'.$user->image)}}" alt="{{ translate('Profile Image')}}" class="b-radius--10 w-100">
                        </div>
                        <div class="mt-2">
                            <h6>{{__($user->name)}}</h6>
                            <span>{{ translate('Joining Date')}} {{getDateTime($user->created_at,'d M, Y h:i A')}}</span>
                        </div>
                    </div>
                </div>
        	</div>

        	<div class="card shadow-sm p-3 mb-5 bg-body rounded">
                <div class="card-body">
                    <h6 class="mb-3">{{ translate('Customer information')}}</h6>
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ translate('SMS Credit')}}
                            <span>{{$user->credit}} {{ translate('credit')}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ translate('Email Credit')}}
                            <span>{{$user->email_credit}} {{ translate('credit')}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ translate('WhatsApp Credit')}}
                            <span>{{$user->whatsapp_credit}} {{ translate('credit')}}</span>
                        </li>

                         <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ translate('Email')}}
                            <span>{{$user->email}}</span>
                        </li>

                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ translate('Status')}}
                            @if($user->status == 1)
                                <span class="badge badge-pill bg--success">{{ translate('Active')}}</span>
                           	@else
                                <span class="badge badge-pill bg--danger">{{ translate('Banned')}}</span>
                            @endif
                        </li>
                    </ul>
                </div>
            </div>
        </div>

		<div class="col-lg-12 col-xl-8">
			<div class="card">
				<div class="card-header bg--lite--violet">
					<h6 class="card-title text-center text-light">{{ translate('Customer Information Update')}}</h6>
				</div>
				<div class="card-body">
					<form action="{{route('admin.user.update', $user->id)}}" method="POST" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="mb-3 col-lg-6 col-md-12">
								<label for="name" class="form-label">{{ translate('Name')}} <sup class="text--danger">*</sup></label>
								<input type="text" name="name" id="name" class="form-control" value="{{@$user->name}}" placeholder="{{ translate('Enter Name')}}" required>
							</div>

							<div class="mb-3 col-lg-6 col-md-12">
								<label for="email" class="form-label">{{ translate('Email')}} <sup class="text--danger">*</sup></label>
								<input type="text" name="email" id="email" class="form-control" value="{{@$user->email}}"  required>
							</div>

							<div class="mb-3 col-lg-6 col-md-12">
								<label for="address" class="form-label">{{ translate('Address')}} <sup class="text--danger">*</sup></label>
								<input type="text" name="address" id="address" class="form-control" value="{{@$user->address->address}}" placeholder="{{ translate('Enter Address')}}" required>
							</div>

							<div class="mb-3 col-lg-6 col-md-12">
								<label for="city" class="form-label">{{ translate('City')}} <sup class="text--danger">*</sup></label>
								<input type="text" name="city" id="city" class="form-control" value="{{@$user->address->city}}" placeholder="{{ translate('Enter City')}}" required>
							</div>

							<div class="mb-3 col-lg-6 col-md-12">
								<label for="state" class="form-label">{{ translate('State')}} <sup class="text--danger">*</sup></label>
								<input type="text" name="state" id="state" class="form-control" value="{{@$user->address->state}}" placeholder="{{ translate('Enter State')}}" required>
							</div>

							<div class="mb-3 col-lg-6 col-md-12">
								<label for="zip" class="form-label">{{ translate('Zip')}} <sup class="text--danger">*</sup></label>
								<input type="text" name="zip" id="zip" class="form-control" value="{{@$user->address->zip}}" placeholder="{{ translate('Enter Zip')}}" required>
							</div>

							<div class="mb-3 col-lg-12">
								<label for="status" class="form-label">{{ translate('Status')}} <sup class="text--danger">*</sup></label>
								<select class="form-control" name="status" id="status">
									<option value="1" @if($user->status == 1) selected @endif>{{ translate('Active')}}</option>
									<option value="2" @if($user->status == 2) selected @endif>{{ translate('Banned')}}</option>
								</select>
							</div>
						</div>

						<button type="submit" class="btn btn--primary w-100 text-light">{{ translate('Submit')}}</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

@endsection

@push('stylepush')
<style type="text/css">
	.user--profile--image img{
		height: 250px
	}
</style>
@endpush
