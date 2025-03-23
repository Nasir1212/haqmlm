@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard Company Reserve Fund condition Setup</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<div class="table-responsive">
                        <h4>Company Reserve Fund condition List &nbsp; <button type="button" class="btn btn-info addNew" data-toggle="modal" data-target="#condition_creating_form">Add new</button></h4>
                        <table class="table custom-table table-bordered table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Condition Name</th>
                                    <th>Amount</th>
                                    <th>Amount_type</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $crc_datas as $key => $data)
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                    <td>{{ $data->cond_name }}</td>
                                    <td>{{ $data->commission }}</td>
                                    <td>
                                        @if ($data->type == 0)
                                            Fix
                                            @else
                                            Percent
                                        @endif
                                       
                                    </td>
                                    <td>
                                       <button class="edit btn btn-dark" data-id="{{ $data->id }}" data-amount="{{ $data->commission }}" data-cond="{{ $data->cond_name }}" data-am_type={{ $data->type }} data-toggle="modal" data-target="#condition_update_form">Edit</button>
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
                    <form action="{{ route('company_reserve_condition_create')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="cond_name">Condition name</label>
                                <input type="text" class="form-control" id="cond_name" name="cond_name" value="">
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" value="">
                            </div>
                            <div class="form-group">
                                <label for="amount">Amount Type</label>
                                <input type="text" class="form-control" id="atype" name="atype" value="">
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
                    <form action="{{ route('company_reserve_condition_update')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="cond_name">Condition name</label>
                            <input type="text" class="form-control" id="cond_name" name="cond_name" value="">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount Type</label>
                            <input type="text" class="form-control" id="atype" name="atype" value="">
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
				modal.find('#amount').val($(this).data('amount'));
				modal.find('#cond_name').val($(this).data('cond'));
				modal.find('#atype').val($(this).data('am_type'));
				modal.find('#c_id').val($(this).data('id'));
			
			})})(jQuery)

	</script>
@endpush