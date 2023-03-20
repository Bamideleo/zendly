@extends('admin.layouts.app')
@section('panel')
<section class="mt-3">
    <div class="container-fluid p-0">
	    <div class="row">
	 		<div class="col-lg-12">
	            <div class="card mb-4">
	                <div class="responsive-table">
		                <table class="w-100 m-0 text-center table--light">
		                    <thead>
		                        <tr>
		                            <th> {{ translate('Name')}}</th>
		                            <th> {{ translate('Subject')}}</th>
		                            <th> {{ translate('Status')}}</th>
		                            <th> {{ translate('Action')}}</th>
		                        </tr>
		                    </thead>
		                    @forelse($emailTemplates as $emailTemplate)
			                    <tr class="@if($loop->even) table-light @endif">
				                    <td data-label=" {{ translate('Name')}}">
				                    	{{__($emailTemplate->name)}}
				                    </td>

				                    <td data-label=" {{ translate('Subject')}}">
				                    	{{__($emailTemplate->subject)}}
				                    </td>

				                    <td data-label=" {{ translate('Status')}}">
				                    	@if($emailTemplate->status == 1)
				                    		<span class="badge badge--success"> {{ translate('Active')}}</span>
				                    	@else
				                    		<span class="badge badge--danger"> {{ translate('Inactive')}}</span>
				                    	@endif
				                    </td>

				                    <td data-label={{ translate('Action') }}>
			                    		<a class="btn--primary text--light" href="{{route('admin.mail.templates.edit', $emailTemplate->id)}}"><i class="las la-pen"></i></a>
				                    </td>
			                    </tr>
			                @empty
			                	<tr>
			                		<td class="text-muted text-center" colspan="100%"> {{ translate('No Data Found')}}</td>
			                	</tr>
			                @endforelse
		                </table>
		            </div>
	                <div class="m-3">
						{{$emailTemplates->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection

