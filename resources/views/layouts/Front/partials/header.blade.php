<header class="main-header header-style-one pc_screen">

    <!-- Main box -->
    <div class="main-box">
        
        <div class="logo-box pc_screen">
            <div class="logo">
                <a href="{{ route('public_index')}}">
                    <img src="{{ asset('/assets/logo.png') }}" >
                    <p>Bangladesh</p>
                </a></div>
        </div>
        <div class="right_part">
            <div class="w-100 dsk pc_screen">   
                <form action="{{ route('product_check_and_display')}}" method="post" class="w-100">
                    @csrf
                    <div class="btn-group w-100" > 
                    <input type="search" name="slug"  placeholder="product name" id="dqfp" class="form-control" style="height:40px !important">
                    <button type="submit" class="btn btn-info">Search</button>
                    </div>
                </form>
            </div>
        
        <div class="nav-outer">

            <nav class="nav main-menu">
                <ul class="navigation">
                    <li><a href="{{ route('public_products') }}">Products</a></li>
                    <li><a href="{{ route('public_packages') }}">Package</a></li>
                    <li><a href="{{ route('public_brands') }}">Brands</a></li> 
                    <li><a href="{{ route('public_categories') }}">Categories</a></li>
                    </li>
                
                    <li><a href="{{ route('contact_us') }}">Contact</a></li>
                    @auth()
                    <li><a href="{{ route('get_cart') }}"><span class="d-inline-block mr-1">Cart</span> <span class="cart_v badge bg-primary mb-3 ml-1">
                  <?php if(isset($c_products)){echo $c_products; }else{ echo 0; } ?>
                  
         
                        
                 </span></a></li>
                    <li><a href="{{ route('get_wishlist') }}">
                        
                        <span class="d-inline-block mr-1">Wish List</span> <span class="wsp_v badge bg-primary mb-3 ml-1">
                            <?php if(isset($wsp_products)){echo $wsp_products; }else{ echo 0; } ?>  
                           </span>
                    </a></li>
                    @else
                    <li><a href="{{ route('login') }}">
                       Cart
                    </a></li>
                    <li><a href="{{ route('login') }}">Wish List</a></li>
                    @endauth
                 
                </ul>
            </nav>
            <!-- Main Menu End-->


            <div class="outer-box">
                <a href="tel:+88{{ $st->phone }}" class="info-btn">
                    <i class="icon fa fa-phone"></i>
                    <small>Call Anytime</small><br> {{ $st->phone }}
                </a>

                <div class="ui-btn-outer">
                
                    @if (Route::has('login'))
                    <div>
                        @auth
                            <a href="{{ url('/dashboard') }}" >My Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" >Log in /</a>
    
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" >Register</a>
                            @endif
                        @endauth
                    </div>
                @endif
    
                </div>
                <!-- Mobile Nav toggler -->
                <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
            </div>
        </div>
        </div>
        
          
        </div>
        <div class="w-100 mbl">   
            <form action="{{ route('product_check_and_display_m')}}" method="post" class="w-100">
                @csrf
                <div class="btn-group w-100" > 
                <input type="search" name="slug" placeholder="product name" id="mqfp" class="form-control" style="height:40px !important">
                <button type="submit" class="btn btn-info">Search</button>
                </div>
            </form>
        </div>
        <!--Nav Box-->
       
    </div>
    <!-- End Main Box -->

    <!-- Mobile Menu  -->
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>

        <!--Here Menu Will Come Automatically Via Javascript / Same Menu as in Header-->
        <nav class="menu-box">
            <div class="upper-box">
                <div class="nav-logo"><a href="{{ route('public_index')}}"><img src="{{ asset('/assets/logo.png') }}" alt="" title=""></a></div>
                <div class="close-btn"><i class="icon fa fa-times"></i></div>
            </div>

            <ul class="navigation clearfix">
                <!--Keep This Empty / Menu will come through Javascript-->
            </ul>
            <ul class="contact-list-one">
                <li>
                    <!-- Contact Info Box -->
                    <div class="contact-info-box">
                        <i class="icon lnr-icon-phone-handset"></i>
                        <span class="title">Call Now</span>
                        <a href="tel:+88{{ $st->phone }}">{{ $st->phone }}</a>
                    </div>
                </li>
                <li>
                    <!-- Contact Info Box -->
                    <div class="contact-info-box">
                        <span class="icon lnr-icon-envelope1"></span>
                        <span class="title">Send Email</span>
                        <a href="mailto:{{ $st->email }}">{{ $st->email }}</a>
                    </div>
                </li>
                
            </ul>


            <ul class="social-links">
                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                <li><a href="#"><i class="fab fa-pinterest"></i></a></li>
                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </nav>
    </div><!-- End Mobile Menu -->

    <!-- Header Search -->
    <div class="search-popup">
        <span class="search-back-drop"></span>
        <button class="close-search"><span class="fa fa-times"></span></button>

        <div class="search-inner">
            <form method="post" action="#">
                <div class="form-group">
                    <input type="search" name="search-field" value="" placeholder="Search..." required="">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </div>
            </form>
        </div>
    </div>
    <!-- End Header Search -->

    <!-- Sticky Header  -->
    <div class="sticky-header">
        <div class="auto-container">
            <div class="inner-container">
                <!--Logo-->
                <div class="logo">
                   <a href="{{ route('public_index') }}" title="">
                    <img src="{{ asset('assets/logo.png') }}" alt="" title="">

                </a>
              
                </div>

                <!--Right Col-->
                <div class="nav-outer">
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-collapse show collapse clearfix">
                            <ul class="navigation clearfix">
                                <!--Keep This Empty / Menu will come through Javascript-->
                            </ul>
                        </div>
                    </nav><!-- Main Menu End-->

                    <!--Mobile Navigation Toggler-->
                    <div class="mobile-nav-toggler"><span class="icon lnr-icon-bars"></span></div>
                </div>
            </div>
        </div>
    </div><!-- End Sticky Menu -->
       	<div class="product-box-m"></div>
    	<div class="product-box"></div>
</header>
@php   $dt =  current_select_dealer();  @endphp
@if($dt != '')
<section class="text-center mb-2 pc_screen">
   {!! $dt !!}
</section>

<section class="mobile_header">

</section>
@endif
<style>
    @media(max-width:767px){
       .dsk{
        display:none !important;
    } 
    .mbl{
              display:block !important;
        }
    
    }
    
    @media(min-width:768px){
        .mbl{
              display:none !important;
        }
         .dsk{
        display:block !important;
    } 
    }
    
</style>
