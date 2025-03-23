@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Users</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
						
							<h4>{{ $page_title }} <form action="{{ route('Users')}}" method="get" class="d-inline-block">
								@csrf
								<input type="search" name="username" class="form-control w-50 d-inline-block" placeholder="username" value="hms">
								<button type="submit" class="btn btn-info">Search</button>
							</form>
							</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								
								<thead>
									<tr>
										<th>User</th>
										<th>Email-phone</th>
										<th>Joined At</th>
										
										<th>Status</th>
										@if($action == 1)
										<th>Action</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach ( $users as $user)
									<tr>
										<td>{{ $user->name }} <br> {{ $user->username }} @if ($gsd->id == 1)
											- {{ $user->id }}
										@endif</td>
										<td>{{ $user->email }} <br> {{ $user->phone }}</td>
										<td>{{ $user->created_at }}</td>
										
										<td>
											@if($user->new_submited_point_status == 1)
											<span class="text-success btn btn-lg">Approve </span>
											@elseif ($user->new_submited_point_status == 2)
											<span class="text-warning btn btn-lg">Pending</span>
											@endif

										</td>
										@if($action == 1)
										@if($user->new_submited_point_status == 2)
										<td>
											<a href="{{ route('account_approve_option',['username' => $user->username])}}" class="mb-3 mb-md-0"><span class="badge badge-info btn btn-lg mb-3 mb-md-0"><span class="icon-laptop"></span> Approve</span></a>
											
										</td>
										@endif
										@endif
									</tr>
									@endforeach
									
						
								</tbody>
								<tfoot>
									<tr>
										<td colspan="5" class="text-center"></td>
									</tr>
								</tfoot>
							</table>
							<hr>
							{{ $users->links() }}
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
    </div>
@endsection