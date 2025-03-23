@extends('layouts.Front.app')
@section('content')


    <div class="container mt-4">
        	    @if (\Session::has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">

 <strong>Success!</strong> {!! \Session::get('success') !!}

	 <button  type="button" class="close btn" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
  </button>
</div>
@endif
    </div>

	<!--Contact Details Start-->
	<section class="contact-details">
		<div class="container ">
	
			<div class="row">
				<div class="col-xl-7 col-lg-6">
					<div class="sec-title">
						<span class="sub-title">Send us email</span>
						<h2>Contact us</h2>
					</div>
					<!-- Contact Form -->
					<form id="contact_form" name="contact_form" class="" action="{{ route('contact_requestex')}}" method="post">
					    @csrf
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<input name="form_name" class="form-control" type="text" placeholder="Enter Name">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="mb-3">
									<input name="form_email" class="form-control required email" type="email" placeholder="Enter Email">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="mb-3">
									<input name="form_subject" class="form-control required" type="text" placeholder="Enter Subject">
								</div>
							</div>
							<div class="col-sm-6">
								<div class="mb-3">
									<input name="form_phone" class="form-control" type="text" placeholder="Enter Phone">
								</div>
							</div>
						</div>
						<div class="mb-3">
							<textarea name="form_message" class="form-control required" rows="7" placeholder="Enter Message"></textarea>
						</div>
						<div class="mb-3">
							<input name="form_botcheck" class="form-control" type="hidden" value="" />
							<button type="submit" class="theme-btn btn-style-one" data-loading-text="Please wait..."><span class="btn-title">Send message</span></button>
							<button type="reset" class="theme-btn btn-style-one bg-theme-color5"><span class="btn-title">Reset</span></button>
						</div>
					</form>
					<!-- Contact Form Validation-->
				</div>
				<div class="col-xl-5 col-lg-6">
					<div class="contact-details__right">
						<div class="sec-title">
							<span class="sub-title">Need any help?</span>
							<h2>Get in touch with us</h2>
							<div class="text">Lorem ipsum is simply free text available dolor sit amet consectetur notted adipisicing elit sed do eiusmod tempor incididunt simply dolore magna.</div>
						</div>
						<ul class="list-unstyled contact-details__info">
							<li>
								<div class="icon bg-theme-color2">
									<span class="lnr-icon-phone-plus"></span>
								</div>
								<div class="text">
									<h6>Have any question?</h6>
									<a href="tel:+88{{ $st->company_helpline}}">{{ $st->company_helpline}}</a>
								</div>
							</li>
							<li>
								<div class="icon">
									<span class="lnr-icon-envelope1"></span>
								</div>
								<div class="text">
									<h6>Write email</h6>
									<a href="mailto:{{ $st->admin_mail}}">{{ $st->admin_mail}}</a>
								</div>
							</li>
							<li>
								<div class="icon">
									<span class="lnr-icon-location"></span>
								</div>
								<div class="text">
								
									<span>{{ $st->company_address}}</span>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!--Contact Details End-->
	
	<!-- Divider: Google Map -->
	<section>
		<div class="container-fluid p-0">
			<div class="row">
				<!-- Google Map HTML Codes -->
			
			</div>
		</div>
	</section>
	@endsection
	