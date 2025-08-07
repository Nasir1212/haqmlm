@extends('layouts.Back.app')
@section('content')
<div class="main-container">
    <!-- Page header start -->
    <div class="page-header">
        <!-- Breadcrumb start -->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">Product Orders  &nbsp; &nbsp;<button onclick="history.back()" class="btn btn-dark">Go Back</button></li>
        </ol>
        <!-- Breadcrumb end -->
    </div>
    <!-- Page header end -->
    <div class="row gutters">
        <div class="col-12 col-md-8">
            <div class="card h-100 w-100 p-3">
                <h4>Order Details</h4>
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="">Order Id #{{$order->id}}</div>
                        <div class="">{{$order->created_at}}</div>
                    </div>
                    <div class="col-12 col-md-6 text-right">
                        <a href="{{ route('generate_product_invoice', ['id'=>$order->id])}}" class="btn btn-info">Print Invoice</a>
                        @if(  $order->payment_status =='Unpaid')
                        <a href="{{ request()->fullUrl() }}?edit=ok" class="btn btn-info">Edit Invoice</a>
                        @endif
                    </div>
                </div>
                <div class="text-right my-4">
                    <div class="mb-1">Status: <span class="ods_confirm">{{$order->status}}</span></div>
                    <div class="mb-1">Payment Method : <strong>{{$order->payment_method}}</strong></div>
                    <div class="mb-1">Payment Status: <span class="ops_unpaid">{{$order->payment_status}}</span></div>
                </div>
                <div class="product_info_table">
                    @if(!is_null(request()->query('edit')) &&  $order->payment_status =='Unpaid')
                <form action="{{ route('product_order_confirm_edit') }} " method="POST">
                    @csrf
                    @endif
                <table class="table fz-12 table-hover table-borderless table-thead-bordered table-nowrap table-align-middle card-table w-100">
                    <thead class="thead-light thead-50 text-capitalize">
                        <tr>
                            <th>SL</th>
                            <th>Item Details</th>
                       
                            <th>Tax</th>
                            <th>Discount</th>
                            <th>Total Point</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $allptotal = 0;
                        $totalp = 0;
                        ?>
                        @foreach ($order->order_detail as $key => $odd)
                            
                     
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>
                                <div class="media align-items-center gap-10">
                                    <img class="avatar avatar-60 rounded" src="{{ asset($odd->product->img_name)}}" alt="{{$odd->product->name}}"/>
                                    <div>
                                        <h6 class="title-color">{{$odd->product->name}}</h6>
                                        <div><strong>Price :</strong> {{$odd->price}}/- TK</div>
                                        <div><strong>Point :</strong> {{ $odd->product->point}}</div>
                                        @if(!is_null(request()->query('edit')) &&  $order->payment_status =='Unpaid')
                                        <input type="hidden" name="prev_qty[]" value="{{$odd->qty}}">
                                        <input type="hidden" name="order_details_id[]" value="{{$odd->id}}">
                                        <input type="hidden" name="order_id[]" value="{{$odd->order_id}}">
                                        <input type="hidden" name="product_id[]" value="{{$odd->product_id}}">
                                        <input type="hidden" name="dealer_id[]" value="{{$order->dealer->user_id}}">
                                       
                                        <div><strong>Qty :</strong> <input type="text" class="form-control" name="qty[]" value="{{ $odd->qty }}"></div>
                                    @else
                                        <div><strong>Qty :</strong> {{ $odd->qty }}</div>
                                    @endif
                                       
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn--primary mt-2" title="File Upload" data-toggle="modal" data-target="#fileUploadModal-204" onclick="modalFocus('fileUploadModal-204')">
                                    <i class="tio-file-outlined"></i> File
                                </button>
                            </td>
                   
                            <td>0/- TK</td>
                            <td>0/- TK</td>
                            <td>{{ $odd->product->point * $odd->qty }}</td>
                            <td>
                                <?php  
                                    $totalp += $odd->product->point * $odd->qty;
                                    $allptotal += $odd->price * $odd->qty; ?>
                                {{ $odd->price * $odd->qty }}/- TK
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    @if(!is_null(request()->query('edit')))
                       <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td> 
                                <button class="btn btn-sm btn-success" type="submit">Update</button>
                             </td>
                        </tr>
                       </tfoot>
                    @endif
                </table>
                @if(!is_null(request()->query('edit')))
            </form>
         @endif
