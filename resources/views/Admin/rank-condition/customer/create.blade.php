@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Add News</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('customer_rank_cond_store')}}" method="post">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="target_point">Target point </label>
								<input type="number" class="form-control " placeholder="target point" id="target_point" name="target_point">
							</div>
							<div class="form-group">
								<label for="rank_name" class="w-100 font-weight-bold mb-1">Rank name </label>
								<input type="text" class="form-control " placeholder="rank_name" id="rank_name" name="rank_name">
							</div>
                            <div class="form-group">
								<label for="rank_price" class="w-100 font-weight-bold mb-1">Rank price </label>
								<input type="text" class="form-control " placeholder="rank_price" id="rank_price" name="rank_price">
							</div>
						
						
							<a href="{{ route('customer_rank_conds')}}" class="btn btn-dark" >Back</a>
                            <button type="submit" class="btn btn-success">Create</button>
						</form>
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection
