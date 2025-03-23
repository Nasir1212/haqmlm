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
						<form action="{{ route('media_store')}}" method="post" enctype="multipart/form-data">
							@csrf
                            @if (auth()->user()->id == 1 && !isset($_GET['media_typer']))
                            <div class="form-group">
								<label for="media_type" class="w-100 font-weight-bold mb-1">Select Media Type</label>
								<select name="media_type" class="form-control">
                                    <option value="products">Product</option>
                                    <option value="packages">Package</option>
                                    <option value="categories">Category</option>
                                    <option value="brands">Brands</option>
                                    <option value="users">Users</option>
                                </select>
							</div>
                            @else
                            @if (isset($_GET['media_typer']))
                            <input type="hidden" name="media_type" value="{{$_GET['media_typer']}}">
                            @endif
                            
                            @endif

							<div class="form-group">
								<label for="media_file" class="w-100 font-weight-bold mb-1">Select Media</label>
								<input type="file" class="form-control pb-2"  id="media_file" name="media_file">
							</div>
							
                            <button type="submit" class="btn btn-success">Upload</button>
						</form>
                    <hr>
                    <div class="media_gallery">
                        <div class="row my-2">
                            <div class="col-12">
                            @if (auth()->user()->id == 1)
                                @if (isset($_GET['win']) && $_GET['win'] == 'small')
                                    <a href="{{ route('media_list') }}" class="btn btn-dark">All</a>
                                    <a href="{{ route('media_list') }}?media_typer=products" class="btn btn-dark">Products</a>
                                    <a href="{{ route('media_list') }}?media_typer=packages" class="btn btn-dark">Packages</a>
                                    <a href="{{ route('media_list') }}?media_typer=categories" class="btn btn-dark">Categories</a>
                                    <a href="{{ route('media_list') }}?media_typer=brands" class="btn btn-dark">Brands</a>
                                    <a href="{{ route('media_list') }}?media_typer=users" class="btn btn-dark">Users</a>
                                @endif
                               
                            @endif
                        </div>
                        </div>
                        
                        <div class="row">
                            @foreach ($media_list as $media)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-3 col-xl-3">
                                <div class="img_wrapper mb-2">
                                    <div class="img">
                                        <img src="{{ $media->path.$media->name }}"  class="img-fluid">
                                    </div>
                                    
                                    <div class="img_control">
                                        <button onclick="copyTextToClipboard('{{ $media->path.$media->name }}')" class="btn btn-success selector">
                                            Select
                                        </button>
                                        <a href="{{ route('media_remove', ['id' => $media->id ]) }}" class="btn btn-danger remover">
                                            Remove
                                        </a>
                                    </div>
                                   
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
				</div>
            </div>
			</div>
		</div>
    </div>
    <style>
        .card-body{
            min-height: 500px;
        }
        
        .img_wrapper{
            position: relative;
            width: 100%;
            height: 200px;

        }
        .img{
            position: absolute;
            left: 0;
            top:0;
            width: 100%;
            height: 100%;
            border:2px solid rgb(0, 0, 0);
            background: #fff;
            border-radius: 10px;
          
        }
        .img img{
            height: 100%;
          
        }

        .img_control{
            position: absolute;
            left: 50%;
            top:50%;
            transform: translate(-50%,-50%);
            display: flex;
        }
    </style>
@endsection
@push('script')
    <script>
        function copyTextToClipboard(text) {
            if (!navigator.clipboard) {
                fallbackCopyTextToClipboard(text);
                return;
            }
            navigator.clipboard.writeText(text).then(function() {
                console.log('Async: Copying to clipboard was successful!');
                window.close();
            }, function(err) {
                console.error('Async: Could not copy text: ', err);
            });
            }

    </script>
@endpush