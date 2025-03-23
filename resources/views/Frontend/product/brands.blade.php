@extends('layouts.Front.app')
@section('content')
<div class="container">
    <h2 class="mt-4">Brands</h2>
   
	<div class="row mb-5">
        @foreach ($brands as $brand)
        <div class="col-12 col-md-4">
            <div class="brands_wrapper">
                <div class="brands_details">
                    <a href="{{ route('frontend.Brand_product',['slug'=>$brand->slug])}}">
                    <div class="img">
                        <img src="{{ asset($brand->img_name)}}" class="img-fluid" alt="">
                    </div>
                    <div class="brands_title">
                        {{ $brand->name }}
                    </div>
                    </a>
                    
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="my-3">
        @if ($brands->hasPages()) 
        <nav aria-label="Page navigation example"> 
         <ul class="pagination justify-content-center"> 
             @if ($brands->onFirstPage()) 
             <li class="page-item disabled"> 
                 <a class="page-link" href="#" 
                    tabindex="-1">Previous</a> 
             </li> 
             @else 
             <li class="page-item"><a class="page-link" 
                 href="{{ $brands->previousPageUrl() }}"> 
                       Previous</a> 
               </li> 
             @endif 
    
             @if ($brands->hasMorePages()) 
             <li class="page-item"> 
                 <a class="page-link" 
                    href="{{ $brands->nextPageUrl() }}"  
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

.brands_wrapper{
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

    .brands_order_option{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
 .brands_price {
    display: flex;
    justify-content: space-between;
    border: 1px solid #e1e1e1;
    background: #f9f9f9;
    padding: 12px 11px;
    border-radius: 4px;
    margin-bottom: 14px;
}
   .brands_wrapper {
    border: 1px solid #d5d5d5;
    padding: 12px 16px;
    border-radius: 9px;
    margin-bottom: 13px;
} 
.brands_wrapper:hover {
    box-shadow: 0px 0px 8px 3px #e9d6ed;
}
.brands_details .img{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;

}

.brands_details .img img{
    height: 200px;

}

/* .btn{
    width: 12px;
    height:12px;
} */
</style>

@endsection


