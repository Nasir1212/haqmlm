@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Edit faq &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('update_faq')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="name">Question <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Question" id="name" name="name" value="{{ $faq->name }}" required>
							</div>
							<div class="form-group">
								<label for="content" class="w-100 font-weight-bold mb-1">Answer <span class="text-danger">*</span></label>
								
							<textarea name="content" placeholder="Answer" class="form-control " id="content" cols="30" rows="10" required>{{ $faq->content }}</textarea>
							</div>
							
							
						
						   <div class="form-group">
						       <label for="publication_status" class="w-100 font-weight-bold mb-1">Publication Status</label>
							   <select class="form-control" name="status" id="publication_status">
							       @if($faq->status == 1)
							       <option value="1">Show</option>
							       <option value="0">Hide</option>
							       @else
							       <option value="0">Hide</option>
							       <option value="1">Show</option>
							       @endif
							   </select>
						  </div>
						
						<input type="hidden" name="id" value="{{ $faq->id }}">
							
                            <button type="submit" class="btn btn-success">Update</button>
						</form>
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection