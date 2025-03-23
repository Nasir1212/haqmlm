@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{ route('sliders') }}" class="btn btn-dark">Go Back</a></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<h4>Add Slider</h4>
						<hr>
						<form action="{{ route('store_slider')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="name">Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Name" id="name" name="name">
							</div>
							<div class="form-group">
								<label for="product_slug" class="w-100 font-weight-bold mb-1">Slug <span class="text-warning">(optional)</span></label>
								<input type="text" class="form-control " placeholder="Slug" id="slug" name="slug">
							</div>
							
							<div class="form-group">
								<label for="product_slug" class="w-100 font-weight-bold mb-1">Target link <span class="text-warning">(optional)</span></label>
								<input type="text" class="form-control " placeholder="Target link" id="target_link" name="target_link">
							</div>
							
						
							<div class="form-group">
								<input type="file" class="form-control d-inline-block" name="media_file" id="img">
							</div>
						
						   <div class="form-group">
						       <label for="publication_status" class="w-100 font-weight-bold mb-1">Publication Status</label>
							   <select class="form-control" name="status" id="publication_status">
							       <option value="1">Show</option>
							       <option value="0">Hide</option>
							   </select>
						  </div>
						
							
                            <button type="submit" class="btn btn-success">Create</button>
						</form>
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection
