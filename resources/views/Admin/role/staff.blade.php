@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Jeba Staff</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<h4>{{ $stp}} List &nbsp; <a href="{{ route('staff_members')}}" class="btn btn-info" >Staff</a>&nbsp; <a href="{{ route('staff_members',['user_type'=>'general'])}}" class="btn btn-info" >General User</a>
							
								<form action="{{ route('staff_members')}}" method="get" class="d-inline-block">
									@csrf
									<input type="search" name="username" class="form-control w-50 d-inline-block" placeholder="username" value="jeba">
									<button type="submit" class="btn btn-info">Search</button>
								</form>

							</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
										<th>SL</th>
								        <th>Username </th>
										<th>Role name</th>
										
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ( $staff_members as $key => $staff_member)
									<tr>
										
										<td>{{ $staff_member->name }}</td>
										<td>{{ $staff_member->username }}</td>
										<td>{{ $staff_member->role_info->name }}</td>
									
										<td>
											<a href="{{ route('role_setup_form',['username'=>$staff_member->username]) }}"><span class="badge badge-success btn btn-lg"><span class="icon-pencil"></span> Edit</span></a>
											
										</td>
									</tr>
									@endforeach
									
								</tbody>
								
							</table>
							
						</div>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection