<?php
use App\Models\User;
use App\Models\DirectBonusCondition;
use App\Models\WorkingGenCondition;
use App\Models\UserExtra;
use App\Models\MatrixLevel;

use App\Http\Controllers\Backend\AddToCartController;
use App\Http\Controllers\Backend\ClubController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\DepositController;
use App\Http\Controllers\Backend\GatewayController;
use App\Http\Controllers\Backend\HighlightProductController;
use App\Http\Controllers\Backend\NoticeBoardController;
use App\Http\Controllers\Backend\OrderController;
use App\Http\Controllers\Backend\PackageController;
use App\Http\Controllers\Backend\PaymentAccountController;
use App\Http\Controllers\Backend\permissionController;
use App\Http\Controllers\Backend\ProductBrandController;
use App\Http\Controllers\Backend\ProductCategoryController;
use App\Http\Controllers\Backend\PurchaseController;
use App\Http\Controllers\Backend\PurchaseGalleryController;
use App\Http\Controllers\Backend\RankConditionController;
use App\Http\Controllers\Backend\ReserveManageController;
use App\Http\Controllers\Backend\SettingsController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\BalanceTransferController;
use App\Http\Controllers\Backend\DealerController;
use App\Http\Controllers\Backend\Stock\ProductStockController;
use App\Http\Controllers\Backend\ShowRoomSellController;
use App\Http\Controllers\ContentFilemanager;
use App\Http\Controllers\CronController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\Frontend\AddToWishlistController;
use App\Http\Controllers\Frontend\ProductDetailController;
use App\Http\Controllers\LogoController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QueueController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SiteController;
use App\Http\Controllers\Backend\LocationManageController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\WithdrawController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Route::controller(ProductDetailController::class)->group(function () {
  
    Route::get('/product-details/{slug}', 'singleProduct')->name('frontend.product_details');
    Route::get('/package-details/{slug}', 'singlePackage')->name('frontend.package_details');

    Route::get('/brand/{slug}', 'Brand_product')->name('frontend.Brand_product');
    Route::get('/category/{slug}', 'Category_product')->name('frontend.Category_product');
});


Route::controller(MediaController::class)->group(function () {
  
    Route::get('/media-list', 'index')->name('media_list');
    Route::post('//media-store', 'store')->name('media_store');
    Route::get('/media-remove/{id}', 'remove')->name('media_remove');
   
});

Route::controller(ProductCategoryController::class)->group(function () {
    Route::get('/product-category-list', 'Index')->name('product_category_list');
    Route::get('/product-category-create', 'Create')->name('product_category_create');
    Route::post('/product-category-store', 'Store')->name('product_category_store');
    Route::get('/product-category-edit/{id}', 'Edit')->name('product_category_edit');
    Route::post('/product-category-update', 'Update')->name('product_category_update');
    Route::get('/product-category-remove/{id}', 'Remove')->name('product_category_remove');
  
});


Route::controller(ProductController::class)->group(function () {
    Route::get('/product-list', 'Index')->name('product_list');
    Route::get('/product-create', 'Create')->name('product_create');
    Route::post('/product-store', 'Store')->name('product_store');
    Route::get('/product-edit/{id}', 'Edit')->name('product_edit');
    Route::post('/product-update', 'Update')->name('product_update');
    Route::get('/product-remove/{id}', 'Remove')->name('product__remove');
    Route::post('/product-name-get', 'product_name_get')->name('product_name_get');
        Route::post('/product-query', 'query')->name('product__query');
          Route::post('/product-query-with-owner', 'query_with_owner')->name('product__query_with_owner');
});



Route::controller(ProductBrandController::class)->group(function () {
    Route::get('/product-brand-list', 'Index')->name('product_brand_list');
    Route::get('/product-brand-create', 'Create')->name('product_brand_create');
    Route::post('/product-brand-store', 'Store')->name('product_brand_store');
    Route::get('/product-brand-edit/{id}', 'Edit')->name('product_brand_edit');
    Route::post('/product-brand-update', 'Update')->name('product_brand_update');
    Route::get('/product-brand-remove/{id}', 'Remove')->name('product_brand_remove');
  
});

Route::controller(PackageController::class)->group(function () {
    Route::get('/package-list', 'Index')->name('package_list');
    Route::get('/package-create', 'Create')->name('package_create');
    Route::post('/package-store', 'Store')->name('package_store');
    Route::get('/package-edit/{id}', 'Edit')->name('package_edit');
    Route::post('/package-update', 'Update')->name('package_update');
    Route::get('/package-remove/{id}', 'Remove')->name('package_remove');
    
});


Route::controller(CronController::class)->group(function () {
    Route::get('/rank_updater', 'RankUpdate')->name('RankUpdate');
    Route::get('/roi_send', 'RoiSend')->name('roi_send');
    Route::get('/user-group-matching', 'matching')->name('matching');
    Route::get('/fchecker', 'fchecker')->name('fchecker');
    Route::get('/cap_check', 'cap_check')->name('cap_check');
    Route::get('/boot_register', 'boot_registerr')->name('boot_register');
    
    Route::get('/gen_debug', 'gen_debug')->name('gen_debug');
    
    Route::get('/team-point-check/{username}', 'team_point_check')->name('team_point_check');
    Route::get('/customer-rank-update', 'customer_rank_update')->name('customer_rank_update');
    Route::get('/leader-rank-update', 'leader_rank_update')->name('leader_rank_update');
    
    Route::get('/unilevel-generation-check/{username}', 'unilevel_generation_check')->name('unilevel_generation_check');
    
    
    
    
    
    
    Route::get('/autom', 'autom')->name('autom');
    Route::get('/tree_level', 'tree_level')->name('tree_level');
    Route::post('/sms-send-before-review', 'sms_send_before_review')->name('sms_send_before_review');
    Route::post('/finally-sms-send', 'finally_sms_send')->name('finally_sms_send');
    
     Route::get('/msg-helper', 'msgCaller');
    
  
});

Route::controller(SiteController::class)->group(function () {
    Route::get('/', 'Index')->name('public_index');
    Route::get('/products', 'Product_list')->name('public_products');
    Route::get('/packages', 'Package_list')->name('public_packages');
    Route::get('/brands', 'Brand_list')->name('public_brands');
    Route::get('/categories', 'Category_list')->name('public_categories');
    Route::get('/page/{slug}', 'get_page')->name('get_page');
    Route::get('/company-faqs', 'get_faqs')->name('get_faqs');
    Route::post('/realtime-product-name-suggest', 'realtime_p_name_sg')->name('realtime_p_name_sg');
    Route::post('/product_check_and_display_m', 'product_check_and_display_m')->name('product_check_and_display_m');
    Route::post('/product_check_and_display', 'product_check_and_display')->name('product_check_and_display');
    Route::get('/testimonials', 'testimonials')->name('testimonials');

    Route::get('/terms-conditions', 'terms')->name('terms');
    Route::get('/privacy-policy', 'privacy_policy')->name('privacy_policy');
    Route::get('/contact-us', 'contact_us')->name('contact_us');
    Route::get('/about-us', 'about_us')->name('about_us');
    Route::get('/course-list', 'course_list')->name('course_list');
    Route::get('/team-list', 'team_list')->name('team_list');
    Route::get('/team-details', 'team_details')->name('team_details');
    Route::get('/course-details', 'course_details')->name('course_details');
    Route::post('/contact-request', 'contact_requestex')->name('contact_requestex');
    Route::post('/check/referral', 'CheckUsername')->name('check.referral');
   
});


// Dashboard controller

Route::middleware('auth')->group(function () {
    
       Route::controller(LocationManageController::class)->group(function () {
          Route::get('/locations', 'index')->name('locations');
            Route::post('/location-query-get-district', 'location_query_get_district')->name('location_query_get_district');
            Route::post('/location-query', 'location_query')->name('location_query');
            Route::get('/location-create', 'create')->name('location_create');
            Route::post('/location-store', 'store')->name('location_store');
            Route::get('/location-edit/{id}', 'edit')->name('location_edit');
            Route::patch('/location-update', 'update')->name('location_update');
            Route::delete('/location-remove', 'remove')->name('location_remove');
       
    }); 
    
        Route::controller(ProductStockController::class)->group(function () {
  
        Route::get('/product-owner-stock-list','owner_stock_list')->name('product_owner_stock_list');
        Route::get('/product-stock-histories','index')->name('product_stock_histories');
        Route::get('/product-stock-option','stocker')->name('product_stock_option');
        Route::post('/product-stock-store','stock_store')->name('product_stock_store');

        Route::get('/product-stock-transfers','stock_transfer_list')->name('product_stock_transfer_list');
        Route::get('/product-stock-transfer-option','stock_transfer_options')->name('product_stock_transfer_options');
        Route::post('/product-stock-transfer-store','stock_transfer_store')->name('product_stock_transfer_store');
        Route::post('/product-stock-transfer-status','stock_transfer_status')->name('product_stock_transfer_status');
        Route::post('/dealer-stock-product','dealer_stock_product')->name('dealer_stock_product');
        Route::post('/check_product_owner_raltime','check_product_owner_raltime')->name('check_product_owner_raltime');


    }); 
    
       Route::controller(DealerController::class)->group(function () {
      
        Route::get('/dealers', 'index')->name('dealers'); 
        Route::get('/add-dealer', 'create')->name('add_dealer'); 
        Route::post('/store-dealer', 'store')->name('store_dealer'); 
        Route::get('/edit-dealer/{id}', 'edit')->name('edit_dealer'); 
        Route::post('/update-dealer', 'update')->name('update_dealer'); 
        Route::post('/dealer-select-for-buying', 'dealer_select_for_buying')->name('dealer_select_for_buying'); 
       
    });
    
    
    
    
    Route::controller(LogoController::class)->group(function(){
    Route::get('/get-logo', 'Index')->name('logo_Index');
    Route::post('/logo-update', 'Update')->name('logo_Update');
    
});

  Route::controller(ShowRoomSellController::class)->group(function(){
    Route::get('/create-sell', 'create_sell')->name('create_sell');
    Route::post('/sell-make', 'sell_make')->name('sell_make');
    
});

    Route::controller(FaqController::class)->group(function () {
        Route::get('/faqs', 'index')->name('faqs'); 
        Route::get('/add-new-faq', 'create')->name('add_new_faq'); 
        Route::post('/store-faq', 'store')->name('store_faq'); 
        Route::get('/edit-faq/{id}', 'edit')->name('edit_faq'); 
        Route::post('/update-faq', 'update')->name('update_faq'); 
        Route::get('/remove-faq/{id}', 'remove')->name('remove_faq'); 
        
    });
     
Route::controller(PageController::class)->group(function () {

    Route::get('/pages', 'page_list')->name('page_list');
  
    Route::get('/add-page', 'add_page')->name('add_page');
    Route::post('/store-page', 'store_page')->name('store_page');
    Route::get('/edit-page/{id}', 'edit_page')->name('edit_page');
    Route::post('/update-page', 'update_page')->name('update_page');
    Route::get('/remove-page/{id}', 'remove_page')->name('remove_page');
 
 });

    Route::controller(SliderController::class)->group(function () {
  
        Route::get('/all-slider', 'index')->name('sliders');
        Route::get('/slider/{slug}', 'index')->name('single_slider');
        Route::get('/add-slider', 'create')->name('add_new_slider');
        Route::post('/store-slider', 'store')->name('store_slider');
        Route::get('/edit-slider/{id}', 'edit')->name('edit_slider');
        Route::post('/update-slider', 'update')->name('update_slider');
        Route::get('/remove-slider', 'remove')->name('remove_slider');
    }); 

    Route::controller(NewsController::class)->group(function () {
  
        Route::get('/all-news', 'index')->name('news');
        Route::get('/news/{slug}', 'index')->name('single_news');
        Route::get('/add-news', 'add')->name('add_news');
        Route::post('/store-news', 'store')->name('store_news');
        Route::get('/edit-news/{id}', 'edit')->name('edit_news');
        Route::post('/update-news', 'update')->name('update_news');
        Route::get('/remove-news', 'remove')->name('remove_news');
    }); 

    Route::controller(AddToCartController::class)->group(function () {
  
        Route::get('/get_cart', 'getCart')->name('get_cart');
        Route::post('/add_to_cart', 'AddCart')->name('add_cart');
        Route::post('/cart_update', 'CartUpdate')->name('cart_update');
        Route::post('/remove_to_cart', 'RemoveCart')->name('remove_cart');
        Route::get('/checkout', 'CartCheckOut')->name('checkout');
        Route::post('/checkout_confirm', 'CartCheckOutConfirm')->name('checkout_confirm');
    }); 
    
    Route::controller(AddToWishlistController::class)->group(function () {
  
        Route::get('/get_wishlist', 'getWishlist')->name('get_wishlist');
        Route::post('/add_to_wishlist', 'AddWishlist')->name('add_wishlist');
        Route::post('/remove_to_wishlist', 'RemoveWishlist')->name('remove_wishlist');
    });    
    
    Route::controller(NoticeBoardController::class)->group(function () {
  
        Route::get('/notice-board', 'index')->name('notice_board');
        Route::post('/notice-update', 'update')->name('notice_update');
        
        Route::get('/sms-sender-option', 'sms_sender_option')->name('sms_sender_option');
        Route::get('/sms-sending-records', 'sms_sending_records')->name('sms_sending_records');
        Route::post('/sms-sending-action', 'sms_sending_action')->name('sms_sending_action');
        
    
    });

    Route::controller(PurchaseController::class)->group(function () {
        Route::get('/package-order/{slug}', 'packageOrder')->name('package_order');
        Route::get('/product-order/{slug}', 'productOrder')->name('product_order');
        Route::post('/product-order-confirm', 'productConfirmOrder')->name('product_order_confirm');
        Route::post('/package-order-confirm', 'packageConfirmOrder')->name('package_order_confirm');
        Route::post('/product-order-reconfirm', 'productConfirmReOrder')->name('product_order_reconfirm');
        Route::post('/product-order-confirm-edit', 'productConfirmOrderEdit')->name('product_order_confirm_edit');
      
    });  

    Route::controller(RankConditionController::class)->group(function () {

        Route::get('/gen-rank-conditions', 'gen_rank_conds')->name('gen_rank_conds');
        Route::get('/gen-rank-condition-create', 'gen_rank_cond_create')->name('gen_rank_cond_create');
        Route::post('/gen-rank-condition-store', 'gen_rank_cond_store')->name('gen_rank_cond_store');
        Route::get('/gen-rank-condition-remove/{id}', 'gen_rank_cond_remove')->name('gen_rank_cond_remove');
        Route::get('/gen-rank-condition-edit/{id}', 'gen_rank_cond_edit')->name('gen_rank_cond_edit');
        Route::post('/gen-rank-condition-update', 'gen_rank_cond_update')->name('gen_rank_cond_update');


        Route::get('/customer-rank-conditions', 'customer_rank_conds')->name('customer_rank_conds');
        Route::get('/customer-rank-condition-create', 'customer_rank_cond_create')->name('customer_rank_cond_create');
        Route::post('/customer-rank-condition-store', 'customer_rank_cond_store')->name('customer_rank_cond_store');
        Route::get('/customer-rank-condition-remove/{id}', 'customer_rank_cond_remove')->name('customer_rank_cond_remove');
   
    }); 



    Route::controller(ReserveManageController::class)->group(function () {
        Route::get('/reserve-fund-balance', 'Index')->name('reserve_fund_balance');
        Route::post('/reserve-fund-update', 'update')->name('reserve_fund_update');
       
    }); 
    
    
    Route::controller(OrderController::class)->group(function () {
        Route::get('/package-orders', 'packageOrders')->name('package_orders');
        Route::get('/package-order-details/{id}', 'packageOrderDetails')->name('package_order_details');
        Route::get('/package-order-invoice/{id}', 'generate_package_invoice')->name('generate_package_invoice');
        Route::post('/package-order-status-change', 'package_order_status_change')->name('package_order_status_change');
        Route::post('/package-order-payment-status-change', 'package_order_payment_status_change')->name('package_order_payment_status_change');
        Route::post('/package-order-shipping_cost-change', 'package_order_shipping_cost_change')->name('package_order_shipping_cost_change');

        Route::get('/product-orders', 'productOrders')->name('product_orders');
        Route::get('/product-order-details/{id}', 'productOrderDetails')->name('product_order_details');
        Route::get('/product-order-invoice/{id}', 'generate_product_invoice')->name('generate_product_invoice');
         Route::get('/product-order-invoice-download/{id}', 'generate_product_invoice_download')->name('generate_product_invoice_download');
        Route::post('/product-order-status-change', 'product_order_status_change')->name('product_order_status_change');
        Route::post('/product-order-payment-status-change', 'product_order_payment_status_change')->name('product_order_payment_status_change');
        Route::post('/product-order-shipping_cost-change', 'product_order_shipping_cost_change')->name('product_order_shipping_cost_change');
    });
    
    Route::controller(PurchaseGalleryController::class)->group(function () {
  
        Route::get('/purchase-gallery/{type}', 'index')->name('purchase_gallery');
    });

    Route::controller(ContentFilemanager::class)->group(function () {
        Route::get('/filemanager_browse', 'Index')->name('filemanager_browse');
        Route::get('/filemanager_file_browse', 'file_browse')->name('file_browse');
        Route::get('/filemanager_file_upload', 'file_upload')->name('file_upload');
        Route::get('/filemanager_browse_selector', 'Selector')->name('file_Selector');
        Route::post('/filemanager/upload','Upload')->name('filemanager_upload');
    });
    
    Route::controller(HighlightProductController::class)->group(function () {
        Route::get('/high-light-products', 'index')->name('high_light_products');
        Route::get('/high-light-product-add', 'create')->name('high_light_product_add');
    
        Route::post('/high-light-product-store', 'store')->name('high_light_product_store');
        Route::get('/high-light-product-remove/{id}', 'remove')->name('high_light_product_remove');
      
    });

    Route::controller(DashboardController::class)->group(function () {
        Route::get('/my-sponsors', 'my_sponsors')->name('my_sponsors');
        Route::get('/fetch_total_team_point_by_sponsors/{id}', 'fetch_total_team_point_by_sponsors')->name('fetch_total_team_point_by_sponsors');
        Route::post('/my-sponsors-jump', 'my_sponsors_jump')->name('my_sponsors_jump');
        Route::get('/dashboard', 'Index')->name('dashboard_index');
         Route::get('/account-active-form', 'account_active_form')->name('account_active_form');
        Route::get('/account-unique-key-manage', 'unique_key_manage')->name('account_unique_key_manage');
        Route::get('/account-balance-trans-manage', 'account_balance_trans_manage')->name('account_balance_trans_manage');
        Route::post('/account-balance-transfer-action', 'account_balance_transfer_action')->name('account_balance_transfer_action');
        Route::post('/account-unique-key-update', 'unique_key_update')->name('account_unique_key_update');
        Route::post('/account_switcher', 'account_switcher')->name('account_switcher');
        Route::post('/account-balance-withdraw-action', 'account_balance_withdraw_action')->name('account_balance_withdraw_action');
        
        Route::get('/point-submit-form', 'point_submit_form')->name('point_submit_form');

        Route::post('/point-submit-for-account-active', 'point_submit_for_account_active')->name('point_submit_for_account_active');
        Route::post('/account-active', 'account_active_action')->name('account_active_action');
        Route::get('/bulk-bonus-sender', 'bonus_bulk_sender')->name('bonus_bulk_sender');
    });

    Route::controller(ProfileController::class)->group(function () {
        Route::get('/profile', 'edit')->name('profile.edit');
        Route::patch('/profile','update')->name('profile.update');
        Route::delete('/profile', 'destroy')->name('profile.destroy');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/my-refer', 'my_refer')->name('my_refer');
        Route::get('/user-matrix-tree/{id}', 'user_tree')->name('user_tree');
        Route::get('/user-unilevel-gen-tree/{id}', 'user_unilevel_gen_tree')->name('user_unilevel_gen_tree');
        Route::get('/user-unilevel-tree/{id}', 'user_unilevel_tree')->name('user_unilevel_tree');
        Route::get('/user-unilevel-tree/{id}', 'user_unilevel_tree')->name('user_unilevel_tree');
        Route::get('/fetch-total-team-point/{id}', 'fetch_total_team_point')->name('fetch_total_team_point');
         
        Route::post('user-unilevel-tree-jump', 'user_unilevel_tree_jump')->name('user_unilevel_tree_jump');
        Route::post('/user-tree-jump', 'user_tree_jump')->name('user_tree_jump');
         Route::get('/my-down-line', 'my_down_line')->name('my_down_line');
         Route::Post('/my-down-line-reset', 'my_down_line_reset')->name('my_down_line_reset');
         
        Route::post('/user-ban', 'User_ban')->name('User_ban');
        Route::post('/user-active', 'User_active')->name('User_active');

        Route::post('/user-unlock', 'User_unlock')->name('User_unlock');
        Route::post('/user-lock', 'User_lock')->name('User_lock');



        Route::get('/users', 'Users')->name('Users');
        Route::get('/approve-accounts', 'Approve_acounts')->name('Approve_accounts');
        Route::get('/pending-accounts', 'Pending_acounts')->name('Pending_accounts');
        Route::get('/account-approve-option', 'account_approve_option')->name('account_approve_option');


        Route::post('/placement-user-check','placement_user_check')->name('placement_user__check');
        Route::post('/placement-join-check','placement_join_check')->name('placement_join_check');

        Route::post('/account-approve-action','account_approve_action')->name('account_approve_action');
         Route::get('/user-detail/{username}', 'userdt')->name('userdt');
         Route::get('/user-account-full-edit', 'FullEditor')->name('FullEditor');
         Route::post('/user-account-full-update', 'FullUpdate')->name('FullUpdater');

         Route::get('/user-account-trx-password-setup/{username}', 'trx_pin_option')->name('trx_pin_option');
         Route::post('/user-account-trx-password-setup', 'trx_pin_action')->name('trx_pin_action');
         Route::post('/user-check', 'user__check')->name('user__check');

         Route::post('/last-user-tree', 'last_user_tree')->name('last_user_tree');



        
        Route::get('/agents', 'agents')->name('agents');
        Route::get('/users-pending', 'Pending_User')->name('Pending_User');
          Route::get('/locked-users', 'locked_Users')->name('locked_Users');
        
        Route::get('/users-active', 'Active_User')->name('Active_User');
        Route::get('/users-band', 'Band_User')->name('Band_User');
        Route::get('/user-details/{username}', 'User_details')->name('user_details');
        Route::get('/user-account-setup/{username}', 'Account_setup')->name('user_account_setup');
        Route::get('/user-edit', 'User_edit')->name('User_edit');
        Route::post('/user-update', 'User_update')->name('User_update');
        Route::post('/user-profile-update', 'user_profile_update')->name('user_profile_update');
       
        Route::post('/search-user', 'searchUser')->name('search.user');
        Route::get('/agent-form', 'agentForm')->name('agentForm');
        Route::get('/agent-form-preview', 'Agent_deposit_preview')->name('agentFormPreview');
        Route::post('/agent-form-insert', 'Agent_deposit_insert')->name('agentFormInsert');
        Route::post('/agent-form-submit', 'Agent_deposit_submit')->name('agentFormSubmit');
        
        
        
        
    }); 
    
    Route::controller(WithdrawController::class)->group(function () {
        Route::get('/withdraw-form', 'Withdraw_form')->name('Withdraw_form');
        Route::post('/withdraw-insert', 'Withdraw_insert')->name('Withdraw_insert');
        Route::get('/withdraw-preview', 'Withdraw_preview')->name('Withdraw_preview');
        Route::post('/withdraw-form-submit', 'Withdraw_form_submit')->name('Withdraw_form_submit');
        Route::get('/withdraw-pending', 'Pending')->name('withdraw_pending');
        Route::get('/withdraw-approved', 'Approved')->name('withdraw_approved');
        Route::get('/withdraw-cancel', 'Canceled')->name('withdraw_canceled');
        Route::post('/withdraw-status-changer', 'Status_changer')->name('withdraw_status_changer');
       
       
    });


    Route::controller(DepositController::class)->group(function () {
       
        Route::get('/deposit-form', 'Deposit_form')->name('Deposit_form');
        Route::post('/deposit-insert', 'Deposit_insert')->name('Deposit_insert');
        Route::get('/deposit-preview', 'Deposit_preview')->name('Deposit_preview');
        Route::post('/deposit-form-submit', 'Deposit_form_submit')->name('Deposit_form_submit');
        Route::get('/deposit-pending', 'Pending')->name('deposit_pending');
        Route::get('/deposit-approved', 'Approved')->name('deposit_approved');
        Route::get('/deposit-cancel', 'Canceled')->name('deposit_canceled');
        Route::post('/deposit-status-changer', 'Status_changer')->name('deposit_status_changer');
     
    });

    Route::controller(ReportController::class)->group(function () {
        Route::get('/transactions', 'Transaction_list')->name('Transaction_list');
         Route::get('/balance-transfer-records', 'balance_transfer_records')->name('balance_transfer_records');
        Route::post('/transaction-report-sheet', 'Transaction_report_sheet')->name('Transaction_report_sheet');
    });

    Route::controller(permissionController::class)->group(function () {
        Route::get('/roles', 'roles')->name('roles');
        Route::get('/staff-members', 'staff_members')->name('staff_members');
        Route::get('/role-setup-form', 'role_setup_form')->name('role_setup_form');
        Route::post('/role-se', 'role_set')->name('role_set');
        Route::get('/role-create', 'role_creator')->name('role_creator');
        Route::post('/role-store', 'role_store')->name('role_store');
        Route::post('/role-update', 'role_update')->name('role_update');
        Route::get('/edit-role/{id}', 'role_edit')->name('role_edit');
        Route::get('/remove-role/{id}', 'remove_role')->name('remove_role');
    });



    Route::controller(GatewayController::class)->group(function () {
     
        Route::get('/gateways', 'gateways')->name('gateways'); 
        Route::get('/add-gateway', 'add_gateway')->name('add_gateway');
        Route::post('/gateway-store', 'gateway_store')->name('gateway_store');
        Route::post('/edit-gateway', 'edit_gateway')->name('edit_gateway');
        Route::post('/upadate-gateway', 'upadate_gateway')->name('upadate_gateway');
        Route::post('/remove-gateway', 'remove_gateway')->name('remove_gateway');

    }); 
    
    Route::controller(PaymentAccountController::class)->group(function () {
     
        Route::get('/pay-accounts', 'pay_accounts')->name('pay_accounts');
        Route::get('/add-account', 'add_account')->name('add_account');
        Route::post('/payaccount-store', 'payaccount_store')->name('payaccount_store');
        
        Route::post('/payaccount-edit_account', 'payaccount_edit_account')->name('payaccount_edit_account');
        Route::post('/payaccount-update-account', 'payaccount_update_account')->name('payaccount_update_account');
        Route::post('/payaccount-remove-account', 'payaccount_remove_account')->name('payaccount_remove_account');
        
        Route::get('/royality-sender-form', 'royality_sender_form')->name('royality_sender_form');
        Route::post('/royality-fund-sender-action', 'royality_fund_sender_action')->name('royality_fund_sender_action');

    }); 
    
    Route::controller(BalanceTransferController::class)->group(function () {
      
        Route::get('/balance-transfer-option', 'transfer_option')->name('balance_transfer_option'); 
        Route::get('/balance-add-option', 'add_option')->name('balance_add_option'); 
        Route::post('/balance-transfer-action', 'transfer_action')->name('balance_transfer_action'); 
        Route::post('/balance-add-action', 'add_action')->name('balance_add_action'); 
    });

        Route::controller(SettingsController::class)->group(function () {
        Route::get('/company-reserve-setting', 'company_reserve_setting')->name('company_reserve_setting'); 
        Route::post('/company-reserve-condition-create', 'company_reserve_condition_create')->name('company_reserve_condition_create'); 
        Route::post('/company-reserve-condition-update', 'company_reserve_condition_update')->name('company_reserve_condition_update'); 
        Route::get('/bonus-sender-form', 'bonus_sender_form')->name('bonus_sender_form'); 
        Route::get('/auto-pv-collector', 'auto_pv_collector')->name('auto_pv_collector'); 
        Route::post('/auto-pv-collection-action', 'auto_pv_collection_action')->name('auto_pv_collection_action'); 
        Route::get('/auto-pv-collection-bull-back-action', 'auto_pv_collection_bullk_back_action')->name('auto_pv_collection_bullk_back_action'); 
        Route::post('/auto-pv-collection-back-action', 'auto_pv_collection_back_action')->name('auto_pv_collection_back_action'); 
        Route::get('/withdraw-setting', 'withdraw_setting')->name('withdraw_setting'); 
        Route::post('/withdraw-setting-update', 'withdraw_setting_update')->name('withdraw_setting_update'); 

        Route::get('/sponsor-gen-conditions', 'sponsor_gen_conditions')->name('sponsor_gen_conditions'); 
        Route::post('/sponsor-gen-condition-store', 'sponsor_gen_condition_store')->name('sponsor_gen_condition_store'); 
        Route::post('/sponsor-gen-condition-update', 'sponsor_gen_condition_update')->name('sponsor_gen_condition_update'); 
        Route::post('/sponsor-gen-condition-remove', 'sponsor_gen_condition_remove')->name('sponsor_gen_condition_remove');

        Route::get('/working-gen-conditions', 'working_gen_conditions')->name('working_gen_conditions'); 
        Route::post('/working-gen-condition-store', 'working_gen_condition_store')->name('working_gen_condition_store'); 
        Route::post('/working-gen-condition-update', 'working_gen_condition_update')->name('working_gen_condition_update'); 
        Route::post('/working-gen-condition-remove', 'working_gen_condition_remove')->name('working_gen_condition_remove');
        
        Route::get('/non-working-gen-conditions', 'non_working_gen_conditions')->name('non_working_gen_conditions'); 
        Route::post('/non-working-gen-condition-store', 'non_working_gen_condition_store')->name('non_working_gen_condition_store'); 
        Route::post('/non-working-gen-condition-update', 'non_working_gen_condition_update')->name('non_working_gen_condition_update'); 
        Route::post('/non-working-gen-condition-remove', 'non_working_gen_condition_remove')->name('non_working_gen_condition_remove'); 
 
        Route::get('/non-working-matrix-conditions', 'non_working_matrix_bonus_conditions')->name('non_working_matrix_bonus_conditions'); 
        Route::post('/non-working-matrix-condition-store', 'non_working_matrix_condition_store')->name('non_working_matrix_condition_store'); 
        Route::post('/non-working-matrix-condition-update', 'non_working_matrix_condition_update')->name('non_working_matrix_condition_update'); 
        Route::post('/non-working-matrix-condition-remove', 'non_working_matrix_condition_remove')->name('non_working_matrix_condition_remove');        Route::get('/non-working-matrix-conditions', 'non_working_matrix_bonus_conditions')->name('non_working_matrix_bonus_conditions'); 
        
        Route::get('/direct-bonus-conditions', 'direct_bonus_conditions')->name('direct_bonus_conditions'); 
        Route::post('/direct-bonus-condition-store', 'direct_bonus_condition_store')->name('direct_bonus_condition_create'); 
        Route::post('/direct-bonus-condition-update', 'direct_bonus_condition_update')->name('direct_bonus_condition_update'); 
        Route::post('/direct-bonus-condition-remove', 'direct_bonus_condition_remove')->name('direct_bonus_condition_remove'); 

     
        Route::get('/rank-conditions', 'rank_conditions')->name('rank_conditions'); 
        Route::post('/rank-condition-create', 'rank_condition_create')->name('rank_condition_create'); 
        Route::post('/rank-condition-update', 'rank_condition_update')->name('rank_condition_update'); 
        Route::post('/rank-condition-remove', 'rank_condition_remove')->name('rank_condition_remove'); 
        Route::get('/web-config', 'web_config')->name('web_config'); 
        Route::post('/web-config-update', 'web_config_update')->name('web_config_update'); 
    });
    

});
Route::get('/run-queue', [QueueController::class, 'run'])->name('run-queue');
Route::get('/run-tree-child-arranger', [QueueController::class, 'tree_child_setter'])->name('tree_child_arranger');


Route::get('/link-storage', function () {
    Artisan::call('storage:link');
    
    return "Storage linked successfully!";
});
    
Route::get('/queuework', function () {
    Artisan::call('queue:work', [
        '--stop-when-empty' => true
    ]);
    
    return "queue work successfully!";
});
    
Route::get('/test', function () {

    $response = Http::get('https://bulksmsbd.net/api/smsapi', [
        'api_key'  => 'DkNOGGOao6AwQAZHXUq4',
        'type'     => 'text',
        'number'   => '01890492444',
        'senderid' => '8809617611753',
        'message'  => 'Hello World. I am from Chittagong',
    ]);
   if ($response->successful()) {
    echo "SMS Sent";
} else {
    echo "Failed to send SMS: " . $response->body();
}
});


Route::get('/clear-all', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('route:clear');
    $exitCode = Artisan::call('config:clear');
$exitCode = Artisan::call('optimize:clear');
$exitCode = Artisan::call('optimize');
    echo "clear";
    // return what you want
});


require __DIR__.'/auth.php';
