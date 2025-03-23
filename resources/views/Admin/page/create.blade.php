@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item text-dark">Add New Page &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('store_page')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="name">Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Name" id="name" name="name">
							</div>
							<div class="form-group">
								<label for="slug" class="w-100 font-weight-bold mb-1">Slug <span class="text-warning">(optional)</span></label>
								<input type="text" class="form-control " placeholder="Slug" id="slug" name="slug">
							</div>
							
							<div class="form-group">
								<label for="content" class="w-100 font-weight-bold mb-1">Content</label>
								<textarea name="content" id="content" cols="30" rows="10"></textarea>
							</div>
							
						
							<div class="form-group">
								<label for="bg_img" class="w-100 font-weight-bold mb-1">Background Image</label>
								<input type="file" class="form-control d-inline-block" name="media_file" id="bg_img">
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

@push('script')
<script src="{{ asset('ckeditor/ckeditor.js')}}"></script>
<script>
	CKEDITOR.replace( 'content',{
                height:500,
                filebrowserBrowseUrl: '{{ route("filemanager_browse") }}',
                filebrowserImageBrowseUrl: '{{ route("file_browse",["type" => "Files"])}}',
                filebrowserUploadUrl: '{{ route("file_upload")}}',
                filebrowserImageUploadUrl: '{{ route("filemanager_upload",["type"=>"Images","thumbnail_type"=>"content_images"])}}&_token={{csrf_token()}}'
            });
</script>
@endpush