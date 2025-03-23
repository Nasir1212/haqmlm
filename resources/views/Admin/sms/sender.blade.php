@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard Sms Sender</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
			<div class="row gutters">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
	
					<div class="card">
						<div class="card-body">
							<form action="{{ route('sms_sending_action')}}" method="post">
								@csrf
							
                           
									<div class="form-group">
										<label for="sms_type" class="w-100 font-weight-bold mb-1">User Selection System<span class="text-danger">*</span></label>
										<select name="sms_type" id="sms_type" class="form-control">
										    <option value="auto">
												Auto All User Number
											</option>
											<option value="manual">
												Manual Number
											</option>
											
										
										</select>
									</div>
								<div class="form-group">
									<label class="w-100 font-weight-bold mb-1" for="manual_sms_numbers">Manual Sms Numbers ----<span class="text-danger"> If is it manual</span></label>
									<input class="form-control" placeholder="017xxxx, 019xxx, 01300xxx" id="manual_sms_numbers" name="manual_sms_numbers">
								
								</div>
								<div class="form-group">
									<label class="w-100 font-weight-bold mb-1" for="sms_body">Sms Body<span class="text-danger">*</span></label>
									<textarea class="form-control" rows="3" cols="5" id="sms_body" name="sms_body"></textarea>
								
								</div>
							
								<button type="submit" class="btn btn-success">Send</button>
							</form>
						</div>
					</div>
	
				</div>
			</div>
    </div>
@endsection
@push('css')
    <style>
        ul#users {
    border: 1px solid black;
    
}

ul#users .user {
    
    padding: 5px 10px;
}
ul#users .user:hover {
    background:#fff;
    color:#000;
 
}
    </style>
@endpush
@push('script')

@endpush