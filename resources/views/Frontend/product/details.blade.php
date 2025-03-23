@extends('layouts.Front.app')
@section('content')
    <div class="container">
        <div class="product_wrapper">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="img_wrapper">
                        <img src="{{ asset($product->img_name) }}" alt="{{ $product->name }}" class="img-fluid">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="prp">
                        <h3 class="text-info">{{ $product->name }}</h3>
                        <div>Brand Name : {{$product->brand->name}}</div>
                        <div>Category Name : {{$product->category->name}}</div>
                        <div>Regular Price : <span class="text-danger"> {{ getAmount($product->regular_price) }}</span></div>
                        <div>Member Price : <strong class="text-success">{{ getAmount($product->main_price) }}</strong></div>
                        <div>Product Point : <strong class="text-success">{{ getAmount($product->point) }}</strong></div>
                            @if($product->owner->qty > 0)
                            <div>Stock : <strong class="text-success">{{ $product->owner_qty }}</strong></div>
                            @endif
                        <div class="qty_wrapper mb-3">
                            <div class="h6">Product Quantity</div>
                            <button type="button" id="addQty" class="btn btn-sm btn-success">+</button>
                            <input type="text" id="qty" value="1" class="border "  style="width:60px;padding:0px 5px">
                            <button type="button" id="subQty" class="btn btn-sm btn-danger">-</button>
                        </div>
                        
                        @auth
                        
                        @if($product->owner_qty > 0)
                            <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Wishlist" type="button" class="add_to_wish_list btn btn-info" data-product_id="{{ $product->id }}">
                            <i class="fa-solid fa-heart"></i>
                        </button>
                        <button data-bs-toggle="tooltip" data-bs-placement="top" title="Add to cart" type="button" class="add_to_cart btn btn-info" data-product_id="{{ $product->id }}">
                            <i class="fa-solid fa-cart-arrow-down"></i> Add to cart
                        </button>
                        <form action="{{ route('product_order', ['slug'=>$product->slug])}}" method="get" class="d-inline-block">
                            @csrf 
                            <input type="hidden" name="qty" id="passQty" value="1">
                            <button type="submit" class="details_link btn btn-success">Order Now</button>
                        </form>
                        @else
                        
                        <button  type="button" class="btn btn-xs btn-warning">
                            Stock Out
                        </button>
                        @endif
                        
                        
               
                        @else
                         <a href="{{ route('login')}}" target="_blank" class="details_link btn btn-success" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to wishlist"> <i class="fa-solid fa-heart"></i></a>
                         <a href="{{ route('login')}}" target="_blank" class="details_link btn btn-success"> <i class="fa-solid fa-cart-arrow-down" data-bs-toggle="tooltip" data-bs-placement="top" title="Add to Cart"></i></a>
                         <a href="{{ route('login')}}" target="_blank" class="details_link btn btn-success">Order Now</a>
                        @endauth
                       
                
                    </div>
                  </div>
                <div class="row mt-5">
                    <hr>
                    <div class="col-12">
                        <div class="h4">Product Details</div>
                        <div class="product_details">
                            {!! $product->details !!}
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <hr>
                    <div class="col-12">
                        <div class="h4">Related Products</div>
                        <div class="row">
                            @if($related_products != '')
                            @foreach($related_products as $related_product)
                                <div class="col-12 col-md-4">
                                    <div class="card">
                                        <img src="{{ asset($related_product->img_name) }}" alt="{{ $related_product->name }}" class="card-img-top">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $related_product->name }}</h5>
                                            <p class="card-text">{{ $related_product->description }}</p>
                                            <a href="{{ route('frontend.product_details', ['slug'=>$related_product->slug]) }}" class="btn btn-primary">View Details</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>


                
            </div>
        </div>
        
    </div>
    <style>
        .img_wrapper{
            display: flex;
            align-items: center;
            justify-content: center;
          
            padding: 10px;
        } 
        .img_wrapper img{
            height: 300px;
            
        }
        .prp{
           
            padding: 10px;
        }
        .product_wrapper {
      
            border-radius: 3px;
            padding: 2px;
            margin-top: 50px;
            margin-bottom: 100px;
            padding: 13px 15px;
        }
    </style>


@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.full.min.js"></script>
<script>
'use strict';
    (function($){

        $('#qty').keyup(function () {
            $('#passQty').val($(this).val());
        });    
        $('#addQty').on('click',function () {
            var previnput =  $('#qty').val();
            previnput = parseInt(previnput);
            var final = previnput +=1;
            $('#qty').val(final);
            $('#passQty').val(final);
            
        });

        $('#subQty').on('click',function () {
            var previnput =  $('#qty').val();
            previnput = parseInt(previnput);
            if(previnput > 1){
                var final = previnput -=1;
              $('#qty').val(final);
              $('#passQty').val(final);
            }
            
            
        });


        $('.add_to_cart').on('click',function() {
          var product_id = $(this).data('product_id');

            $.ajax({
                url: "{{ route('add_cart') }}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
                data: { id: product_id, qty: $('#qty').val()}, // Replace with your data
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