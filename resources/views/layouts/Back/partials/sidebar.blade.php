<nav id="sidebar" class="sidebar-wrapper">

    <!-- Sidebar brand start  -->
    <div class="sidebar-brand">
        <a href="{{ route('dashboard_index') }}" class="logo bg-white" >
            <img style="width: 210px" src="{{ asset('/assets/banner.png') }}" alt="" title="">
        </a>
    </div>
    <!-- Sidebar brand end  -->
    
    <!-- Sidebar content start -->
    <div class="sidebar-content" style="overflow: hidden scroll">
        <!-- sidebar menu start -->
        <div class="sidebar-menu">
            <ul>
                <li>
                    <a href="{{ url('/') }}">
                        <i class="icon-fa-shopping-cart">🛒 </i>
                        <span class="menu-text">Visit Front / Buy Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('dashboard_index') }}">
                        <i class="icon-home2"></i>
                        <span class="menu-text">Dashboard</span>
                    </a>
                </li>
            @if (permission_checker($gsd->role_info,'user_manage') == 1)
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-users"></i>
                        <span class="menu-text">Users</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('Users')}}">All User</a>
                            </li>
                            <li>
                                <a href="{{ route('Active_User')}}">Active user</a>
                            </li>
                            <li>
                                <a href="{{ route('locked_Users')}}">Locked User</a>
                            </li>
                            <li>
                                <a href="{{ route('Band_User')}}">Banned user</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
            @endif
           
               {{-- @if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'dealer_manage') == 1)
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-credit-card"></i>
                        <span class="menu-text">Dealer Manage</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                          
                            <li>
                                <a href="{{ route('dealers') }}">List</a>
                            </li>
                            
                            <li>
                                <a href="{{ route('add_dealer') }}">Add dealer</a>
                            </li>	
                           									
                        </ul>
                    </div>
                </li>
                @endif	  --}}
            
            
            @if (permission_checker($gsd->role_info,'user_manage') == 1)
            {{-- <li class="sidebar-dropdown">
                <a href="#">
                    <i class="icon-users"></i>
                    <span class="menu-text">Non-Working Board Placement</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li>
                            <a href="{{ route('Approve_accounts')}}">Approved account</a>
                        </li>
                        <li>
                            <a href="{{ route('Pending_accounts')}}">Pending new account</a>
                        </li>
                       
                    </ul>
                </div>
            </li> --}}
         
        @endif
           <li class="sidebar-dropdown">
                <a href="#">
                    {{-- <i class="icon-users"></i> --}}
                    <i class="icon-" style="font-weight: bold">&#x1F4B0;</i>
                    <span class="menu-text">For Request</span>
                </a>
                <div class="sidebar-submenu">
                    <ul>
                        <li>
                            <a href="{{ route('Deposit_form') }}">
                                {{-- <i class="icon-call_made"></i> --}}
                                <span class="menu-text"> Balance request</span>
                               
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('Withdraw_form') }}">
                                {{-- <i class="icon-call_made"></i> --}}
                                <span class="menu-text"> Withdraw request</span>
                               
                            </a>
                        </li>   
                        <li>
                            <a href="{{ route('Withdraw_pension_form') }}">
                                {{-- <i class="icon-call_made"></i> --}}
                                <span class="menu-text"> Pension request</span>
                               
                            </a>
                        </li>   
                       
                    </ul>
                </div>
            </li>
            {{-- @if (auth()->user()->id != 1)
            <li>
                <a href="{{ route('Deposit_form') }}">
                    <i class="icon-call_made"></i>
                    <span class="menu-text"> Balance request</span>
                   
                </a>
            </li>
            @if ($gsd->lock_status == 0)
            <li>
                <a href="{{ route('Withdraw_form') }}">
                    <i class="icon-call_made"></i>
                    <span class="menu-text"> Withdraw request</span>
                   
                </a>
            </li>   
            @endif
            @endif --}}
              
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-">&#127974;</i>
                       
                        <span class="menu-text">Deposit History</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('deposit_approved') }}">Approved deposit</a>
                            </li>
                            <li>
                                <a href="{{ route('deposit_pending') }}">Pending deposit</a>
                            </li>
                            <li>
                                <a href="{{ route('deposit_canceled') }}">Cancel deposit</a>
                            </li>

                        </ul>
                    </div>
                </li>
              
                
               
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-">&#128184;</i>
                        <span class="menu-text">Withdraw History</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('withdraw_approved') }}">
                                    Approved withdraw</a>
                            </li>										
                            <li>
                                <a href="{{ route('withdraw_pending') }}">Pending withdraw</a>
                            </li>
                            <li>
                                <a href="{{ route('withdraw_canceled') }}">Cancel withdraw</a>
                            </li>
                        </ul>
                    </div>
                </li>	
          
           
               
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-magnet"></i>
                        <span class="menu-text">My Orders Details</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('product_orders')}}">
                                    {{-- <i class="icon-circular-graph"></i> --}}
                                    <span class="menu-text">Product</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('package_orders')}}">
                                    {{-- <i class="icon-circular-graph"></i> --}}
                                    <span class="menu-text">Package</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('auto_active_non_working_user')}}">
                                    {{-- <i class="icon-circular-graph"></i> --}}
                                    <span class="menu-text">Auto Activated</span>
                                </a>
                            </li>

                           
                        </ul>
                    </div>
                </li>
                @if (dealer_check() == 1 || auth()->user()->id == 1)

                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-magnet"></i>
                        <span class="menu-text">My Dealer Order Details</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('product_owner_stock_list')}}">
                                    {{-- <i class="icon-circular-graph"></i> --}}
                                    <span class="menu-text">My Products</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('product_stock_transfer_list')}}">
                                    {{-- <i class="icon-circular-graph"></i> --}}
                                    <span class="menu-text">Stock Transfer History</span>
                                </a>
                            </li> 
                            <li>
                                <a href="{{ route('product_dealer_order_history')}}">
                                    {{-- <i class="icon-circular-graph"></i> --}}
                                    <span class="menu-text">Dealer Order History</span>
                                </a>
                            </li> 
                            @if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'dealer_manage') == 1)
                            <li>
                                <a href="{{ route('dealers') }}">Dealer Manage</a>
                            </li>
                            @endif
                        </ul>
                    </div>
                </li>

                @endif

                {{-- @if (auth()->user()->id == 1) --}}
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-users"></i>
                        <span class="menu-text">My Networks</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                        

                            <li>
                                <a href="{{ route('user_unilevel_tree',['id'=> $gsd->username])}}">
                                    {{-- <i class="icon-pets"></i> --}}
                                    <span class="menu-text">Working Team</span>
                                </a>
                            </li>
                              <li>
                                <a href="{{ route('my_sponsors',['id'=> $gsd->username])}}">
                                    {{-- <i class="icon-pets"></i> --}}
                                    <span class="menu-text">Sponsors Team</span>
                                </a>
                            </li>
                            
                            
                            <li>
                                <a href="{{ route('user_tree',['id'=> $gsd->username])}}">
                                    {{-- <i class="icon-pets"></i> --}}
                                    <span class="menu-text">Non Working Team</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('my_refer')}}">
                                    {{-- <i class="icon-circular-graph"></i> --}}
                                    <span class="menu-text">My Affiliates</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                {{-- @endif --}}
              


              
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-credit-card"></i>
                        <span class="menu-text">Transfer And Records</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
               
                <li>
                    <a href="{{ route('balance_transfer_records')}}">
                        {{-- <i class="icon-circular-graph"></i> --}}
                        <span class="menu-text">Transfer Records</span>
                    </a>
                </li>

                @if (auth()->user()->id == 1)
                   
                <li>
                    <a href="{{ route('balance_add_option')}}">
                        {{-- <i class="icon-circular-graph"></i> --}}
                        <span class="menu-text">Balance Add</span>
                    </a>
                </li>
            @endif
            
            @if (auth()->user()->id != 1 && $gsd->lock_status == 0)
            <li>
                <a href="{{ route('balance_transfer_option')}}">
                    {{-- <i class="icon-circular-graph"></i> --}}
                    <span class="menu-text">Balance Transfer</span>
                </a>
            </li>
            
            @endif

                </ul>
                    </div>
                </li>
                
    
                
                @if (auth()->user()->id == 1 ||  permission_checker($gsd->role_info,'page_manage') == 1)
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-credit-card"></i>
                        <span class="menu-text">Page|News|FAQ|Notice </span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                          
                            <li>
                                <a href="{{ route('page_list') }}">Page Manage</a>
                            </li>
                            
                            {{-- <li>
                                <a href="{{ route('add_page') }}">Add new page</a>
                            </li>	 --}}
                           					
                            {{-- @if (auth()->user()->id == 1) --}}
                   
                            <li>
                                <a href="{{ route('faqs')}}">
                                    {{-- <i class="icon-circular-graph"></i> --}}
                                    <span class="menu-text">Faqs Manage</span>
                                </a>
                            </li>
                        {{-- @endif --}}
                        <li>
                            <a href="{{ route('news') }}">News Manage</a>
                        </li>

                        <li>
                            <a href="{{ route('notice_board') }}">Notice Board</a>
                        </li>

                        </ul>
                    </div>
                </li>
                @endif	
              
                
                
                @if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'product_manage') == 1)
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-credit-card"></i>
                        <span class="menu-text">Products</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('product_list')}}">
                                    <i class="icon-circular-graph"></i>
                                    <span class="menu-text">Manage</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('product_category_list')}}">
                                    <i class="icon-circular-graph"></i>
                                    <span class="menu-text">Category</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('product_brand_list')}}">
                                    <i class="icon-circular-graph"></i>
                                    <span class="menu-text">Brand</span>
                                </a>
                            </li>	
                            
           
                              <li>
                                <a href="{{ route('product_stock_histories')}}">
                                    <i class="icon-circular-graph"></i>
                                    <span class="menu-text">Stock</span>
                                </a>
                            </li>
                            
                            
                        </ul>
                    </div>
                </li>
                @endif
                
                
                                 
               
                
                
                
                @if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'product_manage') == 1)
                <li>
                    <a href="{{ route('package_list')}}">
                        <i class="icon-circular-graph"></i>
                        <span class="menu-text">Package Manage</span>
                    </a>
                </li>
                @endif

                {{-- <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-magnet"></i>
                        <span class="menu-text">Purchase / Buy</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('public_products')}}">
                                    <i class="icon-circular-graph"></i>
                                    <span class="menu-text">Product</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('public_packages')}}">
                                    <i class="icon-circular-graph"></i>
                                    <span class="menu-text">Package</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
                @if (auth()->user()->id != 1 || permission_checker($gsd->role_info,'submit_pv_off') != 1)
                <li>
                    <a href="{{ route('point_submit_form')}}">
                        {{-- <i class="icon-circular-graph">&#127942;</i> --}}
                        <i class="icon-">&#127942;</i>
                        <span class="menu-text"> Submit Points</span>
                    </a>
                </li> 
                @endif
                
                 {{-- <li>
                    <a href="{{ route('my_down_line')}}">
                        <i class="icon-circular-graph"></i>
                        <span class="menu-text">My Down line</span>
                    </a>
                </li> --}}
                
                
                @if (permission_checker($gsd->role_info,'role_manage') == 1)
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-magnet"></i>
                        <span class="menu-text">Permission</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('roles')}}">Role List</a>
                            </li>
                            <li>
                                <a href="{{ route('staff_members')}}">Staff List</a>
                            </li>									
                           
                        </ul>
                    </div>
                </li>
                @endif
                @if (permission_checker($gsd->role_info,'pay_account_manage') == 1)
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-credit-card"></i>
                        <span class="menu-text">Gateway</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            @if (permission_checker($gsd->role_info,'gateway_manage') == 1)
                            <li>
                                <a href="{{ route('gateways') }}">Add Gateway</a>
                            </li>
                            @endif
                            @if (permission_checker($gsd->role_info,'pay_account_manage') == 1)
                            <li>
                                <a href="{{ route('pay_accounts') }}">Add pay Account</a>
                            </li>	
                            @endif										
                        </ul>
                    </div>
                </li>
                @endif	
                {{-- @if (permission_checker($gsd->role_info,'news_feed') == 1)
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-edit1"></i>
                        <span class="menu-text">News Feeds</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            
                            <li>
                                <a href="{{ route('add_news') }}">Add New</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif --}}

                <li>
                    <a href="{{ route('Transaction_list',['remark'=>'refer_bonus']) }}">
                        {{-- <i class="icon-circular-graph"></i> --}}
                        <i class="icon">&#128221;</i>
                        <span class="menu-text">My Reports</span>
                    </a>
                </li>

                {{-- <li class="sidebar-dropdown">
                    <a href="{{ route('Transaction_list',['remark'=>'refer_bonus']) }}">
                        <i class="icon-edit1"></i>
                        <span class="menu-text">My Reports</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            <li>
                                <a href="{{ route('Transaction_list',['remark'=>'refer_bonus']) }}">Transactions</a>
                            </li>
                        </ul>
                    </div>
                </li> --}}
       
                @if (permission_checker($gsd->role_info,'settings') == 1 || auth()->user()->id == 1)
                <li class="sidebar-dropdown">
                    <a href="#">
                        <i class="icon-globe1"></i>
                        <span class="menu-text">Settings</span>
                    </a>
                    <div class="sidebar-submenu">
                        <ul>
                            
                                <li>
                                <a href="{{ route('sliders') }}">Sliders</a>
                            </li>     
                            
                            <li>
                                <a href="{{ route('high_light_products') }}">High light Products</a>
                            </li>
                          <li>
                                <a href="{{ route('logo_Index') }}">Logo Setting</a>
                            </li>
                            <li>
                                <a href="{{ route('web_config') }}">Web Config</a>
                            </li>
                            <li>
                                <a href="{{ route('bonus_sender_form') }}">Bonus Sender</a>
                            </li>
                            <li>
                                <a href="{{ route('auto_pv_collector',['point'=>400,'point_type'=>'Normal']) }}">Auto Pv Collector</a>
                            </li>
                            
                            <li>
                                <a href="{{ route('customer_rank_conds')}}">Customer Rank Condition</a>
                            </li>   
                            <li>
                                <a href="{{ route('gen_rank_conds')}}">Gen Rank Condition</a>
                            </li>   
                            <li>
                                <a href="{{ route('working_gen_conditions')}}">Working Gen Condition</a>
                            </li>    
                               <li>
                                <a href="{{ route('sponsor_gen_conditions')}}">Sponsor Gen Condition</a>
                            </li>  
                            
                            
                            <li>
                                <a href="{{ route('non_working_gen_conditions')}}">Non working Gen Condition</a>
                            </li>
                            <li>
                                <a href="{{ route('non_working_matrix_bonus_conditions')}}">Non working matrix Conditions</a>
                            </li>
                  
                            <li>
                                <a href="{{ route('direct_bonus_conditions')}}">Direct Bonus Conditions</a>
                            </li>
                            <li>
                                <a href="{{ route('withdraw_setting') }}">Withdraw Setting</a>
                            </li>
                
                         
                            
                            <li>
                                <a href="{{ route('sms_sender_option') }}">Sms Sender Option</a>
                            </li>

                            <li>
                                <a href="{{ route('account_unique_key_manage') }}">Unique Manage With Username</a>
                            </li>
                            
                        </ul>
                    </div>
                </li>
             
                  <li>
                    <a href="{{ route('notification-temps.index')}}">
                        <i class="fas fa-bell"></i>
                        <span class="menu-text">Notification Template</span>
                    </a>
                </li>
                @endif
            </ul>
            <br>
            <br>
            <br>
            <br>
            <br>
        </div>
        <!-- sidebar menu end -->

    </div>
    <!-- Sidebar content end -->
    
</nav>