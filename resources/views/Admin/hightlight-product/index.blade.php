@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Highlight Product List</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>Highlight Product List &nbsp; <a href="{{ route('high_light_product_add')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $products as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $data->product->name }}</td>
                                    
                                        <td>
                                          
                                            <a href="{{route('high_light_product_remove',['id'=>$data->id])}}" class="btn btn-danger">Remove</a>
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
