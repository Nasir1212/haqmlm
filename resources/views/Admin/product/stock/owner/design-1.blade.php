@extends('layouts.Back.app')
@section('content')
<div class="card">
    <h4 class="px-4 pt-2">
        <div class="row">
            <div class="col-lg-3 col-xl-2">
                Product Stock
            </div>
            <div class="col-lg-9 col-xl-10">
                
                <div class="float-lg-end">
                    <div class="row row-cols-lg-auto g-2">
                        @if ($gsd->id == 1)
                        <div class="col-6">
                            <select name="dealer" id="dealer" class="single-select form-control form-select">
                                <option value="None">Select Dealer</option>
                                @foreach ($dealers as $dealer)
                                  <option value="{{ $dealer->id }}">{{ $dealer->name }} -- {{ $dealer->phone }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="position-relative">
                                <input type="search" class="form-control ps-5" id="product_search_text" placeholder="Search Product..."> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                            </div>
                        </div>

                            @else
                           
                            <div class="col-12">
                                <div class="position-relative">
                                    <input type="search" class="form-control ps-5" id="product_search_text" placeholder="Search Product..."> <span class="position-absolute top-50 product-show translate-middle-y"><i class="bx bx-search"></i></span>
                                </div>
                            </div>

                        @endif
                        
                        
                    </div>
                </div>
            </div>
        </div>
    </h4>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table mb-0 table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Owner Name</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Product Category</th>
                    <th scope="col">Qty</th>
                </tr>
            </thead>
            <tbody id="content_box">
                @foreach ($stocks as $key => $stock)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $stock?->owner?->name }}</td>
                        <td>{{ $stock?->product?->name }}</td>
                        <td>{{ $stock?->product?->category?->name }}</td>
                        <td @if ($gsd->id == 1) id="stockId_{{ $stock?->id  }}" onblur="save_change(this,{{ $stock?->id  }})" ondblclick="this.setAttribute('contenteditable', 'true'); this.focus();" @endif>{{ $stock?->qty }}</td>
                     
                    </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $('#dealer').on('change',()=>{
            product_query();
        });

      $('#product_search_text').keyup(function (e) { 
            product_query();
        })

        function product_query(){
@if ($gsd->id == 1)
var dealer_id = $('#dealer').val();
        var product_search_text = $('#product_search_text').val();
    @else

    var product_search_text = $('#product_search_text').val();
@endif
        

            $.ajax({
                        url: "{{ route('check_product_owner_raltime') }}",
                        method: 'POST',
                        headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    @if ($gsd->id == 1)
                    data: { id: dealer_id,product_name:product_search_text }, 

                    @else
                    data: { product_name:product_search_text }, 
                    @endif
                    success: function(response) {
                       
                           $('#content_box').html(response)
                            
                            },
                            error: function(error) {
                              
                                // Handle errors here
                        }
                    });
        }

        function save_change (e,id) {
            // alert('Double click to edit the stock quantity');
            // return false;
            // This function is called when the stock quantity is changed
            var qty = $('#stockId_' + id).text();
            $.ajax({
                url: "{{ route('update_product_stock') }}",
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                data: { id: id, qty: qty },
                success: function(response) {
                    // Optionally handle success response
                    console.log('Stock updated successfully');
                },
                error: function(error) {
                    // Handle errors here
                    console.error('Error updating stock:', error);
                }
            });
            e.setAttribute('contenteditable', 'false')
        }
    </script>
@endpush