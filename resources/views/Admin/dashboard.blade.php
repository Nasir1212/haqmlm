@extends('layouts.Back.app')
@section('content')
<style>
.badgelg {
    font-size: 20px;
    display: flex;
    justify-content: space-between;
    height: 42px;
    align-items: center;
}
	.NBoard {
		background: #fff;
		border: 1px solid black;
		border-radius: 3px;
		min-height: 200px;
		padding: 20px;
		color: #000;
}
.news_wrap{
	border: 1px solid #000;
	padding: 10px;
	margin: 5px;
	background: #fff;
	color: #000;

}
</style>
@php
    use App\Models\CountTotalSubmittedPoint;
   
@endphp
	<div class="main-container">

		<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">@if($gsd->id == 1)
				Admin
				@endif
				Dashboard</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->

		<!-- Row start -->

	@if ($power == 'management')

	
	<div class="card mt-3">
					<div class="card-body">
						<form action="{{ route('dashboard_index') }}" method="GET">
							<div class="form-row align-items-center">
							    	<div class="col-md-2 my-1">
							    <button onclick="history.back()" class="btn btn-dark">Go Back</button>
							    	<a href="{{ route('dashboard_index') }}" class="btn btn-success">All</a>
							    </div>
								<div>From</div>
								<div class="col-md-2 my-1">
									<input name="date" type="month" class="form-control from-control-lg" value="<?php if(isset($_GET['date'])){ echo $_GET['date'];}else{ echo now()->format('Y-m'); } ?>">
								</div>
								<div>
								{{-- <input onclick="handle_e_date(this)" name="is_to" type="checkbox" class="form-control from-control-lg" > --}}
									<input 
									type="checkbox" 
									id="rangeCheckbox" 
									name="is_to" 
									{{ request('e_date') ? 'checked' : '' }}
									onchange="handle_e_date(this)"
									>
								</div>
								<div>To</div>
								<div class="col-md-2 my-1" >
									<input id="e_date" name="{{ request('is_to') ==  'on'? 'e_date' : '' }}" type="month" class="form-control from-control-lg {{ request('e_date') ? '' : 'd-none' }}" value="<?php if(isset($_GET['e_date'])){ echo $_GET['e_date'];}else{ echo now()->addMonths(1)->format('Y-m'); } ?>">
								</div>
							
									<div class="col-md-2 my-1">
									<button type="submit" class="btn btn-primary btn-block">Search</button>
								</div>
							</div>
						</form>
					</div>
				</div>
		<div class="row gutters">
		
		
			
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
				<a href="{{ url('/users') . (request()->only(['date', 'e_date']) ? '?' . http_build_query(request()->only(['date', 'e_date'])) : '') }}" class="link-light menu-text">
				<div class="info-stats2">
					<div class="info-icon success">
						<i class="icon-users"></i>
					</div>
					<div class="sale-num">
						<h3>{{ getAmount($total_users) }}</h3>
						<p>Users</p>
					</div>
				</div>
				</a>
			</div>
			
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
				<a href="{{url('/users-active'). (request()->only(['date', 'e_date']) ? '?' . http_build_query(request()->only(['date', 'e_date'])) : '') }}" class="link-light menu-text">
				<div class="info-stats2">
					<div class="info-icon danger">
						<i class="icon-users"></i>
					</div>
					
					<div class="sale-num">
						<h3>{{ $matrix_inac_users }}</h3>
						<p>Total Active Member</p>
					</div>
					
				</div>
				</a>
			</div>
		
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
			<a href="{{url('/free-user'). (request()->only(['date', 'e_date']) ? '?' . http_build_query(request()->only(['date', 'e_date'])) : '') }}" class="link-light menu-text">
				<div class="info-stats2">
					<div class="info-icon success">
						<i class="icon-users"></i>
					</div>
					<div class="sale-num">
						<h3>{{ $matrix_ac_users }}</h3>
						<p>Total Free Members</p>
					</div>
				</div>
			</a>
			</div>
			
	
		

			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
				<a href="{{url('/locked-users'). (request()->only(['date', 'e_date']) ? '?' . http_build_query(request()->only(['date', 'e_date'])) : '') }}" class="link-light menu-text">
				<div class="info-stats2">
					<div class="info-icon danger">
						<i class="icon-lock"></i>
					</div>
					<div class="sale-num">
						<h3>{{ $total_locked }}</h3>
						<p>Total Locked Member</p>
					</div>
				</div>
				</a>
			</div>

			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
				<a href="{{url('/users-band'). (request()->only(['date', 'e_date']) ? '?' . http_build_query(request()->only(['date', 'e_date'])) : '') }}" class="link-light menu-text">
				<div class="info-stats2">
					<div class="info-icon danger">
						<i class="icon-users"></i>
					</div>
					<div class="sale-num">
						<h3>{{ $total_bannded }}</h3>
						<p>Total Banned Member</p>
					</div>
				</div>
				</a>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
				<a href="{{url('/total-point-sale'). (request()->only(['date', 'e_date']) ? '?' . http_build_query(request()->only(['date', 'e_date'])) : '') }}">
				<div class="info-stats2">
					<div class="info-icon primary border">
						<i class="icon-shopping_cart"></i>
					</div>
					<div class="sale-num">
						<h3>{{ getAmount($total_sale_point,2) }}</h3>
						<p>Total Point Sale</p>
					</div>
				</div>
				</a>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
				<a href="{{url('/total-submitted-point-sale'). (request()->only(['date', 'e_date']) ? '?' . http_build_query(request()->only(['date', 'e_date'])) : '') }}">
				<div class="info-stats2">
					<div class="info-icon primary border">
						<i class="icon-shopping_cart"></i>
					</div>
				
					<div class="sale-num">
						<h3>
							{{-- @if(Auth::id() == 1 && request('date') && request('e_date'))
							 @php
							[$year, $month] = explode('-', request('date'));
							[$eyear, $emonth] = explode('-', request('e_date'));
							$records = CountTotalSubmittedPoint::whereMonth('created_at', '>=', $month)
							->whereYear('created_at', '>=', $year)
							->whereMonth('created_at', '<=', $emonth)
							->whereYear('created_at', '<=', $eyear)
							->sum('point');
							 @endphp
								{{ $records }}
							
							@elseif (Auth::id() == 1 && request('date') != null)
							 @php
							[$year, $month] = explode('-', request('date'));

							$records = CountTotalSubmittedPoint::whereYear('created_at', $year)
							->whereMonth('created_at', $month)
							->sum('point');
						
							 @endphp
								{{ $records }}
							 @else
							{{ getAmount($total_submitted_point,2) }}
							@endif --}}
							{{ getAmount($total_submitted_point,2) }}
						</h3>
						<p>Total Submitted Point</p>
					</div>
				</div>
				</a>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
				<a href="{{url('/out-bonus-history'). (request()->only(['date', 'e_date']) ? '?' . http_build_query(request()->only(['date', 'e_date'])) : '') }}">
				<div class="info-stats2">
					<div class="info-icon info">
						<i class="icon-gift"></i>
					</div>
					<div class="sale-num">
						<h3>{{ getAmount($out_point,2) }}</h3>
						<p>Total Bonus Out</p>
					</div>
				</div>
				</a>
			</div>
			<div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-12">
				<a href="{{url('/delivered-bonus-history'). (request()->only(['date', 'e_date']) ? '?' . http_build_query(request()->only(['date', 'e_date'])) : '') }}">
				<div class="info-stats2">
					<div class="info-icon info">
						<i class="icon-gift"></i>
					</div>
					<div class="sale-num">
						<h3>{{ getAmount($bonus_delivered,2) }}</h3>
						<p>Total Bonus Delivered</p>
					</div>
				</div>
				</a>
			</div>
		</div>
		<!-- Row end -->
		@else

		<div class="row gutters mb-4">
		    	<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-2">
		    	{{-- <div class="badge badge-dark">
		    	    	<form id="copyBoard1" class="d-inline-block">
        				    <input value="{{$gsd->uniqe_key_code}}" type="text" id="ref3" class="py-2 text-dark pl-2"  readonly> 
        				</form> 
        				<button type="button" @click="copyBtnClick" data-copytarget="#ref3" id="copybtn1" class="btn btn-primary"> <i class="fa fa-copy"></i> Unique_Key &nbsp; @lang('Copy')</button>
		    	</div> --}}
			
				</div>
				
			
		
			<div class="col-lg-4 col-md-4 col-sm-4 col-12 mb-2">
				<span class="badge badge-dark badgelg w-100 text-left"><span>Account Status &nbsp; </span> <span class="badge badge-dark border badgelg"> @if ($gsd->invest_status == 1)
					Active
					@else
					Inactive
					@endif</span> </span>
					
					<span class="badge badge-dark badgelg mt-2 w-100 text-left"><span>Lock  Status &nbsp; </span><span class="badge badge-dark border badgelg"> @if ($gsd->lock_status == 1)
					Lock 
					@else
					Unlock
					@endif</span> </span>
			
				
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-12 text-left mb-2">
			
				<span class="badge badge-dark badgelg w-100 text-left"><span>Leader Rank &nbsp; </span> <span class="badge badge-dark border badgelg"> @if ($gsd->user_rank != null && $gsd->user_rank != '')
					{{ $gsd->user_rank }}
					@else
					No Rank
					@endif</span> </span>
					
					<span class="badge badge-dark badgelg mt-2 w-100 text-left"><span>Customer Rank  &nbsp; </span><span class="badge badge-dark border badgelg"> @if ($crn != null && $crn != '')
					{{ $crn }}
					@else
					Distributor
					@endif</span> </span>
				
			</div>
		</div>
		<h2>Notice</h2>
