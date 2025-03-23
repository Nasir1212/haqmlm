@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Product Brand List</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>Product Brand List &nbsp; <a href="{{ route('product_brand_create')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        {{-- <th>Status</th> --}}
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $ProductBrands as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->slug }}</td>
                                        <td>
                                            <a href="{{ route('product_brand_edit', ['id'=>$data->id] )}}" class="btn btn-warning">Edit</a>
                                            <a href="{{ route('product_brand_remove', ['id' => $data->id ]) }}" class="btn btn-danger">Remove</a>
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
