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
							<div class="mb-4">
							
								<form action="{{ route('auto_pv_collector')}}" method="get">
									@csrf
									<input type="text" name="point" class="d-inline-block w-25 form-control" placeholder="point" value="{{ $cpoint }}">
									<select name="point_type" class="d-inline-block w-25 form-control" id="point_type">
									
										<option value="Normal" @if ($_GET['point_type'] == 'Normal') selected="true"  @endif>Normal Point</option>
										<option value="Lock" @if ($_GET['point_type'] == 'Lock') selected="true"  @endif>Lock Point</option>
										<option value="sps_date" @if ($_GET['point_type'] == 'sps_date') selected="true"  @endif>Self Sub  Point</option>
										
										
										
									</select>
									<button type="submit" class="btn btn-info">Check User</button>
								</form>
							</div>
							<h4>{{ $page_title }} 
								<div class="">
									<form action="{{ route('auto_pv_collection_action')}}" method="post">
										@csrf
										<input type="text" name="point" class="d-inline-block w-25 form-control" placeholder="point" value="{{ $cpoint }}">
										<select name="point_type" class="d-inline-block w-25 form-control" id="point_type">
											<option value="Normal" @if ($_GET['point_type'] == 'Normal') selected="true"  @endif>Normal Point</option>
											<option value="Lock" @if ($_GET['point_type'] == 'Lock') selected="true"  @endif>Lock Point</option>
											<option value="sps_date" @if ($_GET['point_type'] == 'sps_date') selected="true"  @endif>Self Sub  Point</option>
											
											
										</select>
										<button type="submit" class="btn btn-info">Confirm Action</button>
									</form>
								</div>
							
							</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								
								<thead>
									<tr>
										<th>User</th>
										<th>Email-phone</th>
                                        <th>Point</th>
                                        <th>Point Submit Date</th>
										<th>Joined At</th>
									</tr>
								</thead>
								<tbody>
									@foreach ( $users as $user)
									<tr>
										<td>{{ $user->name }} <br> {{ $user->username }} @if ($gsd->id == 1)
											- {{ $user->id }}
										@endif</td>
										<td>{{ $user->email }} <br> {{ $user->phone }}</td>
										@if(request('point_type')=='Lock')
                                        <td>{{ $user->lock_point }}</td>
										@else
                                        <td>{{ $user->point }}</td>
										@endif
                                        <td>{{ $user->point_submit_date }}</td>
										<td>{{ $user->created_at }}</td>
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