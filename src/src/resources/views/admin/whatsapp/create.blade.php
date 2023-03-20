@extends('admin.layouts.app')
@section('panel')
<section class="mt-3 rounded_box">
	<div class="container-fluid p-0 mb-3 pb-2">
		<div class="row">
			<div class="col-xl-4">
                <form action="{{route('admin.gateway.whatsapp.create')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card mb-2">
                        <div class="card-header">
                            {{ translate('Whatsapp Device Add')}}
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 mb-4">
                                    <label for="name">{{ translate('Name')}} <span  class="text-danger">*</span>  </label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror " name="name" id="name" value="{{old('name')}}" placeholder="{{ translate('Put Session Name (Any)')}}">
                                    @error('name')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="number">{{ translate('Number')}} <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control @error('number') is-invalid @enderror " name="number" id="number" value="{{old('number')}}" placeholder="{{ translate('Put Your WhatsApp number here')}}">
                                    @error('number')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="description">{{ translate('Description')}}</label>
                                    <textarea name="description" id="description" class="form-control" placeholder="{{ translate('Remark Your WhatsApp device(any)')}}">{{old('description')}}</textarea>
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="multidevice">{{ translate('Multi Device')}}
                                        <span class="text-danger" >*</span>
                                    </label>
                                    <select name="multidevice" id="multidevice" class="form-control @error('multidevice') is-invalid @enderror ">
                                        <option value="">{{ translate('Select One')}}</option>
                                        <option {{old('multidevice') == 'yes' ? 'selected' : ' '}} value="yes">{{ translate('YES')}}</option>
                                        <option {{old('multidevice') == 'no' ? 'selected' : ' '}} value="no">{{ translate('No')}}</option>
                                    </select>
                                    @error('multidevice')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-4">
                                    <label for="delay_time">{{ translate('Message Delay Time')}}
                                        <span class="text-danger" >*</span>
                                    </label>
                                    <input type="number" class="form-control @error('delay_time') is-invalid @enderror " name="delay_time" id="delay_time" value="{{old('delay_time')}}" placeholder="{{ translate('Message delay time in second')}}">
                                    @error('delay_time')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 float-end">{{ translate('Submit')}}</button>
                        </div>
                    </div>
                </form>
			</div>
            <div class="col-xl-8">
                <div class="card mb-2">
                    <div class="card-header">
                        {{ translate('WhatsApp Device List')}}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <tr>
                                    <th>{{ translate('Name')}}</th>
                                    <th>{{ translate('Number')}}</th>
                                    <th>{{ translate('Description')}}</th>
                                    <th>{{ translate('Status')}}</th>
                                    <th>{{ translate('Multi Device')}}</th>
                                    <th>{{ translate('Action')}}</th>
                                </tr>
                                @forelse ($whatsapps as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->number}}</td>
                                    <td>{{$item->description}}</td>
                                    <td>
                                        <span class="badge bg-{{$item->status == 'initiate' ? 'primary' : ($item->status == 'connected' ? 'success' : 'danger')}}">
                                            {{ucwords($item->status)}}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge bg-{{$item->multidevice == 'YES' ? 'primary' : 'danger'}}">
                                            {{$item->multidevice}}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->status == 'initiate')
                                            <a title="Scan" href="javascript:void(0)" id="textChange" class="badge bg-success p-2 qrQuote textChange{{$item->id}}" value="{{$item->id}}"><i class="fas fa-qrcode"></i>&nbsp {{ translate('Scan')}}</a>
                                        @elseif($item->status == 'connected')
                                        <a title="Disconnect" href="javascript:void(0)" onclick="return deviceStatusUpdate('{{$item->id}}','disconnected','deviceDisconnection','Disconnecting','Connect')" class="badge bg-danger p-2 deviceDisconnection{{$item->id}}" value="{{$item->id}}"><i class="fas fa-plug"></i>&nbsp {{ translate('Disconnect')}}</a>
                                        @else
                                        <a title="Scan" href="javascript:void(0)" id="textChange" class="badge bg-success p-2 qrQuote textChange{{$item->id}}" value="{{$item->id}}"><i class="fas fa-qrcode"></i>&nbsp {{ translate('Scan')}}</a>
                                        @endif

                                        <a title="Edit" href="{{route('admin.gateway.whatsapp.edit', $item->id)}}" class="badge bg-primary p-2"><i class="fas fa-pen"></i></a>

                                        <a title="Delete" href="" class="badge bg-danger p-2 whatsappDelete" value="{{$item->id}}"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="50"><span class="text-danger">{{ translate('No data Available')}}</span></td>
                                    </tr>
                                @endforelse
                            </table>
                        </div>
                        <div class="m-3">
                            {{$whatsapps->appends(request()->all())->links()}}
                        </div>
                    </div>
                </div>
		    </div>
	   </div>
    </div>
