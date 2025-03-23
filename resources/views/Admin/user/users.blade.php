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
								
										<th>Account Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ( $users as $user)
									<tr>
										<td>{{ $user->name }} <br> {{ $user->username }} @if ($gsd->id == 1)
											- {{ $user->id }}
											<br>
											Balance - {{ getAmount($user->balance,2) }}
											<br> 
												Point - {{ getAmount($user->point,2) }}
										@endif</td>
										<td>{{ $user->email }} <br> {{ $user->phone }}</td>
										<td>{{ $user->created_at }}</td>
									
										<td>
										    <div>
										        	@if($user->lock_status == 1)
											<span class="badge badge-danger btn btn-lg"><span class="icon-lock"></span>  LOCK </span>
											@elseif ($user->lock_status == 0)
											<span class="badge badge-success btn btn-lg"><span class="icon-unlock"></span>  UNLOCK</span>
											 
											@else
											<span class="badge badge-danger btn btn-lg">BANNED</span>
											@endif
										    </div>
										    <div>
										        @if($user->status == 1)
											<span class="badge badge-success btn btn-lg"> <span class="icon-check"></span> ACTIVE </span>
											@elseif ($user->status == 2)
											<span class="badge badge-warning btn btn-lg">PENDING</span>
											 
											@else
											<span class="badge badge-danger btn btn-lg"> BANNED</span>
											@endif
										    </div>
											 <div>
										        @if($user->matrix_activation_status == 1)
											<span class="badge badge-success btn btn-lg"> <span class="icon-check"></span> Paid </span>
										
											@else
											<span class="badge badge-danger btn btn-lg"> Free </span>
											@endif
										    </div>

										</td>
										<td>

											<form class="d-block mb-2" action="{{ route('User_unlock') }}" method="post">
												@csrf
											  <input type="hidden" name="id" value="{{ $user->id }}">
											  <button type="submit" class="w-100 d-block"><span class="badge badge-success  d-block btn btn-lg"><span class="icon-unlock"></span> Account Unlock</span></a></button>
											  </form>
											
											    <form class=" d-block mb-2" action="{{ route('User_lock') }}" method="post">
												  @csrf
												<input type="hidden" name="id" value="{{ $user->id }}">
												<button type="submit" class="w-100 d-block"><span class="badge badge-danger  d-block btn btn-lg"><span class="icon-lock"></span> Account Lock</span></a></button>
												</form>

											<form class="d-block mb-2" action="{{ route('User_active') }}" method="post">
												@csrf
											  <input type="hidden" name="id" value="{{ $user->id }}">
											  <button type="submit" class="w-100 d-block"><span class="badge badge-success  d-block btn btn-lg"><span class="icon-laptop "></span> Account Active</span></a></button>
											  </form>
											
											    <form class=" d-block mb-2" action="{{ route('User_ban') }}" method="post">
												  @csrf
												<input type="hidden" name="id" value="{{ $user->id }}">
												<button type="submit" class="w-100 d-block"><span class="badge badge-danger  d-block btn btn-lg"><span class="icon-laptop "></span> Account Banned</span></a></button>
												</form>
												
											<a href="{{ route('user_details',['username' => $user->username])}}" class="mb-2"><span class="badge badge-info d-block btn btn-lg mb-2"><span class="icon-laptop"></span> Details</span></a>
											<a href="{{ route('FullEditor',['type'=>'username','arg' => $user->username])}}"><span class="badge badge-info d-block btn btn-lg"><span class="icon-laptop"></span> Account Edit </span></a>
										</td>
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