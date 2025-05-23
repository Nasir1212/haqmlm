@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard sponsor Condition Manage</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100 p-3">
					<div class="table-responsive">
                        <h4>sponsor Gen Condition List &nbsp; <button type="button" class="btn btn-info addNew" data-toggle="modal" data-target="#condition_creating_form">Add new</button></h4>
                        <table class="table custom-table table-bordered table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                  
                                    <th>Level</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $SponsorGens as $key => $data)
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                 
                                    <td>{{ $data->level }}</td>
                                    <td>{{ $data->amount }}</td>
                                    <td>
                                       <button class="edit btn btn-dark" data-id="{{ $data->id }}"  data-amount="{{ $data->amount }}" data-level="{{ $data->level }}" data-toggle="modal" data-target="#condition_update_form">Edit</button>
                                       <form action="{{ route('sponsor_gen_condition_remove') }}" method="post" class="d-inline-block">
                                    @csrf
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                         <table> 
                    </div>  
				</div>
			</div>
		</div>
        <div class="modal fade" id="condition_creating_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Condition update Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('sponsor_gen_condition_store')}}" method="post">
                        @csrf
                    <div class="modal-body">
                       
                        <div class="form-group">
                            <label for="level">Level</label>
                            <input type="text" class="form-control" id="level" name="level" value="">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="">
                        </div>
                    </div>
                    <div class="modal-footer">
                      
                        <button type="submit"  class="btn btn-success" >Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
                </div>
          </div>
        </div>
        <div class="modal fade" id="condition_update_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Condition update Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('sponsor_gen_condition_update')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="ulevel">Level</label>
                            <input type="text" class="form-control" id="ulevel" name="level" value="">
                        </div>
                        <div class="form-group">
                            <label for="uamount">Amount</label>
                            <input type="text" class="form-control" id="uamount" name="amount" value="">
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
				modal.find('#uamount').val($(this).data('amount'));
			
				modal.find('#ulevel').val($(this).data('level'));
				modal.find('#c_id').val($(this).data('id'));
			
			});

            $('.addNew').on('click', function () {
				var modal = $('#condition_creating_form');
			})
        
        })(jQuery)

	</script>
@endpush