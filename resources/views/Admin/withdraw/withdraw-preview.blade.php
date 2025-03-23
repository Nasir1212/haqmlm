@extends('layouts.Back.app')
@section('content')
<style>
	.receiver_data{
		padding: 10px;
		background: #fff;
		color: #000;
		margin: 20px 0;
		text-align: center;
	}
	.receiver_data img{
		margin: auto;
		text-align: center;
	}
</style>
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">withdraw</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row  justify-content-center">
            <div class="col-md-8">

                <div class="card card-withdraw text-center">
                    <div class="card-body card-body-withdraw">
                        <ul class="list-group text-center">
                            <li class="list-group-item ">
                                <img class="max-w-h-100px" src="{{ asset($_GET['gateway_image']) }}">
                            </li>
                            <p class="list-group-item">
                                Amount:
                                <strong>{{ $_GET['request_amount']}} </strong>BDT
                            </p>
                  
                            <p class="list-group-item">
                                You will get: <strong> {{ $_GET['payable_amount']}}</strong> 
                            </p>
                         
                           
                            </ul>
							<a href="{{ route('Withdraw_form') }}" class="btn btn-secondary font-weight-bold" >Close</a>
                            <button type="button" data-pay_account="{{ $_GET['pay_ac_id'] }}" class="btn btn-success font-weight-bold withdraw-confirm" data-toggle="modal" data-target="#withdrawModal">Confirm withdraw</button>
								
                            </div>
                </div>

            </div>
        </div>
</div>
<div class="modal fade" id="withdrawModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true" style="padding-right: 17px;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myLargeModalLabel">withdraw</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('Withdraw_form_submit')}}" method="post" enctype="multipart/form-data">
				@csrf
			
			<div class="modal-body">
				<div class="col-md-12">
					<div class="card card-withdraw">
						<div class="card-header card-header-bg">
							<h3>withdraw Confirm</h3>
						</div>
						<div class="card-body">
								<div class="row">
									<div class="col-md-12 text-center">
										<p class="text-center mt-2">You have requested  <b class="text--success">{{ $_GET['request_amount']}} BDT</b>, You will get  <b class="text--success"> {{ $_GET['payable_amount']}} </b> for this withdraw  </p>
										<h4 class="text-center mb-4">Please follow the instruction bellow</h4>
										
									</div>
									</div>
									<div class="col-md-12">
										<h3 class="text-success text-center">Transaction Comfirmation Data</h3>
										<div class="form-group">
											<label><strong>Receive Account number  <span class="text-danger">*</span>  </strong></label>
											<input type="text" class="form-control form-control-lg" name="account_number" value="" placeholder="Account number">
											</div>

											<div class="form-group">
												<label for="ac_qr"><strong>Receive Account qr-code ---  Optional</strong></label>
												<input type="file" class="form-control form-control-lg" name="account_qr_code" id="ac_qr">
											</div>
											<div class="form-group">
												<label for="ac_extra_info"><strong>Extra Note</strong></label>
												<textarea name="extra_info" id="ac_extra_info" class="form-control" cols="30" rows="10"></textarea>
											</div>
									</div>
								
									
								</div>
							
						</div>
					</div>
				</div>
			<div class="modal-footer">
				<input type="hidden"  name="amount" value="{{ $_GET['request_amount']}}">
				<input type="hidden"  name="payable_amount" value="{{ $_GET['payable_amount']}}">

				<input type="hidden" name="pay_account" id="pay_account"> 
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success" >Request Submit</button>
			</div>
		  </form>
		</div>
  </div>
</div>
@endsection

@push('script')
	<script>
		  'use strict';
        (function($){
            $('.withdraw-confirm').on('click', function () {
				var modal = $('#withdrawModal');
				modal.find('#pay_account').val($(this).data('pay_account'));
			})})(jQuery)

	</script>
@endpush