@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Roles</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<h4>Role List &nbsp; <a href="{{ route('role_creator')}}" class="btn btn-info" >Create Role</a></h4>
							<table class="table custom-table table-bordered table-striped m-0">
								<thead>
									<tr>
										<th>SL</th>
										<th>Created Time</th>
										<th>Role name</th>
										<th>Access Module</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ( $roles as $key => $role)
									<tr>
										<td>{{ $key+1 }}</td>
										<td>{{ $role->created_at }}</td>
										
										<td>{{ $role->name }}</td>
										<td>{{ $role->access_module }}</td>
										<td>
											@if($role->status == 1)
											<span class="badge badge-success btn btn-lg">ACTIVE </span>
											@else
											<span class="badge badge-danger btn btn-lg">Disable</span>
											@endif

										</td>
										<td>
											<a href="{{ route('role_edit',['id'=>$role->id]) }}"><span class="badge badge-success btn btn-lg"><span class="icon-pencil"></span> Edit</span></a>
											<a href="{{ route('remove_role',['id'=>$role->id]) }}"><span class="badge badge-danger btn btn-lg"><span class="icon-trash"></span> Delete</span></a>
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
						</div>
					</div>
				</div>

			</div>
		</div>
    </div>
	

@endsection