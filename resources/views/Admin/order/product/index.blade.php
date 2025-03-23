@extends('layouts.Back.app') @section('content')
<div class="main-container">
    <!-- Page header start -->
    <div class="page-header">
        <!-- Breadcrumb start -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Product Order</li>
        </ol>
        <!-- Breadcrumb end -->
    </div>
    <!-- Page header end -->
    <form action="{{ route('product_order_confirm')}}" method="post">
        @csrf
    <div class="row gutters">
        <div class="col-12">
            <div class="card h-100">
                <div class="card-body">
                    <div>
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-8 ">
                                <div class="d-block my-3 px-4 py-2" style="box-shadow:0px 0px 1px">
                                    <div class="d-flex align-items-center">
                                        <input name="rMethod" type="radio" checked id="Office" value="Office" class="receiver_method" />
                                        <label class="receiver_method_label mx-2">Receive From Office</label>
    
                                        <input name="rMethod" type="radio" id="Courier" value="Courier" class="receiver_method" />
                                        <label class="receiver_method_label ml-2">Receive From Courier</label>
                                       
                                    </div>
                                </div>
    
                                <div class="sbf">
                                    <div class="shipping_option" style="display: none">
                                        <h4 class="mb-3">Shipping address | Editable</h4>
                                        <h5 class="mb-3">By Default Setup your Account Address</h5>
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="firstName">Full name</label>
                                                <input type="text" class="form-control" name="sp_name" id="firstName" placeholder="Full name" value="{{ $gsd->name}}" />
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="email">Email <span class="text-muted">(Optional)</span></label>
                                                <input type="email" class="form-control" name="sp_email" id="email" placeholder="you@example.com" value="{{ $gsd->email }}" />
                                            </div>
                                        </div>
        
                                        <div class="mb-3">
                                            <label for="address">Address</label>
                                            <input type="text" class="form-control" name="sp_address" placeholder="village, Upzila, District" id="address" value="{{ $user_address->city}}" />
                                        </div>
        
                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="phone">Phone Number</label>
                                                <input type="text" class="form-control" name="sp_phone" id="phone" placeholder="phone number" />
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="country">Country</label>
                                                <select class="custom-select d-block w-100" name="sp_country" id="country">
                                                    <option value="bangladesh">Banglaesh</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="state">State</label>
                                                <select class="custom-select d-block w-100" name="sp_state" id="sp_state">
                                                    @if ($user_address->state != '--')
                                                    <option value="{{$user_address->state}}">{{$user_address->state}}</option>
                                                    @endif
                                                    <option value="Dhaka">Dhaka</option>
                                                    <option value="Rajshahi">Rajshahi</option>
                                                    <option value="Khulna">Khulna</option>
                                                    <option value="Barishal">Barishal</option>
                                                    <option value="Chittagong">Chittagong</option>
                                                    <option value="Shylet">Shylet</option>
                                                    <option value="Mymensingh">Mymensingh</option>
                                                    <option value="Rangpur">Rangpur</option>
                                                </select>
                                            </div>
                                            
                                           
                                        </div>
                                        <hr />
                                  
                                    
                                    </div>
                              
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="payment_method mb-4">
                                                <span class="bg-white text-dark pl-3 py-2 border border-dark"> Current  Balance <span class="bg-dark text-white px-3 py-2">{{ $gsd->balance }} BDT</span></span>
                                            </div>
                                        <h4 class="mb-3">Payment</h4>
    
                                            <div class="d-block my-3">
                                                <div class="d-flex align-items-center">
                                                    <input name="paymentMethod" type="radio" id="cash_pay" value="Cash" class="h4" />
                                                    <label class="h4 mx-2">Cash</label>
            
                                                    <input name="paymentMethod" type="radio" checked id="wallet_pay" value="Wallet" class="h4" />
                                                    <label class="h4 ml-2">Wallet</label>
                                                    <a href="{{route('Deposit_form')}}" class="btn btn-info ml-5 border border-dark">Wallet Balance Add</a>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                 
                                </div>
                            </div>
                            <div class="col-12 col-md-4  mb-4">
                              <h4 class="d-flex justify-content-between align-items-center mb-3">
                                  <span class="text-muted">Your Product</span>
                                  <span>
                                    <button type="button" class="badge badge-success badge-rounded" id="addQty">+</button>
                                    <span class="badge badge-dark badge-rounded">Qty <span class="qty">1</span></span>
                                    <button type="button" class="badge badge-secondary badge-rounded" id="subQty">-</button>
                                  </span>
                                  
                              </h4>
                              <ul class="list-group mb-3">
                                  <li class="list-group-item d-flex justify-content-between lh-condensed">
                                      <div>
                                          <h6 class="my-0">{{ $product->name }} <span >Qty --- <span class="qty">1</span></span></h6>
                                      </div>
                                      <span class="text-muted p_price">{{ $product->main_price}}</span>
                                  </li>
                              </ul>
                              <button class="btn btn-primary btn-lg btn-block edit" data-toggle="modal" data-target="#preview_order_form" type="button">Preview Order</button>
                          </div>
                        </div>
                        <input type="hidden" id="product_main_price" value="{{ $product->main_price }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="modal fade" id="preview_order_form" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Preview Order Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
         
            <div class="modal-body preview_tbl">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Qty</th>
                            <th>Point</th>
                            <th>Total Point</th>
                            <th>Price</th>
                            <th>Total Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td id="pqty">1</td>
                            <td id="ppoint">{{ $product->point}}</td>
                            <td id="product_total_point">{{ $product->point}}</td>
                            <td id="pprice">{{ $product->main_price}}</td>
                            <td id="product_total_price">{{ $product->main_price}}</td>
                        </tr>
                        <tr id="shipping_cost_data">
                            <td colspan="5" class="text-right">Shipping Charge</td>
                            <td id="sp_cp">0</td>
                        </tr>
                        <tr class="border-t">
                            <td colspan="5" class="text-right">Gross Price = </td>
                            <td id="Gross_price">0</td>
                        </tr>
                    </tbody>
                </table>
          
            </div>
            <div class="modal-footer">
                <input type="hidden" id="product_qty" name="product_qty" value="1" />
                <input type="hidden" name="product_id" value="{{ $product->id }}" />
                <button type="submit"  class="btn btn-success" >Confirm Order</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
 
        </div>
  </div>
