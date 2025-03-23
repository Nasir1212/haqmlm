@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Wellcome To Package Purchase</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="row">
							@foreach ($packages as $package)
							<div class="col-4">
								<div class="product_wrapper">
									<div class="product_details">
										<div class="img">
											<img src="{{ asset($package->img_name)}}" alt="">
										</div>
										<div class="product_title">
											{{ $package->name }}
										</div>
										<div class="product_price">
											<div class="sell_price">
												{{ $package->main_price }}
											</div>
											<div class="regular_price">
												{{ $package->regular_price }}
											</div>
										</div>
									</div>
									<div class="product_order_option">
										<a href="{{ route('package_order', ['slug'=>$package->slug])}}" class="details_link btn btn-primary">Order</a>
										<a href="{{ route('frontend.package_details', ['slug'=>$package->slug])}}" class="details_link btn btn-primary">See Details</a>
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
@endsection
