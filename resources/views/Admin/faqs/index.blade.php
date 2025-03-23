@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Faq List &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>Faq List &nbsp; <a href="{{ route('add_new_faq')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Questions</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $faqs as $key => $faq)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $faq->name }}</td>
                                      
                                        <td>
                                            @if($faq->status == 1)
                                                Show
                                            @else
                                               Hide
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('edit_faq',['id'=>$faq->id])}}" class="btn btn-warning mb-3 mb-md-0">Edit</a>
                                            <a href="{{ route('remove_faq',['id'=>$faq->id])}}" class="btn btn-danger">Remove</a>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                             <table> 
                             
                             {{ $faqs->links() }}
                        </div>  
                    </div>
					
				</div>
			</div>
		</div>

    
    </div>
@endsection