<div class="row gutters">

			<div class="col-12">
				<div class="NBoard">
					{!! $Notice->content !!}
				</div>
				
			</div>
</div>
<hr>
<h2>News Feed</h2>
<div class="row w-100">
	@foreach ($news as $data)
		

	<div class="col-12 col-md-4">
		<div class="news_wrap">
			<h5>{{ $data->title }}</h5>
			<div class="news_img my-2">
				<img src="{{ config('app.url', 'Laravel').$data->featured_img }}" alt="">
			</div>
			<div class="news_content">
				{{ Str::limit(strip_tags($data->content, 20)) }}
			</div>
		</div>
		
	</div>
	@endforeach
</div>
{{ $news->links() }}

		@endif
	

	</div>
@endsection
   
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
	
// document.addEventListener("DOMContentLoaded", function () {
//     const checkbox = document.getElementById("rangeCheckbox");
//     const toDateWrapper = document.getElementById("toDateWrapper");

//     function toggleToDate() {
//         if (checkbox.checked) {
//             toDateWrapper.style.display = "block";
//         } else {
//             toDateWrapper.style.display = "none";
//             // optional: clear e_date value if unchecked
//             document.querySelector('input[name="e_date"]').value = "";
//         }
//     }

//     // initial check (for page reload with query params)
//     toggleToDate();

//     // change event
//     checkbox.addEventListener("change", toggleToDate);
// });

function handle_e_date(checkbox) {
	const eDateInput = document.querySelector('#e_date');
    eDateInput.classList.toggle('d-none', !checkbox.checked);
	eDateInput.name = checkbox.checked ? 'e_date' : '';
	console.log(eDateInput);
}

</script>
@endpush