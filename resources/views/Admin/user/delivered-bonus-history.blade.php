@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">delivered bonus history </li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							
						<table class="table table-bordered">
    <thead>
        <tr>
            <th>User</th>
            <th>Details</th>
            <th>Email & Phone</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($deposits as $deposit)
            <tr>
                <td>
                    {{ $deposit->user->name }} <br>
                    {{ $deposit->user->username }}
                </td>
                <td>
                    Details : {{ $deposit->detail }} <br>
                    Amount : {{ getAmount($deposit->amount,2) }} <br>
                    Payment : {{ $deposit->payment_r_ac }} <br>
                    Method : {{ $deposit->method_code }} <br>
                    Status : {{ $deposit->status }}
                </td>
                <td>
                    {{ $deposit->user->email }} <br>
                    {{ $deposit->user->phone }}
                </td>
                <td>
                    {{ $deposit->created_at->format('d M Y, h:i A') }}
                </td>
            </tr>
        @endforeach
    </tbody>
   
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