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
	                        	<th> {{ translate('#')}}</th>
	                            <th> {{ translate('Name')}}</th>
	                            <th> {{ translate('Image')}}</th>
	                            <th> {{ translate('Method Currency')}}</th>
	                            <th> {{ translate('Status')}}</th>
	                            <th> {{ translate('Action')}}</th>
	                        </tr>
	                    </thead>
	                    @php
	                    $i = 0;
	                    @endphp
	                    @forelse($paymentMethods as $paymentMethod)
	                    @php
	                    $i++;
	                    @endphp
		                    <tr class="@if($loop->even) table-light @endif">
		                    	<td data-label=" {{ translate('#')}}">
		                    		{{__($i)}}
		                    	</td>
			                    <td data-label=" {{ translate('Name')}}">
			                    	{{__($paymentMethod->name)}}
			                    </td>

			                    <td data-label=" {{ translate('Logo')}}">
			                    	<img src="{{showImage(filePath()['payment_method']['path'].'/'.$paymentMethod->image)}}" class="brandlogo">
			                    </td>

			                    <td data-label=" {{ translate('Currency')}}">
			                    	{{$general->currency_name}} = {{shortAmount($paymentMethod->rate)}} {{__($paymentMethod->currency->name)}}
			                    </td>
			                    <td data-label=" {{ translate('Status')}}">
			                    	@if($paymentMethod->status == 1)
			                    		<span class="badge badge--success"> {{ translate('Active')}}</span>
			                    	@else
			                    		<span class="badge badge--danger"> {{ translate('Inactive')}}</span>
			                    	@endif
			                    </td>
			                    <td data-label=" {{ translate('Action')}}">
			                    	@if(substr($paymentMethod->unique_code,0,6) == "MANUAL")
		                    		<a href="{{route('admin.manual.payment.edit',$paymentMethod->id)}}" class="btn--primary text--light"><i class="las la-pen"></i></a>
		                    		@else
		                    		<a href="{{route('admin.payment.edit', [slug($paymentMethod->name), $paymentMethod->id])}}" class="btn--primary text--light"><i class="las la-pen"></i></a>
		                    		@endif
			                    </td>
		                    </tr>
		                @empty
		                	<tr>
		                		<td class="text-muted text-center" colspan="100%"> {{ translate('No Data Found')}}</td>
		                	</tr>
		                @endforelse
	                </table>
	            </div>
	                <nav aria-label="Page navigation example">
						<ul class="pagination justify-content-end">
						   	{{$paymentMethods->links()}}
						</ul>
					</nav>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection

@push('stylepush')
	<style>
		.brandlogo{
			width: 50px;
		}
	</style>
@endpush
