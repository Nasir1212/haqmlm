@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Pay Accounts</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<h4>Payment Account List <a href="{{ route('add_account')}}" class="btn btn-info">Add Account</a></h4>
							<table class="table custom-table table-bordered table-striped m-0">
								
								<thead>
									<tr>
										<th>SL</th>
                                        <th>Method Name</th>
                                        <th>Method Charge</th>
										<th>Account</th>
										<th>Status</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach ( $pay_accounts as $key => $pay_account)
									<tr>
										<td>{{ $key + 1 }}</td>
										<td>{{ $pay_account?->gateway?->name }}</td>
										<td>{{ $pay_account?->charge }}</td>
										<td>{{ $pay_account?->account }}</td>
										<td>
											@if($pay_account->status == 1)
											<span class="badge badge-success btn btn-lg">ACTIVE </span>
											@else
											<span class="badge badge-danger btn btn-lg">Disable</span>
											@endif

										</td>
										<td>
										    <form action="{{ route('payaccount_edit_account') }}" method="post">
										        @csrf
										        <input type="hidden" name="id" value="{{ $pay_account->id }}">
										        <button type="submit" class="badge badge-success btn btn-lg"><span class="icon-pencil"></span>Edit</button>
										        </form>
										  <form action="{{ route('payaccount_remove_account') }}" method="post">
										        @csrf
										        <input type="hidden" name="id" value="{{ $pay_account->id }}">
										        <button type="submit" class="badge badge-danger btn btn-lg"><span class="icon-trash"></span> Delete</span></button>
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