</div>
                <div class="row justify-content-md-end mb-3">
                    <div class="col-md-9 col-lg-8">
                        <dl class="row gy-1 text-sm-right">
                            <dt class="col-6 font-weight-normal">Shipping</dt>
                            <dd class="col-6 font-weight-normal title-color">
                                {{ $order->shipping_cost}}/- TK
                            </dd>
                            <dt class="col-6 font-weight-normal">Coupon discount</dt>
                            <dd class="col-6 font-weight-normal title-color">
                                - {{ $order->copun_value }}/- TK
                            </dd>
                            <dt class="col-6">Total Amount</dt>
                            <dd class="col-6 title-color">
                                <strong>{{ $allptotal + $order->shipping_cost - $order->copun_value}}/- TK</strong>
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="d-flex justify-content-between">
                    <div>Total Point {{ $totalp }}</div>
                    @if( $order->payment_status =='Unpaid')
                    <div>
                        <button  class="btn btn-sm btn-primary"  data-toggle="modal" data-target=".bd-example-modal-lg">Add Product</button>
                    </div>
                    @endif
                </div>
<hr style="color: white;background:white">
                <div class="row">
                    <form action="{{route('product_order_reconfirm')}}" method="POST">
                        <div id="selected_product_rebuy">

                        </div>
                       @csrf 
                    </form>
                </div>
                
            </div>
        </div>
       
        <div class="col-12 col-md-4">
            <div class="card h-100 w-100 p-2">
                @if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'order_manage') == 1|| is_dealer(auth()->user()->id) == true  )
                @if(get_dealer_id($order->user_id) == null && get_dealer_id(auth()->user()->id)?->id != get_dealer_id($order->user_id)?->id || (auth()->user()->id == 1 ))
                <div class="card">
                    <h4>Order & Shipping Info</h4>
                    <div class="mb-2">
                        @if( $order->status != 'Delivered' ) 
                        <label class="font-weight-bold title-color fz-14">Order Status</label>
                        <select name="order_status" onchange="order_status(this.value)" class="status form-control" data-id="{{ $order->id}}">
                            <option value="Pending"> Pending</option>
                            <option value="Confirmed" selected=""> Confirmed</option>
                            <option value="Processing">Packaging </option>
                            <option value="Out_for_delivery">Out for delivery </option>
                            <option value="Delivered">Delivered </option>
                            <option value="Returned"> Returned</option>
                            <option value="Failed">Failed to deliver </option>
                            <option value="Canceled">Canceled </option>
                        </select>
                        @endif
                    </div>
                    <div class="mb-2">
                          @if( $order->payment_status == 'Unpaid' )
                        <label class="font-weight-bold title-color fz-14">Payment Status</label>
                        <select name="payment_status" class="payment_status form-control" data-id="{{ $order->id }}">
                        <option value="Paid" {{ $order->payment_status == 'Paid' ? 'selected' : '' }}>Paid</option>
                        <option value="Unpaid" {{ $order->payment_status == 'Unpaid' ? 'selected' : '' }}>Unpaid</option>
                        </select>
                        @endif
                    </div>
                    
                    <div class="mb-2">
                        <label class="font-weight-bold title-color fz-14">Shipping Cost Update</label>
                        <input type="number" id="shipping_c" class="form-control" value="{{ $order->shipping_cost }}">
                        <button type="button" class="form-control mt-1" id="shipping_c_update">Shipping Cost Update</button>
                    </div>
                </div>
                @endif
                @endif

                <div class="card">

                    <div class="card-body">
                    <h4 class="mb-4 d-flex gap-2">
                    <img src="https://6valley.6amtech.com/public/assets/back-end/img/seller-information.png" class="mr-2">
                    Customer information
                    </h4>
                    <div class="media flex-wrap gap-3">
                    <div class="text-center">
                    <img class="avatar rounded-circle avatar-70" onerror="this.src='https://6valley.6amtech.com/public/assets/front-end/img/image-place-holder.png'" src="https://6valley.6amtech.com/storage/app/public/profile/2023-01-10-63bd4498b881c.png" alt="Image">
                    <span class="title-color text-center"><strong>{{ $order->user->username}}</strong></span>
                </div>
                    <div class="media-body d-flex flex-column gap-1">
                    
                    <span class="title-color"> <strong>{{ $order->user->name }}</strong></span>
                   
                    <span class="title-color break-all">{{ $order->user->phone}}</span>
                    <span class="title-color break-all">{{ $order->user->email}}</span>
                    <span class="title-color"> <strong>{{ count($order->order_detail) }}</strong> Orders</span>
                    </div>
                    </div>
                    </div>
                    
                    </div>
                  <div class="text-center">
                    <h3>Truking Id:</h3>
                    <strong class="text-success">{{ $order->trucking_code }}</strong>
                  </div>
                   
                       
            </div>
         
        </div>
    </div>
    <div class="row gutters mt-2">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                <h4 class="mb-4 d-flex gap-2">
                <img src="https://6valley.6amtech.com/public/assets/back-end/img/seller-information.png" class="mr-2">
                Shipping address
                </h4>
                @if ($order->shipping_address)
                <div class="d-flex flex-column gap-2">
                    <div>
                    <span>Name :</span>
                    <strong>{{ $order->shipping_address->contact_person_name}}</strong>
                    </div>
                    <div>
                    <span>Contact:</span>
                    <strong>{{ $order->shipping_address->phone }}</strong>
                    </div>
                    <div>
                    <span>City:</span>
                    <strong>{{ $order->shipping_address->city }}</strong>
                    </div>
                    <div>
                    <span>Zip code :</span>
                    <strong>{{ $order->shipping_address->zip }}</strong>
                    </div>
                    <div class="d-flex align-items-start gap-2">
                    <span>Address :</span>
                    <strong>{{ $order->shipping_address->address }}</strong>
                    </div>
                    </div>
                @endif
               
                </div>
                
                </div>
        </div>
       
    </div>
