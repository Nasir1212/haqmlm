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