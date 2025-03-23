@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">User Details</li>
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
								<a href="{{ route('user_account_setup', ['username' => $user->username])}}" class="btn btn-success mt-2 d-block"><i class="icon-settings1"></i> Account Settings</a>
								
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
				<div class="card h-100">
					<div class="card-body">
						<div class="row gutters">
                            <div class="col-12">
							<form action="{{ route('trx_pin_action')}}" method="post" enctype="multipart/form-data">
								@csrf
                                @if ($gsd->id == 1)
                                    <div class="form-group">
                                        <label for="new_password" class="w-100 font-weight-bold mb-1">New Password<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control " placeholder="New Password" id="new_password" name="new_password">
                                    </div>
                                    @else
                                    @if ($user->trx_password != null || $user->trx_password != '')
                                    <div class="form-group">
                                        <label class="w-100 font-weight-bold mb-1" for="current_password">Current Password<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control " placeholder="current password" id="current_password" name="current_password">
                                    </div>
                                @endif
								
								<div class="form-group">
									<label for="new_password" class="w-100 font-weight-bold mb-1">New Password<span class="text-danger">*</span></label>
									<input type="text" class="form-control " placeholder="New Password" id="new_password" name="new_password">
								</div>
                                <div class="form-group">
									<label for="confirm_password" class="w-100 font-weight-bold mb-1">Confirm Password<span class="text-danger">*</span></label>
									<input type="text" class="form-control " placeholder="Confirm Password" id="confirm_password" name="confirm_password">
								</div>

                                @endif
                              
                                <input type="hidden" name="user" value="{{ $user->username }}">
								<button type="submit" class="btn btn-success">Submit</button>
							</form>
						</div>
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection