@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Update News</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('update_news')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="title">News Title <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Title" id="title" name="title" value="{{ $news->title }}">
							</div>
							<div class="form-group">
								<label for="slug" class="w-100 font-weight-bold mb-1">News Slug <span class="text-warning">(optional)</span></label>
								<input type="text" class="form-control " placeholder="Slug" id="slug" name="slug" value="{{ $news->title }}">
							</div>
							<div class="form-group">
								<label for="content" class="w-100 font-weight-bold mb-1">News details <span class="text-danger">*</span></label>
								<textarea  class="form-control "  id="content" name="content">{{ $news->content }}</textarea>
							</div>
							<div class="form-group">
								<label for="status" class="w-100 font-weight-bold mb-1">Publication Status</label>
								<select name="status" class="form-control " id="status">
                                   @if ($news->status == 1)
                                       <option value="1">Public</option>
                                       <option value="0">Hide</option>
                                       @else
                                       <option value="0">Hide</option>
                                       <option value="1">Public</option>
                                      
                                   @endif
									
								</select>
							</div>
							<div class="col-12">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <button type="button" id="gallery_browse" class="btn btn-primary">Image Gallery</button><input type="text" class="form-control d-inline-block" name="img" id="img" value="{{ $news->featured_img }}">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <img src="{{ config('app.url', 'Laravel').$news->featured_img }}" class="img-fluid" alt="">
                                    </div>
                                </div>
								
							</div>
							<input type="hidden"  name="id" value="{{ $news->id }}">
							<a href="{{ route('news')}}" class="btn btn-dark" >Back</a>
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
	<script>
		$('#gallery_browse').on('click',function(){
			let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
width=600,height=400,left=200,top=200`;
			window.open('{{ route("media_list",["media_typer"=>"news_feed","win"=>"small"])}}','Image Gallery',params);
		})
	</script>
@endpush