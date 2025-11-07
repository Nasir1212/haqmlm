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
							
							<table class="table custom-table table-bordered table-striped m-0">
                            @if(request('date') || request('e_date'))	
							<thead>
									<tr>
										
                                        <th>Point</th>
										<th>date</th>
									</tr>
								</thead>
								<tbody>
                                    @foreach ( $records as $record)
									<tr>
                                        <td>
                                              {{ getAmount($record->point,2) }}
                                        </td>
                                        <td>{{ $record->created_at }}</td>
                                    </tr>
                                    @endforeach
								</tbody>
							
                            </table>
                            @else
                            <table class="table custom-table table-bordered table-striped m-0">
                            <thead>
                            <th>User</th>
                            <th>Point</th>
                            <th>Email-phone</th>
                            <th>date</th>
                        </thead>
                        <tbody> 
                            @foreach ( $records as $record)
                            <tr>
                                <td>{{ $record->user->name }} <br> {{ $record->user->username }} 
                                    <br>
                                    Balance - {{ getAmount($record->user->balance,2) }}
                                  
                                </td>
                                <td>
                                      {{ getAmount($record->point,2) }}
                                </td>
                                <td>
                                    {{ $record->user->email }} <br> 
                                    {{ $record->user->phone }}</td>
                                </td>
                                <td>{{ $record->created_at }}</td>

                            </tr>
                            @endforeach
                        </tbody>
                            </table>
                            @endif
                                
							<hr>
							{{ $records->links() }}
						</div>
					</div>
					
				</div>
				
			</div>
		</div>
    </div>
@endsection