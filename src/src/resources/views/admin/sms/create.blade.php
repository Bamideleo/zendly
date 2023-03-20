@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row d-flex align--center rounded">
			<div class="col-xl-12">
				<div class="col-xl">
					<form action="{{route('admin.sms.store')}}" method="POST" enctype="multipart/form-data">
						@csrf
					    <div class="card mb-2">
						    <h6 class="card-header"{{ translate('To recipient number collect in a different ways')}}</h6>
						    <div class="card-body">
					    		<div class="row">
					          		<div class="mb-3">
					            		<label class="form-label">
					            			{{ translate('To Recipient Number')}}
					            		</label>
					            		<div class="input-group input-group-merge">
					              			<div class="input-group">
									          <span class="input-group-text" id="basic-addon11">({{$general->country_code}})</span>
									          <input type="text"  class="form-control" name="number" id="number" placeholder="{{ translate('Enter with country code ')}}{{$general->country_code}}{{ translate('XXXXXXXXX')}}" aria-label="number" aria-describedby="basic-addon11">
									        </div>
					            		</div>
					          		</div>
					          		<div class="col-md-6 mb-4">
					            		<label class="form-label">
					            			{{ translate('To Recipient Number From Group')}}
					            		</label>
					            		<div class="input-group input-group-merge">
								            <select class="form-control keywords" name="group_id[]" id="group" multiple="multiple">
												<option value="" disabled="">{{ translate('Select One')}}</option>
												@foreach($groups as $group)
													<option value="{{$group->id}}">{{__($group->name)}}</option>
												@endforeach
											</select>
					            		</div>
					            		<div class="form-text">
					            			{{ translate('Can be select single or multiple group')}}
										</div>
					          		</div>
					          		<div class="col-md-6 mb-4">
					            		<label class="form-label">
					            			{{ translate('To Recipient Number From File Upload')}}
					            		</label>
					            		<div class="input-group input-group-merge">
					              			<input class="form-control" type="file" name="file" id="file">
					            		</div>
					            		<div class="form-text">
					            			{{ translate('Supported files: txt, csv, excel. Download all files from here: ')}} {{ translate('')}}
											<a href="{{route('demo.file.downlode', 'txt')}}">{{ translate('txt')}},</a>
											<a href="{{route('demo.file.downlode', 'csv')}}">{{ translate('csv')}}, </a>
											<a href="{{route('demo.file.downlode', 'xlsx')}}">{{ translate('xlsx')}}</a>
										</div>
					          		</div>
					    		</div>
					      	</div>
					    </div>
					    <div class="card mb-2">
						    <h6 class="card-header">{{ translate('SMS Body')}}</h6>
						    <div class="card-body">
				          		<div class="row">
				          			<div class="mb-3">
					            		<label class="form-label">
					            			{{ translate('Select SMS Type')}} <sup class="text-danger">*</sup>
					            		</label>
					            		<div class="input-group input-group-merge">
					              			<div class="form-check form-check-inline">
					              				<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="smsType" id="smsTypeText" value="plain" checked="">
													<label class="form-check-label" for="smsTypeText">{{ translate('Text')}}</label>
												</div>

												<div class="form-check form-check-inline">
													<input class="form-check-input" type="radio" name="smsType" id="smsTypeUnicode" value="unicode">
													<label class="form-check-label" for="smsTypeUnicode">{{ translate('Unicode')}}</label>
												</div>
                                            </div>
					            		</div>
					          		</div>

					          		<div class="md-12">
					            		<label class="form-label">
					            			{{ translate('Write Message')}} <sup class="text-danger">*</sup>
					            		</label>
					            		<div class="input-group input-group-merge speech-to-text" id="messageBox">
										  	<textarea class="form-control" name="message" id="message" placeholder="{{ translate('Enter SMS Content &  For Mention Name Use ')}}@php echo "{{". 'name' ."}}"  @endphp" aria-describedby="text-to-speech-icon"></textarea>
										  	<span class="input-group-text" id="text-to-speech-icon">
										    	<i class='fa fa-microphone pointer text-to-speech-toggle'></i>
										  	</span>
										</div>
					            		<div class="input-group">
					            			<a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#templatedata">{{ translate('Use Template')}}</a>
					            		</div>
					            		<div class="text-end message--word-count"></div>
					          		</div>
				          		</div>
					      	</div>
					    </div>

					    <div class="card mb-2">
						    <h6 class="card-header">{{ translate('SMS Send Options')}}</h6>
						    <div class="card-body">
				          		<div class="row">
				          			<div class="col-md-6 mb-4">
				          				<label for="schedule" class="form-label">{{ translate('SMS')}} <sup class="text-danger">*</sup></label>
										<div>
											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="schedule" id="schedule" value="1" checked="">
												<label class="form-check-label" for="schedule">{{ translate('Send Now')}}</label>
											</div>

											<div class="form-check form-check-inline">
												<input class="form-check-input" type="radio" name="schedule" id="schedule2" value="2">
												<label class="form-check-label" for="schedule2">{{ translate('Send Later')}}</label>
											</div>
										</div>
					          		</div>
					          		<div class="col-md-6 scheduledate"></div>
				          		</div>
				          	</div>
				          </div>
					    <button type="submit" class="btn btn-primary me-sm-3 me-1">Submit</button>
				    </form>
				</div>
			</div>
		</div>
	</div>
