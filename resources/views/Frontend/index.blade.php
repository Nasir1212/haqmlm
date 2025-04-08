@extends('layouts.Front.app')
@section('content')

  
<div class="container">
    <div class="row">
        <!--<div class="col-12 col-md-4 order-2 order-md-1">-->
        <!--   <img src="https://haqmultishop.com/storage/uploads/products/8189383_20231021_024343_0000.jpg" class="img-fluid" alt="">-->
        <!--</div>-->
        <div class="col-12  order-1 order-md-2">
            <div id="carouselExampleCaptions" class="carousel slide bg-dark" data-bs-ride="carousel">
                <div class="carousel-indicators">
                  <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                  <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                  <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>
                <div class="carousel-inner bg-dark border">
                        @foreach ($sliders as $key =>  $slider)
                  <div class="carousel-item <?php if($key == 0){ echo 'active';} ?>">
                    <img src="{{ asset($slider->image_path.$slider->image_name) }}" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                      <h5>{{ $slider->name }}</h5>
                      
                    </div>
                  </div>
                  @endforeach
               
                 
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
        </div>
    </div>
<div class="section_latest">
    <div class="photobanner" style="width:<?php echo count($highlight_products)*130; ?>px">
        @foreach ($highlight_products as $data)
        <img src="{{ config('app.url', 'Laravel').$data->product->img_name}}" style="width:100px" class="img-fluid">
        @endforeach
       
   
      </div>
</div>





    <div class="brands mt-5">
        <h5 class="sec_title">Brands</h5>
        <div class="row">
            @foreach ($latest_brands as $item)
            <div class="col-4 col-md-2">
                <a href="{{ route('frontend.Brand_product',['slug'=>$item->slug])}}" class="text-center">
                    <div class="img-circle m-auto">
                        <img src="{{ asset($item->img_name)}}" class="img-fluid" alt="">
                    </div>
                    
                    <div class="">{{ $item->name }}</div>
                </a>
           
            </div>
            @endforeach
          
        </div>
    </div>
   
    <div class="categories mt-3">
        <h5 class="sec_title">Categories</h5>
        <div class="row">
            @foreach ($latest_categories as $item)
            <div class="col-4 col-md-2">
                <a href="{{ route('frontend.Category_product',['slug'=>$item->slug])}}"  class="text-center">
                    <div class="img-circle m-auto">
                        <img src="{{ asset($item->img_name)}}" class="img-fluid" alt="">
                    </div>
                    <div class="">{{ $item->name }}</div>
                </a>
           
            </div>
            @endforeach
        </div>
    </div>
    <hr>
    <div class="product_sec">
        
        
        
         <div class="dealer_selection_tool mt-3">
        <div class="h4 text-center">Dealer select area</div>
       
            <form action="{{ route('dealer_select_for_buying') }}" method="post" id="dealerForm">
                @csrf
                <select name="dealer" id="dealer_select" class="form-control dealerS">
                    <option value="">Select Dealer</option>
                    @if (isset($dealers))
                    @foreach ($dealers as $dealer)
                    @if (isset($selected_dealer) && $selected_dealer != '')
                      <option @selected($selected_dealer->dealer_id == $dealer->user_id) value="{{ $dealer->user_id }}">{{ $dealer->name }} -- {{ $dealer->phone }} -- {{ $dealer->type }} : {{ $dealer->type_name }}</option>
                    @else
                    <option  value="{{ $dealer->user_id }}">{{ $dealer->name }} -- {{ $dealer->phone }} -- {{ $dealer->type }}</option>
                      @endif
                    @endforeach
                    @endif
                  
                </select>
            </form>
    </div>

        
        
        <h3 class="text-dark my-3">Products &nbsp;<i class="fa-solid fa-list"></i></h3>
        <div class="row">
            @foreach ($latest_products as $product)
            <div class="col-12 col-md-3 mb-2">
                <div class="product_wrapper">
                    <div class="product_details">
                        <div class="img">
                            <img src="{{ config('app.url', 'Laravel').$product->img_name}}" class="img-fluid" alt="">
                        </div>
                        <div class="product_title">
                            {{ $product->name }}
                        </div>
                        <div class="product_price">
                            <div class="regular_price">
                                Regular {{ getAmount($product->regular_price) }}
                            </div>
                            <div class="sell_price">
                               DP {{ getAmount($product->main_price) }}
                            </div>
                            
                        </div>
                    </div>
                    <div class="product_order_option btn-group">
                        
                        @if($product->owner_qty  > 0)
                        
                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Wishlist" type="button" class="add_to_wish_list btn btn-xs btn-info" data-product_id="{{ $product->id }}">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                          <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart" type="button" class="add_to_cart btn btn-xs btn-primary" data-product_id="{{ $product->id }}">
                            <i class="fa-solid fa-cart-arrow-down"></i>
                        </button>
                   
                        @else
                        
                        <button  type="button" class="btn btn-xs btn-warning">
                            Stock Out
                        </button>
                        @endif
                        
                        <a data-bs-toggle="tooltip" data-bs-placement="top" title="See Details" href="{{ route('frontend.product_details', ['slug'=>$product->slug])}}" class="details_link btn btn-xs btn-success"><i class="fa-solid fa-eye"></i></a>
                    </div>
                    <div class="point_bar">
                    
                        P- {{ $product->point }}
                    </div>
                     <div class="stock_status_bar">
                        Stock {{ $product->owner_qty  }}
                    </div>
                    
                </div>
            </div>
            @endforeach
        </div>
        
    </div>
