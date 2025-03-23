@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard Non Working Gen Condition Manage</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<div class="table-responsive">
                        <h4>Non Working Gen Condition
                        <table class="table custom-table table-bordered table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Limit</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $NonWorkingGens as $key => $data)
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                 
                                    <td>{{ $data->limit }}</td>
                                    <td>{{ $data->amount }}</td>
                                    <td>
                                       <button class="edit btn btn-dark" data-id="{{ $data->id }}"  data-amount="{{ $data->amount }}" data-limit="{{ $data->limit }}" data-toggle="modal" data-target="#condition_update_form">Edit</button>
                                
                                    </td>
                                </tr>
                                @endforeach
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
                        <h5 class="modal-title" id="myLargeModalLabel">Condition update Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('non_working_gen_condition_update')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        
                        <div class="form-group">
                            <label for="limit">Limit</label>
                            <input type="text" class="form-control" id="limit" name="limit" value="">
                        </div>
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount" value="">
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
				modal.find('#limit').val($(this).data('limit'));
				modal.find('#c_id').val($(this).data('id'));
			
			});

     
        
        })(jQuery)

	</script>
@endpush