@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>Slider List &nbsp; <a href="{{ route('add_new_slider')}}" class="btn btn-info" >Add new</a></h4>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Image</th>
                                        <th>Name, slug & target link</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $sliders as $key => $slider)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td><a href="{{ asset($slider->image_path.$slider->image_name) }}"><img src="{{ asset($slider->image_path."extra_small/".$slider->image_name) }}"></a> </td>
                                        <td style="font-size:18px">
                                            <strong>Name</strong>  -- {{ $slider->name }}
                                            <br>
                                           <strong>Slug</strong>  -- {{ $slider->slug }}
                                        <br>
                                           <strong>Target</strong>  -- <a href="{{ $slider->target_link }}" style="color:#fff">{{ $slider->target_link }}</a>
                                        </td>
                                        <td>
                                            @if($slider->status == 1)
                                                Show
                                            @else
                                               Hide
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('edit_slider',['id'=>$slider->id])}}" class="btn btn-warning mb-3 mb-md-0">Edit</a>
                                            <a href="{{ route('remove_slider',['id'=>$slider->id])}}" class="btn btn-danger">Remove</a>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                             <table> 
                             
                             {{ $sliders->links() }}
                        </div>  
                    </div>
					
				</div>
			</div>
		</div>

    
    </div>
@endsection
