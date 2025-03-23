@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Member Dashboard</li>
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
								<a href="{{ route('user_details',['username' => $user->username])}}" class="btn btn-success d-block"><i class="icon-settings1"></i> Balance Information</a>
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
					<form action="{{ route('user_profile_update')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card-body">
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<h4 class="mb-3 text-success">Personal Details</h4>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="firstName">Full Name</label>
									<input type="text" class="form-control" name="firstName" id="fullName" value="{{ $user->first_name }}">
								</div>
							</div>
					
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="fatherName">Father's Name</label>
									<input type="text" class="form-control" name="fatherName" id="fatherName" value="{{ $user->father_name }}">
								</div>
							</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="motherName">Mother's Name</label>
									<input type="text" class="form-control" name="motherName" id="motherName" value="{{ $user->mother_name }}">
								</div>
							</div>
								
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="email">Email</label>
									<input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="phone">Phone</label>
									<input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}">
								</div>
							</div>
						
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="country">Country</label>
									<input type="text" class="form-control" name="country" id="country" value="{{ $address->country }}">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="state">State / Division</label>
									<input type="text" class="form-control" name="state" id="state" value="{{ $address->state }}">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="city">City / District</label>
									<input type="text" class="form-control" name="city" id="city" value="{{ $address->city }}">
								</div>
							</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="upzila">Upzila / Thana</label>
									<input type="upzila" class="form-control" name="upzila" id="upzila" value="<?php if(isset($address->upzila)){ echo $address->upzila; } ?>">
								</div>
							</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="zip_code">Post office name & Zip-code</label>
									<input type="text" class="form-control" name="zip_code" id="zip_code" value="{{ $address->zip_code }}">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="village">Village & Word</label>
									<input type="village" class="form-control" name="village" id="village" value="<?php if(isset($address->village)){ echo $address->village; } ?>">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="country">House Name / Holding Number</label>
									<input type="text" class="form-control" name="house_holding" id="house_holding" value="<?php if(isset($address->house_holding)){ echo $address->house_holding; } ?>">
								</div>
							</div>
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="identity_number">Nid / Birth certificate / Passport Number</label>
									<input type="text" class="form-control" name="identity_number" id="identity_number" value="{{ $user->identity_number }}">
								</div>
							</div>
						
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="birth_date">Date Of Birth </label>
									<input type="date" class="form-control" name="birth_date" id="birth_date" value="{{ $user->birth_of_date }}">
								</div>
							</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="religion">Religion </label>
									<input type="text" class="form-control" name="religion" id="religion" value="{{ $user->religion }}">
								</div>
							</div>
	<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="password" class="text-danger">Change login Password, then fillup! </label>
									<input type="text" class="form-control" name="password" id="password" v>
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
										<img src="{{ asset($user->user_pic_path.$user->user_pic)}}" class="mb-1" style="width:100px">
									<button type="button" id="gallery_browse" class="btn btn-primary">Image Gallery</button> <strong class="text-white">Image Upload Or Select then paste bellow</strong>
									<input type="text" class="form-control d-inline-block mt-1" name="profile_pic" id="profile_pic" value="{{ $user->user_pic_path.$user->user_pic }}">
								</div>
							</div>
							
							
							
						</div>
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<h4 class="mb-3 text-success">Nominee Details</h4>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nName">Full Name</label>
								
									<input type="text" class="form-control" name="nName" id="nName" value="{{ $user->nominee->name??'' }}">
								</div>
							</div>
						
						
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nfather_name">Father's Name</label>
									<input type="text" class="form-control" name="nfather_name" id="nfather_name" value="{{ $user->nominee->father_name??"" }}">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nmother_name">Mother's Name</label>
									<input type="text" class="form-control" name="nmother_name" id="nmother_name" value="{{ $user->nominee->mother_name??"" }}">
								</div>
							</div>
						<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nrelation">Both Relation</label>
									<input type="text" class="form-control" name="nrelation" id="nrelation" value="{{ $user->nominee->relation??"" }}">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nidentity_number">Nid / Birth certificate / Passport Number</label>
									<input type="text" class="form-control" name="nidentity_number" id="nidentity_number" value="{{ $user->nominee->identity_number??"" }}">
								</div>
							</div>
						

					
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nbirth_date">Date Of Birth</label>
									<input type="date" class="form-control" name="nbirth_date" id="nbirth_date" value="{{ $user->nominee->birth_of_date??"" }}">
								</div>
							</div>
							
					
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<a target="_blank" href="{{ asset($user->nominee?->pic_path . $user->nominee?->profile_pic) }}">
									<img src="{{ asset($user->nominee?->pic_path . $user->nominee?->profile_pic) }}" style="width:100px">
								</a>
							    	<img src="
									{{-- @if($user->nominee?->pic_path && $user->nominee?->profile_pic != null ) --}}
									{{ asset($user->nominee?->pic_path.$user->nominee?->profile_pic)}}
									 {{-- @endif --}}

									 " style="width:100px"></a>
								<label for="ngallery_browse">Image Upload Or Select then paste bellow</label>
								<div class="form-group">
							
									<button type="button" id="ngallery_browse" class="btn btn-primary">Image Gallery</button>
									<input type="text" class="form-control w-50 d-inline-block" name="nprofile_pic" id="n_profile_pic" value="{{ $user->nominee?->pic_path.$user->nominee?->profile_pic }}">
								</div>
							</div>
						
						</div>
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="text-left">
									<input type="hidden" name="username" value="{{ $user->username }}">
									<button type="button" id="submit" name="submit" class="btn btn-secondary">Cancel</button>
									<button type="submit" id="submit" name="submit" class="btn btn-primary">Update</button>
								</div>
							</div>
						</div>
					</div>
				</form>
				</div>
			</div>
		</div>
    </div>

	<style>
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
	</style>
@endsection
@push('script')
	<script>
		$('#gallery_browse').on('click',function(){
			let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=600,height=400,left=200,top=200`;
			window.open('{{ route("media_list",["media_typer"=>"users","win"=>"small"])}}','Gallery',params);
		})	
		
		$('#ngallery_browse').on('click',function(){
			let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=600,height=400,left=200,top=200`;
			window.open('{{ route("media_list",["media_typer"=>"users","win"=>"small"])}}','Gallery',params);
		})
	</script>
@endpush