<div class="my-3">
    @if ($latest_products->hasPages()) 
    <nav aria-label="Page navigation example"> 
     <ul class="pagination justify-content-center"> 
         @if ($latest_products->onFirstPage()) 
         <li class="page-item disabled"> 
             <a class="page-link" href="#" 
                tabindex="-1">Previous</a> 
         </li> 
         @else 
         <li class="page-item"><a class="page-link" 
             href="{{ $latest_products->previousPageUrl() }}"> 
                   Previous</a> 
           </li> 
         @endif 

         @if ($latest_products->hasMorePages()) 
         <li class="page-item"> 
             <a class="page-link" 
                href="{{ $latest_products->nextPageUrl() }}"  
                rel="next">Next</a> 
         </li> 
         @else 
         <li class="page-item disabled"> 
             <a class="page-link" href="#">Next</a> 
         </li> 
         @endif 
     </ul> 
   </nav> 
     @endif 
    
</div>
   
   
</div>

<style>

.product_sec {
    background: #e9e9e973;
    padding: 10px;
}
.dealer_selection_tool {
    border: 1px solid #ababab;
    padding: 12px;
    box-shadow: 1px 1px 2px #444444;
}

form#dealerForm {
    border: 1px solid #b7b5b5;
    padding: 10px;
    background: #fff;
}

			.categories {

    border-radius: 5px;
    padding: 10px;
      box-shadow: 0px 0px 10px #545050;
}
.brands {
    /* border: 10px solid #e7e7e7; */
    border-radius: 5px;
    padding: 10px;
    box-shadow: 0px 0px 10px #545050;
}
.sec_title {
    font-size: 19px;
    border-bottom: 1px solid #ddd1d1;
    padding: 10px;
}
    .product_wrapper{
        position: relative;
        overflow: hidden;
    }
.point_bar {
    position: absolute;
    left: -50px;
    top: -3px;
    transform: rotate(307deg);
    color: black;
    background: #e5dada2b;
    width: 131px;
    height: 58px;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    border-bottom: 2px solid black;
}


.stock_status_bar {
    position: absolute;
    right: -50px;
    top: -3px;
    transform: rotate(49deg);
    color: black;
    background: #e5dada2b;
    width: 131px;
    height: 58px;
    display: flex;
    align-items: flex-end;
    justify-content: center;
    border-bottom: 2px solid black;
    z-index: 50000;
    font-size: 13px;
}

    .product_order_option{
        display: flex;
        align-items: center;
        
    }
 .product_price {
    display: flex;
    justify-content: space-between;
    border: 1px solid #e1e1e1;
    background: #f9f9f9;
    padding: 12px 11px;
    border-radius: 4px;
    margin-bottom: 14px;
}
.product_wrapper {
    border: 1px solid #d5d5d5;
    padding: 12px 16px;
    border-radius: 9px;
    margin-bottom: 13px;
    background: #fff;
    height: 398px;
}

