@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Add Brand</li>
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
								<label class="w-100 font-weight-bold mb-1" for="brand_name">Brand Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Brand Name" id="brand_name" name="brand_name">
							</div>
							<div class="form-group">
								<label for="brand_slug" class="w-100 font-weight-bold mb-1">Brand Slug <span class="text-warning">(optional)</span></label>
								<input type="text" class="form-control " placeholder="Brand slug" id="brand_slug" name="brand_slug">
							</div>
							<div class="col-12">
								<div class="form-group">
									<button type="button" id="gallery_browse" class="btn btn-primary">Image Gallery</button><input type="text" class="form-control d-inline-block" name="img" id="img">
								</div>
							</div>
							<a href="{{ route('product_brand_list')}}" class="btn btn-dark" >Back</a>
                            <button type="submit" class="btn btn-success">Create</button>
						</form>
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection
@push('script')
	<script>
		$('#gallery_browse').on('click',function(){
			let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=600,height=400,left=200,top=200`;
			window.open('{{ route("media_list",["media_typer"=>"brands","win"=>"small"])}}','Image Gallery',params);
		})
	</script>
@endpush