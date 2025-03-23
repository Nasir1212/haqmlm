@extends('layouts.Front.app')
@section('content')
<div class="container">
    
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

    
    <h2 class="mt-4">Product</h2>
   
	<div class="row mb-5">
        @foreach ($products as $product)
        <div class="col-12 col-md-4">
            <div class="product_wrapper">
                <div class="product_details">
                    <div class="img">
                        <img src="{{ asset($product->img_name)}}" class="img-fluid" alt="">
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
                <div class="point_bar">
                
                    P- {{ $product->point }}
                </div>
                 <div class="stock_status_bar">
                        Stock {{ $product->owner_qty }}
                    </div>
                    
                
                
                <div class="product_order_option btn-group">
                    @auth
                 
                    
                    
                         @if($product->owner_qty > 0)
                      <a href="{{ route('product_order', ['slug'=>$product->slug])}}" target="_blank" class="details_link btn btn-success">Order Now</a>
                    <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart" type="button" class="add_to_cart btn btn-xs btn-info" data-product_id="{{ $product->id }}">
                        <i class="fa-solid fa-cart-arrow-down"></i>
                    </button>
                   
                        @else
                        
                        <button  type="button" class="btn btn-xs btn-warning">
                            Stock Out
                        </button>
                        @endif
                    
                    
                    @else
                    <a href="{{ route('login') }}" target="_blank" class="details_link btn btn-success">Order Now</a>
                    @endauth
                    <a data-bs-toggle="tooltip" data-bs-placement="top" title="See Details" href="{{ route('frontend.product_details', ['slug'=>$product->slug])}}" class="details_link btn btn-xs btn-primary"><i class="fa-solid fa-eye"></i></a>
                </div>
               
            </div>
        </div>
        @endforeach
    </div>
    <div class="my-3">
        @if ($products->hasPages()) 
        <nav aria-label="Page navigation example"> 
         <ul class="pagination justify-content-center"> 
             @if ($products->onFirstPage()) 
             <li class="page-item disabled"> 
                 <a class="page-link" href="#" 
                    tabindex="-1">Previous</a> 
             </li> 
             @else 
             <li class="page-item"><a class="page-link" 
                 href="{{ $products->previousPageUrl() }}"> 
                       Previous</a> 
               </li> 
             @endif 
    
             @if ($products->hasMorePages()) 
             <li class="page-item"> 
                 <a class="page-link" 
                    href="{{ $products->nextPageUrl() }}"  
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
form#dealerForm {
    border: 1px solid #b7b5b5;
    padding: 10px;
    background: #fff;
}

.dealer_selection_tool {
    border: 1px solid #ababab;
    padding: 12px;
    box-shadow: 1px 1px 2px #444444;
}

.dlset select {
    padding: 6px 10px !important;
    height: 41px;
    font-size: large;
    color: #000;
}

.dealerS {
    padding: 6px 10px !important;
    height: 41px;
    font-size: large;
    color: #000;
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
} 
.product_wrapper:hover {
    box-shadow: 0px 0px 8px 3px #e9d6ed;
}
.product_details .img{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;

}

.product_details .img img{
    height: 200px;

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
                },
                error: function(error) {
                    console.log(error);
                    // Handle errors here
                }
            });
        });
    
    })(jQuery)
    </script>
@endpush