</div>
@if(  $order->payment_status =='Unpaid')

<div class="modal fade" id="payment_status" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Payment Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body"></div>
            <div class="modal-footer">
                <input type="hidden" id="product_qty" name="product_qty" value="1" />

                <button type="submit" class="btn btn-success">Confirm Order</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="delivery_status" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Delivery Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>

            <div class="modal-body"></div>
            <div class="modal-footer">
                <input type="hidden" id="product_qty" name="product_qty" value="1" />

                <button type="submit" class="btn btn-success">Confirm Order</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif
@if(  $order->payment_status =='Unpaid')

<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="card">
        <div class="card-header">
                <input class="form-control me-2" type="search" placeholder="Search Product by name" aria-label="Search"  onkeyup="search_product(this.value)">
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
            <h5>Select Product</h5>
             <div class="float-right">
                <button class="btn btn-sm btn-primary" onclick="handle_select_product(this)">Next</button>
            </div>
            </div>
            <div>
                <div class="row">
                 
                    @foreach ($products as $product)
                    @if($odd->product_id !=$product->id )
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card details_product_card_section" data-product="['{{ $product->id }}','{{ $product->name}}','{{ $product->main_price }}','{{ $order->dealer->user_id }}','{{ $product->img_name }}']" style="border: 1px solid white">
                            <div class="card-body">
                                <div>
                                    <img style="width: 200px;height:150px" src="{{ $product->img_name}}" alt="">
                                    {{-- <img style="width: 150px;height:150px " src="https://d2v5dzhdg4zhx3.cloudfront.net/web-assets/images/storypages/primary/ProductShowcasesampleimages/JPEG/Product+Showcase-1.jpg" alt=""> --}}
                                </div>
                                <p style="font-size: 12px;font-weight:bold">{{$product->name}}</p>
                                <h6>Price : <Strong>{{$product->main_price}} </Strong></h6>
                            </div>
                        </div>
                    </div>
                    @endif
               
                    @endforeach
                </div>
            </div>
        </div>
        <div class="card-footer ">
           
        </div>
      </div>
    </div>
  </div>
</div>
@endif

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.6/dist/sweetalert2.all.min.js"></script>
<link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/sweetalert2@10.10.1/dist/sweetalert2.min.css'>
<style>
  .product_info_table{
        overflow: auto;
       
    }
    .product_info_table table{

        width: 800px;
    }
    .ods_confirm {
        color: #00c9a7;
        background-color: rgba(0, 201, 167, 0.1);
    }
    .ops_unpaid {
        color: rgb(226, 226, 226);
        background: rgb(36, 36, 36);
    }

    .details_product_card_section{
        cursor: pointer;
    }
    /* .details_product_card_section:hover{
        opacity: 0.6;
    } */
    .buy{
        opacity: 0.4;
    }
</style>
@if (auth()->user()->id == 1 || permission_checker($gsd->role_info,'order_manage') == 1|| is_dealer(auth()->user()->id) == true)

