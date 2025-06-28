@extends('layouts.Front.app')
@section('content')
<div class="container">
    <h2 class="mt-4">Product List</h2>
   
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
                        Stock {{ $product->stock  }}
                    </div>
                <div class="product_order_option btn-group">
                    @auth
                    <a href="{{ route('product_order', ['slug'=>$product->slug])}}" target="_blank" class="details_link btn btn-success">Order Now</a>
                    <button type="button" class="add_to_cart btn btn-xs btn-info" data-product_id="{{ $product->id }}">
                        <i class="fa-solid fa-cart-arrow-down"></i>
                    </button>
                    @else
                    <a href="{{ route('login') }}" target="_blank" class="details_link btn btn-success">Order Now</a>
                    @endauth
                    <a href="{{ route('frontend.product_details', ['slug'=>$product->slug])}}" class="details_link btn btn-xs btn-primary"><i class="fa-solid fa-eye"></i></a>
                </div>
               
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>

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
    display: flex
;
    align-items: flex-end;
    justify-content: center;
    border-bottom: 2px solid black;
    z-index: 0;
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
    
    /* .btn{
        width: 12px;
        height:12px;
    } */
    </style>

@endsection

@push('script')
<script>
'use strict';
    (function($){
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
