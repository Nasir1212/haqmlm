@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Total Point Sale </li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							{{-- <h4>{{ $page_title }} <form action="{{ route('Users')}}" method="get" class="d-inline-block">
								@csrf
								<input type="search" name="username" class="form-control w-50 d-inline-block" placeholder="username" value="hms">
								<button type="submit" class="btn btn-info">Search</button>
							</form>
							</h4> --}}
							<table class="table custom-table table-bordered table-striped m-0">
								
								<thead>
									<tr>
										<th>User</th>
                                        <th>Point</th>
										<th>Email-phone</th>
										<th>date</th>
								

									</tr>
								</thead>
								<tbody>
									@foreach ( $deposits as $deposit)
									<tr>
                                        <td>{{ $deposit->user->name }} <br> {{ $deposit->user->username }} @if ($gsd->id == 1)
                                            - {{ $deposit->user->id }}
                                            <br>
                                            Balance - {{ getAmount($deposit->user->balance,2) }}
                                          
                                        @endif
                                        <td>
                                              {{ getAmount($deposit->point,2) }}
                                        </td>
                                    </td>
                                        <td>{{ $deposit->user->email }} <br> 
                                            {{ $deposit->user->phone }}</td>
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