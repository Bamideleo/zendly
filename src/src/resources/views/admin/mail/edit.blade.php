@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="table_heading d-flex align--center justify--between">
                    <nav  aria-label="breadcrumb">
					  	<ol class="breadcrumb">
					    	<li class="breadcrumb-item"><a href="{{route('admin.mail.configuration')}}"> {{ translate('Mail Configuration')}}</a></li>
					    	<li class="breadcrumb-item" aria-current="page">{{__($mail->name)}}</li>
					  	</ol>
					</nav>
                </div>

				<div class="card">
					<div class="card-header bg--lite--violet text-center">
						<h6 class="text-light">{{__($mail->name)}}  {{ translate('Mail Configuration Update Form')}}</h6>
					</div>
					<div class="card-body">
						<form action="{{route('admin.mail.update', $mail->id)}}" method="POST">
							@csrf

							@if($mail->name === "SMTP")
								<div class="row">
									<div class="mb-3 col-lg-6">
										<label for="driver" class="form-label"> {{ translate('Driver')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="driver" id="driver" class="form-control" value="{{@$mail->driver_information->driver}}" placeholder="{{ translate('Enter Driver')}}" required>
									</div>

									<div class="mb-3 col-lg-6">
										<label for="host" class="form-label"> {{ translate('Host')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="host" id="host" class="form-control" value="{{@$mail->driver_information->host}}" placeholder=" {{ translate('Enter Host')}}" required>
									</div>

									<div class="mb-3 col-lg-6">
										<label for="smtp_port" class="form-label"> {{ translate('SMTP Port')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="smtp_port" id="smtp_port" class="form-control" value="{{@$mail->driver_information->smtp_port}}" placeholder=" {{translate('Enter SMTP Port')}}" required>
									</div>

									<div class="mb-3 col-lg-6">
										<label for="encryption" class="form-label"> {{ translate('Encryption')}} <sup class="text--danger">*</sup></label>
										<select class="form-control" name="encryption" id="encryption">
										    <option value="">Select Encryption Types</options>
										    <option value="TLS" @if('TLS' == $mail->driver_information->encryption) selected @endif>Standard encryption (TLS)</option>
										    <option value="SSL" @if('SSL' == $mail->driver_information->encryption) selected @endif>Secure encryption (SSL)</option>
										    <option value="PWMTA" @if('PWMTA' == $mail->driver_information->encryption) selected @endif>PowerMTA Server        </option>
										    <option value="STARTTLS" @if('STARTTLS' == $mail->driver_information->encryption) selected @endif>STARTTLS       </option>
										    <option value="none" @if('none' == $mail->driver_information->encryption) selected @endif>None or No SSL     </option>

										</select>
									</div>

									<div class="mb-3 col-lg-6">
										<label for="username" class="form-label"> {{ translate('Username')}}<sup class="text--danger">*</sup></label>
										<input type="text" name="username" id="username" class="form-control" value="{{@$mail->driver_information->username}}" placeholder=" {{ translate('Enter Mail Username')}}" required>
									</div>

									<div class="mb-3 col-lg-6">
										<label for="password" class="form-label"> {{ translate('Password')}}<sup class="text--danger">*</sup></label>
										<input type="password" name="password" id="password" class="form-control" value="{{@$mail->driver_information->password}}" placeholder=" {{ translate('Enter Mail Password')}}" required>
									</div>

									<div class="mb-3 col-lg-6">
										<label for="from_address" class="form-label"> {{ translate('From Address')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="from_address" id="from_address" class="form-control" value="{{@$mail->driver_information->from->address}}" placeholder=" {{ translate('Enter From Address')}}" required>
									</div>

									<div class="mb-3 col-lg-6">
										<label for="from_name" class="form-label"> {{ translate('From Name')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="from_name" id="from_name" class="form-control" value="{{@$mail->driver_information->from->name}}" placeholder=" {{ translate('Enter From Name')}}" required>
									</div>
								</div>
							@elseif($mail->name === "SendGrid Api")
								<div class="row">
									<div class="mb-3 col-lg-12">
										<label for="app_key" class="form-label"> {{ translate('App Key')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="app_key" id="app_key" class="form-control" value="{{@$mail->driver_information->app_key}}" placeholder=" {{ translate('Enter App key')}}" required>
									</div>
									<div class="mb-3 col-lg-6">
										<label for="from_address" class="form-label"> {{ translate('From Address')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="from_address" id="from_address" class="form-control" value="{{@$mail->driver_information->from->address}}" placeholder=" {{ translate('Enter From Address')}}" required>
									</div>

									<div class="mb-3 col-lg-6">
										<label for="from_name" class="form-label"> {{ translate('From Name')}}<sup class="text--danger">*</sup></label>
										<input type="text" name="from_name" id="from_name" class="form-control" value="{{@$mail->driver_information->from->name}}" placeholder=" {{ translate('Enter From Name')}}" required>
									</div>
								</div>
							@endif
							<button type="submit" class="btn btn--primary w-100 text-light"> {{ translate('Submit')}}</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="card">
					<div class="card-header bg--lite--violet text-center">
						<h6 class="text-light">{{__($mail->name)}}  {{ translate('Mail Configuration Test Form')}}</h6>
					</div>
					<div class="card-body">
						<form action="{{route('admin.mail.test', $mail->id)}}" method="POST">
							@csrf
							<div class="row"> 
								<label>{{ translate('Test To')}}</label>
								<div class="col-lg-8">
									<input type="email" value="{{@old('email')}}" name="email" class="form-control" placeholder="{{ translate('Put Your Email where you will received a test mail from your mail configuration settings') }}">
								</div>
								<div class="col-lg-4">
									<button class="form-control btn btn--primary" type="submit">{{ translate('Submit')}}</button>
								</div> 
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endsection
