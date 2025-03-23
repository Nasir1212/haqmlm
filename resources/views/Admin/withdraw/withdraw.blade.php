@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Withdraw</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<h4>{{ $page_title }}</h4>
							<table class="table custom-table table-bordered table-striped m-0">
								
								<thead>
									<tr>
									      <th class="text-center">Created
									    <br> 
										<span class="text-success">Updated</span> 
									    </th>
										<th class="text-center">Method</th>
										<th class="text-center">User</th>
										<th class="text-center">Receiver Account</th> 
										<th class="text-center">Amount</th>
										<th class="text-center">Status</th>
									
										@if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'withdraw_manage') == 1)
										<th class="text-center">Action</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $value)
									<tr>
									    <td>
										<span>{{ $value->created_at }}</span>
										<span class="text-success">{{ $value->updated_at }}</span>
									</td>
										<td>{{ $value->method_code }}</td>
										
											<td>
{{ $value->userdata->name }}
<br>
{{ $value->userdata->phone }}
<br>
{{ $value->userdata->email }}
<br>
<strong style="color:green;font-size:20px;font-weight:bold">{{ $value->userdata->username }}</strong>
											</td>
											<td>{{ $value->payment_r_ac }}
												
											</td>
											<td>
												{{ $value->amount }}
											</td>
											
											<td>
												{{ $value->status }}
												
											</td>
											@if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'withdraw_manage') == 1)
											<td class="text-center">
													<form class="d-inline-block" action="{{ route('withdraw_status_changer') }}" method="post">
													@csrf
														<input type="hidden" name="action_order" value="approve">
													    <input type="hidden" name="id" value="{{ $value->id }}">
													
												        <button type="submit" class="btn btn-success">Approve</button>
												
													</form>
													
													<form class="d-inline-block" action="{{ route('withdraw_status_changer') }}" method="post">
													@csrf
														<input type="hidden" name="action_order" value="reject">
													    <input type="hidden" name="id" value="{{ $value->id }}">
												        <button type="submit" class="btn btn-danger">Reject</button>
													</form>
											</td>
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
						</div>
					</div>
				</div>

			</div>
		</div>
    </div>
@endsection