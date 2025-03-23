@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Add Gateway</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
<style>

.payment-method-item .payment-method-header .thumb .profilePicPreview {
    width: 210px;
    height: 210px;
    display: block;
    border: 3px solid #f1f1f1;
    box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.25);
    border-radius: 10px;
    background-size: cover;
    background-position: center;
}
.payment-method-item .payment-method-header .thumb {
    width: 220px;
    position: relative;
	margin: auto;
    margin-bottom: 30px;
}
.payment-method-item .payment-method-header .thumb .avatar-edit {
    position: absolute;
    bottom: -15px;
    right: 0;
}
.payment-method-item .payment-method-header .thumb .profilePicUpload {
    font-size: 0;
    opacity: 0;
    width: 0;
}
.payment-method-item .payment-method-header .thumb .avatar-edit label {
    width: 45px;
    height: 45px;
    border-radius: 50%;
    text-align: center;
    line-height: 45px;
    border: 2px solid #fff;
    font-size: 18px;
    cursor: pointer;
}
</style>
				<div class="card">
					<div class="card-body">
						<form action="{{ route('gateway_store')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="payment-method-item">
								<div class="payment-method-header d-flex flex-wrap">
									<div class="thumb">
										<div class="avatar-preview">
											<div class="profilePicPreview" style="background-image: url('https://mlm2.allitservice.com/placeholder-image/800x800')"></div>
										</div>
										<div class="avatar-edit">
											<input type="file" name="image" class="profilePicUpload" id="image" accept=".png, .jpg, .jpeg">
											<label for="image" class="bg-primary"><i class="la la-pencil"></i></label>
										</div>
									</div>

									<div class="content">
										<div class="row mt-4 mb-none-15">
											<div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
												<div class="form-group">
													<label class="w-100 font-weight-bold mb-1">Gateway Name <span class="text-danger">*</span></label>
													<input type="text" class="form-control " placeholder="Method Name" name="name" value="">
												</div>
											</div>
											
							
											<div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 mb-15">
												<label class="w-100 font-weight-bold mb-1" for="g_status">Gateway Status</label>
												<div class="input-group has_append">
													
													<select name="gateway_status" id="g_status" class="form-control">
														<option value="1">Active</option>
														<option value="0">Disable</option>
													</select>
													
												</div>
											</div>
										
											<div class="col-12 my-3">
												<label class="w-100 font-weight-bold mb-1" for="g_details">Gateway Details</label>
												<div class="input-group has_append">
												<textarea name="g_details" class="form-control" id="" cols="30" rows="5"></textarea>
													
												</div>
											</div>
											
										</div>
									</div>
								</div>
								<div class="payment-method-body mt-5">
									<div class="row">
									
										<div class="col-md-12">
											<a href="{{ route('gateways')}}" class="btn btn-secondary">Back</a>
											<button type="submit" class="btn btn-success">Save</button>
										</div>
									</div>
								</div>
							</div>
						</form>
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection