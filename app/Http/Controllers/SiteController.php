<?php

namespace App\Http\Controllers;
use App\Models\BdLocation;
use App\Models\Faq;
use App\Models\HighLightProduct;
use App\Models\Package;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductCategory;
use App\Models\Slider;
use Illuminate\Http\Request;
use App\Models\Dealer;
use App\Models\DealerSelection;
use App\Models\ProductOwner;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function product_check_and_display(Request $request){
        
        if($request->slug == ''){
             notify()->error("Find the product you want");
        return back();
        }
        
        
        return redirect()->route('frontend.product_details',['slug'=>$request->slug]);
    }
    
    public function product_check_and_display_m(Request $request){
          if($request->slug == ''){
             notify()->error("Find the product you want");
        return back();
        }
        return redirect()->route('frontend.product_details',['slug'=>$request->slug]);
    }
  
    
    public function realtime_p_name_sg(Request $request){
        
        $products = Product::where('name','LIKE', "%$request->product_name%")->orWhere('b_name', 'LIKE', "%$request->product_name%")->get();
        $tb = '';
        if($products){
            $tb = '<ul id="product_names">';
    
            foreach ($products as $key => $product) {
                $tb .= '<li class="product_name" data-product_slug="'.$product->slug.'" >'.$product->name.'</li>';
            }
            $tb .= '</ul>';
        }else{
            $tb = '';
        }
    
        return response()->json($tb);
    }
    
     
    public function get_page(Request $request){
        $gsd = global_user_data();
        $page = Page::where('slug',$request->slug)->where('status',1)->first();
        return  view('Frontend.page', compact('gsd','page'));
    
    }  
    public function get_faqs(Request $request){
        $gsd = global_user_data();
        $faqs = Faq::where('status',1)->latest('id')->get();
        return  view('Frontend.faqs', compact('gsd','faqs'));
    
    }     
    public function Index(){ 
        
         $selected_dealer = '';

        $gsd = '';
        if (Auth::check()) {
           $gsd = global_user_data();
           $selected_dealer = DealerSelection::where('user_id', $gsd->id)->first();
           if(!$selected_dealer){
               $selected_dealer = new DealerSelection();
               $selected_dealer->user_id = $gsd->id;
               $selected_dealer->dealer_id = 1;
               $selected_dealer->save();
           }
        }
        

        $c_products = cart_counter();
        $wsp_products = wishlist_counter();
        if (Auth::check()) {
        if (!$selected_dealer) {
      
              $dealerId = 1;  

        
        $latest_products = Product::select('products.*', 'product_owners.qty as owner_qty')
    ->join('product_owners', 'products.id', '=', 'product_owners.product_id')
    ->where('product_owners.dealer_id', $dealerId)
    ->latest('products.id')
    ->paginate(24);
        } else{
             $dealerId = $selected_dealer->dealer_id;

$latest_products = Product::select('products.*', 'product_owners.qty as owner_qty')
    ->join('product_owners', 'products.id', '=', 'product_owners.product_id')
    ->where('product_owners.dealer_id', $dealerId)
    ->latest('products.id')
    ->paginate(24);

    
        } 
            
        } else{
            
        $dealerId = 1;  

        
        $latest_products = Product::select('products.*', 'product_owners.qty as owner_qty')
    ->join('product_owners', 'products.id', '=', 'product_owners.product_id')
    ->where('product_owners.dealer_id', $dealerId)
    ->latest('products.id')
    ->paginate(24);
        
        
        
        
        
    }          
        
        
        $latest_brands = ProductBrand::latest('id')->take(12)->get();
        $latest_categories = ProductCategory::latest('id')->take(12)->get();
        
        $sliders = Slider::where('status',1)->latest('id')->get();
        $highlight_products = HighLightProduct::orderBy("id")->with('product')->get();
        
        $dealers = Dealer::where('status','Active')->latest('id')->get();
        $divisions = BdLocation::where('division',1)->get();

      return  view('Frontend.index', compact('divisions','dealers','selected_dealer','highlight_products','latest_brands','latest_categories','latest_products','gsd','c_products','wsp_products','sliders'));
    }

    public function Package_List(){
        $gsd = global_user_data();
        $packages = Package::latest('id')->paginate(12);
        $c_products = cart_counter();
        $wsp_products = wishlist_counter();
        return  view('Frontend.package.index', compact('packages','gsd','c_products','wsp_products'));
    }
    
    public function Category_list(){
        $gsd = global_user_data();
        $categories = ProductCategory::latest('id')->paginate(12);
        $c_products = cart_counter();
        $wsp_products = wishlist_counter();
        return  view('Frontend.product.categories', compact('categories','gsd','c_products','wsp_products'));
    }

 public function Brand_list(){
        $gsd = global_user_data();
        $brands = ProductBrand::latest('id')->paginate(12);
        $c_products = cart_counter();
        $wsp_products = wishlist_counter();
        return  view('Frontend.product.brands', compact('brands','gsd','c_products','wsp_products'));
    }

    public function Product_list(){ 
         $selected_dealer = '';
            $gsd = '';
        if (Auth::check()) {
        $gsd = global_user_data();
        $selected_dealer = DealerSelection::where('user_id', $gsd->id)->first();
        }

    if (!$selected_dealer) {
      $dealerId = 1;
    $products = Product::select('products.*', 'product_owners.qty as owner_qty')
    ->join('product_owners', 'products.id', '=', 'product_owners.product_id')
    ->where('product_owners.dealer_id', $dealerId)
    ->latest('products.id')
    ->paginate(24);

    
    }else{
         
      $dealerId = $selected_dealer->dealer_id;
          $products = Product::select('products.*', 'product_owners.qty as owner_qty')
    ->join('product_owners', 'products.id', '=', 'product_owners.product_id')
    ->where('product_owners.dealer_id', $dealerId)
    ->latest('products.id')
    ->paginate(24);

    }
        $c_products = cart_counter();
        $wsp_products = wishlist_counter();
      
  $divisions = BdLocation::where('division',1)->get();

 // Return view with data
 $dealers = Dealer::latest('id')->get();
 
        return  view('Frontend.product.index', compact('divisions',
    'selected_dealer','products','gsd','c_products','wsp_products','dealers'));
    }

    public function terms(){
        $gsd = global_user_data();
        return  view('Frontend.pages.terms_cond', compact('gsd'));
    }
    
 
    public function team_details(){
        $gsd = global_user_data();
        return  view('Frontend.page-team-details', compact('gsd'));
    }
    public function team_list(){
        $gsd = global_user_data();
        return  view('Frontend.page-team', compact('gsd'));
    }
    

    public function about_us(){
        $gsd = global_user_data();
        return  view('Frontend.pages.about', compact('gsd'));
    }
    
    public function contact_us(){
        $gsd = global_user_data();
        return  view('Frontend.contact-us', compact('gsd'));
    }
    public function privacy_policy(){
        $gsd = global_user_data();
        return  view('Frontend.pages.privacy', compact('gsd'));
    }
    public function testimonials(){
        $gsd = global_user_data();
        return  view('Frontend.pages.testimonial', compact('gsd'));
    }
    
    public function faqs(){
        $gsd = global_user_data();
        return  view('Frontend.pages.faq', compact('gsd'));
    }
    
    public function contact_requestex(Request $request){
        
            $setting =  setting();
            $received_mail = $setting->admin_mail;
            
            $name = $request->form_name;
            $email = $request->form_email;
            $subject = $request->form_subject;
            $phone = $request->form_phone;
            $message = $request->form_message;
        
        //   Mail::to($received_mail)->send(new ContactMail($subject,$name,$phone,$email,$message));
          
         
          return back()->with('success','You information successfully submitted');
    }
}
