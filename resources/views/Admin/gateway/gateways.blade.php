@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Gateways</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<h4>Gateway List <a href="{{ route('add_gateway')}}" class="btn btn-info">Add Gateway</a></h4>
							<table class="table custom-table table-bordered table-striped m-0">
								
								<thead>
									<tr>
										<th>SL</th>
										<th>Method Name</th>
                                   
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ( $gateways as $gateway)
									<tr>
										<td>{{ $gateway->name }}</td>
									
										
										<td>{{ $gateway->name }}</td>
										<td>
											@if($gateway->status == 1)
											<span class="badge badge-success btn btn-lg">ACTIVE </span>
											@else
											<span class="badge badge-danger btn btn-lg">Disable</span>
											@endif

										</td>
										<td>
										    <form action="{{ route('remove_gateway')}}" method="post">
										        @csrf
										        <input type="hidden" name="id" value="{{ $gateway->id }}">
										        <button type="submit"><span class="badge badge-success btn btn-lg"><span class="icon-trash"></span> Delete</span></button>
										    </form>
											
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