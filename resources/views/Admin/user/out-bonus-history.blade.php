@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">out bonus history </li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							
							<table class="table custom-table table-bordered table-striped m-0">
								
								<thead>
									<tr>
										<th>User</th>
                                        <th>Amount</th>
										<th style="width: 15%">Remark  </th>
										<th>date</th>
								

									</tr>
								</thead>
								<tbody>
									@foreach ( $deposits as $deposit)
									<tr>
                                        <td> 
											<a class="btn btn-info" href="{{ route('userdt',['username'=>$deposit->user->username])}}">{{ $deposit->user->username }}</a> 
                                        <td>
										{{ RgetAmount(\App\Models\User::getTotalMonthlyIncome($deposit->user->id,$deposit->created_at), 2) }}
                                        </td>
                                    </td>
                                        <td>
											
											@if($deposit->mark == 'refer_bonus')
											{{ $deposit->mark }}
											@else
											<form action="{{ route('Transaction_report_sheet') }}" method="post" class="d-inline-block mr-3">
											@csrf

										
											<input type="hidden" name="username" class="form-control" placeholder="username" value="{{ $deposit->user->username }}">
											<input type="hidden" id="date" name="date" class="form-control" value="{{ $deposit->created_at }}">
											<button type="submit" class="btn btn-info">Bonus Sheet</button>
											</form>
											@endif
										</td>
                                        <td>{{ $deposit->created_at }}</td>
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
							{{ $deposits->links() }}
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
    </div>
@endsection