@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Add Product Category</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('product_category_store')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="category_name">Category Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Category Name" id="category_name" name="category_name">
							</div>
							<div class="form-group">
								<label for="category_slug" class="w-100 font-weight-bold mb-1">Category Slug <span class="text-warning">(optional)</span></label>
								<input type="text" class="form-control " placeholder="Category slug" id="category_slug" name="category_slug">
							</div>
							<div class="col-12">
								<div class="form-group">
									<button type="button" id="gallery_browse" class="btn btn-primary">Image Gallery</button><input type="text" class="form-control d-inline-block" name="img" id="img">
								</div>
							</div>
							<a href="{{ route('product_category_list')}}" class="btn btn-dark" >Back</a>
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
			window.open('{{ route("media_list",["media_typer"=>"categories","win"=>"small"])}}','Image Gallery',params);
		})
	</script>
@endpush