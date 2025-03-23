@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">My Account Details</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12 col-12">
				<div class="card h-100">
					<div class="card-body">
						<div class="account-settings">
							<div class="user-profile">
								<div class="user-avatar">
									@if ($user->user_pic == '' || $user->user_pic ==  null)
									<img src="{{ asset('assets/backend/img/user2.png') }}" class="user-avatar" alt="Avatar">
									@else
									<img src="{{ asset($user->user_pic_path.$user->user_pic) }}" class="user-avatar" alt="Avatar">
									@endif
								</div>
								<h5 class="user-name">{{ $user->first_name }}</h5>
								<h6 class="user-email">{{ $user->user_mail }}</h6>
								<a href="{{ route('user_account_setup', ['username' => $user->username])}}" class="btn btn-success d-block"><i class="icon-settings1"></i> Account Settings</a>
								<a href="{{ route('trx_pin_option', ['username' => $user->username])}}" class="btn btn-success mt-2 d-block"><i class="icon-settings1"></i> Transaction Password</a>
								{{-- @if (auth()->user()->id != 1)
								<div class="border mt-3 pb-2">
									<div class="acount_switcher_level mt-2">Account Switch</div>
									<form action="{{ route('account_switcher') }}" method="post">
										@csrf
									<div class="mt-2 px-2 select">
										
											<select id="selected_account" name="selected_account" class="bg-dark  p-1">
												@foreach ($connected_accounts as $account)
												<option value="{{$account->id }}">Usn - {{ $account->username }}</option>
												@endforeach
											</select>
										<div class="arrow"></div>
									</div>
									<div class="">
										<button type="submit" class="btn btn-success mt-2">Update</button>
									</div>
								</form>
								</div>
								<div class="p-1 border">
									<h3>Current Account</h3>
									<div class="">Usn - {{$gsd->username}}</div>
								</div>
								@endif --}}
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
				<div class="card h-100">
					<div class="card-body">
						<div class="row gutters">
						
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="info-stats info-stats3">
									<div class="info-icon danger border">
										<i class="icon-wallet"></i>
									</div>
									<div class="sale-num">
										<h3>{{ getAmount($user->balance)}}</h3>
										<p>Balance</p>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="info-stats info-stats3">
									<div class="info-icon danger border">
										<i class="icon-wallet"></i>
									</div>
									<div class="sale-num">
										<h3>{{ getAmount($user->point)}}</h3>
										<p>
											<span>Point</span>
											
										</p>
									</div>
								</div>
							</div>

							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="info-stats info-stats3">
									<div class="info-icon danger border">
										<i class="icon-wallet"></i>
									</div>
									<div class="sale-num">
										<h3>{{ getAmount($user->submitted_point)}}</h3>
										<p>
											<span>Last Submitted Point</span>
											
										</p>
									</div>
								</div>
							</div>
							
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="info-stats info-stats3">
									<div class="info-icon danger border">
										<i class="icon-wallet"></i>
									</div>
									<div class="sale-num">
										<h3>{{ getAmount($user->total_submitted_point)}}</h3>
										<p>
											<span>Total Submitted Point</span>
											
										</p>
									</div>
								</div>
							</div>


					
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="info-stats info-stats3">
									<div class="info-icon warning border">
										<i class="icon-wallet"></i>
									</div>
									<div class="sale-num">
										<h3>{{ getAmount($user->deposit)}}</h3>
										<p>Requested Balance</p>
									</div>
								</div>
							</div>
							
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="info-stats info-stats3">
									<div class="info-icon warning border">
										<i class="icon-wallet"></i>
									</div>
									<div class="sale-num">
										<h3>{{ getAmount($user->total_income)}}</h3>
										<p>Total Earn</p>
									</div>
								</div>
							</div>
							<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="info-stats info-stats3">
									<div class="info-icon warning border">
										<i class="icon-wallet"></i>
									</div>
									<div class="sale-num">
										<h3>{{ getAmount($user->lock_point)}}</h3>
										<p>Lock point</p>
									</div>
								</div>
							</div>
							
					
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>

	<style>
		.lst{
			font-size: 17px;
		}
		.acount_switcher_level{
			font-size: 17px;
		}
		.select select{
			border: none;
			outline: none;
			font-size: 18px;
			padding: 5px 55px 5px 5px;
			background-color: slategray;
			color: white;
			-webkit-appearance: none; /* for Safari */
			margin: 0;
			border-radius: 0;
			border: 1px solid #000;
			width: 100%;
			text-align: center;
		}
		.select select option {
			border: none;
			outline: none;
			font-size: 18px;
			padding: 5px 55px 5px 5px;
			background-color: rgb(255, 255, 255);
			color: rgb(18, 18, 19);
			-webkit-appearance: none; /* for Safari */
			margin: 0;
			border-radius: 0;
		}
		.select {
			width: 100%;
			position: relative;
			display: inline-block;
		}
		.select .arrow {
			position: absolute;
			height: 100%;
			width: 25px;
			top: 0;
			right: 5px;
			background-color: rgb(77 84 78);
			
		}
		.select:focus + .arrow,
		.select:hover + .arrow{
			background-color: dodgerblue;
		}
		.select .arrow::before,
		.select .arrow::after {
			content: "";
			position: absolute;
			width: 0;
			height: 0;
			border-style: solid;
			left: 5px;
		}
		.select .arrow::before {
			border-color: transparent transparent white transparent;
			border-width: 0 8px 8px 8px;
			top: 20%;
		}
		.select .arrow::after {
			border-color: white transparent transparent transparent;
			border-width: 8px 8px 0 8px;
			bottom: 20%;
		}
		.bbc {
    width: 100%;
    padding: 16px;
}
		.info-stats3 .bbc p {
    margin: 0;
    color: #8A99B5;
    display: flex;
    justify-content: space-between;
    width: 100%;
    align-items: center;
}
	</style>
@endsection
