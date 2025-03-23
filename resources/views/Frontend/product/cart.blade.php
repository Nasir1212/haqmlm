@extends('layouts.Front.app')
@push('css')
<style>
    .product_wrap{
        padding: 20px;
        border: 1px solid #000;
        margin-bottom: 120px;
        margin-top: 12px;
        box-shadow: 0px 0px 4px rgb(28, 240, 9);
        border-radius: 3px;
        background:#10222e;
    }
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
       .product_wrapper {
        border: 1px solid #000;
        padding: 12px 16px;
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
        border: 1px solid #ededed;
        margin-bottom: 10px;
        padding:10px;
        border-radius:10px;
        color:#fff;
    }
     .pname{
        color:#fff;
    }
    .product_single_wrap:hover .pname{

        color:#000;
    }
    
     .product_single_wrap:hover{
        box-shadow: 2px 2px 2px rgb(255, 255, 255);
        background: #edecec;
        color:#000;
    }
   
    
    
    /* .btn{
        width: 12px;
        height:12px;
    } */
    </style>
@endpush
@section('content')
<div class="container">
    <h2 class="mt-4">Carts Product</h2>
   
	<div class="product_wrap">
        <div class="row" id='pwrp'>
            @if (!empty($cart_products))
            <?php $ic = 0; ?>
            @foreach ($cart_products as $data)
            <?php $ic++; ?>
            <div class="col-12" id="p{{$data->id}}">
                <div class="product_single_wrap">
                    <div class="row">
                          <div class="col-12">
                           <h4 class="pname">{{ $data->product->name }}</h4>
                           
                        </div>
                        <div class="col-12 col-md-4">
                            <img src="{{ asset($data->product->img_name) }}" class="img-fluid" alt="{{ $data->product->name}}">
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="">Price : {{ $data->product->main_price }} Tk/-</div>
                            <div class="">Point : {{ $data->product->point }}</div>
                            <div class="">Brand : {{ $data->product->brand->name }}</div>
                            <div class="">Category : {{ $data->product->category->name }}</div>
                        </div>
                        <div class="col-12 col-md-4 text-right">
                            
                           
                            <div class="qty_wrapper ">
                                <div class="h6">Product Quantity</div>
                                <button type="button"  data-target="{{ $data->id }}" class="addQty btn btn-sm btn-success"><i class="fa-solid fa-circle-plus"></i></button>
                                <input type="text" id="qty{{ $data->id }}" value="{{ $data->qty }}" class="border "  style="width:69px;padding:0px 5px">
                                <button type="button"  data-target="{{ $data->id }}" class="subQty btn btn-sm btn-danger"><i class="fa-solid fa-circle-minus"></i></button>
                            </div>
                            <a href="{{ route('frontend.product_details', ['slug'=>$data->product->slug])}}" class="details_link btn btn-xs btn-primary mt-2"><i class="fa-solid fa-eye"></i> Details</a>
                            <button type="button" class="btn btn-danger mt-2 cart_remover" data-product_id="{{ $data->id }}" ><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
            @if($ic > 0)
            <a href="{{route('checkout')}}" class="btn btn-success d-block ckout_btn">Checkout</a>
            @else
            <h4 class="text-light text-center"> Product not found</h4>
            @endif
            @endif
      
        </div>
    </div>
</div>

@endsection
@push('script')
<script>
'use strict';

    (function($){

        $('.qty').on('keyup',function () {
          
           // $('#passQty').val($(this).val());
        }); 
        
        
        $('.addQty').on('click',function () {
            var tg = '#qty'+$(this).data('target');
            var previnput =  $(tg).val();
            previnput = parseInt(previnput);
            var final = previnput +=1;
            $(tg).val(final);

            cart_update(final,$(this).data('target'));

           // $('#passQty').val(final);
            
        });

        $('.subQty').on('click',function () {
            var tg = '#qty'+$(this).data('target');
            var previnput =  $(tg).val();
            previnput = parseInt(previnput);
            if(previnput > 1){
                var final = previnput -=1;
              $(tg).val(final);
              cart_update(final,$(this).data('target'));
            }
            
        });

        var pc = {{$ic}};


            function cart_update(qty,cart_id){
               
            $.ajax({
                url: "{{ route('cart_update') }}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
                data: { id: cart_id, qty: qty }, // Replace with your data
                success: function(response) {
                   
                },
                error: function(error) {
                    console.log(error);
                    // Handle errors here
                }
            });
            }



        $('.cart_remover').on('click',function() {
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
                url: "{{ route('remove_cart') }}",
                method: 'POST',
                headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
                data: { id: product_id }, // Replace with your data
                success: function(response) {
                    var gid = '#p'+product_id;
                    $(gid).remove();
                    $('.cart_v').html(response[1]);
                    pc  -= 1;
                    if(pc == 0){
                    $('.ckout_btn').remove();
                    $('#pwrp').html('<h4 class="text-light text-center"> Product not found</h4>');
                    }
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
