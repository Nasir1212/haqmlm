@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Rank Condition Manage</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<div class="table-responsive">
                        <h4>Rank Condition List &nbsp; <button type="button" class="btn btn-info addNew" data-toggle="modal" data-target="#condition_creating_form">Add new</button></h4>
                        <table class="table custom-table table-bordered table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Rank Royality</th>
                                    <th>Insentive Amount</th>
                                    <th>Left</th>
                                    <th>Right</th>
                                    <th>Rank Name</th>
                                    {{-- <th>Status</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $Ranks as $key => $data)
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                    <td>{{ $data->rank_royality }}</td>
                                    <td>{{ $data->position }}</td>
                                    <td>{{ $data->left }}</td>
                                    <td>{{ $data->right }}</td>
                                    <td>{{ $data->rank_name }}</td>
                                    <td>
                                       <button class="edit btn btn-dark" data-rank_royality="{{ $data->rank_royality}}" data-id="{{ $data->id }}" data-position="{{ $data->position }}" data-left="{{ $data->left }}" data-right="{{ $data->right }}" data-rank_name="{{ $data->rank_name }}" data-toggle="modal" data-target="#condition_update_form">Edit</button>
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
                    <form action="{{ route('rank_condition_create')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="rankroyality">Rank Royality %</label>
                            <input type="text" class="form-control" id="rankroyality" name="rank_royality" >
                        </div>
                        <div class="form-group">
                            <label for="position">Insentive Amount</label>
                            <input type="text" class="form-control" id="position" name="position" >
                        </div>
                        <div class="form-group">
                            <label for="left">Left</label>
                            <input type="text" class="form-control" id="left" name="left" >
                        </div>
                        <div class="form-group">
                            <label for="right">Right</label>
                            <input type="text" class="form-control" id="right" name="right" >
                        </div>
                        <div class="form-group">
                            <label for="rank_name">Rank Name</label>
                            <input type="text" class="form-control" id="rank_name" name="rank_name" >
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
                    <form action="{{ route('rank_condition_update')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="urankroyality">Rank Royality %</label>
                            <input type="text" class="form-control" id="urankroyality" name="rank_royality" >
                        </div>
                        <div class="form-group">
                            <label for="uposition">Insentive Amount</label>
                            <input type="text" class="form-control" id="uposition" name="position" >
                        </div>
                        <div class="form-group">
                            <label for="uleft">Left</label>
                            <input type="text" class="form-control" id="uleft" name="left" >
                        </div>
                        <div class="form-group">
                            <label for="uright">Right</label>
                            <input type="text" class="form-control" id="uright" name="right" >
                        </div>
                        <div class="form-group">
                            <label for="urank_name">Rank Name</label>
                            <input type="text" class="form-control" id="urank_name" name="rank_name" >
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

				modal.find('#urankroyality').val($(this).data('rank_royality'));
				modal.find('#uposition').val($(this).data('position'));
				modal.find('#uleft').val($(this).data('left'));
				modal.find('#uright').val($(this).data('right'));
				modal.find('#urank_name').val($(this).data('rank_name'));
				modal.find('#c_id').val($(this).data('id'));
			
			});

            $('.addNew').on('click', function () {
				var modal = $('#condition_creating_form');
			})
        
        })(jQuery)

	</script>
@endpush