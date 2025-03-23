@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Edit page &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('update_page')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="name">Name <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Name" id="name" name="name" value="{{ $page->name }}">
							</div>
							<div class="form-group">
								<label for="product_slug" class="w-100 font-weight-bold mb-1">Slug <span class="text-warning">(optional)</span></label>
								<input type="text" class="form-control " placeholder="Slug" id="slug" name="slug" value="{{ $page->slug }}">
							</div>
							
							<div class="form-group">
								<label for="content" class="w-100 font-weight-bold mb-1">Content</label>
								<textarea name="content" placeholder="content" id="" cols="30" rows="10" id="content">
									{{ $page->content }}
								</textarea>
								
							</div>
							
							<div class="img_wrap">
							    <a href="{{ asset($page->image_path.$page->image_name) }}"><img src="{{ asset($page->image_path."extra_small/".$page->image_name) }}"></a>
							</div>
							
							<div class="form-group">
								<input type="file" class="form-control d-inline-block" name="media_file" id="img">
							</div>
						   <div class="form-group">
						       <label for="publication_status" class="w-100 font-weight-bold mb-1">Publication Status</label>
							   <select class="form-control" name="status" id="publication_status">
							       @if($page->status == 1)
							       <option value="1">Show</option>
							       <option value="0">Hide</option>
							       @else
							       <option value="0">Hide</option>
							       <option value="1">Show</option>
							       @endif
							   </select>
						  </div>
						
						<input type="hidden" name="id" value="{{ $page->id }}">
							
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
	CKEDITOR.replace( 'content',{
                height:500,
                filebrowserBrowseUrl: '{{ route("filemanager_browse") }}',
                filebrowserImageBrowseUrl: '{{ route("file_browse",["type" => "Files"])}}',
                filebrowserUploadUrl: '{{ route("file_upload")}}',
                filebrowserImageUploadUrl: '{{ route("filemanager_upload",["type"=>"Images","thumbnail_type"=>"content_images"])}}&_token={{csrf_token()}}'
            });
</script>
@endpush