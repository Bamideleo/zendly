@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="table_heading d-flex align--center justify--between">
                    <nav  aria-label="breadcrumb">
					  	<ol class="breadcrumb">
					    	<li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}"> {{ translate('Dashboard')}}</a></li>
					    	<li class="breadcrumb-item" aria-current="page"> {{__($title)}}</li>
					  	</ol>
					</nav>
                    <a href="{{route('admin.manual.payment.index')}}" class="btn--dark text--light border-0 px-3 py-1 rounded ms-3"><i class="las la-angle-double-left"></i>  {{ translate('Go Back')}}</a>
                </div>
				<div class="card">
					<div class="card-header bg--lite--violet">
						<h6 class="card-title text-center text-light"> {{__($title)}}</h6>
					</div>
					<div class="card-body">
						<form action="{{route('admin.manual.payment.update', $manulaPayment->id)}}" method="POST" enctype="multipart/form-data">
							@csrf
							<div class="shadow-lg p-3 mb-5 bg-body rounded">
								<div class="row">

									<div class="mb-3 col-lg-6 col-md-12">
										<label for="name" class="form-label"> {{ translate('Name')}} <sup class="text--danger">*</sup></label>
										<input type="text" name="name" id="name" value="{{$manulaPayment->name}}" class="form-control" placeholder=" {{ translate('Enter Name')}}" required="">
									</div>

									<div class="mb-3 col-lg-6 col-md-12">
										<label for="search_min" class="form-label"> {{ translate('Percent Charge')}} <sup class="text--danger">*</sup></label>
										<div class="input-group">
										  	<input type="text" class="form-control" id="percent_charge" name="percent_charge" value="{{shortAmount($manulaPayment->percent_charge)}}"  placeholder=" {{ translate('Enter Number')}}" aria-describedby="basic-addon2">
										  	<span class="input-group-text" id="basic-addon2">%</span>
										</div>
									</div>

									<div class="mb-3 col-lg-6 col-md-12">
										<label for="currency_id" class="form-label"> {{ translate('Select Currency')}} <sup class="text--danger">*</sup></label>
										<select class="form-control" name="currency_id" id="currency_id" required>
											<option value=""> {{ translate('Select One')}}</option>
											@foreach($currencies as $currency)
												<option value="{{$currency->id}}" @if($manulaPayment->currency_id == $currency->id) selected="" @endif data-rate_value="{{shortAmount($currency->rate)}}">{{__($currency->name)}}</option>
											@endforeach
										</select>
									</div>

									<div class="mb-3 col-lg-6 col-md-12">
										<label for="rate" class="form-label"> {{ translate('Currency Rate')}} <sup class="text--danger">*</sup></label>
										<div class="input-group mb-3">
										  	<span class="input-group-text">1 {{$general->currency_name}} = </span>
										  	<input type="text" name="rate" value="{{shortAmount($manulaPayment->rate)}}" class="method-rate form-control" aria-label="Amount (to the nearest dollar)">
										  	<span class="input-group-text limittext"></span>
										</div>
									</div>


									<div class="mb-3 col-lg-6 col-md-12">
										<label for="image" class="form-label"> {{ translate('Image')}}</label>
										<input type="file" name="image" id="image" class="form-control">
									</div>

									<div class="mb-3 col-lg-6 col-md-12">
										<label for="status" class="form-label"> {{ translate('Status')}} <sup class="text--danger">*</sup></label>
										<select class="form-control" name="status" id="status" required>
											<option value="1" @if($manulaPayment->status == 1) selected="" @endif> {{ translate('Active')}}</option>
											<option value="2" @if($manulaPayment->status == 2) selected="" @endif> {{ translate('Inactive')}}</option>
										</select>
									</div>
								</div>
								@if($manulaPayment->payment_parameter != null)
                                    @foreach($manulaPayment->payment_parameter as $key => $value)
                                    	@if($key=="0")
										<div class="shadow-lg p-3 mb-5 bg-body rounded">
											<h6> {{ translate('Payment Information')}}</h6><hr>
											<div class="row my-3">
												<div class="col-lg-12">
                                                    {{ translate('Put here gateway information while user will see and make payment to here')}}
												</div>
												<div class="col-lg-12">
													<textarea class="form-control" name="payment_gw_info" placeholder=" {{ translate('Give payment gateway information')}}">{{$value->payment_gw_info}}</textarea>
												</div>
											</div>
										</div>
										@endif
									@endforeach
	                            @endif
								<div class="shadow-lg p-3 mb-5 bg-body rounded">
									<h6> {{ translate('User Information')}}</h6><hr>
									<div class="row my-3">
										<div class="col-lg-10 col-md-8 col-sm-12">
                                            {{ translate('Add information to get back from your customer payment method, please click add a new button on the right side')}}
										</div>

										<div class="col-lg-2 col-md-4 col-sm-12">
											<a href="javascript:void(0)" class="btn--primary text--light border-0 rounded newdata"><i class="las la-plus"></i>  {{ translate('Add New')}}</a>
										</div>
									</div>
									<div class="newdataadd">
										@if($manulaPayment->payment_parameter != null)
	                                        @foreach($manulaPayment->payment_parameter as $key => $value)
	                                        	@if($key!="0")
		                                        <div class="row newuserdata  my-2">
										    		<div class="mb-3 col-lg-4">
														<input name="field_name[]" class="form-control" value="{{$value->field_label}}" type="text" required placeholder=" {{ translate('User Field Name')}}">
													</div>

													<div class="mb-3 col-lg-4">
														<select name="field_type[]" class="form-control">
									                        <option value="text" @if($value->field_type == 'text') selected @endif>
		                                                        {{ translate('Input Text')}}
		                                                    </option>
		                                                     <option value="file" @if($value->field_type == 'file') selected @endif>
                                                                {{ translate('File')}}
		                                                    </option>
		                                                    <option value="textarea" @if($value->field_type == 'textarea') selected @endif>
                                                                {{ translate('Textarea')}}
		                                                    </option>
									                    </select>
													</div>

										    		<div class="col-lg-2 col-md-12 mt-md-0 mt-2 text-right">
										                <span class="input-group-btn">
										                    <button class="btn btn-danger btn-sm removeBtn w-100" type="button">
										                        <i class="fa fa-times"></i>
										                    </button>
										                </span>
										            </div>
										        </div>
										        @endif
	                                        @endforeach
	                                    @endif
									</div>
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
	(function($){
		"use strict";
		$("#currency_id").on('change', function(){
			var value = $(this).find("option:selected").text();
			$(".limittext").text(value);
			$(".method-rate").val($('select[name=currency_id] :selected').data('rate_value'));
		}).change();

		$('.newdata').on('click', function(){
	        var html = `
		        <div class="row newdata my-2">
		    		<div class="mb-3 col-lg-4">
						<input name="field_name[]" class="form-control" type="text" required placeholder=" {{ translate('User Field Name')}}">
					</div>

					<div class="mb-3 col-lg-4">
						<select name="field_type[]" class="form-control">
	                        <option value="text" >  {{ translate('Input Text')}} </option>
	                        <option value="file" >  {{ translate('File')}} </option>
	                        <option value="textarea" >  {{ translate('Textarea')}}</option>
	                    </select>
					</div>

		    		<div class="col-lg-2 col-md-12 mt-md-0 mt-2 text-right">
		                <span class="input-group-btn">
		                    <button class="btn btn-danger btn-sm removeBtn w-100" type="button">
		                        <i class="fa fa-times"></i>
		                    </button>
		                </span>
		            </div>
		        </div>`;
	        $('.newdataadd').append(html);
	    });

	    $(document).on('click', '.removeBtn', function () {
	        $(this).closest('.newuserdata').remove();
	    });
	})(jQuery);
</script>
@endpush
