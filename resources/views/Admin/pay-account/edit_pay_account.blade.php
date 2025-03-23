@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Edit Pay Account</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('payaccount_update_account')}}" method="post"  enctype="multipart/form-data">
							@csrf
							<div class="payment-method-item">
							
								<div class="payment-method-body">
									<div class="row">
										
										<div class="col-12">
											<div class="card border--primary mt-3">
												<div class="card-body">
													<label class="font-weight-bold">Account Select <span class="text-danger">*</span></label>
													<div class="input-group mb-3">
														<Select name="gateway_id" class="form-control">
														    <option value="{{ $account->gateway_id }}">Selected If you wish, you can change</option>
															@foreach ($gateways as $gateway)
																<option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
															@endforeach
														</Select>
														
													</div>

													<label class="font-weight-bold">Account number <span class="text-danger">*</span></label>
													<div class="input-group">
														<input type="text" class="form-control" name="account_number" value="{{$account->account}}">
															<input type="hidden" class="form-control" name="id" value="{{$account->id}}">
													</div>

													<label class="font-weight-bold">Account Charge <span class="text-danger">*</span></label>
													<div class="input-group">
														<input type="text" class="form-control" name="charge" value="{{$account->charge}}">
															
													</div>

													<label class="font-weight-bold">Account Qr-Code <span class="text-danger">*</span></label>
													<div class="input-group">
														<input type="file" class="form-control" name="account_qr" accept=".png, .jpg, .jpeg">
													</div>

													<label class="font-weight-bold">Account Details <span class="text-danger">*</span></label>
													<div class="input-group">
														<textarea name="account_details" class="form-control" id="" cols="30" rows="10">{{$account->description}}</textarea>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-12">
											<a href="{{ route('pay_accounts')}}" class="btn btn-secondary">Back</a>
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