</div>
</div>
</form>
<style>
    .preview_tbl{
        overflow:scroll;
        width:100%;
    }
    .payment_method{
        font-size:20px;
    }
    .receiver_method_label{
        font-size:25px;
    }
    @media(max-width:767px){
        .payment_method{
        font-size:17px;
    }
    .receiver_method_label{
        font-size:18px;
    }
    }
</style>
@endsection @push('script')
<script>
    var picup = 'office';
$('#Office').on('click', function () {
    $('.shipping_option').css('display','none');
    picup = 'office';
});
$('#Courier').on('click', function () {
    $('.shipping_option').css("display", "block");
    picup = 'Courier';
});

  var billing_address_box = 0;
  var product_price = {{ $product->main_price }};
  var product_point = {{ $product->point }};
  
  var product_price_calc = {{ $product->main_price }};
  
  var product_qty = 1;
  var sp_daka_cost = 80;
  var sp_not_dhaka_cost = 130;

  var product_total_price = parseInt({{ $product->main_price }})+parseInt(sp_daka_cost);


  $('#addQty').on('click', function () {
    product_qty += 1;
    product_price_calc += product_price;
    product_total_price += product_price;
    
    $('.p_price').html(product_price_calc);
    $('.ptotal').html(product_total_price);
    $('.qty').html(product_qty);
    $('#product_qty').val(product_qty);


  });

  $('#subQty').on('click', function () {
    if(product_qty > 1){
      product_qty -= 1;
      product_price_calc -= product_price;
      product_total_price -= product_price;

    $('.ptotal').html(product_total_price);
    $('.p_price').html(product_price_calc);
    
      $('.qty').html(product_qty);
      $('#product_qty').val(product_qty);
    }
 
  });

   var csclick = 0;









    $('.edit').on('click', function () {
				var modal = $('#preview_order_form');
				modal.find('#pqty').html(product_qty);
				modal.find('#pprice').html(product_price);
				modal.find('#product_total_price').html(product_price_calc);
				
			   var ptpoint =	product_qty * product_point;
				
				modal.find('#product_total_point').html(ptpoint);
				
				
				// modal.find('#cond_name').val($(this).data('cond'));
				// modal.find('#atype').val($(this).data('am_type'));
				// modal.find('#c_id').val($(this).data('id'));
                if(picup == 'office'){
                    modal.find('#sp_cp').html(0);
                    modal.find('#Gross_price').html(product_price_calc);
                }else{
                    var jkl = $('#sp_state').val();
                    if(jkl == 'Dhaka'){
                        modal.find('#sp_cp').html(sp_daka_cost);
                        modal.find('#Gross_price').html(sp_daka_cost+product_price_calc);

                    }else{
                        modal.find('#sp_cp').html(sp_not_dhaka_cost);
                        modal.find('#Gross_price').html(sp_not_dhaka_cost+product_price_calc);
                    }
                    
                }
              
			
			})
	
</script>
@endpush
