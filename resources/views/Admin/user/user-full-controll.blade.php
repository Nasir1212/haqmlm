@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>

		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<form action="{{ route('FullUpdater')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card-body">
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<h4 class="mb-3 text-primary">Personal Details</h4>
							</div>
					
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="name">Full Name</label>
									<input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}">
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
									<label for="old_username">Refer Username</label>
									{{-- @dd($user->sponsor->first()) --}}
									{{-- @dd($user->children->first()) --}}
									{{-- @dd($user->ref_id) --}}
										@php
										$ref = \App\Models\User::where('id',$user->ref_id)->first();
										
										@endphp
									<input type="text" class="form-control" name="ref_usern" id="ref_usern" value="{{ $ref->username }}">
								</div>
							</div>
							
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="sponsor_username">Sponsor Username</label>
									<input type="text" class="form-control" name="sponsor_username" id="sponsor_username" value="{{ $spn }}">
								</div>
							</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="old_username">Username</label>
									<input type="text" class="form-control" name="old_username" id="old_username" value="{{ $user->username }}">
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
									<label for="identity_number">Nid / Birth certificate / Passport Number</label>
									<input type="text" class="form-control" name="phone" id="identity_number" value="{{ $user->identity_number }}">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="phone">Phone</label>
									<input type="text" class="form-control" name="phone" id="phone" value="{{ $user->phone }}">
								</div>
							</div>
						
						</div>
						<div class="balance _sect">
							<h3 class="text-dark">Balance Section</h3>
							<div class="row">
								<div class="col-4">
									<div class="form-group">
										<label for="main_balance">Main Balance</label>
										<input type="text" class="form-control" name="main_balance" id="main_balance" value="{{ $user->balance }}">
									</div>
								</div>
								
					
								<div class="col-4">
									<div class="form-group">
										<label for="point">Point</label>
										<input type="text" class="form-control" name="point" id="point" value="{{ $user->point }}">
									</div>
								</div>
								<div class="col-4">
									<div class="form-group">
										<label for="lock_point">Lock Point</label>
										<input type="text" class="form-control" name="lock_point" id="lock_point" value="{{ $user->lock_point }}">
									</div>
								</div>
						
								
								
							</div>

						</div>
				
					
						<div class="h3 text-dark">Address</div>
						<div class="row">
						    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="house_holding">House name / Holding number</label>
									<input type="text" class="form-control" name="house_holding" id="house_holding" value="<?php if(isset($address->house_holding)){ echo $address->house_holding; } ?>">
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
									<label for="upzila">Upazila / Thana</label>
									<input type="text" class="form-control" name="upzila" id="upzila" value="<?php if(isset($address->upzila)){ echo $address->upzila; } ?>">
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
									<input type="text" class="form-control" name="village" id="village" value="<?php if(isset($address->village)){ echo $address->village; } ?>">
								</div>
							</div>
							<div class="col-12">
								<div class="form-group">
									
								</div>
							</div>

							<div class="col-12">
								<div class="form-group">
									<button type="button" id="gallery_browse" class="btn btn-primary">Image Gallery</button> <strong class="text-dark">Image Upload Or Select then paste bellow</strong> 
									<input type="text" class="form-control d-inline-block mt-1" name="profile_pic" id="profile_pic" value="{{ $user->user_pic_path.$user->user_pic }}">
								</div>
							</div>
							
								<div class=" col-12">
								<div class="form-group">
									<label for="password" class="text-danger h4">If you want to change  Password! then fillup it, otherwise not. </label>
									<input type="text" class="form-control" name="password" id="password" v>
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
									
									<input type="text" class="form-control" name="nName" id="nName" value="{{ $user->nominee?->name }}">
								</div>
							</div>
						
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nfather_name">Father's name</label>
									<input type="text" class="form-control" name="nfather_name" id="nfather_name" value="{{ $user->nominee?->father_name }}">
								</div>
							</div>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nmother_name">Mother's name</label>
									<input type="text" class="form-control" name="nmother_name" id="nmother_name" value="{{ $user->nominee?->mother_name }}">
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nrelation">Both Relation</label>
									<input type="text" class="form-control" name="nrelation" id="nrelation" value="{{ $user->nominee?->relation }}">
								</div>
							</div>
						
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<div class="form-group">
									<label for="nidentity_number">Nid / Birth certificate / Passport Number</label>
									<input type="text" class="form-control" name="nidentity_number" id="nidentity_number" value="{{ $user->nominee?->identity_number }}">
								</div>
							</div>

					
							<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
								<label for="ngallery_browse">Image Upload Or Select then paste bellow</label>
								<div class="form-group">
								
									<button type="button" id="ngallery_browse" class="btn btn-primary">Image Gallery</button>
									<input type="text" class="form-control w-75 d-inline-block" name="nprofile_pic" id="n_profile_pic" value="{{ $user->nominee?->pic_path.$user->nominee?->profile_pic }}">
								</div>
							</div>
							
							
						</div>
						</div>
						
						<div class="row gutters">
							<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
								<div class="text-right">
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
		label{
			font-size:17px;
			margin-bottom: 4px;
			color:#000
		}
		input{
			color:black;
		}
		.card-body {
    background: #fff;
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