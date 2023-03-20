@extends('user.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12 ">
			 <div class="row align--center px-2">
	                	<div class="col-12 col-md-4 col-lg-4 col-xl-5">
	                	
	                	</div>
	                	<div class="col-12 col-md-8 col-lg-8 col-xl-7">
						<form  action="" method="POST">			
	    <div class="row justify-content-end">
	
	<div class="col">
    <input type="text" class="form-control" id="search" name="search" placeholder="Enter Lead Name" aria-label="First name">
  </div>
  <div class="col">

<div class="input-group mb-3">
  <input type="text" class="form-control" id="location" name="location" placeholder="Enter Location" aria-label="Recipient's username" aria-describedby="button-addon2">
  <button class="btn--primary text--light border-0 w-50 px-1 py-2 rounded" type="submit"  id="search-form">Search</button>
</div>
</div>


			                </div>
							</form>
	                	</div>
	                </div>
	      <div class="card mb-4 p-4">
		  <div class="text-center" id='search-loader'  style="display:none">
					<div class="spinner-border text-dark" role="status">
					<span class="visually-hidden">Loading...</span>
					</div>
					</div>
		  <div class="row" id="search-list"></div>
        <div class="row" id="list-data">
        @foreach($value as $val)
  <div class="col-lg-4 mb-4">
    <div class="card">
      <img src="{{$val['image_url']}}" class="card-img-top" alt="..." style="height:250px;">
      <div class="card-body">
        <h6 class="card-title"><span style="font-weight:bold">Name: </span>{{$val['name']}}</h6>
		<h6 class="card-text"><span style="font-weight:bold">Location: </span>{{$val['location']['address1']}}</h6>
		<h6 class="card-text"><span style="font-weight:bold">Contact Info: </span>{{$val['phone']}}</h6>
			<p>&nbsp;</p>
		<a class="btn--primary text--light group" data-bs-toggle="modal" data-bs-target="#updatebrand" href="javascript:void(0)"
			                    			data-id="{{$val['id']}}"
											 data-status="1"
											title="Enable" >View Lead</a>
		<!-- <a href="{{route('user.email.bussiness',$val['id'])}}" class="btn-primary">add to lead</a> -->
      </div>

	
    </div>
  </div>
  @endforeach
</div>
<div class="m-3">
<nav>
<ul class="pagination" id="search-list-2"></ul>
        <ul class="pagination" id="list-data-2">            
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '20'])}}">1</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '40'])}}">2</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '60'])}}">3</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '80'])}}">4</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '100'])}}">5</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '120'])}}">6</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '140'])}}">7</a></li>                                                            
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '160'])}}">8</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '180'])}}">9</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '200'])}}">10</a></li>
<!-- <li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '130'])}}">12</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '140'])}}">13</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '150'])}}">14</a></li> 
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '160'])}}">15</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '170'])}}">16</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '180'])}}">17</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '190'])}}">18</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '200'])}}">19</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '210'])}}">20</a></li>       
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '220'])}}">21</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '230'])}}">22</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '240'])}}">23</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '250'])}}">24</a></li>
<li class="page-item"><a class="page-link" href="{{route('user.email.lead',['model' => '260'])}}">25</a></li> -->
                          
                    </ul>
    </nav>
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
<div class="modal fade" id="updatebrand" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
			<form action="{{route('user.email.contact.store')}}" method="POST">
				@csrf
	            <div class="modal-body">
	            	<div class="card">
		                <div class="card-body">
					<div class="text-center" id='loader' >
					<div class="spinner-border text-dark" role="status">
					<span class="visually-hidden">Loading...</span>
					</div>
					</div>
						<input type="hidden" name="id">
						<input type="hidden" name="email" id="email">
						<input type="hidden" name="name" id="name">
						<div class="lead-data"></div>
						<div class="lead-error"></div>
						</div>
	            	</div>
					<br/>
					<div class="mb-3">

								<select class="form-control" name="email_group_id" id="email_group_id" required>
									<option value="">{{ translate('Select List')}}</option>
									@foreach($groups as $group)
										<option value="{{$group->id}}">{{__($group->name)}}</option>
									@endforeach
								</select>
							</div>
	            </div>
				

	            <div class="modal_button2">
	                <button type="button" class="" data-bs-dismiss="modal">{{ translate('Cancel')}}</button>
	                <button type="submit" class="bg--success">{{ translate('Add To List')}}</button>
	            </div>
	        </form>
        </div>
    </div>
</div>
@endsection


