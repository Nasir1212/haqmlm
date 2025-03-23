@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">page List &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>page List &nbsp; <a href="{{ route('add_page')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name, slug</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $pages as $key => $page)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td><a href="{{ asset($page->image_path.$page->image_name) }}"><img src="{{ asset($page->image_path."extra_small/".$page->image_name) }}"></a> </td>
                                        <td style="font-size:18px">
                                            <strong>Name</strong>  -- {{ $page->name }}
                                            <br>
                                           <strong>Slug</strong>  -- {{ $page->slug }}
                                        
                                        <td>
                                            @if($page->status == 1)
                                                Show
                                            @else
                                               Hide
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('edit_page',['id'=>$page->id])}}" class="btn btn-warning mb-3 mb-md-0">Edit</a>
                                            <a href="{{ route('remove_page',['id'=>$page->id])}}" class="btn btn-danger">Remove</a>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                             <table> 
                             
                             {{ $pages->links() }}
                        </div>  
                    </div>
					
				</div>
			</div>
		</div>

    
    </div>
@endsection
