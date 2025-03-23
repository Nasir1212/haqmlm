

<header class="header">
    <div class="toggle-btns">
        <a id="toggle-sidebar" href="#">
            <i class="icon-menu"></i>
        </a>
        <a id="pin-sidebar" href="#">
            <i class="icon-menu"></i>
        </a>
    </div>

   
    <div class="header-items">
        <!-- Custom search start -->
        {{-- <div class="custom-search">
            <input type="text" class="search-query" placeholder="Search here ...">
            <i class="icon-search1"></i>
        </div> --}}
        <!-- Custom search end -->

        <!-- Header actions start -->
        <ul class="header-actions">
  
            <li class="dropdown user-settings">
                <a href="#" id="userSettings" data-toggle="dropdown" aria-haspopup="true" style="display: flex;flex-direction: column;">
                    @if ($gsd->user_pic == '' || $gsd->user_pic ==  null)
                    <img src="{{ asset('assets/backend/img/user2.png') }}" class="user-avatar" alt="Avatar">
                    @else
                    <img src="{{ asset($gsd->user_pic_path.$gsd->user_pic) }}" class="user-avatar" alt="Avatar">
                    @endif
                    <p style="font-weight: bold;color:white">{{$gsd->username}}</p>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userSettings">
                    <div class="header-profile-actions">
                        <div class="header-user-profile">
                            
                            <h5>{{ $gsd->first_name }}</h5>
                            <p>HMS USER</p>
                        </div>
                        <a href="{{ route('user_details',['username' => $gsd->username])}}" ><i class="icon-settings1"></i>Balance Summary</a>
                        <a href="{{ route('user_account_setup', ['username'=> $gsd->username])}}"><i class="icon-settings1"></i> My Profile</a>
                        
                        <form action="{{ route('logout') }}" id="logout-form" method="post">
                            @csrf
                            <button type="submit" class="btn-none" style="padding: .2rem 0.7rem;display: flex;align-items: center;color: #687690;font-size:1rem;position: relative;background: transparent;margin: auto;margin-top: 12px;"><i class="icon-log-out1"></i> &nbsp; Sign Out</button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>						
        <!-- Header actions end -->
    </div>
</header>

<div class="extra_logo">
    <div>
        <img src="{{asset('/assets/olter_logo.png')}}" style="width: 55px; height: 55px; border-radius: 50%;" alt="">
    </div>

    <!-- Notification Icon -->
    <div style="position: relative; width: 26px; height: 20px; text-align: center;">
        <i class="fa-solid fa-bell" style="font-size: 25px;"></i>
        <span style="
            position: absolute;
            top: -5px;
            right: -5px;
            background: red;
            color: white;
            font-size: 12px;
            font-weight: bold;
            padding: 2px 6px;
            border-radius: 50%;
            min-width: 16px;
            height: 16px;
            display: flex;
            justify-content: center;
            align-items: center;
        ">3</span>
    </div>

    <!-- Wrap the Shopping Cart Icon Inside the <a> Tag -->
    <a href="{{ route('get_cart') }}" style="text-decoration: none; color: inherit;">
        <div style="position: relative; width: 26px; height: 20px; text-align: center;">
            <i class="fa-solid fa-shopping-cart" style="font-size: 25px;"></i>
            <span id="cart-count" style="
                position: absolute;
                top: -5px;
                right: -5px;
                background: red;
                color: white;
                font-size: 12px;
                font-weight: bold;
                padding: 2px 6px;
                border-radius: 50%;
                min-width: 16px;
                height: 16px;
                display: flex;
                justify-content: center;
                align-items: center;
            ">{{cart_counter()}}</span>
        </div>
    </a>
</div>
