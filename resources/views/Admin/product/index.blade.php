@extends('layouts.Back.app')
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Product List</li>
			</ol>
			<!-- Breadcrumb end -->


		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-12">
				<div class="card h-100">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h4>Product List &nbsp; <a href="{{ route('product_create')}}" class="btn btn-info" >Add new</a> 
                            <form action="{{ route('product_list') }}" method="get" class="d-inline-block">
                                @csrf
                                <div class="btn-group">
                                    <input type="search" name="product_name" id="product_name" class="form-control" placeholder="product name search">
                                    <button type="submit" class="btn btn-info">Search</button>
                                </div>
                                
                            </form></h4>
                            <div>
                                	<div class="product-box">

									</div>
									<div class="realtime_msg"></div>
                            </div>
                            <table class="table custom-table table-bordered table-striped m-0">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Name</th>
                                        <th>Category Name</th>
                                        <th>Brand Name</th>
                                        <th>Sell Price</th>
                                        <th>Regular Price</th>
                                        <th>Point</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ( $products as $key => $data)
                                    <tr>
                                        <td>{{ $key + 1  }}</td>
                                        <td>{{ $data->name }}</td>
                                        <td>{{ $data->category?->name }}</td>
                                        <td>{{ $data->brand?->name }}</td>
                                        <td>{{ $data->main_price }}</td>
                                        <td>{{ $data->regular_price }}</td>
                                        <td>{{ $data->point }}</td>
                                        <td>
                                            @if ($data->status == 1)
                                                Active
                                            @else
                                                Disable
                                            @endif
                                            
                                        </td>
                                 
                                        <td>
                                            <a href="{{ route('product_edit',['id'=>$data->id])}}" class="btn btn-warning mb-3 mb-md-0">Edit</a>
                                            
                                            <a href="{{ route('product__remove',['id'=>$data->id])}}" class="btn btn-danger mt-2 remove-btn">Remove</a>
                                            
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                             <table> 
                             
                             {{ $products->links() }}
                        </div>  
                    </div>
					
				</div>
			</div>
		</div>

    
    </div>
@endsection
@push('css')
    <style>
        ul#products {
    border: 1px solid black;
    
}

ul#products .product {
    
    padding: 5px 10px;
}
ul#products .product:hover {
    background:#fff;
    color:#000;
 
}
    </style>
@endpush
@push('script')
<script>
'use strict';

(function($){
	
	$(document).on('click', 'ul#products .product', function () {
    $('#product_name').val($(this).data('product_name'));
    $('.product-box').html('');
});

      $('#product_name').on('keyup',function() {
            var product_name = $('#product_name').val();
              
              if(product_name == ''){
             
                var msg = "<h4 style='color:red;padding:10px'>Please input your product_name !</h4>";
                    $('.realtime_msg').html(msg);
              }else{
                $('.realtime_msg').html('');
              $.ajax({
                  url: '{{ route('product_name_get') }}',
                  method: 'POST',
				  dataType: 'json',
                  headers: {
                  'X-CSRF-TOKEN': '{{ csrf_token() }}'
              },
                  data: { product_name: product_name }, // Replace with your data
                  success: function(response) {
                  console.log(response);
                      var msg = response;
                 
                      $('.product-box').html(msg);
                
                  },
                  error: function(error) {
                      console.log(error);
                      // Handle errors here
                  }
              });
              }
              
          });
          
})(jQuery)
     
          
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const removeButtons = document.querySelectorAll('.remove-btn');

        removeButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                const confirmation = confirm('Are you sure you want to remove this product?');

                if (!confirmation) {
                    event.preventDefault();
                }
            });
        });
    });
</script>

@endpush
