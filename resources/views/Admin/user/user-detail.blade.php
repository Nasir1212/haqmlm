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
							
							
							</div>
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12 col-12">
				<div class="card h-100">
				<h2 class="mb-3 text-primary text-center my-3">Personal Details</h2>
				<div class="table-responsive">
				<table class="table custom-table table-bordered table-striped m-0">
				    <thead>
				        <tr>
				            <th>Name</th>
				            <th>Father Name</th>
				              <th>Mother Name</th>
				            <th>Phone</th>
				            <th>Email</th>
				            <th>Username</th>
				        </tr>
				    </thead>
				    <tbody>
				        <tr>
				            <td>{{ $user->first_name }}</td>
				            <td>{{ $user->father_name }}</td>
				            <td>{{ $user->mother_name }}</td>
				             <td>{{ $user->phone }}</td>
				              <td>{{ $user->email }}</td>
				               <td>{{ $user->username }}</td>
				        </tr>
				    </tbody>
				</table>
				</div>
				</div>
			</div>
		</div>
    </div>
@endsection