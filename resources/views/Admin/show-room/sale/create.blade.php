@extends('layouts.Back.app')
@push('css')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
	<div class="main-container">
        	<!-- Page header start -->
		<div class="page-header">
			<!-- Breadcrumb start -->
			<ol class="breadcrumb">
				<li class="breadcrumb-item">Custom Order Creating Form</li>
			</ol>
			<!-- Breadcrumb end -->
		</div>
		<!-- Page header end -->
		<div class="row gutters">
			<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">

				<div class="card">
					<div class="card-body">
					    	<form action="{{ route('sell_make')}}" method="post" enctype="multipart/form-data">
							@csrf
					    <div class="row">
					        <div class="col-9">
					            		<div class="form-group">
								<label class="w-100 font-weight-bold mb-1" for="select_product">Select Product</label>
								<select class="form-control select2 select-form form-select text-dark" id="select_product" name="select_product">
								    <option value="">Select a Product</option>

    @foreach($products as $product)
    <option value="{{ $product->id }}" data-img-src="{{ config('app.url', 'Laravel').$product->img_name }}">{{ $product->name }} -- Price {{ $product->main_price }} -- Point {{ $product->point }}</option>
    @endforeach
</select>

							 
							</div>
							
							<div class="form-group">
								<label for="qty" class="w-100 font-weight-bold mb-1">Qty</label>
								<input type="number" class="form-control" placeholder="Enter quantity" id="qty" name="qty">
							</div>
							
						   <div class="form-group">
							 <button type="button" class="btn btn-success">Add Item</button>
							</div>
							<div class="show_add_products">
							    
							    
							    
							    
							</div>
					        </div>
					        <div class="col-3">
					            <div class="border p-3 mb-2">
					                <div> 
					                    Order Amount : 0/- 
					                
					                </div>
					                <div class="mt-1">
					                      Wallet Balance : 0/- 
					                </div>
					   
					                  <hr>
    					       <div class="form-group">
    								<label for="user_name" class="w-100 font-weight-bold mb-1">Customer Username</label>
    								<input type="text" class="form-control" placeholder="Enter customer username" id="user_name" name="user_name">
    								
    								
    							</div>
    					            
    					      
    					            
    					            
    					       <div class="form-group">
    								<label for="user_name" class="w-100 font-weight-bold mb-1">Payment method</label>
    									<select class="form-control " id="payment_method" name="payment_method">
								             <option value="Cash">Cash</option>
								              <option value="Wallet">Wallet</option>
								        </select>
    								
    								
    							</div>
    					            <div class="form-group">
    								<label for="pay_amount" class="w-100 font-weight-bold mb-1">Pay Amount</label>
    								<input type="text" class="form-control" placeholder="Enter amount to pay" id="pay_amount" name="pay_amount">
    								
    								
    							</div>
					                
					                
					            </div>
					           
    					            
    							<a href="{{ route('product_category_list')}}" class="btn btn-dark mt-1" >Back</a>
							
							
							
                            <button type="submit" class="btn btn-success">Confirm Order</button>
					        </div>
					    </div>
					</form>
					
						
					
                    </div>
				</div>

			</div>
		</div>
    </div>
@endsection

@push('script')

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>

$('.select2').select2({
    templateResult: formatProduct
});
$('.btn-success').on('click', function() {
    var selectedProduct = $('#select_product').find(':selected').text();
    var qty = $('#qty').val();
    
    if (selectedProduct && qty > 0) {
        var productRow = `<p>${selectedProduct} ---- Quantity : ${qty}</p>`;
        $('.show_add_products').append(productRow);
    } else {
        alert('Please select a product and enter a valid quantity.');
    }
});

function formatProduct(product) {
    if (!product.id) {
        return product.text;
    }
    var $product = $('<span><img src="' + $(product.element).data('img-src') + '" width="100"'+'"class="d-inline-block" /> ' + product.text + '</span>');
    return $product;
}

    $(document).ready(function() {
    $('#select_product, #qty').change(function() {
        var selectedProduct = $('#select_product').find(':selected');
        var price = selectedProduct.data('price');
        var qty = $('#qty').val();
        var total = price * qty;

        if (!isNaN(total)) {
            $('.order-amount').text('Order Amount: ' + total + '/-');
        }
    });
});
    
</script>


@endpush