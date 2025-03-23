@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<form action="{{ route('logo_Update')}}" method="post" enctype="multipart/form-data">
						@csrf
						
						<div class="pt-5 pl-3">
						    
						    	<img class="img-fluid" src="https://haqmultishop.com/assets/logo.png">
						</div>
					
						
						<div class="card-body">
							<div class="row gutters">
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-12">
									<div class="form-group">
										<label for="thumbnail">Logo uploader</label>
										<input type="file" class="form-control" id="thumbnail" name="thumbnail">
									</div>
								</div>
							
							</div>
							
							<div class="row gutters">
								<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
									<div class="text-right">
										<button type="button"  class="btn btn-secondary">Cancel</button>
										<button type="submit"  class="btn btn-primary">Update</button>
									</div>
								</div>
							</div>
						</div>
				    </form>
				</div>
			</div>
		</div>
    </div>
@endsection