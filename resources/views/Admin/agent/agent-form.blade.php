@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Deposit</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
	
		<div class="row">
			
			@foreach ( $pay_accounts as $pay_account )
			<div class="col-lg-3 col-md-3 mb-4">
				<div class="card card-deposit">
					<h5 class="card-header text-center">{{ $pay_account->gateway->name }}
					</h5>
					<div class="card-body card-body-deposit">
						<img src="{{ asset($pay_account->gateway->image_path.$pay_account->gateway->image_name)}}" class="card-img-top depo" alt="Bkash">
					</div>
					<div class="card-footer">
						<a href="javascript:void(0)" data-id="1" data-pay_account_id="{{$pay_account->id}}"  class="btn  btn-success btn-block custom-success deposit_gateway_select deposit" data-toggle="modal" data-target="#depositModal">
							Deposit Now</a>
					</div>
				</div>
			</div>
			@endforeach
	
		</div>
		</div>
		<div class="modal fade" id="depositModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true" style="padding-right: 17px;">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="myLargeModalLabel">Deposit</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">×</span>
						</button>
					</div>
					<form action="{{ route('agentFormInsert')}}" method="post">
						@csrf
					
					<div class="modal-body">
						<h4>Deposit Limit Minimum - ${{ setting()->id_active_condition }}</h4>
						<input type="number" name="amount" class="form-control" placeholder="Amount">
					</div>
					<div class="modal-footer">
						<input type="hidden" name="pay_account_id" id="pay_account_id">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success" >Save</button>
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
            $('.deposit_gateway_select').on('click', function () {
				var modal = $('#depositModal');
				modal.find('#pay_account_id').val($(this).data('pay_account_id'));
			})})(jQuery)

	</script>
@endpush
