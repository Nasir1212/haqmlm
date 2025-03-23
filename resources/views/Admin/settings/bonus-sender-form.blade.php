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
						    
						    <div class="row">
						          <div class="col-12">
						             <form action="{{ route('auto_pv_collection_bullk_back_action')}}" method="post" class="d-inline-block ml-auto form-inline">
        								@csrf
        								<div class="form-group">
        								<input type="date" name="date" class="form-control" >
        								<button type="submit" class="btn btn-info">Bulk Point Return</button>
        								</div>
        							
        							</form>
						        </div>
						        
						    </div>
						    
						    <hr>
						    
						    <div class="row mb-5">
						        
						        
						        
						        
						        
						        <div class="col-12 col-md-6">
						             <form action="{{ route('sms_send_before_review')}}" method="post" class="d-inline-block ml-auto form-inline">
								@csrf
								<div class="form-group">
								    	<input type="text" name="month_year" class="form-control" placeholder="month year">
								<button type="submit" class="btn btn-info">Review</button>
								</div>
							
							</form>
						        </div>
						        <div class="col-12 col-md-6">
						             <form action="{{ route('finally_sms_send')}}" method="post" class="form-inline d-inline-block ml-auto">
								@csrf
								<input type="text" name="month_year" class="form-control" placeholder="month year">
								<button type="submit" class="btn btn-info">Sms Send</button>
							</form>
						        </div>
						       
						    </div>
						    
						    
							<h4>{{ $page_title }} <form action="{{ route('bonus_bulk_sender')}}" method="get" class="d-inline-block ml-auto">
								@csrf
								
								<button type="submit" class="btn btn-info">Confirm Send</button>
							</form>
							</h4>
							<?php $point = 0; ?>
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
									<?php $point += $user->submitted_point; ?>
									<tr>
										<td>{{ $user->name }} <br> {{ $user->username }} @if ($gsd->id == 1)
											- {{ $user->id }}
										@endif</td>
										<td>{{ $user->email }} <br> {{ $user->phone }}</td>
                                        <td>{{ $user->submitted_point }}</td>
                                        <td>{{ $user->point_submit_date }}</td>
										<td>{{ $user->created_at }}</td>
									</tr>
									@endforeach
									
						
								</tbody>
								<tfoot>
									<tr>
										<td colspan="2" class="text-center">Total </td>
										<td  class="text-center">{{ $point }}</td>
										<td colspan="2" class="text-center"></td>
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