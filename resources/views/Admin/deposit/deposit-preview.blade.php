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
				<li class="breadcrumb-item">Balance Request</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row  justify-content-center">
            <div class="col-md-8">

                <div class="card card-deposit text-center">
                    <div class="card-body card-body-deposit">
                        <ul class="list-group text-center">
                            <li class="list-group-item ">
                                <img class="max-w-h-100px" src="{{ asset($_GET['gateway_image']) }}">
                            </li>
                            <p class="list-group-item">
                                Amount:
                                <strong>{{ $_GET['request_amount']}} </strong> BDT
                            </p>
                            <p class="list-group-item">
                                Charge:
                                <strong>{{ $_GET['charge']}}</strong> 
                            </p>
                            <p class="list-group-item">
                                Payable: <strong> {{ $_GET['payable_amount']}}</strong> 
                            </p>
                          
                           
                            </ul>
							<a href="{{ route('Deposit_form') }}" class="btn btn-secondary font-weight-bold" >Close</a>
                            <button type="button" data-pay_account="{{ $_GET['pay_ac_id'] }}" class="btn btn-success font-weight-bold deposit-confirm" data-toggle="modal" data-target="#depositModal">Confirm Request</button>
								
                            </div>
                </div>

            </div>
        </div>
</div>
<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true" style="padding-right: 17px;">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="myLargeModalLabel">Balance Request</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<form action="{{ route('Deposit_form_submit')}}" method="post" enctype="multipart/form-data">
				@csrf
			
			<div class="modal-body">
				<div class="col-md-12">
					<div class="card card-deposit">
						<div class="card-header card-header-bg">
							<h3>Deposit Confirm</h3>
						</div>
						<div class="card-body">

							
								<div class="row">
									<div class="col-md-12 text-center">
										<p class="text-center mt-2">You have requested  <b class="text--success">{{ $_GET['request_amount']}} BDT</b>, Please pay  <b class="text--success"> {{ $_GET['payable_amount']}} BDT</b> for successful payment                                </p>
										<h4 class="text-center mb-4">Please follow the instruction bellow</h4>
										<p class="text-success bg-dark p-2">Guideline >> {{ $_GET['pay_ac_description']}}</p>
										<div class="receiver_data">
											<h4 class="my-4 text-center">Payment Account -- {{ $_GET['pay_ac_number']}}</h4>
											@if ($_GET['pay_ac_qr_code'] != 'no')
											<div class="w-100 text-center"><img class="max-w-h-100px" src="{{ asset('storage/uploads/payment-account/'.$_GET['pay_ac_qr_code']) }}"></div> 
											@endif
										
										</div>
										
									</div>
		
									
									</div>


									<div class="col-md-12">
										<h3 class="text-success text-center">Transaction Comfirmation Data</h3>
										<div class="form-group">
											<label><strong>Sender Account number  <span class="text-danger">*</span>  </strong></label>
											<input type="text" class="form-control form-control-lg" name="account_number" value="" placeholder="Account number">
											</div>
									</div>
								

									<div class="col-md-12">
										<div class="form-group">
											<label><strong>Sender TRX ID  <span class="text-danger">*</span>  </strong></label>
											<input type="text" class="form-control form-control-lg" name="trx_id" value="" placeholder="TRX_ID">
										</div>
									</div>

									<div class="col-md-12">
										<div class="form-group">
											<label><strong>Balance Type  <span class="text-waring">*</span>  </strong></label>
											<select name="blc_type" class="form-control form-control-lg">
												<option value="main_balance">Main Balance</option>
												<option value="point_balance">Point Balance</option>
											</select>
										</div>
									</div>
									
								</div>
							
						</div>
					</div>
				</div>
			<div class="modal-footer">
				<input type="hidden"  name="amount" value="{{ $_GET['request_amount']}}">
				<input type="hidden"  name="payable_amount" value="{{ $_GET['payable_amount']}}">
				<input type="hidden"  name="charge" value="{{ $_GET['charge']}}">
				<input type="hidden" name="pay_account" id="pay_account"> 
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success" >Pay Now</button>
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
            $('.deposit-confirm').on('click', function () {
				var modal = $('#depositModal');
				modal.find('#pay_account').val($(this).data('pay_account'));
			})})(jQuery)

	</script>
@endpush