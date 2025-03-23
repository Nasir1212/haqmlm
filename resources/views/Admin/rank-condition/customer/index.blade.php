@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Customer Rank Conds</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>Ranks &nbsp; <a href="{{ route('customer_rank_cond_create')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Target Point</th>
                                        <th>Rank name</th>
                                        <th>Rank price</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $rank_conditions as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $data->target_point }}</td>
                                        <td>{{ $data->rank_name }}</td>
                                        <td>{{ $data->rank_price }}</td>
                                      
                                        <td>
                                           
                                            <a href="{{ route('customer_rank_cond_remove', ['id' => $data->id ]) }}" class="btn btn-danger">Remove</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                             <table> 
                        </div>  
                    </div>
					
				</div>
			</div>
		</div>
    </div>
@endsection
