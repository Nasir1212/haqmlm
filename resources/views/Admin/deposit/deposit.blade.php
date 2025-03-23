@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Balance Request</li>
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
									    <th>User</th>
										<th class="text-center">Method</th>
										
										<th class="text-center">Amount / <br> <span class="text-success"> Payable amount </span></th>
								
										<th class="text-center">Pay Trx  <br> 
										<span class="text-success">Sender Account</span> 
										</th>
									
										<th class="text-center">Status</th>
										@if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'deposit_manage') == 1)
										<th class="text-center">Action</th>
										@endif
									</tr>
								</thead>
								<tbody>
									@foreach ($data as $value)
										<tr class="text-center">
										    <td>
										        {{ $value->created_at }}
										    <br>
										    <span class="text-success">{{ $value->updated_at }}</span></td>
										    
										    <td>
										        {{ $value->userdata->name }}
<br>
{{ $value->userdata->phone }}
<br>
{{ $value->userdata->email }}
<br>
<strong style="color:green;font-size:20px;font-weight:bold">{{ $value->userdata->username }}</strong>
										        
										    </td>
										    
											<td>{{ $value->method_code }}</td>
											
											
											<td>{{ $value->amount }}
												<br>
												<span class="text-success">	
												{{ $value->payable_amount }}
											 </span>
											</td>
										
												<td>
												{{ $value->trx }}
												<br>
												{{
													$value->payment_s_ac
												}}
											
											</td>
											
											<td>
												{{ $value->status }}
												
											</td>
											@if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'deposit_manage') == 1)
											<td class="text-center">
												<form class="d-inline-block" action="{{ route('deposit_status_changer') }}" method="post">
													@csrf
													<input type="hidden" name="action_order" value="approve">
													<input type="hidden" name="id" value="{{ $value->id }}">
													<button type="submit" class="btn btn-success btn-sm">Approve</button>
												</form>
												<form class="d-inline-block" action="{{ route('deposit_status_changer') }}" method="post">
													@csrf
													<input type="hidden" name="action_order" value="reject">
													<input type="hidden" name="id" value="{{ $value->id }}">
													<button type="submit" class="btn btn-danger btn-sm">Reject</button>
												</form>
											
											</td>
											@endif
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