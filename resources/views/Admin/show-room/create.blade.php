@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Custom Order Create</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
						<form action="{{ route('sell_make')}}" method="post" enctype="multipart/form-data">
							@csrf
							<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="select_product">Select Product</label>
								<select class="form-control " id="select_product" name="select_product">
								    <option value="id">Product name</option>
								</select>
							 
							</div>
							
							<div class="form-group">
								<label for="qty" class="w-100 font-weight-bold mb-1">Qty</label>
								<input type="number" class="form-control " placeholder="qty" id="qty" name="qty">
							</div>
							
							<div class="form-group">
								<label for="user_name" class="w-100 font-weight-bold mb-1">Customer Username</label>
								<input type="text" class="form-control " placeholder="username" id="user_name" name="user_name">
							</div>
					
							<a href="{{ route('product_category_list')}}" class="btn btn-dark" >Back</a>
                            <button type="submit" class="btn btn-success">Confirm Order</button>
						</form>
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection

@push('script')

@endpush