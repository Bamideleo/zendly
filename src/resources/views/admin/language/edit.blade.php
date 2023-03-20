@extends('admin.layouts.app')
@push('style-include')
<link rel="stylesheet" href="{{asset('assets/dashboard/css/dataTables.bootstrap5.min.css')}}"> 
<style type="text/css">
	table{ 
	  clear: both;
	  border-collapse: collapse;
	  table-layout: fixed;
	  word-wrap:break-word;
	}
	thead>tr>th{
        color: #FFFFFF!important;
    }
    td,th{
    	white-space: normal!important;
    }
</style>
@endpush

@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12 p-1">
	            <div class="rounded_box">
	                <div class="table_heading d-flex align--center justify--between">
	                    <h6 class="my-3">{{ translate($title) }}</h6>
	                </div>
	                <div class="table-responsive">
		                <table id="translate-table" class="table--light" cellspacing="0" width="100%">
		                    <thead>
		                    	<tr>
	                                <th>{{ translate('Key') }}</th>
		                            <th>{{__($language->name) }}</th>
		                            <th>{{ translate('Action') }}</th>
		                        </tr>
		                    </thead>
		                    <tbody>
		                    @forelse($datas as $key => $data)
			                    	<tr class="@if($loop->even) table-light @endif">
		                                <td data-label="{{ translate('Value') }}">
		                                    {{ $data }}
					                    </td>
					                    <td data-label="{{ translate('Value') }}">
		                                    <input id="lang-key-value-{{ $loop->iteration }}" class="form-control" value="{{ $data }}" type="text">
					                    </td>
					                    <td data-label="{{ translate('Action') }}">
				                    		<a href="javascript:void(0)" class="btn--primary text--light"
				                    		id="updatelanguage"
				                    		data-key="{{$key}}"
				                    		data-code="{{$language->code}}"
		                                    unique-id="{{$loop->iteration}}"
				                    		data-value="{{$data}}"><i class="lar la-save"></i></a>

				                    		<a href="javascript:void(0)" class="btn--danger text--light languagedelete"
				                    		data-bs-toggle="modal"
				                    		data-bs-target="#delete"
				                    		data-key="{{$key}}"><i class="las la-trash"></i></a>
					                    </td>
				                    </tr>
			                @empty 
			                		<tr>
				                		<td class="text-muted text-center" colspan="100%"> 
				                			{{ translate('No Data Found') }}
				                		</td>
				                	</tr>
			                @endforelse
			                </tbody>
		                </table>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>

<div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        	<form action="{{route('admin.language.data.delete')}}" method="POST">
        		@csrf
        		<input type="hidden" name="id" value="{{$language->id}}">
        		<input type="hidden" name="key">
	            <div class="modal_body2">
	                <div class="modal_icon2">
	                    <i class="las la-trash-alt"></i>
	                </div>
	                <div class="modal_text2 mt-3">
	                    <h6> {{ translate('Are you sure to want delete this keyword?') }}</h6>
	                </div>
	            </div>
	            <div class="modal_button2">
	                <button type="button" data-bs-dismiss="modal"> {{ translate('Cancel') }}</button>
	                <button type="submit" class="bg--danger"> {{ translate('Delete') }}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
@endsection

@push('script-include')
   <script src="{{asset('assets/dashboard/js/jquery.dataTables.min.js')}}"></script>
   <script src="{{asset('assets/dashboard/js/dataTables.bootstrap5.min.js')}}"></script> 
@endpush
@push('scriptpush')
<script>
	(function($){
       	"use strict";
        //data table
        // var table = $('#translate-table').DataTable( {
        //   fixedHeader: true, 
        //   columnDefs: [
        //   	{ width: "500px", targets: 0 },{ width: "500px", targets: 1 }],
        // });
       	$(document).ready(function(){
	        $('#translate-table').DataTable({
	            columnDefs: [
	                { width: "50px", targets: [2] }
	            ],
	        });
	    });

		$('.language').on('click', function(){
			var modal = $('#updatelanguage');
			modal.find('input[name=key]').val($(this).data('key'));
			modal.find('input[name=value]').val($(this).data('value'));
			modal.modal('show');
		});

		$('.languagedelete').on('click', function(){
			var modal = $('#delete');
			modal.find('input[name=key]').val($(this).data('key'));
			modal.modal('show');
		});

        //update lang key method

        $(document).on('click','#updatelanguage',function(e){
            e.preventDefault()
            const code = $(this).attr('data-code')
            const id = $(this).attr('unique-id')
            const keyValue = $(`#lang-key-value-${id}`).val()
            const key= $(this).attr('data-key')
            const data = {
                "code":code,
                "key":key,
                "keyValue":keyValue,
              }
            updateLangKeyValue(data)
          })

          //update language value function
          function updateLangKeyValue(data){

            $.ajax({
              method:'post',
              url: "{{ route('admin.language.data.update') }}",
              headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              data:{
                data
              },
              dataType: 'json'
            }).then(response => {
				if(response.status == '200'){
					notify('success',response.message)
				}
				else{
					notify('error','Translation Failed')
				}
            })
          }
	})(jQuery);
</script>
@endpush
