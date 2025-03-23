@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Club Member Manage</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card p-3">
					<div class="table-responsive">
					    
                        <h4>Club Member List &nbsp; <button type="button" class="btn btn-info addNew mb-2" data-toggle="modal" data-target="#condition_creating_form">Add new</button> <form class="d-inline mb-2" action="{{ route('cmbs')}}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-success mb-2">Balance Send</button>
                        </form></h4>
                        
                        <hr>
                        <h3>
                            Club Reserve Fund -- {{ $club_income_fund }} -- Per member Amount -- @php
                            $tt = 0;
                            if(count($club_members) != 0){
                              $tt = $club_income_fund / count($club_members);
                            }
                            
                             echo $tt;
                            
                            @endphp
                        </h3>
                        <table class="table custom-table table-bordered table-striped m-0">
                            <thead>
                                <tr>
                                    <th>Sl</th>
                                    <th>Position</th>
                                    <th>Club Member Username</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ( $club_members as $key => $data)
                                <tr>
                                    <td>{{ $key + 1  }}</td>
                                    <td>{{ $data->pos }}</td>
                                    <td>{{ $data->username }}</td>
                                    <td>{{ $data->status }}</td>
                                   
                                    <td>
                                       <button class="edit btn btn-dark" data-id="{{ $data->id }}" data-position="{{ $data->pos }}" data-username="{{ $data->username }}" data-status="{{ $data->status }}" data-toggle="modal" data-target="#condition_update_form">Edit</button>
                                       <form action="{{ route('club_member_remove')}}" method="post" class="d-inline-block">
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                     
                                    </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                         <table> 
                         
                         {{ $club_members->links() }}
                    </div>  
				</div>
			</div>
		</div>
        <div class="modal fade" id="condition_creating_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myLargeModalLabel">Member Create Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('club_member_create')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="position">Position</label>
                            <input type="text" class="form-control" id="position" name="position" >
                        </div>
                        <div class="form-group">
                            <label for="left">Username</label>
                            <input type="text" class="form-control" id="username" name="username" >
                        </div>
                        <div class="form-group">
                            <label for="right">Status</label>
                            <input type="text" class="form-control" id="status" name="status" >
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
                        <h5 class="modal-title" id="myLargeModalLabel">Member Update Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('club_member_update')}}" method="post">
                        @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="uposition">Position</label>
                            <input type="text" class="form-control" id="uposition" name="position" >
                        </div>
                        <div class="form-group">
                            <label for="uleft">Left</label>
                            <input type="text" class="form-control" id="uusername" name="username" >
                        </div>
                        <div class="form-group">
                            <label for="uright">Status</label>
                            <input type="text" class="form-control" id="ustatus" name="status" >
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

				modal.find('#uposition').val($(this).data('position'));
				modal.find('#uusername').val($(this).data('username'));
				modal.find('#ustatus').val($(this).data('status'));
		
				modal.find('#c_id').val($(this).data('id'));
			
			});

            $('.addNew').on('click', function () {
				var modal = $('#condition_creating_form');
			})
        
        })(jQuery)

	</script>
@endpush