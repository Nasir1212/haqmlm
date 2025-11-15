<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Meta -->
		<meta name="description" content="Invesco is one of the populer investment platform">
		<link rel="shortcut icon" href="{{ asset('assets/logo.png') }}">
<link rel="icon" href="{{ asset('assets/logo.png') }}">

		<!-- Title -->
		<title>HMS Affiliate System</title>
		<link rel="stylesheet" href="{{ asset('assets/backend/css/notify.css') }}">
		{{-- @notifyCss --}}
		<!-- ***** Common Css Files ***** -->
		<!-- Bootstrap css -->
		<link rel="stylesheet" href="{{ asset('assets/backend/css/bootstrap.min.css') }}">
		<!-- Icomoon Font Icons css -->
		<link rel="stylesheet" href="{{ asset('assets/backend/fonts/style.css') }}">
		<!-- Main css -->
		<link rel="stylesheet" href="{{ asset('assets/backend/css/main.css') }}">
		<!-- Chat css -->
		<link rel="stylesheet" href="{{ asset('assets/backend/css/chat.css') }}">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

		<!-- ******* Vendor Css Files ************ -->
		@stack('css')
		<style>
			.notify{
				z-index: 9999999999999999999999999999;
			}

			

			.extra_logo {
			display: flex;
			align-items: center;
			position: absolute;
			top: 17px;
			left: 22rem;
			width: 13rem;
    		justify-content: space-around;
			z-index: 20000;
			}

/* .extra_logo {
    position: fixed;
    top: 17px;
    left: 5rem;
    width: 13rem;
    justify-content: space-around;
} */
    @media screen and (max-width: 575px) {  
		.extra_logo{
		
			top: 17px;
			left: 5rem;
			}
			.tra_title{
				font-size: 16px;
			}
			.tran_left_side_info h4, .tran_left_side_info h3, .tran_right_side_info h4{
				font-size: 14px;
			}
}

  @media screen and (max-width: 375px) { 
		.extra_logo{
       
		width: 10rem;
		}


   }


    /* #notificationDropdown {
        display: none;
    } */
    /* #notificationDropdown.show {
        display: block;
    } */

	.show {
        display: block !important;
    }


	/* Target the scroll container */
.notificatin_ul {
    max-height: 300px;
    overflow-y: auto;
}

/* Scrollbar Track */
.notificatin_ul::-webkit-scrollbar {
    width: 8px; /* Vertical scrollbar width */
}

/* Scrollbar Thumb */
.notificatin_ul::-webkit-scrollbar-thumb {
    background-color: #888;
    border-radius: 10px;
}

/* Scrollbar Thumb on Hover */
.notificatin_ul::-webkit-scrollbar-thumb:hover {
    background-color: #555;
}

/* Scrollbar Track Background */
.notificatin_ul::-webkit-scrollbar-track {
    background-color: #f1f1f1;
}

</style>
	

		
	</head>

	<body>
		<x-notify::notify />
		
		<!-- Loading starts -->
		{{-- <div id="loading-wrapper">
			<div class="spinner-border" role="status">
				<span class="sr-only">Loading...</span>
			</div>
		</div> --}}
		<!-- Loading ends -->
		
		<!-- Page wrapper start -->
		<div class="page-wrapper">
			
			<!-- Sidebar wrapper start -->
            @include('layouts.Back.partials.sidebar')
			<!-- Sidebar wrapper end -->

			<!-- Page content start  -->
			<div class="page-content">
				
				<!-- Header start -->
				@include('layouts.Back.partials.header')
				<!-- Header end -->

				<!-- Main container start -->
			    @yield('content')
				<!-- Main container end -->

				<!-- Container fluid start -->
			    @include('layouts.Back.partials.footer')
				<!-- Container fluid end -->
				@include('layouts.Back.partials.notification')
				<!-- Chat start -->
                @include('layouts.Back.partials.chat')
				<!-- Chat end -->

			</div>
			<!-- Page content end -->

		</div>
		<!-- Page wrapper end -->

		<!--**************************
			**************************
				**************************
							Required JavaScript Files
				**************************
			**************************
		**************************-->
		<!-- Required jQuery first, then Bootstrap Bundle JS -->
		
		<script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script>
		<script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>
		<script src="{{ asset('assets/backend/js/moment.js') }}"></script>


		<!-- *************
			************ Vendor Js Files *************
		************* -->
		<!-- Slimscroll JS -->
		<script src="{{ asset('assets/backend/vendor/slimscroll/slimscroll.min.js') }}"></script>
		<script src="{{ asset('assets/backend/vendor/slimscroll/custom-scrollbar.js') }}"></script>

		<!-- Polyfill JS -->
		<script src="{{ asset('assets/backend/vendor/polyfill/polyfill.min.js') }}"></script>
		<script src="{{ asset('assets/backend/vendor/polyfill/class-list.min.js') }}"></script>

		<!-- Apex Charts -->
		{{-- <script src="{{ asset('assets/backend/vendor/apex/apexcharts.min.js') }}"></script>
		<script src="{{ asset('assets/backend/vendor/apex/custom/home/lineRevenueGradientGraph.js') }}"></script>
		<script src="{{ asset('assets/backend/vendor/apex/custom/home/radialTasks.js') }}"></script>
		<script src="{{ asset('assets/backend/vendor/apex/custom/home/lineNewCustomersGradientGraph.js') }}"></script>
		 --}}
		<!-- Peity Charts -->
		<script src="{{ asset('assets/backend/vendor/peity/peity.min.js') }}"></script>
		<script src="{{ asset('assets/backend/vendor/peity/custom-peity.js') }}"></script>
		
		<!-- Circleful Charts -->
		<script src="{{ asset('assets/backend/vendor/circliful/circliful.min.js') }}"></script>
		<script src="{{ asset('assets/backend/vendor/circliful/circliful.custom.js') }}"></script>
		
		<!-- Main JS -->
		<script src="{{ asset('assets/backend/js/main.js') }}"></script>
		<script src="{{ asset('assets/backend/js/notify.js') }}"></script> 
	{{-- @notifyJs --}}
		@stack('script')

		<script>
			let pageWrapper = document.getElementsByClassName("page-wrapper")[0]; 
			let toggleBtns = document.getElementsByClassName("toggle-btns")[0]; 
			let extra_logo = document.getElementsByClassName("extra_logo")[0]; 

			toggleBtns.addEventListener("click", function () {
				if(pageWrapper.classList.contains("toggled")){
					extra_logo.style.cssText = "display: none;";
				}else{
					extra_logo.style.cssText = "display: flex;";
				}
        });
		</script>
>

	</body>
</html>