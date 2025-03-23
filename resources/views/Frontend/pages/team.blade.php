@extends('layouts.Front.app')
@section('content')


	<!-- Start main-content -->
	<section class="page-title" style="background-image: url({{asset('assets/frontend/images/background/page-title.jpg')}});">
		<div class="auto-container">
			<div class="title-outer">
				<h1 class="title">Team Grid</h1>
				<ul class="page-breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li><a href="#">Pages</a></li>
					<li>Team</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- end main-content -->

	<!-- Team Section -->
	<section class="team-section">
		<div class="auto-container">
			<div class="row">
				<!-- Team block -->
				<div class="team-block col-lg-3 col-md-6 col-sm-12">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="page-team-details.html"><img src="{{asset('assets/frontend/images/resource/team-1.jpg')}}" alt=""></a></figure>
							<span class="share-icon fa fa-share-alt"></span>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
						<div class="info-box">
							<h4 class="name"><a href="page-team-details.html">Edward norton</a></h4>
							<span class="designation">Musian</span>
						</div>
					</div>
				</div>

				<!-- Team block -->
				<div class="team-block col-lg-3 col-md-6 col-sm-12">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="page-team-details.html"><img src="{{asset('assets/frontend/images/resource/team-2.jpg')}}" alt=""></a></figure>
							<span class="share-icon fa fa-share-alt"></span>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
						<div class="info-box">
							<h4 class="name"><a href="page-team-details.html">Jane seymour</a></h4>
							<span class="designation">Designer</span>
						</div>
					</div>
				</div>

				<!-- Team block -->
				<div class="team-block col-lg-3 col-md-6 col-sm-12">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="page-team-details.html"><img src="{{asset('assets/frontend/images/resource/team-3.jpg')}}" alt=""></a></figure>
							<span class="share-icon fa fa-share-alt"></span>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
						<div class="info-box">
							<h4 class="name"><a href="page-team-details.html">Mike hardson</a></h4>
							<span class="designation">Developer</span>
						</div>
					</div>
				</div>

				<!-- Team block -->
				<div class="team-block col-lg-3 col-md-6 col-sm-12">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="page-team-details.html"><img src="{{ asset('assets/frontend/images/resource/team-4.jpg')}}" alt=""></a></figure>
							<span class="share-icon fa fa-share-alt"></span>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
						<div class="info-box">
							<h4 class="name"><a href="page-team-details.html">Christine eve</a></h4>
							<span class="designation">Artisit</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Team Section -->
@endsection