</section>


<div class="modal fade" id="templatedata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
            	<div class="card">
            		<div class="card-header bg--lite--violet">
            			<div class="card-title text-center text--light">{{ translate('SMS Template')}}</div>
            		</div>
	                <div class="card-body">
						<div class="mb-3">
							<label for="template" class="form-label">{{ translate('Select Template')}} <sup class="text--danger">*</sup></label>
							<select class="form-control" name="template" id="template" required>
								<option value="" disabled="" selected="">{{ translate('Select One')}}</option>
								@foreach($templates as $template)
									<option value="{{$template->message}}">{{$template->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
            	</div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('scriptpush')
<script>
	(function($){
		"use strict";
		$('.keywords').select2({
			tags: true,
			tokenSeparators: [',']
		});

		$('input[type=radio][name=schedule]').on('change', function(){
	        if(this.value == 2){
	        	var html = `
	        		<label for="shedule_date" class="form-label">{{ translate('Schedule')}}<sup class="text-danger">*</sup></label>
					<input type="datetime-local" name="shedule_date" id="shedule_date" class="form-control" required="">`;
	        	$('.scheduledate').append(html);
	        }else{
	        	$('.scheduledate').empty();
	        }
	    });

	    $('select[name=template]').on('change', function(){
	    	var character = $(this).val();
	    	$('textarea[name=message]').val(character);
		    $('#templatedata').modal('toggle');
		});

		$(`textarea[name=message]`).on('keyup', function(event) {
		 	var credit = 160;
            var character = $(this).val();
            var characterleft = credit - character.length;
            var word = character.split(" ");
            var sms = 1;
			if (character.length > 160) {
    			sms = Math.ceil(character.length / 160);
    		}
            if (character.length > 0) {
                $(".message--word-count").html(`
                	<span class="text--success character">${character.length}</span> {{ translate('Character')}} |
					<span class="text--success word">${word.length}</span> {{ translate('Words')}} |
					<span class="text--success word">${sms}</span> {{ translate('SMS')}} (160 Char./SMS)`);
            }else{
                $(".message--word-count").empty()
            }
        });

        var t = window.SpeechRecognition || window.webkitSpeechRecognition,
            e = document.querySelectorAll(".speech-to-text");
	    if (null != t && null != e) {
	        var n = new t;
            var e = !1;
        	$('#text-to-speech-icon').on('click',function () {
				var messageBox = document.getElementById('messageBox');
				messageBox.querySelector(".form-control").focus(), n.onspeechstart = function() {
                    e = !0
                }, !1 === e && n.start(), n.onerror = function() {
                    e = !1
                }, n.onresult = function(e) {
                    messageBox.querySelector(".form-control").value = e.results[0][0].transcript
                }, n.onspeechend = function() {
                    e = !1, n.stop()
                }
			});
	    }

	})(jQuery);


</script>
@endpush

