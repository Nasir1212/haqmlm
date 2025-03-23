@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Add faq &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('store_faq')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="name">Questions <span class="text-danger">*</span></label>
								<input type="text" class="form-control " placeholder="Questions" id="name" name="name" required>
							</div>
							<div class="form-group">
								<label for="content" class="w-100 font-weight-bold mb-1">Answer <span class="text-danger">*</span></label>
								<textarea name="content" placeholder="Answer" class="form-control " id="content" cols="30" rows="10" required></textarea>
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