.product_wrapper:hover {
    box-shadow: 0px 0px 8px 3px #752c8db8;
}

.product_details .img{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;

}
.product_details {
    height: 334px;
}
.product_details .img img{
    height: 200px;

}

.img-circle{
    width:100px;
    height:100px;
    border-radius: 50%;
    border: 1px solid #000;
}
.img-circle img{
    width:100px;
    height:100px;
    border-radius: 50%;
    border: 1px solid #000;
}
.section_latest {
    height: 130px;
    position: relative;
    overflow: hidden;
    z-index: 7;
}
    
    .photobanner {
      position:absolute; 
      top:0px; 
      left:0px; 
     
      overflow:hidden; 
      white-space: nowrap;
      animation: bannermove 10s linear infinite;
      display: flex;
    }
    
    .photobanner img {
    border: 1px solid #000;
    margin: 10px 10px;
    height: 120px;
}
    @keyframes bannermove {
      0% {
          transform: translate(0, 0);
      }
      100% {
          transform: translate(-50%, 0);
      }
    }
    .section_latest:hover {
       overflow: auto;
    }
    
    .section_latest:hover .photobanner {
       animation-play-state:paused;
    }
/* .btn{
    width: 12px;
    height:12px;
} */
</style>

@endsection
@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>

<script>
'use strict';
    (function($){
        $( '#dealer_select' ).select2( {
    theme: 'bootstrap-5'
} );
$('#dealer_select').on('select2:select', function(e) {
        $('#dealerForm').submit();
    });

        
        
        $('.add_to_cart').on('click',function() {
          var product_id = $(this).data('product_id');

            $.ajax({
                url: "{{ route('add_cart') }}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
                data: { id: product_id, qty: 1 }, // Replace with your data
                success: function(response) {
                    $('.cart_v').html(response[1]);
                    if(response[0] == 'success'){
                        Swal.fire(
                        'Thanks for Add!',
                        'Shoping Cart!',
                        'success'
                        )
                    }

                    if(response[0] == 'error'){
                        Swal.fire(
                        'Already Exists!',
                        'Shoping Cart!',
                        'error'
                        )
                    }
                },
                error: function(error) {
                    console.log(error);
                    // Handle errors here
                }
            });
        });
        
        $('.add_to_wish_list').on('click',function() {
          var product_id = $(this).data('product_id');

            $.ajax({
                url: "{{ route('add_wishlist') }}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
                data: { id: product_id }, // Replace with your data
                success: function(response) {
                    $('.wsp_v').html(response[1]);
                    if(response[0] == 'success'){
                        Swal.fire(
                        'Thanks for Add!',
                        'Wishlist!',
                        'success'
                        )
                    }

                    if(response[0] == 'error'){
                        Swal.fire(
                        'Already Exists!',
                        'You clicked the button!',
                        'error'
                        )
                    }
                },
                error: function(error) {
                    console.log(error);
                    // Handle errors here
                }
            });
        });
        
        
        
        
    function get_location(p,r){
    var st = '#'+p;
    var parent_id = $(st).val();
     $.ajax({
                url: "{{ route('location_query') }}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
                data: { location: parent_id }, // Replace with your data
                success: function(response) {
                    var receiver = "#"+r;
                    var options = '';
                    var cts = '';
                    $.each(response, function (indexInArray, valueOfElement) { 
                        options +="<option value='"+valueOfElement.id+"'>"+ valueOfElement.b_name+" ("+valueOfElement.e_name+") </option>";
                        cts = indexInArray;
                    });

                            $(receiver).html(options);
                            $(receiver).prepend("<option selected=''>Select "+r+"</option>");
                        if(cts == ''){
                            if(r == 'district'){
                                $('#upzila').html("<option selected=''>Select Upzila</option>");
                                $('#l_union').html("<option selected=''>Select Union</option>");
                            }else if(r == 'upzila'){
                               
                                $('#l_union').html("<option selected=''>Select Union</option>");
                            }
                        }
                            
                           

                },
                error: function(error) {
                    console.log(error);
                    // Handle errors here
                }
            });
}
        
        
    
    })(jQuery)
    </script>
@endpush



