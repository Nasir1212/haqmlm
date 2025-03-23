@extends('layouts.Front.app')
@section('content')
    <div class="container">
        <div class="package_wrapper">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="img_wrapper">
                        <img src="{{ asset($package->img_name) }}" alt="{{ $package->name }}" class="img-fluid">
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="prp">
                        <h3 class="text-info">{{ $package->name }}</h3>
                        @php
                        $product_total_price = 0;
                        foreach ($products as $key => $data) {
                            $product_total_price += $data->regular_price;
                        }
                        @endphp
                      
                        <div>Regular Price : <del class="text-danger"> {{ getAmount($product_total_price) }} Tk/-</del></div>
                        <div>Point : <strong class="text-success">{{ getAmount($package->point) }}</strong></div>
                        <div>Sell Price : <strong class="text-success">{{ getAmount($package->main_price) }} Tk/-</strong></div>
                        @auth
                        <a href="{{ route('package_order', ['slug'=>$package->slug])}}" target="_blank" class="details_link btn btn-success">Order Now</a>
                        @else
                        <a href="{{ route('login') }}" target="_blank" class="details_link btn btn-success">Order Now</a>
                        @endauth
                    </div>
                    <div class="col-12 mt-3">
                        <div class="h4">Package Details</div>
                        <div class="package_details">
                            {!! $package->details !!}
                        </div>
                    </div>
                  </div>
                <div class="row mt-5">
                    <hr>
                    <div class="col-12">
                        <div class="h4">Package Product List</div>
                        <div class="product_wrap">
                            <div class="row">
                                @foreach ($products as $product)
                                <div class="col-12 col-md-4">
                                    <div class="product_single_wrap">
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <img src="{{ asset($product->img_name) }}" class="img-fluid" alt="{{ $product->name}}">
                                            </div>
                                            <div class="col-12 col-md-8">
                                                <div class="">Price : {{ getAmount($product->main_price) }} Tk/-</div>
                                                <div class="">Brand : {{ $product->brand->name }} Tk/-</div>
                                                <div class="">Category : {{ $product->category->name }}</div>
                                                <a href="{{ route('frontend.product_details', ['slug'=>$product->slug])}}" class="details_link btn btn-xs btn-primary mt-3">See Details</a>
                                            </div>
                                        </div>
                                    </div>
                                  
                                </div>
                                @endforeach
                            </div>
                        </div>
                </div>
                </div>
              
            </div>
        </div>
        
    </div>
    <style>
        .product_single_wrap{
            border: 1px solid #000;
            padding: 10px;
            border-radius:10px;
        }


        .img_wrapper{
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid #000;
            padding: 10px;
        } 
        .img_wrapper img{
            height: 300px;
            
        }
        .prp{
            border: 1px solid #000;
            padding: 10px;
        }
        .package_wrapper {
            border: 1px solid #000;
            border-radius: 3px;
            padding: 2px;
            margin-top: 50px;
            margin-bottom: 100px;
            padding: 13px 15px;
        }
    </style>

@endsection