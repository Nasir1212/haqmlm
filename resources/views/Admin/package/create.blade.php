@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Add Package Category</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('package_store')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="package_name">Package Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Package Name" id="package_name" name="package_name">
							</div>
							<div class="form-group">
								<label for="package_slug" class="w-100 font-weight-bold mb-1">Package Slug <span class="text-warning">(optional)</span></label>
								<input type="text" class="form-control " placeholder="Package slug" id="package_slug" name="package_slug">
							</div>
							<div class="form-group">
								<label for="package_regular_price" class="w-100 font-weight-bold mb-1">Package Regular Price <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Package Regular price" id="package_regular_price" name="package_regular_price">
							</div>

							<div class="form-group">
								<label for="package_sell_price" class="w-100 font-weight-bold mb-1">Package Sell Price <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Package sell price" id="package_sell_price" name="package_sell_price">
							</div>

							<div class="form-group">
								<label for="package_point" class="w-100 font-weight-bold mb-1">Package Point <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Package point" id="package_point" name="package_point">
							</div>

							<div class="form-group">
								<label for="package_spcd" class="w-100 font-weight-bold mb-1">Package Shipping In Dhaka <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Package shipping cost amount" id="package_spcd" name="package_spcd">
							</div>
							
							<div class="form-group">
								<label for="package_spco" class="w-100 font-weight-bold mb-1">Package Shipping Out Dhaka <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Package shipping cost amount" id="package_spco" name="package_spco">
							</div>


							<div class="form-group">
								<label for="package_details" class="w-100 font-weight-bold mb-1">Package details <span class="text-danger">*</span></label>
								<textarea  class="form-control "  id="package_details" name="package_details"></textarea>
							</div>

							<div class="form-group">
								<label for="product List" class="w-100 font-weight-bold mb-1">Product List <span class="text-danger">*</span></label>
								@foreach ($products as  $product)
								<input type="checkbox" name="product_code[]" value="{{ $product->id}}"> &nbsp; <div class="d-inline-block p-2 border">{{ $product->name }} <div class="badge">{{ $product->brand->name }}</div></div> 
								@endforeach
								
							</div>
							
							<div class="form-group">
								<label for="package_status" class="w-100 font-weight-bold mb-1">Package Status <span class="text-danger">*</span></label>
								<select name="package_status" class="form-control" id="package_status">
									<option value="1">Active</option>
									<option value="0">Disable</option>
								</select>
							</div>

							<div class="col-12">
								<div class="form-group">
									<button type="button" id="gallery_browse" class="btn btn-primary">Image Gallery</button><input type="text" class="form-control d-inline-block" name="img" id="img">
								</div>
							</div>
							<a href="{{ route('package_list')}}" class="btn btn-dark" >Back</a>
                            <button type="submit" class="btn btn-success">Create</button>
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
	CKEDITOR.replace( 'package_details',{
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
			window.open('{{ route("media_list",["media_typer"=>"packages","win"=>"small"])}}','Image Gallery',params);
		})
	</script>
@endpush