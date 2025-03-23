@extends('layouts.Back.app')
@section('content')
<div class="card">
    <h4 class="px-4 pt-2">Product Stock Transfer Histories 
        @if ($gsd->id == 1)
        <a href="{{ route('product_stock_transfer_options') }}" class="btn btn-light mb-3 mb-lg-0"><i class='bx bxs-plus-square'></i>Sending option</a>
        @endif
       
    </h4>
    <div class="card-body">
        <div class="table-responsive">
        <table class="table mb-0 table-striped table-hover" style="width: 1500px">
            <thead class="table-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Action</th>
                    <th scope="col">Product Name</th>
                    <th scope="col">Sender Name</th>
                    <th scope="col">Receiver Name</th>
                    <th scope="col">Qty</th>
                    <th scope="col">Status</th>
                    <th scope="col">Created By</th>
                    <th scope="col">Created Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transfer_histories as $key => $transfer_history)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>
                            @if($transfer_history->status == "Pending")

                            @if($gsd->id != $transfer_history->sender_id)
                            <form action="{{ route('product_stock_transfer_status') }}" method="post" class="d-inline-block">
                                @csrf
                                <input type="hidden" name="id" value="{{ $transfer_history->id }}">
                                <input type="hidden" name="status" value="Accept">
                                <button type="submit" class="btn btn-success">Accept</button>
                            </form>
                            @endif

                            <form action="{{ route('product_stock_transfer_status') }}" method="post" class="d-inline-block">
                                @csrf
                                <input type="hidden" name="id" value="{{ $transfer_history->id }}">
                                <input type="hidden" name="status" value="Cancel">
                                <button type="submit" class="btn btn-warning">Cancel</button>
                            </form>
                            @if($gsd->id != $transfer_history->sender_id)
                            <form action="{{ route('product_stock_transfer_status') }}" method="post" class="d-inline-block">
                                @csrf
                                <input type="hidden" name="id" value="{{ $transfer_history->id }}">
                                <input type="hidden" name="status" value="Reject">
                                <button type="submit" class="btn btn-danger">Reject</button>
                            </form>
                            @endif
                            @else
                                No Action
                            @endif
                        </td>
                        <td>{{ $transfer_history->product->name }}</td>
                        <td>{{ $transfer_history->sender->name }}</td>
                        <td>{{ $transfer_history->receiver->name }}</td>
                        <td>{{ $transfer_history->qty }}</td>
                        <td>{{ $transfer_history->status }}</td>
                        <td>{{ $transfer_history->creator->name }}</td>
                        <td>{{ $transfer_history->created_at }}</td>
                    </tr> 
                @endforeach
            </tbody>
        </table>
    </div>
    </div>
</div>
@endsection