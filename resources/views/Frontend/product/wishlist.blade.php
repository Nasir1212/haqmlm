@extends('layouts.Front.app')
@section('content')
<div class="container">
    <h2 class="mt-4">Wish List Product</h2>
   
	<div class="product_wrap">
        <div class="row">
            @foreach ($wish_list as $data)
            <div class="col-12" id="p{{$data->id}}">
                <div class="product_single_wrap">
                    <div class="row">
                         <div class="col-12">
                           <h4 class="pname">{{ $data->product->name }}</h4>
                           
                        </div>
                        <div class="col-12 col-md-4 text-center text-md-left  text-lg-left">
                            <img src="{{ asset($data->product->img_name) }}" class="img-fluid" alt="{{ $data->product->name}}">
                        </div>
                        <div class="col-12 col-md-8 text-right text-md-center">
                            <div class="">Price : {{ $data->product->main_price }} Tk/-</div>
                            <div class="">Brand : {{ $data->product->brand->name }} Tk/-</div>
                            <div class="">Category : {{ $data->product->category->name }}</div>
                            <button type="button" class="btn btn-success mt-3 add_to_cart"  data-product_id="{{ $data->product->id }}"><i class="fa-solid fa-cart-arrow-down"></i> Add To Cart</button>
                            
                            <a href="{{ route('frontend.product_details', ['slug'=>$data->product->slug])}}" class="details_link btn btn-xs btn-primary mt-3"><i class="fa-solid fa-eye"></i> Details</a>
                            <button type="button" class="btn btn-danger mt-3 wishlist_remover" data-product_id="{{ $data->id }}"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
              
            </div>
            @endforeach
        </div>
    </div>
</div>

<style>
    .product_order_option{
        display: flex;
        align-items: center;
        justify-content: space-between;
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
.product_wrap {
    padding: 20px;
    border: 1px solid #000;
    margin-bottom: 120px;
    margin-top: 12px;
    box-shadow: 0px 0px 4px rgb(28, 240, 9);
    border-radius: 3px;
    background: #10222e;
}
.product_details .img{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 200px;

}
.product_single_wrap img {
    height: 137px;
}
.product_single_wrap{
    border: 1px solid #000;
    margin-bottom: 10px;
    padding:10px;
    border-radius:10px;
}
    .product_single_wrap:hover{
        box-shadow: 2px 2px 2px rgb(255, 255, 255);
        background: #edecec;
        color:#000;
    }
     .pname{
        color:#fff;
    }
    .product_single_wrap:hover .pname{

        color:#000;
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
        
$('.wishlist_remover').on('click',function() {

            Swal.fire({
  title: 'Are you sure?',
  text: "You won't be able to revert this!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
if(result.isConfirmed == true){

          var product_id = $(this).data('product_id');
          
            $.ajax({
                url: "{{ route('remove_wishlist') }}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
                data: { pid: product_id }, // Replace with your data
                success: function(response) {
                    var gid = '#p'+product_id;
                    $(gid).remove();
                    $('.wsp_v').html(response[1]);
                   
                },
                error: function(error) {
                    console.log(error);
                    // Handle errors here
                }
            });

        }


if (result.isConfirmed) {
  Swal.fire(
    'Deleted!',
    'Your file has been deleted.',
    'success'
  )
}
})
        });
   
    })(jQuery)
    </script>
@endpush

