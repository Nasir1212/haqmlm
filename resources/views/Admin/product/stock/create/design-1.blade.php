@extends('layouts.Back.app')
@section('content')

  <div class="card">
      <div class="card-body p-4">
          <h5 class="card-title">Product Stock</h5>
          <hr/>
          <form action="{{ route('product_stock_store') }}" method="post">
            @csrf
            <div class="form-body mt-4">
              <div class="row">
                 <div class="col-lg-12">
                 <div class="border border-3 p-4 rounded">
                  <div class="mb-3">
                      <label for="product_qty" class="form-label">Product Qty <span class="text-danger">*</span></label>
                      <input type="number" class="form-control" name="product_qty" id="product_qty" placeholder="Enter product qty">
                  </div>  
            
                <div class="mb-3">
                    <label for="product_purchase_price" class="form-label">Product Purchase Price <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="product_purchase_price" id="product_purchase_price" placeholder="Enter product purchase price">
                </div> 
                
                <div class="mb-3">
                    <label for="product_sell_price" class="form-label">Product Sell Price <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="product_sell_price" id="product_sell_price" placeholder="Enter product sell price">
                </div> 
                <div class="mb-3">
                        <label for="product_brand" class="form-label">Product Brand </label>
                        <select name="brand" id="product_brand" onchange="product_get_with_brand_and_category()"  class="select-brand form-select form-control">
                            <option value="">Select Brand</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="product_category" class="form-label">Category</label>
                        <select name="category" id="product_category" onchange="product_get_with_brand_and_category()" class="select-category form-select form-control">
                          <option value="">Select Category</option>
                          @foreach ($categories as $category)
                          <option value="{{ $category->id }}">{{ $category->name }}</option>
                          @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                      <label for="supplier" class="form-label">Suppliers</label>
                     <textarea name="supplier"  class="form-control" id="supplier" cols="30" rows="5"></textarea>
                    </div>

                    <div class="mb-3">
                      <label for="products" class="form-label">Products</label>
                      <select name="product" id="products" class="single-select form-control form-select">
                        <option value="None">Select Product</option>
                      </select>
                    </div>
           
                  <div class="mb-3">
                    <label for="stock_type" class="form-label">Stock Type</label>
                    <select name="stock_type" id="stock_type" class="form-control form-select">
                      <option value="IN">In</option>
                      <option value="OUT">Out</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <div class="d-grid">
                       <button type="submit" class="btn btn-light">Stock</button>
                    </div>
                </div>
                  </div>
                 </div>
              
             </div><!--end row-->

          </form>
          
        </div>
      </div>
  </div>

@endsection
@push('css')
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/backend/plugins/select2/css/select2-bootstrap4.css') }}">
@endpush
@push('script')
<script src="{{ asset('assets/backend/plugins/select2/js/select2.min.js') }}" > </script>
<script src="{{ asset('assets/backend/plugins/select2/js/select2-custom.js') }}" > </script>
<script>
  $(document).ready(function() {
      $('.select-brand').select2({
          theme: 'bootstrap4'
      });
  }); 


  
  $(document).ready(function() {
      $('.select-category').select2({
          theme: 'bootstrap4'
      });
  });
  
  $(document).ready(function() {
      $('.single-select').select2({
          theme: 'bootstrap4'
      });
  });

</script>

@endpush
@push('script')
<script>

function product_get_with_brand_and_category(){
  var brand = $('#product_brand').val();
  var category = $('#product_category').val();
              $.ajax({
                      url: "{{ route('product__query') }}",
                      method: 'POST',
                      headers: {
                      'X-CSRF-TOKEN': "{{ csrf_token() }}"
                  },
                  data: { brand: brand, category:category }, // Replace with your data
                  success: function(response) {
                     
                      var dqreceiver = '#products';
    
                          var options = '';
                          var cts = '';
                          options +=`<option value="None">Select Product</option>`;
                          $.each(response, function (indexInArray, valueOfElement) { 
                              options +="<option value='"+valueOfElement.id+"'>"+(indexInArray+1) +" "+ valueOfElement.name+" Sell Price "+ valueOfElement.main_price+" </option>";
                              cts = indexInArray;
                          });

                          $(dqreceiver).html(options);
  
                          
                          // console.log(response);
                              
                          },
                          error: function(error) {
                              console.log(error);
                              // Handle errors here
                      }
                  });



}

</script>
@endpush