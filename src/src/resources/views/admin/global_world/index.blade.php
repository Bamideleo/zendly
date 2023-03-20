@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="responsive-table">
		                <table class="m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th>{{ translate('Name') }}</th>
                                        <th>{{ translate('Value')}}</th>
                                        <th>{{ translate('Action')}}</th>
                                    </tr>
		                    </thead>
                            <tbody>
                                @forelse ($offensiveData as $key => $data)
                                    <tr>
                                        <td>{{$key}}</td>
                                        <td width="30%">
                                        <form action="{{route('admin.global.world.update')}}" method="POST">
                                            @csrf
                                            <input type="hidden" name="key" value="{{$key}}" class="form-control">
                                            <input type="text" name="value" value="{{$data}}" class="form-control">
                                        </td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-sm text--light">
                                                    <i class="las la-edit"></i>
                                            </button>
                                        </form>
                                            <button class="btn btn-danger btn-sm  text--light worddelete" data-bs-toggle="modal" data-bs-target="#worddelete" data-id="{{$key}}"><i class="las la-trash"></i></button>
                                        </td>
                                    </tr>
                                    @empty

                                    @endforelse
                            </tbody>
		                </table>
		            </div>
	            </div>


	        </div>
	    </div>
	</div>

        <a href="javascript:void(0);" class="support-ticket-float-btn" data-bs-toggle="modal" data-bs-target="#createWord" title="{{ translate('Add New Word')}}">
        <i class="fa fa-plus ticket-float"></i>
    </a>

    {{-- add word --}}
    <div class="modal fade" id="createWord" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('admin.global.world.store')}}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="card">
                            <div class="card-header bg--lite--violet">
                                    <div class="card-title text-center text--light">{{ translate('Add New Word')}}</div>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                        <label for="key" class="form-label">{{ translate('Name')}} <sup class="text--danger">*</sup></label>
                                        <input type="text" class="form-control" id="key" name="key" placeholder="{{ translate('Enter Name')}}" required>
                                </div>
                                <div class="mb-3">
                                        <label for="value" class="form-label">{{ translate('Value')}} <sup class="text--danger">*</sup></label>
                                        <input type="text" class="form-control" id="value" name="value" placeholder="{{ translate('Enter value')}}" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal_button2">
                            <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
                            <button type="submit" class="bg--success">{{ translate('Submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="worddelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{route('admin.global.world.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id">
                    <div class="modal_body2">
                        <div class="modal_icon2">
                            <i class="las la-trash-alt"></i>
                        </div>
                        <div class="modal_text2 mt-3">
                                <h6>{{ translate('Are you sure to want delete this?')}}</h6>
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

</section>




@endsection


@push('scriptpush')
<script>
	(function($){
		"use strict";

		$('.worddelete').on('click', function(){
			var modal = $('#worddelete');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.modal('show');
		});

	})(jQuery);
</script>
@endpush