@push('scriptpush')
<script>
var url_load_list =`{{route('user.email.bussiness')}}`;
var url_search_list =`{{route('user.email.search')}}`;
var _token = `{{ csrf_token() }}`;
	(function($){
		"use strict";
		
	    $(document).on('click', '.group', function () {
			var modal = $('#updatebrand');
			modal.find('input[name=id]').val($(this).data('id'));
			modal.modal('show');
			var id = $('input[name=id]').val();
			$('.lead-data').empty();
			$('.lead-error').empty();
			$.ajax({
			type: "POST",
            async: true,
            url:  url_load_list,
            data: {
               "_token":_token,
                id:id,
            },
			cache: false,
			beforeSend: function() {
        $("#loader").show();
            },
           success: function(response) {
			 
			$('.lead-data').empty();
			$('.lead-error').empty();
			$("#loader").hide();
					//   console.log(response.name); 
		$('.lead-data').append('<div><img src="'+response.image+'" alt="" style="width:435px;height:180px;"><br/><br/><h6 class="card-title"><span style="font-weight:bold">Name: </span>'+response.name+'</h6><h6 class="card-title"><span style="font-weight:bold">Email: </span>'+response.email+'</h6><h6 class="card-title"><span style="font-weight:bold">Phone: </span>'+response.phone+'</h6><h6 class="card-title"><span style="font-weight:bold">Address: </span>'+response.address+'</h6><h6 class="card-title"><span style="font-weight:bold">Country: </span>'+response.country+'</h6><h6 class="card-title"><span style="font-weight:bold">City: </span>'+response.city+'</h6></div>');
		$('#email').val(response.email);	
		$('#name').val(response.name);	 
	},
		error: function (error) {
			$('.lead-data').empty();
			$('.lead-error').empty();
			$('.lead-error').append('<div><h6 class="card-title" style="text-align:center;font-weight:bold;">Lead Not Available</h6></div>');
			$("#loader").hide();
		}
			});
		});

	

		// $('#search-form').on('click', function(e){
		$(document).on('click', '#search-form', function (e) {
			e.preventDefault();
			var search = $('input[name=search]').val();
			var location = $('input[name=location]').val();
			var offset = $(this).data('id');
			$('#search-list').empty();
			$('#search-list-2').empty();
			$('#list-data').hide();
			$('#list-data-2').hide();
			$.ajax({
			type: "POST",
            async: true,
            url:  url_search_list,
            data: {
               "_token":_token,
                search:search,
				location:location,
				offset:offset,
            },
			cache: false,
			beforeSend: function() {
        	$("#search-loader").show();
            },
			success: function(response) {
				// console.log(response)
			$("#search-loader").hide();
			$('#list-data').hide();
			$('#list-data-2').hide();
			$('#search-list').empty();
			$('#search-list-2').empty();
			$.each(response, function(index, value){
				$('#search-list').append('<div class="col-lg-4 mb-4"><div class="card"><img src="'+value.image_url+'" class="card-img-top" alt="..." style="height:250px;"><div class="card-body"><h6 class="card-title"><span style="font-weight:bold">Name: </span>'+value.name+'</h6><h6 class="card-text"><span style="font-weight:bold">Location: </span>'+value.location.address1+'</h6><h6 class="card-text"><span style="font-weight:bold">Contact Info: </span>'+value.phone+'</h6><p>&nbsp;</p><a class="btn--primary text--light group" data-bs-toggle="modal" data-bs-target="#updatebrand" href="javascript:void(0)" data-id="'+value.id+'" data-status="1">View Lead</a></div</div></div>');
			});
			
			$('#search-list-2').append('<li class="page-item"><a class="page-link offset" href="javascript:void(0)" id="search-form" data-id="20">1</a></li><li class="page-item"><a class="page-link offset" href="javascript:void(0)" data-id="40" id="search-form">2</a></li><li class="page-item"><a class="page-link offset" href="javascript:void(0)" data-id="60" id="search-form">3</a></li><li class="page-item"><a class="page-link offset" href="javascript:void(0)" data-id="80" id="search-form">4</a></li><li class="page-item"><a class="page-link offset" href="javascript:void(0)" data-id="100" id="search-form">5</a></li><li class="page-item"><a class="page-link offset" id="search-form" href="javascript:void(0)" data-id="120">6</a></li><li class="page-item"><a id="search-form" class="page-link offset" href="javascript:void(0)" data-id="140">7</a></li><li class="page-item"><a class="page-link offset" href="javascript:void(0)" data-id="160" id="search-form">8</a></li><li class="page-item"><a class="page-link offset" id="search-form" href="javascript:void(0)" data-id="180">9</a></li><li class="page-item"><a class="page-link offset" id="search-form" href="javascript:void(0)" data-id="200" id="search-form">10</a>');
			}

		});
			
		})
	})(jQuery);
</script>
@endpush
