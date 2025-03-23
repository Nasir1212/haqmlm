@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Role Edit</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('role_set')}}" method="post">
                            @csrf
                                <h4> <a href="{{ route('staff_members')}}" class="btn btn-info" >Back</a> Name: {{$user->name}}  ---- Username: {{ $user->username }}</h4>
                                <hr>
                                <h5>Role List</h5>
                                <select name="access_id" class="form-control">
                                    <option value="{{ $user->role_info->id}}">Current -- {{ $user->role_info->name }}</option>
                                    @foreach ($roles as $role )
                                    <option value="{{ $role->id}}">{{ $role->name }}</option>
                                    @endforeach
                                    
                                </select>
								<input type="hidden" name="username" value="{{ $user->username }}">

                                <button type="submit" class="btn btn-success d-block mt-2" >Save</button>
                        </form>
					</div>
				</div>
			</div>
		</div>
    </div>
@endsection