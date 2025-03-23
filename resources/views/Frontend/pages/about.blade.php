@extends('layouts.Front.app')
@section('content')


	<!-- Start main-content -->
	<section class="page-title" style="background-image: url({{ asset('assets/frontend/images/background/page-title.jpg') }});">
		<div class="auto-container">
			<div class="title-outer">
				<h1 class="title">About Us</h1>
				<ul class="page-breadcrumb">
					<li><a href="index.html">Home</a></li>
					<li><a href="#">Pages</a></li>
					<li>About</li>
				</ul>
			</div>
		</div>
	</section>
	<!-- end main-content -->

	<!-- About Section -->
	<section class="about-section">
		<div class="anim-icons">
			<span class="icon icon-dotted-map"></span>
		</div>
		<div class="auto-container">
			<div class="row">
				<div class="content-column col-lg-6 col-md-12 order-2 wow fadeInRight" data-wow-delay="600ms">
					<div class="inner-column">
						<div class="sec-title">
							<span class="sub-title">Get to know us</span>
							<h2>Grow your skills learn with us from anywhere</h2>
							<div class="text">Lorem ipsum dolor sit amet consectur adipiscing elit sed eiusmod tempor incididunt labore dolore magna aliquaenim ad minim. Sed risus augue, commodo ornare felis non, eleifend molestie metus pharetra eleifend.</div>
						</div>

						<ul class="list-style-one two-column">
							<li><i class="icon fa fa-check"></i> Expert trainers</li>
							<li><i class="icon fa fa-check"></i> Online learning</li>
							<li><i class="icon fa fa-check"></i> Lifetime access</li>
							<li><i class="icon fa fa-check"></i> Great results</li>
						</ul>

						<div class="btn-box">
							<a href="page-about.html" class="theme-btn btn-style-one"><span class="btn-title">Discover more</span></a>
						</div>
					</div>
				</div>

				<!-- Image Column -->
				<div class="image-column col-lg-6 col-md-12">
					<div class="anim-icons">
						<span class="icon icon-dotted-map-2"></span>
						<span class="icon icon-paper-plan"></span>
						<span class="icon icon-dotted-line"></span>
					</div>
					<div class="inner-column wow fadeInLeft">
						<figure class="image-1 overlay-anim wow fadeInUp"><img src="{{ asset('assets/frontend/images/resource/about-1.png')}}" alt=""></figure>
						<figure class="image-2 overlay-anim wow fadeInRight"><img src="{{ asset('assets/frontend/images/resource/about-2.jpg')}}" alt=""></figure>
						<div class="experience bounce-y"><span class="count">16</span> Years of Experience</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Emd About Section -->

	<!-- Courses Section -->
	<section class="courses-section">
		<div class="auto-container">
			<div class="anim-icons">
				<span class="icon icon-e wow zoomIn"></span>
			</div>

			<div class="sec-title">
				<span class="sub-title">popular courses</span>
				<h2>Pick a course to<br> get started your study</h2>
			</div>

			<div class="carousel-outer">
				<!-- Courses Carousel -->
				<div class="courses-carousel owl-carousel owl-theme default-nav">
					<!-- Course Block -->
					<div class="course-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-course-details.html"><img src="{{ asset('assets/frontend/images/resource/course-1.jpg')}}" alt=""></a></figure>
								<span class="price">$49.00</span>
								<div class="value">Advanced</div>
							</div>
							<div class="content-box">
								<ul class="course-info">
									<li><i class="fa fa-book"></i> 8 Lessons</li>
									<li><i class="fa fa-users"></i> 16 Students</li>
								</ul>
								<h5 class="title"><a href="page-course-details.html">Starting seo as your home based business</a></h5>
								<div class="other-info">
									<div class="rating-box">
										<span class="text">(4.9 /8 Rating)</span>
										<div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></div>
									</div>
									<div class="duration"><i class="fa fa-clock"></i> 3 Weeks</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Course Block -->
					<div class="course-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-course-details.html"><img src="{{ asset('assets/frontend/images/resource/course-2.jpg')}}" alt=""></a></figure>
								<span class="price">$49.00</span>
								<div class="value">Advanced</div>
							</div>
							<div class="content-box">
								<ul class="course-info">
									<li><i class="fa fa-book"></i> 8 Lessons</li>
									<li><i class="fa fa-users"></i> 16 Students</li>
								</ul>
								<h5 class="title"><a href="page-course-details.html">Starting seo as your home based business</a></h5>
								<div class="other-info">
									<div class="rating-box">
										<span class="text">(4.9 /8 Rating)</span>
										<div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></div>
									</div>
									<div class="duration">3 Weeks</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Course Block -->
					<div class="course-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-course-details.html"><img src="{{ asset('assets/frontend/images/resource/course-3.jpg')}}" alt=""></a></figure>
								<span class="price">$49.00</span>
								<div class="value">Advanced</div>
							</div>
							<div class="content-box">
								<ul class="course-info">
									<li><i class="fa fa-book"></i> 8 Lessons</li>
									<li><i class="fa fa-users"></i> 16 Students</li>
								</ul>
								<h5 class="title"><a href="page-course-details.html">Starting seo as your home based business</a></h5>
								<div class="other-info">
									<div class="rating-box">
										<span class="text">(4.9 /8 Rating)</span>
										<div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span></div>
									</div>
									<div class="duration">3 Weeks</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Course Block -->
					<div class="course-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-course-details.html"><img src="{{ asset('assets/frontend/images/resource/course-4.jpg')}}" alt=""></a></figure>
								<span class="price">$49.00</span>
								<div class="value">Advanced</div>
							</div>
							<div class="content-box">
								<ul class="course-info">
									<li><i class="fa fa-book"></i> 8 Lessons</li>
									<li><i class="fa fa-users"></i> 16 Students</li>
								</ul>
								<h5 class="title"><a href="page-course-details.html">Starting seo as your home based business</a></h5>
								<div class="other-info">
									<div class="rating-box">
										<span class="text">(4.9 /8 Rating)</span>
										<div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span
												class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>
										</div>
									</div>
									<div class="duration">3 Weeks</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Course Block -->
					<div class="course-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-course-details.html"><img src="{{ asset('assets/frontend/images/resource/course-1.jpg')}}" alt=""></a></figure>
								<span class="price">$49.00</span>
								<div class="value">Advanced</div>
							</div>
							<div class="content-box">
								<ul class="course-info">
									<li><i class="fa fa-book"></i> 8 Lessons</li>
									<li><i class="fa fa-users"></i> 16 Students</li>
								</ul>
								<h5 class="title"><a href="page-course-details.html">Starting seo as your home based business</a></h5>
								<div class="other-info">
									<div class="rating-box">
										<span class="text">(4.9 /8 Rating)</span>
										<div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span
												class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>
										</div>
									</div>
									<div class="duration"><i class="fa fa-clock"></i> 3 Weeks</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Course Block -->
					<div class="course-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-course-details.html"><img src="{{ asset('assets/frontend/images/resource/course-2.jpg')}}" alt=""></a></figure>
								<span class="price">$49.00</span>
								<div class="value">Advanced</div>
							</div>
							<div class="content-box">
								<ul class="course-info">
									<li><i class="fa fa-book"></i> 8 Lessons</li>
									<li><i class="fa fa-users"></i> 16 Students</li>
								</ul>
								<h5 class="title"><a href="page-course-details.html">Starting seo as your home based business</a></h5>
								<div class="other-info">
									<div class="rating-box">
										<span class="text">(4.9 /8 Rating)</span>
										<div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span
												class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>
										</div>
									</div>
									<div class="duration">3 Weeks</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Course Block -->
					<div class="course-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-course-details.html"><img src="{{ asset('assets/frontend/images/resource/course-3.jpg')}}" alt=""></a></figure>
								<span class="price">$49.00</span>
								<div class="value">Advanced</div>
							</div>
							<div class="content-box">
								<ul class="course-info">
									<li><i class="fa fa-book"></i> 8 Lessons</li>
									<li><i class="fa fa-users"></i> 16 Students</li>
								</ul>
								<h5 class="title"><a href="page-course-details.html">Starting seo as your home based business</a></h5>
								<div class="other-info">
									<div class="rating-box">
										<span class="text">(4.9 /8 Rating)</span>
										<div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span
												class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>
										</div>
									</div>
									<div class="duration">3 Weeks</div>
								</div>
							</div>
						</div>
					</div>

					<!-- Course Block -->
					<div class="course-block">
						<div class="inner-box">
							<div class="image-box">
								<figure class="image"><a href="page-course-details.html"><img src="{{ asset('assets/frontend/images/resource/course-4.jpg')}}" alt=""></a></figure>
								<span class="price">$49.00</span>
								<div class="value">Advanced</div>
							</div>
							<div class="content-box">
								<ul class="course-info">
									<li><i class="fa fa-book"></i> 8 Lessons</li>
									<li><i class="fa fa-users"></i> 16 Students</li>
								</ul>
								<h5 class="title"><a href="page-course-details.html">Starting seo as your home based business</a></h5>
								<div class="other-info">
									<div class="rating-box">
										<span class="text">(4.9 /8 Rating)</span>
										<div class="rating"><span class="fa fa-star"></span><span class="fa fa-star"></span><span
												class="fa fa-star"></span><span class="fa fa-star"></span><span class="fa fa-star"></span>
										</div>
									</div>
									<div class="duration">3 Weeks</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="bottom-text">
				<div class="content">
					<strong>23,000+</strong> more skillful courses you can explore <a href="page-courses.html" class="theme-btn btn-style-one small">Explore All Courses</a>
				</div>
			</div>
		</div>
	</section>
	<!-- End Courses Section-->

	<!-- Features Section -->
	<section class="features-section">
		<div class="auto-container">
			<div class="row">
				<!-- Feature Block -->
				<div class="feature-block col-lg-3 col-md-6 col-sm-6 wow fadeInUp">
					<div class="inner-box ">
						<i class="icon flaticon-online-learning"></i>
						<h5 class="title">Online<br> Certifications</h5>
					</div>
				</div>

				<!-- Feature Block -->
				<div class="feature-block col-lg-3 col-md-6 col-sm-6 wow fadeInUp" data-wow-delay="400ms">
					<div class="inner-box ">
						<i class="icon flaticon-elearning"></i>
						<h5 class="title">Top<br> Instructors</h5>
					</div>
				</div>

				<!-- Feature Block -->
				<div class="feature-block col-lg-3 col-md-6 col-sm-6 wow fadeInUp" data-wow-delay="800ms">
					<div class="inner-box ">
						<i class="icon flaticon-web-2"></i>
						<h5 class="title">Unlimited <br>Online Courses</h5>
					</div>
				</div>

				<!-- Feature Block -->
				<div class="feature-block col-lg-3 col-md-6 col-sm-6 wow fadeInUp" data-wow-delay="1200ms">
					<div class="inner-box ">
						<i class="icon flaticon-users"></i>
						<h5 class="title">Experienced <br>Members</h5>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Features Section-->

	<!-- Team Section -->
	<section class="team-section">
		<div class="auto-container">
			<div class="sec-title text-center">
				<span class="sub-title">qualified teachers</span>
				<h2>Meet the teacher who <br>teaches you online</h2>
			</div>

			<div class="row">
				<!-- Team block -->
				<div class="team-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{ asset('assets/frontend/images/resource/team-1.jpg')}}" alt=""></a></figure>
							<span class="share-icon fa fa-share-alt"></span>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
						<div class="info-box">
							<h4 class="name"><a href="#">Edward norton</a></h4>
							<span class="designation">Musian</span>
						</div>
					</div>
				</div>

				<!-- Team block -->
				<div class="team-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="400ms">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{ asset('assets/frontend/images/resource/team-2.jpg')}}" alt=""></a></figure>
							<span class="share-icon fa fa-share-alt"></span>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
						<div class="info-box">
							<h4 class="name"><a href="#">Jane seymour</a></h4>
							<span class="designation">Designer</span>
						</div>
					</div>
				</div>

				<!-- Team block -->
				<div class="team-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="800ms">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{ asset('assets/frontend/images/resource/team-3.jpg')}}" alt=""></a></figure>
							<span class="share-icon fa fa-share-alt"></span>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
						<div class="info-box">
							<h4 class="name"><a href="#">Mike hardson</a></h4>
							<span class="designation">Developer</span>
						</div>
					</div>
				</div>

				<!-- Team block -->
				<div class="team-block col-xl-3 col-lg-6 col-md-6 col-sm-12 wow fadeInUp" data-wow-delay="1200ms">
					<div class="inner-box">
						<div class="image-box">
							<figure class="image"><a href="#"><img src="{{ asset('assets/frontend/images/resource/team-4.jpg')}}" alt=""></a></figure>
							<span class="share-icon fa fa-share-alt"></span>
							<div class="social-links">
								<a href="#"><i class="fab fa-twitter"></i></a>
								<a href="#"><i class="fab fa-facebook-f"></i></a>
								<a href="#"><i class="fab fa-pinterest-p"></i></a>
								<a href="#"><i class="fab fa-instagram"></i></a>
							</div>
						</div>
						<div class="info-box">
							<h4 class="name"><a href="#">Christine eve</a></h4>
							<span class="designation">Artisit</span>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- End Team Section -->
@endsection