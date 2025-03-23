@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Gen Rank Conds</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>Ranks &nbsp; <a href="{{ route('gen_rank_cond_create')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Pos</th>
                                        <th>Lock status</th>
                                        <th>Down Check Total</th>
                                        <th>First Check Total</th>
                                        <th>Second Check Total</th>
                                        <th>Prev Rank</th>
                                        <th>Rank</th>
                                        <th>Royality</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $rank_conditions as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $data->pos }}</td>
                                        <td>{{ $data->lock_status }}</td>
                                        <td>{{ $data->down_check }}</td>
                                        <td>{{ $data->first_check }}</td>
                                        <td>{{ $data->second_check }}</td>
                                        <td>{{ $data->prev_rank }}</td>
                                        <td>{{ $data->rank_name }}</td>
                                        <td>{{ $data->rank_royality }}</td>
                                      
                                        <td>
                                           
                                            <a href="{{ route('gen_rank_cond_edit', ['id' => $data->id ]) }}" class="btn btn-warning">Edit</a>
                                            <a href="{{ route('gen_rank_cond_remove', ['id' => $data->id ]) }}" class="btn btn-danger">Remove</a>
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
