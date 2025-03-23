@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Location&nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>List &nbsp; <a href="{{ route('location_create')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Parent</th>
                                        <th>Type</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $locations as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $data->e_name }} - ({{ $data->b_name }})</td>
                                        <td>@if($data->parent_id != ''){{ $data->parent_e_name }} - {{ $data->parent_b_name }} @endif</td>
                                        <td>
                                            @if ($data->country == 1)
                                                Country
                                            @endif
                                            @if ($data->upzila == 1)
                                                Upzila
                                            @endif

                                            @if ($data->district == 1)
                                                District
                                            @endif

                                            @if ($data->l_union == 1)
                                                Union
                                            @endif
                                            @if ($data->division == 1)
                                                Division
                                            @endif

                                        </td>
                                        <td>
                                            <a href="{{ route('location_edit', ['id' => $data->id])}}" class="btn btn-warning  mb-3 mb-md-0">Edit</a>
                                           
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