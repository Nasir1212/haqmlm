@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Transfer info &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<h4>Balance Transfer Records </h4>
							<div class="row">
							   	<div class="col-12 col-md-6">
							   	    <div class="my-2 h5">Date filter</div>
							    <form action="{{ route('balance_transfer_records') }}" method="get">
							        @csrf
							        <div class="btn-group w-100">
							            
							         <input type="date" class="form-control" name="date">
							        <button type="submit" class="btn btn-info">Search</button>
							        </div>
					
							    </form>
							</div>
						@if (auth()->user()->id == 1 || permission_checker(auth()->user()->role_info, 'balance_transfer_record_check') == 1)
    <div class="col-12 col-md-6">
        <div class="my-2 h5">Username filter</div>
        <form action="{{ route('balance_transfer_records') }}" method="get">
            @csrf
            <div class="btn-group w-100">
                <input type="text" class="form-control" name="name" placeholder="username">
                <button type="submit" class="btn btn-info">Search</button>
            </div>
        </form>
    </div>
@endif

							</div>
						<hr>
							<table class="table custom-table table-bordered table-striped m-0">
								
								<thead>
									<tr>
									    <th class="text-center">
									        Created
									  
									    </th>
									    <th>
									        Sender Name - (username)
									    </th>
									    <th>
									        Receiver Name - (username)
									    </th>
									
										<th class="text-center">Balance Type</th>
										
										<th class="text-center">Before Amount</th>
										<th class="text-center">Amount</th>
										<th class="text-center">After Amount</th>
								
									</tr>
								</thead>
								<tbody>
									@foreach ($btsrs as $value)
										<tr class="text-center">
										    <td>
										        {{ $value->created_at }}
										   
										    </td>
										   
											<td>{{ $value->sender->name."(".$value->sender->username.")" }}</td>
											<td>{{ $value->receiver->name."(".$value->receiver->username.")" }}</td>
											
											<td>{{ $value->balance_type }}</td>
											
											<td>
												<span class="text-success">	
												{{ getAmount($value?->prev_blance ) }}
											 </span>
											</td>
											<td>
												<span class="text-success">	
												{{ getAmount($value->amount) }}
											 </span>
											</td>
											<td>
												<span class="text-success">	
												{{ getAmount($value?->after_blance ) }}
											 </span>
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