<?php
ob_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Invoice</title>
   
    <style>
        <?php include(public_path().'/assets/frontend/css/bootstrap.min.css');?>
        .plist td,th{
            padding: 10px;
        }
    </style>
    
</head>
<body>
    <div class="container">
        <table class="w-100 mb-3">
            <tr>
                <td>   <h1> {{ $setting->company_name }}</h1>
                    <h3> {{ $setting->company_address }}</h3> </td>
                <td style="text-align: right">  
                    <img src="{{ asset('/assets/logo.png') }}" alt="">
                </td>
            </tr>
           </table>

     
        
       <table class="w-100">
        <tr>
            <td> <h5>Help-line: {{ $setting->company_helpline }} </h5> </td>
            <td style="text-align: right">  
                <h5>Date: {{ $order->created_at }}</h5> 
            </td>
        </tr>
       </table>
    

       <table class="w-100 mb-2">
        <tr>
            <td>  <div class="">Id: {{$order->user->id }}</div>
                <div class="">Name: {{$order->user->name }}</div>
                <div class="">Address: {{ $user_address->city.' '.$user_address->state.' '.$user_address->country }}</div></td>
            <td style="text-align: right">  
                <div class="">&nbsp;</div>
                    <div class="">Sponsor: {{$order->user->sponsor->name }}</div>
                    <div class="">call:  {{$order->user->sponsor->phone }}</div>
            </td>
        </tr>
       </table>
       
        <table class="table border mt-2 plist m-0">
            <thead>
                <tr class="bg-dark text-light">
                    <th>SN</th>
                    <th>package Name</th>
                    <th>Qty</th>
                    <th>Unit PV</th>
                    <th>Unit Price</th>
                    <th>Total Pv</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @php
                $price =0;
                $total_price =0;
                $point =0;
                $total_point =0;
               
            @endphp
                @foreach($order->order_detail as $key=> $detail)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{$detail->package_id ? $detail->package->name:'' }}</td>
                    <td>{{$detail->qty}}</td>
                    <td>{{$detail->package->point ? $detail->package->point:0 }}</td>
                    <td>{{$detail->package->main_price ? $detail->package->main_price:0 }}</td>
                    <td>{{$detail->qty * ($detail->package->point ? $detail->package->point:0)}}</td>
                    <td>{{$detail->qty * ($detail->package->main_price ? $detail->package->main_price:0)}}</td>
                </tr>
                @php
                $price += ($detail->package->main_price ? $detail->package->main_price:0) * $detail->qty;
                $total_price += $price;
                $point += ($detail->package->point ? $detail->package->point:0) * $detail->qty;
                $total_point += $point;

            @endphp
                @endforeach
            </tbody>
            <tfoot class="bg-dark text-white">
                <tr >
                    <td colspan="2" style="text-align: right">Total Point Value =</td>
                    <td colspan="2">{{ $total_point }}</td>
                    
                    <td colspan="2" style="text-align: right">Total Amount =</td>
                    <td>{{ $total_price }}</td>
                </tr>
            </tfoot>
        </table>
<br>
<br>
<br>

        <div class="w-100 mt-4" style="text-align: right">
            <h2 class="d-inline-block ml-auto" style="width:150px;border-top:1px solid black;">Signature</h2>
        </div>

    </div>
   
   
</body>
</html>