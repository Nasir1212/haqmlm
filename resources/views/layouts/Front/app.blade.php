<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8">
<title>{{ config('app.name') }}</title>
<!-- Stylesheets -->
	<link rel="stylesheet" href="{{ asset('assets/backend/css/notify.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link href="{{ asset('assets/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/frontend/css/style.css') }}" rel="stylesheet">
<link href="{{ asset('assets/frontend/css/responsive.css') }}" rel="stylesheet">
<link href="{{ asset('assets/frontend/css/cf765ba6f2a5b22c.css') }}" rel="stylesheet">

<link rel="shortcut icon" href="{{ asset('assets/logo.png') }}">
<link rel="icon" href="{{ asset('assets/logo.png') }}">

<!-- Responsive -->
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
@stack('css')

		<style>
			.notify{
				z-index: 9999999999999999999999999999;
			}
			
body{
font-family: __SolaimanLipi_b8d676 !important;
/* max-width: 1280px;
width: 100%;
margin: 0 auto; */
}
h1,h2,h3,h4,h5,h6{
font-family: __SolaimanLipi_b8d676 !important;

}
p{
font-family: __SolaimanLipi_b8d676 !important;

}

strong{
font-family: __SolaimanLipi_b8d676 !important;

}
.header_dealer_container{
    display: flex;
    justify-content: center;
    margin-block: 11px;
}

.mbl #mqfp{
    
    height: 40px !important;
}

@if(Auth::check())

.mobile_header{
    display: none ;
}

@media screen and (max-width: 375px) {
 
}
@media screen and (max-width: 767px) {
    .mobile_header{
    justify-content: space-between;
    margin: 0px 12px 0px 12px;
    display: flex !important;
    height: 67px;
    position: sticky;
    overflow: hidden;
    top: 0px;
    bottom: 0;
    z-index: 8;
    background: white;
    width: 94%;
    left: 0;
    height: 90px;
}


    .pc_screen {
    display: none !important;
}

    .header_dealer_container {
    display: block;
}
.dealer_name {
    font-weight: bolder;
    color: black;
    font-size: 27px;
}
.dealer_address {
    font-size: 17px;
    font-weight: bold;
    color: black;
}
.dealer_phone {
    font-size: 14px;
    font-weight: bold;
}



.m_logo a img {
    border: none;
    width: 50px;
    height: 50px;
}
.m_logo .m_country {
	font-size: 11px;
	font-weight: bold;
	padding: 0;
	margin: 0;
	color: red;
	transform: translateY(-9px);
}
.auth_container {
	transform: translateY(6px);
}
.m_shop_heading_container h3{
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    margin-top: 12px;
    margin-bottom: 0px;
    color: #1e521e;
}
.m_shop_heading_container h5{
    font-size: 12px;
    text-align: center;
    margin-bottom: 0px;
    color: green;

}

.m_shop_heading_container h6{
    font-size: 11px;
    font-weight: bold;
    text-align: center;
}
.notify_burgur_icon_container {
    width: 66px;
    transform: translateX(12px);
}
.auth_notify_container {
	display: flex;
	flex-direction: column-reverse;
	justify-content: space-evenly;
	margin-right: 2px;
    height: 20px;
}
.auth_container a {
    font-size: 12px;
    font-weight: bold;
}

._mobile_popup {
    position: static !important;
    height: 23vh;
   
}
.mbl {
    position: fixed;
    top: 59px;
    width: 94% !important;
    left: 12px;
    padding: 0;
    overflow: hidden;
}
.mbl #mqfp{
    padding: 4px 18px;
    height: 23px !important;
}
.mbl button{
    padding: 0px 13px;
    height: 23px;
    text-align: center;
    font-size: 14px;
}
}
@endif

		</style>
</head>

<body>
	<x-notify::notify />
<div class="page-wrapper">
	<!-- Main Header-->

    @include('layouts.Front.partials.header')
	<!--End Main Header -->

	@yield('content')

	<!-- Main Footer -->

	@include('layouts.Front.partials.footer')
	<!--End Main Footer -->

</div><!-- End Page Wrapper -->

<!-- Scroll To Top -->
<div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>

<script src="{{ asset('assets/frontend/js/jquery.js') }}"></script> 
<script src="{{ asset('assets/frontend/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/bootstrap.min.js') }}"></script>


<script src="{{ asset('assets/frontend/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/frontend/js/swiper.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<script src="{{ asset('assets/frontend/js/script.js') }}"></script>
<script src="{{ asset('assets/backend/js/notify.js') }}"></script> 
<script type="text/javascript">
$( document ).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>
@stack('script')
    <style>
     .product-box-m {
    position:absolute;
    left:0;
    right:0;
    top:115px;
    margin: 0 32px;
    background:#fff;
    border-radius:10px;
    box-shadow:0px 0px 2px #000;
    z-index:555555;
}
    .product-box {
    position:absolute;
    left:0;
    right:0;
    top:100px;
    margin: 0 32px;
    background:#fff;
    border-radius:10px;
    box-shadow:0px 0px 2px #000;
    z-index:555555;
}
        ul#product_names {
    border: 1px solid black;
        border-radius:10px;
    
}

ul#product_names .product_name {
    padding: 5px 10px;
    border-bottom: 1px solid black;
}

ul#product_names .product_name:last-child {
    padding: 5px 10px;
    border-bottom: none;
}
ul#product_names .product_name:hover {
    background:#fff;
    color:#000;
 
}
    </style>
    <script>


(function($){
    $(document).on('click', 'ul#product_names .product_name', function () {
    $('#mqfp').val($(this).data('product_slug'));
    $('.product-box-m').html('');
});
    
       $('#mqfp').on('keyup',function() {
            var product_name = $('#mqfp').val();
              
              if(product_name == ''){

              }else{
               
              $.ajax({
                  url: '{{ route('realtime_p_name_sg') }}',
                  method: 'POST',
				  dataType: 'json', 
                  headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
                  data: { product_name: product_name }, // Replace with your data
                  success: function(response) {
                  
                      $('.product-box-m').html(response);
                
                  },
                  error: function(error) {
                      console.log(error);
                      // Handle errors here
                  }
              });
              }
              
          });
	
$(document).on('click', 'ul#product_names .product_name', function () {
    $('#dqfp').val($(this).data('product_slug'));

    
    $('.product-box').html('');
});
 		

        $('#dqfp').on('keyup',function() {
            var product_name = $('#dqfp').val();
              
              if(product_name == ''){

              }else{
               
              $.ajax({
                  url: '{{ route('realtime_p_name_sg') }}',
                  method: 'POST',
				  dataType: 'json', 
                  headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
                  data: { product_name: product_name }, // Replace with your data
                  success: function(response) {
                  
                 
                      $('.product-box').html(response);
                
                  },
                  error: function(error) {
                      console.log(error);
                      // Handle errors here
                  }
              });
              }
              
          });

})(jQuery)

         
    </script>
</body>
</html>