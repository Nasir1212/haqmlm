@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Media Uploader</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('product_brand_store')}}" method="post" enctype="multipart/form-data">
							@csrf
					
							<div class="form-group">
								<label for="media_file" class="w-100 font-weight-bold mb-1">Select Media</label>
								<input type="file" class="form-control "  id="media_file" name="media_file" accept="image/*" size="200000">
							</div>
							
                            <button type="submit" class="btn btn-success">Upload</button>
						</form>
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection