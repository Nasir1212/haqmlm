@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Package Orders   &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100 w-100">
                    <div class="card-body">
						<div class="table-responsive">
							<h4>Package </h4>
							<table class="table custom-table table-bordered table-striped m-0">
								
								<thead>
									<tr>
									    <th class="text-center">Order_ ID</th>
									    <th class="text-center">Order_ Date</th>
									    <th class="text-center">Customer Info</th>

										<th class="text-center">Payment Status</th>
										<th class="text-center">Order Status</th>
										@if (auth()->user()->id == 1 || is_dealer(auth()->user()->id) == true )

										<th class="text-center">Action</th>
										@endif
									</tr>
								</thead>
								<tbody>

									@foreach ($orders as $order)
										<tr>
										<td  class="text-white">#{{ $order->id }}</td>
										<td>
											{{$order->created_at }}
										</td>
											<td class="text-white">
										    <a href="#" class="text-white">Username -- {{$order->user->username}}</a>
											<br>
											<a href="#" class="text-white">Name -- {{$order->user->name}}</a>
											<br>
											<a href="#" class="text-white">Phone -- {{$order->user->phone}}</a>
											<br>
											<a href="#" class="text-white">Email --{{$order->user->email}}</a>
										</td>
									
							
										<td>

											{{ $order->payment_status }}
											
										
										</td>
										<td>
											{{ $order->status }}
											
										
										</td>
										@if (auth()->user()->id == 1 || is_dealer(auth()->user()->id) == true )
										<td>
											<a href="{{ route('package_order_details',['id'=>$order->id])}}" class="btn btn-primary">See</a>
											<button class="btn btn-danger">Delete</button>
										</td>
										@endif
										</tr>
									@endforeach
									
						
								</tbody>
							
							</table>
							<hr>
								{{ $orders->links() }}
						</div>
                    </div>
					
				</div>
			</div>
		</div>

		
    </div>
	<div class="modal fade" id="payment_status" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myLargeModalLabel">Payment Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			 
				<div class="modal-body">
					
			  
				</div>
				<div class="modal-footer">
					<input type="hidden" id="package_qty" name="package_qty" value="1" />
			
					<button type="submit"  class="btn btn-success" >Confirm Order</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
	 
			</div>
	  </div>
	</div>	
	<div class="modal fade" id="delivery_status" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="myLargeModalLabel">Delivery Status</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
			 
				<div class="modal-body">
					
			  
				</div>
				<div class="modal-footer">
					<input type="hidden" id="package_qty" name="package_qty" value="1" />
			
					<button type="submit"  class="btn btn-success" >Confirm Order</button>
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				</div>
	 
			</div>
	  </div>
	</div>
@endsection