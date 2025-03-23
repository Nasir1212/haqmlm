@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">New List</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>News &nbsp; <a href="{{ route('add_news')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $news as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $data->title }}</td>
                                        <td>
                                            @if ($data->status == 1)
                                                Public
                                                @else
                                                Hide
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('edit_news', ['id'=>$data->id] )}}" class="btn btn-warning">Edit</a>
                                            <a href="{{ route('remove_news', ['id' => $data->id ]) }}" class="btn btn-danger">Remove</a>
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
