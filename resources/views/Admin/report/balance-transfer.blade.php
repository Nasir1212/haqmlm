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
										@if (auth()->user()->id == 1)
										<th class="text-center">Reciver After Amount</th>
										@endif
								
									</tr>
								</thead>
								<tbody>
									{{-- @dd($btsrs)  --}}
									{{-- @dd( global_user_data()) --}}
									@php
									$auth_id = global_user_data()->id;
									@endphp
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
													@if($value->receiver->id == $auth_id) 
												{{ getAmount($value?->prev_blance ) }}
												@else
												{{ getAmount($value?->sender_before_blance ) }}
												@endif
											 </span>
											</td>
											<td>
												<span class="@if($value->receiver->id == $auth_id) text-success @else text-danger @endif">
												@if($value->receiver->id == $auth_id) + @else - @endif
												{{ getAmount($value->amount) }}
											 </span>
											</td>
											
											<td>
												<span class="text-success">	
												@if($value->receiver->id == $auth_id) 
												+ {{ getAmount($value?->after_blance ) }}
												@else
												- {{ getAmount($value?->sender_after_blance ) }}
												@endif
												
											 </span>
											</td>

											@if (auth()->user()?->id == 1)
											<td>
											{{ getAmount($value?->after_blance ) }}
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