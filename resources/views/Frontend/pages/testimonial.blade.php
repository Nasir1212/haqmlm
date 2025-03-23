@extends('layouts.Front.app')
@section('content')

	<!-- Start main-content -->
	<section class="page-title" style="background-image: url(images/background/page-title.jpg);">
		<div class="auto-container">
			<div class="title-outer">
				<h1 class="title">Testimonial</h1>
				<ul class="page-breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li><a href="#">Pages</a></li>
					<li>Testimonial</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- end main-content -->

	<!-- Testimonial Section -->
	<section>
		<div class="container pb-90">
			<div class="row">
				<!-- Testimonial Carousel -->
				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="testimonial-block mb-md-30">
						<div class="inner-box">
							<div class="content-box">
								<figure class="thumb"><img src="images/resource/testi-thumb-1.jpg" alt=""></figure>
								<div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								<div class="text">Lorem ipsum is simply free text dolor sit amet, consectetur adipisicing elit, sed do incididunt ut labore et dolore magna aliqua.</div>
								<div class="info-box">
									<span class="icon-quote"></span>
									<h4 class="name">Jame sickres</h4>
									<span class="designation">Market Manager</span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-12 col-sm-12">
					<div class="testimonial-block">
						<div class="inner-box">
							<div class="content-box">
								<figure class="thumb"><img src="images/resource/testi-thumb-2.jpg" alt=""></figure>
								<div class="rating"><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i><i class="fa fa-star"></i></div>
								<div class="text">Lorem ipsum is simply free text dolor sit amet, consectetur adipisicing elit, sed do incididunt ut labore et dolore magna aliqua.</div>
								<div class="info-box">
									<span class="icon-quote"></span>
									<h4 class="name">Aleesha brown</h4>
									<span class="designation">Market Manager</span>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Testimonial Section -->
@endsection