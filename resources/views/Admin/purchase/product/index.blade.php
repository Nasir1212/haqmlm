@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Wellcome To Product Purchase</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="row">
							@foreach ($products as $product)
							<div class="col-12 col-md-4 col-xl-4 col-lg-4">
								<div class="product_wrapper">
									<div class="product_details">
										<div class="img">
											<img src="{{ asset($product->img_name)}}" class="img-fluid" alt="">
										</div>
										<div class="product_title">
											{{ $product->name }}
										</div>
										<div class="product_price">
											<div class="sell_price">
												Regular Price <del>{{ $product->regular_price }}</del>
											</div>
											<div class="regular_price">
											Sell Price	{{ $product->main_price }}
											</div>
										</div>
									</div>
									<div class="product_order_option mt-2">
										<button class="add_to_cart btn btn-info">
											Add To Cart
										</button>
										<a href="{{ route('product_order', ['slug'=>$product->slug])}}" target="_blank" class="details_link btn btn-success">Order Now</a>
										<a href="{{ route('frontend.product_details', ['slug'=>$product->slug])}}" target="_blank" class="details_link btn btn-primary">See Details</a>
									</div>
									
								</div>
							</div>
							@endforeach
						</div>
                    </div>
					
				</div>
			</div>
		</div>
    </div>
	<style>
.product_wrapper {
    border: 1px solid #000;
    padding: 14px;
    background: #141414;
    text-align: center;
    margin-bottom: 20px;
}
.product_title {
    font-size: 22px;
    margin-top: 20px;
}
.sell_price{
    font-size:21px;
}
.regular_price{
    font-size:21px;
}
.img {
    text-align: center;
    display: flex;
    width: 100%;
    justify-content: center;
}
.img img {
    max-width: 100%;
    height: 449px;
}
	</style>
@endsection
