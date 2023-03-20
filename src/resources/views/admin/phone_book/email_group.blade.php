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
	                            <th> {{ translate('Name')}}</th>
	                            <th> {{ translate('User')}}</th>
	                            <th> {{ translate('Contact')}}</th>
	                            <th> {{ translate('Status')}}</th>
	                        </tr>
	                    </thead>
	                    @forelse($emailGroups as $emailGroup)
		                    <tr class="@if($loop->even) table-light @endif">
			                    <td data-label=" {{ translate('Name')}}">
			                    	{{__($emailGroup->name)}}
			                    </td>
			                    <td data-label=" {{ translate('User')}}">
			                    	<a href="{{route('admin.user.details', $emailGroup->user_id)}}" class="fw-bold text-dark">{{__(@$emailGroup->user->email)}}</a>
			                    </td>

			                    <td data-label=" {{ translate('Contact')}}">
			                    	<a href="{{route('admin.group.email.groupby', $emailGroup->id)}}" class="s_btn--primary text--light"> {{ translate('view email')}}</a>
			                    </td>
			                    <td data-label=" {{ translate('Status')}}">
			                    	@if($emailGroup->status == 1)
			                    		<span class="badge badge--success"> {{ translate('Active')}}</span>
			                    	@else
			                    		<span class="badge badge--danger"> {{ translate('Inactive')}}</span>
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
	                <div class="m-3">
	                	{{$emailGroups->appends(request()->all())->links()}}
					</div>
	            </div>
	        </div>
	    </div>
	</div>
</section>
@endsection
