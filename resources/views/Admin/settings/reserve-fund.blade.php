@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Reserve Fund Manage</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<div class="table-responsive">
                       
                        <table class="table custom-table table-bordered table-striped m-0">
                            <thead>
                                <tr>
                                 
                                    <th>Royality_fund</th>
                                    <th>Club Fund</th>
                                    <th>Repurchase_perform_bonus Fund</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                             
                                <tr>
                                   
                                    <td>{{ $reserve->royality_fund }}</td>
                                    <td>{{ $reserve->club_income }}</td>
                                    <td>{{ $reserve->repurchase_perform_bonus }}</td>
                                   
                                    <td>
                                       <button class="edit btn btn-dark"  data-royality_fund="{{ $reserve->royality_fund }}" data-club_income="{{ $reserve->club_income }}" data-repurchase_perform_bonus="{{ $reserve->repurchase_perform_bonus }}" data-toggle="modal" data-target="#condition_update_form">Edit</button>
                                       
                                    </td>
                                </tr>
                              
                            </tbody>
                         <table> 
                    </div>  
				</div>
			</div>
		</div>
     
        <div class="modal fade" id="condition_update_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Reserve Update Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('reserve_fund_update')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="uposition">Royality_fund</label>
                            <input type="text" class="form-control" id="royality_fund" name="ryf" >
                        </div>
                        <div class="form-group">
                            <label for="uleft">Club Fund</label>
                            <input type="text" class="form-control" id="club_income" name="clb" >
                        </div>
                        <div class="form-group">
                            <label for="uright">Repurchase_perform_bonus Fund</label>
                            <input type="text" class="form-control" id="repurchase_perform_bonus" name="rpb" >
                        </div>
                        
                    </div>
                    <div class="modal-footer">
                        <input type="hidden"  name="id" id="c_id">
                        <button type="submit"  class="btn btn-success" >Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>
          </div>
        </div>
    </div>
@endsection

@push('script')
	<script>
		  'use strict';
        (function($){
            $('.edit').on('click', function () {
				var modal = $('#condition_update_form');

				modal.find('#royality_fund').val($(this).data('royality_fund'));
				modal.find('#club_income').val($(this).data('club_income'));
				modal.find('#repurchase_perform_bonus').val($(this).data('repurchase_perform_bonus'));
		
				
			});

            $('.addNew').on('click', function () {
				var modal = $('#condition_creating_form');
			})
        
        })(jQuery)

	</script>
@endpush