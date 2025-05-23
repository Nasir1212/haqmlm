@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Package List</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>Package List &nbsp; <a href="{{ route('package_create')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Sell Price</th>
                                        <th>Regular Price</th>
                                        <th>Point</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $packages as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->main_price }}</td>
                                        <td>{{ $data->regular_price }}</td>
                                        <td>{{ $data->point }}</td>
                                        <td>
                                            @if ($data->status == 1)
                                                Active
                                            @else
                                                Disable
                                            @endif
                                            
                                        </td>
                                       
                                        <td>
                                            <a href="{{ route('package_edit', ['id' => $data->id])}}" class="btn btn-warning  mb-3 mb-md-0">Edit</a>
                                            <a href="{{ route('package_remove', ['id' => $data->id])}}" class="btn btn-danger">Remove</a>
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
