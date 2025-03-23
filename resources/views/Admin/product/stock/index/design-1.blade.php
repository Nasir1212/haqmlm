@extends('layouts.Back.app')
@section('content')
<div class="main-container">
<div class="card">
    <h4 class="px-4 pt-2">Product Stock History <a href="{{ route('product_stock_option') }}" class="btn btn-light mb-3 mb-lg-0"><i class='bx bxs-plus-square'></i>Add New</a></h4>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table mb-0 table-striped table-hover" style="width: 2000px">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Product Name</th>
                    {{-- <th scope="col">Owner Name</th> --}}
                    <th scope="col">Supplier Name</th>
                    <th scope="col">Stock Type</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Purchase Price</th>
                    <th scope="col">Sell Price</th>
                    <th scope="col">Purchase Total</th>
                    <th scope="col">Sell Total</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Created Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stocks as $key => $stock)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $stock->product->name }}</td>
           {{-- /             <td>{{ $stock->owner->name }}</td> --}}
                        <td>{{ $stock->supplier }}</td>
                        <td>{{ $stock->stock_type }}</td>
                        <td>{{ $stock->qty }}</td>
                        <td>{{ getAmount($stock->purchase_price) }}/-</td>
                        <td>{{ getAmount($stock->sell_price) }}/-</td>
                        <td>{{ getAmount($stock->purchase_price * $stock->qty) }}/-</td>
                        <td>{{ getAmount($stock->sell_price * $stock->qty) }}/-</td>
                        <td>{{ $stock->creator->name }}</td>
                        <td>{{ $stock->created_at }}</td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>
</div>
@endsection