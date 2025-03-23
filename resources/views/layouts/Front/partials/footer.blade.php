<footer class="main-footer">

    <div class="widgets-section">
        <div class="auto-container">
            <div class="row">
                <!--Footer Column-->
                <div class="footer-column col-xl-3 col-lg-12 col-md-6 col-sm-12">
                  
                </div>

                <!--Footer Column-->
                <div class="footer-column col-xl-2 col-lg-4 col-md-6 col-sm-12 mdc">
                    <div class="footer-widget">
                        <h4 class="widget-title">Explore</h4>
                        <ul class="user-links">
                          
                            <li><a href="{{ route('get_faqs')}}">FAQ's</a></li>
                            <li><a href="{{ route('login')}}">Sign In/Registration</a></li>
                            
                            <li><a href="{{ route('contact_us') }}">Contacts</a></li>
                        </ul>
                    </div>
                </div>

                <!--Footer Column-->
                <div class="footer-column col-xl-2 col-lg-4 col-md-6 col-sm-12 mdc">
                    <div class="footer-widget">
                        <h4 class="widget-title">Links</h4>
                        <ul class="user-links">
                            <li><a href="{{ route('get_page',['slug'=>'about-us']) }}">About</a></li>
                            <li><a href="{{ route('get_page',['slug'=>'terms-condition']) }}">Terms & Condition</a></li>
                            <li><a href="{{ route('get_page',['slug'=>'privacy-policy']) }}">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>

                <!--Footer Column-->
                <div class="footer-column col-xl-5 col-lg-4 col-md-6 col-sm-12 mdc">
                    <div class="footer-widget contact-widget">
                        <h4 class="widget-title">Contact</h4>
                        <div class="widget-content">
                            <ul class="contact-info">
                                <li><i class="fa fa-phone-square"></i> <a href="tel:+88{{ $st->phone }}">{{ $st->company_helpline }}</a></li>
                                <li><i class="fa fa-envelope"></i> <a href="mailto:{{ $st->email }}">{{ $st->admin_mail }}</a></li>
                                <li><i class="fa fa-map-marker-alt"></i>{{ $st->company_address }}</li>
                            </ul>
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Footer Bottom-->
    <div class="footer-bottom mdc">
        <div class="auto-container">
            <div class="inner-container">
                <div class="copyright-text">&copy; Copyright 2023 by  <a href="#">{{ $st->company_name }}</a></div>
            </div>
        </div>
    </div>
</footer>
<style>
    @media(max-width:767px){
        .mdc{
            text-align:center;
        }
        .main-footer .widgets-section {
    position: relative;
    padding: 0px; 
}
    }
</style>