<script>
 $(document).on('click', '#shipping_c_update', function () {
        
        var value = $('#shipping_c').val();
        Swal.fire({
            title: 'Are you sure Change this?',
            text: "You will not be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#377dff',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes  Change it!'
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                $.ajax({
                    url: "{{ route('product_order_shipping_cost_change')}}",
                    method: 'POST',
                    data: {
                        "id": '{{ $order->id}}',
                        "amount": value
                    },
                    success: function (data) {
                        Swal.fire({
                            title: 'shipping cost Operation',
                            text: data.success,
                        
                        });
                                setTimeout(() => {
                        window.location.reload();
                    }, 1000); // Delay of 1 second
                            
                        
                    },
                error: function (xhr, status, error) {
                    Swal.fire({
                            title: 'Error',
                            text: 'Failed to change status: ' +error,
                        
                        });
                }
                });
            }
        })
    });

    $(document).on('change', '.payment_status', function () {
        var id = $(this).attr("data-id");
        var value = $(this).val();
        Swal.fire({
            title: 'Are you sure Change this?',
            text: "You will not be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#377dff',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes  Change it!'
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                $.ajax({
                    url: "{{ route('product_order_payment_status_change')}}",
                    method: 'POST',
                    data: {
                        "id": id,
                        "payment_status": value
                    },
                    success: function (data) {
                             Swal.fire({
                            title: 'Payment Operation',
                            text: data.success,
                        
                        });
                                setTimeout(() => {
                     //   window.location.reload();
                    }, 1000); // Delay of 1 second
                            
                        
                    },
                        error: function (xhr, status, error) {
                    Swal.fire({
                            title: 'Error',
                            text: 'Failed to change status: ' +error,
                        
                        });
                }
                });
            }
        })
    });

    function order_status(status) {
                    Swal.fire({
            title: 'Are you sure Change this?',
            text: "You will not be able to revert this!",
            showCancelButton: true,
            confirmButtonColor: '#377dff',
            cancelButtonColor: 'secondary',
            confirmButtonText: 'Yes  Change it!'
        }).then((result) => {
            if (result.value) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                });
                $.ajax({
                    url: "{{ route('product_order_status_change')}}",
                    method: 'POST',
                    data: {
                        "id": '{{ $order->id}}',
                        "order_status": status
                    },
                    success: function (data) {
                        Swal.fire({
                            title: 'Order status Operation',
                            text: data.success,
                        
                        });
                                setTimeout(() => {
                     //   window.location.reload();
                    }, 1000); // Delay of 1 second

                    },
                      error: function (xhr, status, error) {
                    Swal.fire({
                            title: 'Error',
                            text: 'Failed to change status: ' +error,
                        
                        });
                }
                });
            }
        })
                }

      
</script>
@endif

<script>
      document.addEventListener("DOMContentLoaded", function() {
        const productCards = document.querySelectorAll('.details_product_card_section');
        productCards.forEach(card => {
        card.addEventListener('click', function() {
        this.classList.toggle('buy');
        });
        });
        });

        function handle_select_product(e){
            let temp = ``;
            
            const buy = document.querySelectorAll('.buy');
            let productArray = [];
        buy.forEach(b => {
         let data = b.getAttribute('data-product');
         let parseData = JSON.parse(data.replace(/'/g, '"'));
         console.log(parseData[0]);
         
         temp += `
         <div class="d-flex" id="single_product_list_${parseData[0] }" >
                <div class=" col-6">
                    <img style="width:200px;height:100px" src="${parseData[4]}" alt="">
                    <h5>${parseData[1]}</h5>
                    
                </div>
                <div class=" col-2">
                    <label for="" class="form-label">Price</label>
                    <input type="text" class="form-control" name="price[]" value="${parseData[2]}" readonly  >
                    <input type="hidden" class="form-control" name="id[]" id="" value="${parseData[0]}" readonly  >
                    <input type="hidden" class="form-control" name="dealer_id[]"  value="${parseData[3]}" readonly  >
                    <input type="hidden" class="form-control" name="order_id[]"  value="{{ request()->segment(2) }}" readonly  >
                </div>
                <div class=" col-2">
                    <label for="" class="form-label">Qty</label>
                    <input type="text" class="form-control" name="qty[]" value="1" placeholder="Enter Qty" >
                </div>
                <div class="col-2 mt-3">

                    <button type="button" onclick="close_single_product_list(this,${parseData[0]})" class="btn btn-danger">x</button>
                </div>
        </div>
        <hr class="single_product_list_${parseData[0] }" style="border-top: 1px solid white";/>
         
         `;
        });
        document.getElementById('selected_product_rebuy').innerHTML = temp+=`
        <div class="float-right">
          <button type="submit" class="btn btn-primary">Submit</button>
          </div>
        `;
        console.log(temp)
        $('.bd-example-modal-lg').modal('hide');
        }

        
        function close_single_product_list(e,id){
            document.getElementById(`single_product_list_${id}`).remove();
            document.querySelector(`.single_product_list_${id}`).remove();

        }
function search_product(value) {
    const searchValue = value.toLowerCase();
    const cards = document.querySelectorAll('.details_product_card_section');

    cards.forEach(card => {
        const productName = card.querySelector('p').textContent.toLowerCase();

        if (productName.includes(searchValue)) {
            card.parentElement.style.display = ''; // show
        } else {
            card.parentElement.style.display = 'none'; // hide
        }
    });
}

</script>


@endsection
