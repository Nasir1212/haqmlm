@extends('layouts.Front.app')
@section('content')
<div class="container">
    <h2 class="mt-4">Package List</h2>
   
	<div class="row mb-5">
        @foreach ($packages as $package)
        <div class="col-12 col-md-4">
            <div class="package_wrapper">
                <div class="package_details">
                    <div class="img">
                        <img src="{{ asset($package->img_name)}}" class="img-fluid" alt="">
                    </div>
                    <div class="package_title">
                        {{ $package->name }}
                    </div>
                    <div class="package_price">
                    <div class="sell_price">
                           Point {{ getAmount($package->point) }}
                        </div>
                        <div class="sell_price">
                           Sell {{ getAmount($package->main_price) }}
                        </div>
                        
                    </div>
                </div>
                <div class="package_order_option">
                    @auth
                    <a href="{{ route('package_order', ['slug'=>$package->slug])}}" target="_blank" class="details_link btn btn-success">Order Now</a>
                    @else
                    <a href="{{ route('login') }}" target="_blank" class="details_link btn btn-success">Order Now</a>
                    @endauth
                    <a href="{{ route('frontend.package_details', ['slug'=>$package->slug])}}" class="details_link btn btn-xs btn-primary">See Details</a>
                </div>
               
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .package_order_option{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
 .package_price {
    display: flex;
    justify-content: space-between;
    border: 1px solid #e1e1e1;
    background: #f9f9f9;
    padding: 12px 11px;
    border-radius: 4px;
    margin-bottom: 14px;
}
.package_wrapper {
  
    padding: 12px 16px;
    box-shadow: 0px 0px 3px #000;
}
.package_details .img{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;

}

.package_details .img img{
    height: 200px;

}

/* .btn{
    width: 12px;
    height:12px;
} */
</style>

@endsection

