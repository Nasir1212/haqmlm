@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Admin Dashboard</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
					<form action="{{ route('account_active_action')}}" method="post" enctype="multipart/form-data">
					@csrf
					<div class="card-body">
					    <h3 class="text-dark">Account Activation Form</h3>
					    <hr>
						<div class="row gutters">
							
							<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-12">
								<div class="form-group">
									<label for="user_list">User Name</label>
									<input type="text" class="form-control" name="username" id="user_list" style="font-size:20px;">
								</div>
							</div>
						</div>
                        <button type="submit" id="submit" name="submit" class="btn btn-primary d-block">Active</button>
						</div>
					
						</div>
					
					</div>
				</form>
				</div>
			</div>
		</div>
    </div>

	<style>
		label{
			font-size:17px;
			margin-bottom: 4px;
			color:#000
		}
		input{
			color:black;
		}
		.card-body {
    background: #fff;
}
		.acount_switcher_level{
			font-size: 17px;
		}
		.select select{
			border: none;
			outline: none;
			font-size: 18px;
			padding: 5px 55px 5px 5px;
			background-color: slategray;
			color: white;
			-webkit-appearance: none; /* for Safari */
			margin: 0;
			border-radius: 0;
			border: 1px solid #000;
			width: 100%;
			text-align: center;
		}
		.select select option {
			border: none;
			outline: none;
			font-size: 18px;
			padding: 5px 55px 5px 5px;
			background-color: rgb(255, 255, 255);
			color: rgb(18, 18, 19);
			-webkit-appearance: none; /* for Safari */
			margin: 0;
			border-radius: 0;
		}
		.select {
			width: 100%;
			position: relative;
			display: inline-block;
		}
		.select .arrow {
			position: absolute;
			height: 100%;
			width: 25px;
			top: 0;
			right: 5px;
			background-color: rgb(77 84 78);
			
		}
		.select:focus + .arrow,
		.select:hover + .arrow{
			background-color: dodgerblue;
		}
		.select .arrow::before,
		.select .arrow::after {
			content: "";
			position: absolute;
			width: 0;
			height: 0;
			border-style: solid;
			left: 5px;
		}
		.select .arrow::before {
			border-color: transparent transparent white transparent;
			border-width: 0 8px 8px 8px;
			top: 20%;
		}
		.select .arrow::after {
			border-color: white transparent transparent transparent;
			border-width: 8px 8px 0 8px;
			bottom: 20%;
		}
	</style>
@endsection
