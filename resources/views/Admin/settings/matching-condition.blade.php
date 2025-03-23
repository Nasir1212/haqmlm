@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard &nbsp;<strong> Matching Condition Manage</strong></li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<div class="table-responsive">
                        <h4>Matching Condition List &nbsp; <button type="button" class="btn btn-info addNew" data-toggle="modal" data-target="#condition_creating_form">Add new</button></h4>
                        <table class="table custom-table table-bordered table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Rank</th>
                                    <th>Point</th>
                                    <th>Amount</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $MatchingConditions as $key => $data)
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                    <td>{{ $data->rank }}</td>
                                    <td>{{ $data->point }}</td>
                                    <td>{{ $data->amount }}</td>
                                    <td>
                                       <button class="edit btn btn-dark" data-rank={{ $data->rank }} data-id="{{ $data->id }}" data-point="{{ $data->point }}" data-amount="{{ $data->amount }}"  data-toggle="modal" data-target="#condition_update_form">Edit</button>
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
                    <form action="{{ route('matching_condition_create')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rank">Rank</label>
                            <input type="text" class="form-control" id="rank" name="rank">
                        </div>
                        <div class="form-group">
                            <label for="point">Point</label>
                            <input type="text" class="form-control" id="point" name="point">
                        </div>
                     
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="text" class="form-control" id="amount" name="amount">
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
                    <form action="{{ route('matching_condition_update')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="urank">Rank</label>
                            <input type="text" class="form-control" id="urank" name="rank">
                        </div>
                        <div class="form-group">
                            <label for="upoint">Point</label>
                            <input type="text" class="form-control" id="upoint" name="point">
                        </div>
                     
                        <div class="form-group">
                            <label for="uamount">Amount</label>
                            <input type="text" class="form-control" id="uamount" name="amount">
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
				modal.find('#urank').val($(this).data('rank'));
				modal.find('#uamount').val($(this).data('amount'));
				modal.find('#upoint').val($(this).data('point'));
				modal.find('#c_id').val($(this).data('id'));
			
			});

            $('.addNew').on('click', function () {
				var modal = $('#condition_creating_form');
			})
        
        })(jQuery)

	</script>
@endpush