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
						<form action="{{ route('gen_rank_cond_store')}}" method="post">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="pos">Position </label>
								<input type="number" class="form-control " placeholder="position" id="pos" name="pos">
							</div>
							<div class="form-group">
								<label for="down_check" class="w-100 font-weight-bold mb-1">Down Total </label>
								<input type="number" class="form-control " placeholder="down_check" id="down_check" name="down_check">
							</div>
                            <div class="form-group">
								<label for="first_check" class="w-100 font-weight-bold mb-1">First gen </label>
								<input type="number" class="form-control " placeholder="rank_price" id="first_check" name="first_check">
							</div>
                            <div class="form-group">
								<label for="second_check" class="w-100 font-weight-bold mb-1">Second gen </label>
								<input type="number" class="form-control " placeholder="second_check" id="second_check" name="second_check">
							</div>  
                            
                            <div class="form-group">
								<label for="prev_rank" class="w-100 font-weight-bold mb-1">Prev rank </label>
								<input type="text" class="form-control " placeholder="prev_rank" id="prev_rank" name="prev_rank">
							</div> 

                            <div class="form-group">
								<label for="rank_name" class="w-100 font-weight-bold mb-1">Rank name </label>
								<input type="text" class="form-control " placeholder="rank_name" id="rank_name" name="rank_name">
							</div> 
                            
                            <div class="form-group">
								<label for="rank_royality" class="w-100 font-weight-bold mb-1">Rank royality </label>
								<input type="text" class="form-control " placeholder="rank_royality" id="rank_royality" name="rank_royality">
							</div>
						
						
							<a href="{{ route('gen_rank_conds')}}" class="btn btn-dark" >Back</a>
                            <button type="submit" class="btn btn-success">Create</button>
						</form>
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection
