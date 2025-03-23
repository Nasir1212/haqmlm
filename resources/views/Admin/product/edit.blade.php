@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Update Product</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('product_update')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="product_name">Product English Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Product English Name" id="product_name" name="product_name" value="{{ $product->name}}">
							</div>
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="product_b_name">Product Bangla Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Product Bangla Name" id="product_b_name" name="product_b_name" value="{{ $product->b_name}}">
							</div>
							<div class="form-group">
								<label for="product_slug" class="w-100 font-weight-bold mb-1">Product Slug <span class="text-warning">(optional)</span></label>
								<input type="text" class="form-control " placeholder="Product slug" id="product_slug" name="product_slug" value="{{ $product->slug }}">
							</div>

							<div class="form-group">
								<label for="product_category_id" class="w-100 font-weight-bold mb-1">Product Category <span class="text-danger">*</span></label>
								<select name="product_category_id" class="form-control " id="product_category_id">
									@if ($product->category != '')
									<option value="{{ $product->category->id }}">{{ $product->category->name }}</option>
									@else
									<option value="">Select this product category name</option>
									@endif
									

									@foreach ($productCategories as $productCategory)
										<option value="{{ $productCategory->id }}">{{ $productCategory->name }}</option>
									@endforeach
								</select>
							</div>

							<div class="form-group">
								<label for="product_brand" class="w-100 font-weight-bold mb-1">Product Brand <span class="text-danger">*</span></label>
								<select name="product_brand_id" class="form-control " id="product_brand">
									@if ($product->brand != '')
									<option value="{{ $product->brand->id }}">{{ $product->brand->name }}</option>
										@else
										<option value="">Select this product brand name</option>
									@endif
									

									@foreach ($brands as $brand)
										<option value="{{ $brand->id }}">{{ $brand->name }}</option>
									@endforeach
								</select>
							</div>


						
							<div class="form-group">
								<label for="product_reg_price" class="w-100 font-weight-bold mb-1">Product Regular Price <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Package price" id="product_reg_price" name="product_reg_price" value="{{ $product->regular_price }}">
							</div>
							<div class="form-group">
								<label for="product_sell_price" class="w-100 font-weight-bold mb-1">Product Sell Price <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Package price" id="product_sell_price" name="product_sell_price" value="{{ $product->main_price }}">
							</div>
							<div class="form-group">
								<label for="product_point" class="w-100 font-weight-bold mb-1">Product point <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Product point" id="product_point" name="product_point" value="{{ $product->point }}">
							</div>
							<div class="form-group">
								<label for="product_status" class="w-100 font-weight-bold mb-1">Product Status <span class="text-danger">*</span></label>
								<select name="product_status" class="form-control" id="product_status">
									@if ($product->status == 1)
									<option value="1">Active</option>
									<option value="0">Disable</option>
									@else
									
									<option value="0">Disable</option>
									<option value="1">Active</option>
									@endif
								</select>
							</div>
							<div class="col-12">
								<div class="form-group">
									<button type="button" id="gallery_browse" class="btn btn-primary">Image Gallery</button><input type="text" class="form-control d-inline-block" name="img" id="img" value="{{ $product->img_name }}">
								</div>
							</div>
							<div class="form-group">
								<label for="product_details" class="w-100 font-weight-bold mb-1">Product details <span class="text-danger">*</span></label>
								<textarea  class="form-control "  id="package_details" name="product_details">{{ $product->details }}</textarea>
							</div>

							<input type="hidden" name="id" value="{{ $product->id }}">
							<a href="{{ route('product_list')}}" class="btn btn-dark" >Back</a>
                            <button type="submit" class="btn btn-success">Update</button>
						</form>
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection
@push('script')
<script src="{{ asset('ckeditor/ckeditor.js')}}"></script>
<script>
	CKEDITOR.replace( 'product_details',{
                height:500,
                filebrowserBrowseUrl: '{{ route("filemanager_browse") }}',
                filebrowserImageBrowseUrl: '{{ route("file_browse",["type" => "Files"])}}',
                filebrowserUploadUrl: '{{ route("file_upload")}}',
                filebrowserImageUploadUrl: '{{ route("filemanager_upload",["type"=>"Images","thumbnail_type"=>"content_images"])}}&_token={{csrf_token()}}'
            });
</script>
	<script>
		$('#gallery_browse').on('click',function(){
			let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=600,height=400,left=200,top=200`;
			window.open('{{ route("media_list",["media_typer"=>"products","win"=>"small"])}}','Image Gallery',params);
		})
	</script>
@endpush