@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">@if($gsd->access_id == 1)
				Admin
				@elseif($gsd->access_id == 3)
				Agent
				@endif Dashboard</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row">
			<div class="col-lg-12 mb-1">
				<div class="card mt-3">
					<div class="card-header">
						<h4 class="card-title font-weight-normal">@lang('Referrer Link')</h4>
					</div>
					<div class="card-body">
						<form id="copyBoard1" >
							<div class="form-row align-items-center">
								<div class="col-md-10 my-1">
									<input value="{{route('register')}}/?ref={{auth()->user()->username}}" type="url" id="ref1" class="form-control from-control-lg" readonly>
								</div>
								<div class="col-md-2 my-1">
									<button   type="button" @click="copyBtnClick" data-copytarget="#ref1" id="copybtn1" class="btn btn-primary btn-block"> <i class="fa fa-copy"></i> @lang('Copy')</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>

			<div class="col-lg-12 mb-1">
				<div class="card mt-3">
					<div class="card-body">
						<div>
							<h3> My Affiliates </h4>
						</div>
						<br>
						<form action="{{ route('my_refer')}}" method="GET">
							<div class="form-row align-items-center">
							    
								<div class="col-md-4 my-1 d-flex">
								     <a href="{{ route('my_refer') }}" class="btn btn-info">All</a>
									<button type="submit" class="ml-2 btn btn-primary ">@lang('Search')</button>
									<input name="month_year" type="month" class="form-control from-control-lg d-inline-block" value="{{ $monthYear }}">
								</div>
								
								<div class="col-md-2 my-1">
									<div class="dbx">
										Total Member == {{ $tuc }}
									</div>
								</div>
								<div class="col-md-2 my-1">
									<div class="dbx">
										Paid Member == {{ $paid }}
									</div>
								</div>
								<div class="col-md-2 my-1">
									<div class="dbx">
										Free Member == {{ $free}}
									</div>
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-12 ">
				<div class="card b-radius--10 overflow-hidden">
					<div class="card-body p-2">
	
						<div class="table-responsive">
							<table class="table table-bordered table-striped m-0">
								<thead>
								<tr>
									<th scope="col">@lang('Sl')</th>
									<th scope="col">@lang('Username')</th>
									<th scope="col">@lang('Name')</th>
									<th scope="col">@lang('Email')</th>
									<th scope="col">@lang('Join Date')</th>
								</tr>
								</thead>
								<tbody>
								@forelse($users as $key=>$user)
									<tr>
										<td data-label="@lang('Sl')" >{{$users->firstItem()+$key}}</td>
										<td data-label="@lang('Username')">{{$user->username}}</td>
										<td data-label="@lang('Name')">{{$user->name}}</td>
										<td data-label="@lang('Email')">{{$user->email}}</td>
										<td data-label="@lang('Join Date')">
											@if($user->created_at != '')
											{{ $user->created_at }}
									
											@endif
										</td>
									</tr>
								@empty
									<tr>
										<td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
									</tr>
								@endforelse
	
								</tbody>
							</table>
							<hr>
							{{ $users->links() }}
						</div>
					</div>
					<div class="card-footer py-4">
				
					</div>
				</div>
			</div>

			<div class="col-lg-12 mb-1">
				<div class="card mt-3">
					<div class="card-body">
						<div>
							<h3>My Sponsors </h4>
						</div>
						<br>
					
						<form action="{{ route('my_refer')}}" method="GET">
							<div class="form-row align-items-center">
							    
								<div class="col-md-4 my-1 d-flex">
								     <a href="{{ route('my_refer') }}" class="btn btn-info">All</a>
									<button type="submit" class="ml-2 btn btn-primary ">@lang('Search')</button>
									<input name="month_year" type="month" class="form-control from-control-lg d-inline-block" value="{{ $monthYear }}">
								</div>
								
								<div class="col-md-2 my-1">
									<div class="dbx">
										Total Member == {{ $sponsors_info['total'] }}
									</div>
								</div>
								<div class="col-md-2 my-1">
									<div class="dbx">
										Paid Member == {{ $sponsors_info['paid'] }}
									</div>
								</div>
								<div class="col-md-2 my-1">
									<div class="dbx">
										Free Member == {{ $sponsors_info['free']}}
									</div>
								</div>
								
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-lg-12 ">
				<div class="card b-radius--10 overflow-hidden">
					<div class="card-body p-2">
	
						<div class="table-responsive">
							<table class="table table-bordered table-striped m-0">
								<thead>
								<tr>
									<th scope="col">@lang('Sl')</th>
									<th scope="col">@lang('Username')</th>
									<th scope="col">@lang('Name')</th>
									<th scope="col">@lang('Email')</th>
									<th scope="col">@lang('Join Date')</th>
								</tr>
								</thead>
								<tbody>
								@forelse($sponsors_info['users'] as $key=>$user)
									<tr>
										<td data-label="@lang('Sl')" >{{$users->firstItem()+$key}}</td>
										<td data-label="@lang('Username')">{{$user->username}}</td>
										<td data-label="@lang('Name')">{{$user->name}}</td>
										<td data-label="@lang('Email')">{{$user->email}}</td>
										<td data-label="@lang('Join Date')">
											@if($user->created_at != '')
											{{ $user->created_at }}
									
											@endif
										</td>
									</tr>
								@empty
									<tr>
										<td class="text-muted text-center" colspan="100%">{{ __($empty_message) }}</td>
									</tr>
								@endforelse
	
								</tbody>
							</table>
							<hr>
							{{ $users->links() }}
						</div>
					</div>
					<div class="card-footer py-4">
				
					</div>
				</div>
			</div>



		</div>
    </div>
	
@endsection
@push('css')
	<style>
		.dbx{
			border:1px solid green;
			padding: 5px 10px;
		}
	</style>
@endpush
   
@push('script')
<script>
	'use strict';
	(function($) {
		document.body.addEventListener('click', copy, true);
		function copy(e) {
			var
				t = e.target,
				c = t.dataset.copytarget,
				inp = (c ? document.querySelector(c) : null);
			if (inp && inp.select) {
				inp.select();
				try {
					document.execCommand('copy');
					inp.blur();
					t.classList.add('copied');
					setTimeout(function() { t.classList.remove('copied'); }, 1500);
				}catch (err) {
					alert(`@lang('Please press Ctrl/Cmd+C to copy')`);
				}
			}
		}
	})(jQuery);
</script>
@endpush