</section>

{{-- whatsapp delete modal --}}
<div class="modal fade" id="whatsappDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('admin.gateway.whatsapp.delete')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id" value="">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash-alt"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6>{{ translate('Are you sure to delete')}}</h6>
	                </div>
	            </div>
	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--danger">{{ translate('Delete')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>

{{-- whatsapp qrQoute scan --}}
  <div class="modal fade" id="qrQuoteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="staticBackdropLabel">{{ translate('Scan Device')}}</h5>
          <button type="button" class="btn-close" aria-label="Close" onclick="return deviceStatusUpdate('','initiate','','','')"></button>
        </div>
        <div class="modal-body">
            <input type="hidden" name="scan_id" id="scan_id" value="">
            <div>
                <h4 class="py-3">{{ translate('To use WhatsApp')}}</h4>
                <ul>
                    <li>{{ translate('1.Open WhatsApp on your phone')}}</li>
                    <li>{{ translate('2.Tap Menu  or Settings  and select Linked Devices')}}</li>
                    <li>{{ translate('3.Point your phone to this screen to capture the code')}}</li>
                </ul>
            </div>
          <div class="text-center">
                <img id="qrcode" class="w-50" src="" alt="">
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
        $(document).on('click', '.whatsappDelete', function(e){
            e.preventDefault()
            var id = $(this).attr('value')
            var modal = $('#whatsappDelete');
			modal.find('input[name=id]').val(id);
			modal.modal('show');
        })

        // recursive function
        function middlePass(id , url, sessionId){
            whatsappSeesion(id, url, sessionId)
        }

        // qrQuote scan
        $(document).on('click', '.qrQuote', function(e){
            e.preventDefault()
            var id = $(this).attr('value')
            var url = "{{route('admin.gateway.whatsapp.qrcode')}}"

            whatsappSeesion(id, url)

        })

        function whatsappSeesion(id, url)
        {
            $.ajax({
                headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
                url:url,
                data: {id:id},
                dataType: 'json',
                method: 'post',
                beforeSend: function(){
                    $('.textChange'+id).html(`{{ translate('Loading...')}}`);
                },
                success: function(res){
                    console.log(res)
                    $("#scan_id").val(res.response.id);

                    if (res.qr!='') {
                        $('#qrcode').attr('src',res.qr);
                    }

                    if(res.data != 'error' || res.data!='' || res.data!='connected'){
                        $('#qrQuoteModal').modal('show');
                        sleep(10000).then(() => {
                            wapSession(id, url);
                        });
                    }
                },
                complete: function(){
                    $('.textChange'+id).html(`<i class="fas fa-qrcode"></i>&nbsp {{ translate('Scan')}}`);
                }
            })
        }
	})(jQuery);

    function wapSession(id,url) {
        $.ajax({
            headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
            url:url,
            data: {id:id},
            dataType: 'json',
            method: 'post',
            success: function(res){
                $("#scan_id").val(res.response.id);
                if (res.qr!='')
                {
                    $('#qrcode').attr('src',res.qr);
                }
                if(res.data != 'error' || res.data!='' || res.data!='connected')
                {
                    sleep(10000).then(() => {
                        wapSession(id, url);
                    });
                }
                if (res.data=='connected')
                {
                    sleep(2500).then(() => {
                        $('#qrQuoteModal').modal('hide');
                        location.reload();
                    });
                }
            }
        })
    }


    function deviceStatusUpdate(id,status,className='',beforeSend='',afterSend='') {
        if (id=='') {
            id = $("#scan_id").val();
        }
        $('#qrQuoteModal').modal('hide');
           $.ajax({
            headers: {'X-CSRF-TOKEN': "{{csrf_token()}}"},
            url:"{{route('admin.gateway.whatsapp.status-update')}}",
            data: {id:id,status:status},
            dataType: 'json',
            method: 'post',
            beforeSend: function(){
                if (beforeSend!='') {
                    $('.'+className+id).html(beforeSend);
                }
            },
            success: function(res){
                sleep(1000).then(()=>{
                    location.reload();
                })
            },
            complete: function(){
                if (afterSend!='') {
                    $('.'+className+id).html(afterSend);
                }
            }
        })
    }

</script>
@endpush

