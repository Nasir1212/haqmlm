
@extends('layouts.Front.app')
@section('content')
<div class="container">
    <h2 class="mt-4">Categories</h2>
   
	<div class="row mb-5">
        @foreach ($categories as $category)
        <div class="col-12 col-md-4">
            <div class="categories_wrapper">
                <div class="categories_details">
                    <a href="{{ route('frontend.Category_product',['slug'=>$category->slug])}}">
                        <div class="img">
                            <img src="{{ asset($category->img_name)}}" class="img-fluid" alt="">
                        </div>
                        <div class="categories_title">
                            {{ $category->name }}
                        </div>
                    </a>
                    
                
                </div>
           
            </div>
        </div>
        @endforeach
    </div>
    <div class="my-3">
        @if ($categories->hasPages()) 
        <nav aria-label="Page navigation example"> 
         <ul class="pagination justify-content-center"> 
             @if ($categories->onFirstPage()) 
             <li class="page-item disabled"> 
                 <a class="page-link" href="#" 
                    tabindex="-1">Previous</a> 
             </li> 
             @else 
             <li class="page-item"><a class="page-link" 
                 href="{{ $categories->previousPageUrl() }}"> 
                       Previous</a> 
               </li> 
             @endif 
    
             @if ($categories->hasMorePages()) 
             <li class="page-item"> 
                 <a class="page-link" 
                    href="{{ $categories->nextPageUrl() }}"  
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

.categories_wrapper{
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

    .categories_order_option{
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
 .categories_price {
    display: flex;
    justify-content: space-between;
    border: 1px solid #e1e1e1;
    background: #f9f9f9;
    padding: 12px 11px;
    border-radius: 4px;
    margin-bottom: 14px;
}
   .categories_wrapper {
    border: 1px solid #d5d5d5;
    padding: 12px 16px;
    border-radius: 9px;
    margin-bottom: 13px;
} 
.categories_wrapper:hover {
    box-shadow: 0px 0px 8px 3px #e9d6ed;
}
.categories_details .img{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;

}

.categories_details .img img{
    height: 200px;

}

/* .btn{
    width: 12px;
    height:12px;
} */
</style>

@endsection


