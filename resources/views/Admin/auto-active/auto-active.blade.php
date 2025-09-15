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

									    <th class="text-center">#</th>
									    <th class="text-center">User Details</th>
									    <th class="text-center">Activation Method</th>
									    <th class="text-center">Activation Date</th>

									</tr>
								</thead>
								<tbody>
                                    @foreach ($user_activations as $activation)
                                        <tr>
                                        <td  class="text-white">#{{ $activation->id }}</td>
                                            <td class="text-white">
                                            <a href="#" class="text-white">Username -- {{$activation->user->username}}</a>
                                            <br>
                                            <a href="#" class="text-white">Name -- {{$activation->user->name}}</a>
                                            <br>
                                            <a href="#" class="text-white">Phone -- {{$activation->user->phone}}</a>
                                            <br>
                                            <a href="#" class="text-white">Email --{{$activation->user->email}}</a>
                                        </td>
                                            <td class="text-white">
                                                {{$activation->activation_method }} 
                                            </td>
                                            <td class="text-white">
                                                {{$activation->created_at }}
                                            </td>
                                        </tr>   
                                    @endforeach
								</tbody>
							
							</table>
							<hr>
								
						</div>
                    </div>
					
				</div>
			</div>
		</div>

		
    </div>
	
@endsection