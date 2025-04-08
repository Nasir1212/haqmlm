<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="UTF-8">
    <title>Invoice</title>
   
    <style>
        <?php include(public_path().'/assets/frontend/css/bootstrap.min.css');?>
    
        .plist td,th{
            padding: 10px;
             border:1px solid #878585;
        }

        .plist th {
            color: #000000;
        }
        
        tr:nth-child(even) {
            background: #e5faff;
        }

        .inv_title{
            font-size:23px;
        }
        .inv_address{
            font-size:13px;
        }
        .inv_company_name{
            font-weight:1000;
            margin-bottom:3px
        }
        .inv_help_line{
            font-size: 19px;
        }
        .inv_img{
            width:100px;
        }
        @media (max-width: 576px) {
            .inv_title{
            font-size: 13px;
            margin: 0;

            }

            .inv_company_name{
            font-size: 22px;
            margin-bottom:0px
            }
            .inv_help_line{
            font-size: 13px;
            margin-bottom: 0px;
            }

            .inv_address{
            font-size: 7px;
            font-weight: bold;
            margin: 0;
            padding: 0;
            }

            .inv_img{
            width: 65px;
            }

            .inv_user_data .user_id, .inv_user_data .name, .inv_user_data .address, .inv_user_data .text-primary {
            font-size: 12px;
            margin: 0px;
            }

            .inv_order_info h6 {
            font-size: 10px;
            }


            .inv_order_table td, .inv_order_table th {
            font-size: 9px;
            }

            .inv_user_data .address  {
            font-size: 9px;

            }

         }
        
    </style>

    <script>
        function handlePrint() {
            // Hide the buttons before printing
            document.getElementById('print-buttons').style.display = 'none';

            // Trigger print
            window.print();

            // Show the buttons again after printing
            setTimeout(() => {
                document.getElementById('print-buttons').style.display = 'block';
            }, 100);
        }
    </script>
</head>
<body>
    <div class="container">
        <div class="w-100 tex-tright mt-3" id="print-buttons">
              <button onclick="handlePrint()" class="btn btn-info">Print</button>
                    <a href="{{ route('generate_product_invoice_download', ['id'=>$order->id])}}" class="btn btn-info">Download</a>
            
        </div>
                          
        <table class="w-100 mb-0">
            <tr>
                <td>   
                    <h1 style="" class="inv_company_name">{{ $setting->company_name }}</h1>
                    <h5 style="" class="inv_title"><strong>Off/Online Digital Affiliate Shop</strong></h5>
                    <h5 style="" class="inv_address">{{ $setting->company_address }}</h5> 
                    <h4 style="" class="inv_help_line"><strong>Help-line: {{ $setting->company_helpline }}</strong></h4>
                </td>
                <td style="text-align: right">  
                    <img class="inv_img" src="{{ asset('/assets/logo.png') }}" style="">
                </td>
            </tr>
        </table>

        <table class="w-100 mb-2 inv_user_data">
            <tr>
                <td>
                    {{-- {"house_holding":null,"country":"--","city":"--","state":"--","upzila":null,"village":null,"zip_code":null} --}}
                    <div class="user_id"><strong>User ID: {{$order->user->username }}</strong></div>
                    <div class="name"><strong>Name: {{$order->user->name }}</strong></div>
                    <div class="address"><strong>Address: {{ $user_address->village.' '.$user_address->zip_code.' '.$user_address->upzila .' '.$user_address->city }}</strong></div>
                    <div class="text-primary"><strong>www.haqmultishop.com</strong></div>
                </td>
                <td style="text-align: right" class="inv_order_info" >  
                    <br>                    
                    <h6 class="text-dark"> #{{ $order->id }}</h6>
                   
                    <h6 class="text-dark">{{ $order->created_at }}</h6>
               
                     <h6 class="text-primary">Call - {{$order->user->phone }}</h6>
                          
                </td>
            </tr>
        </table>
       
        <table class="table border mt-2 plist m-0 inv_order_table">
            <thead>
                <tr class="bg-light" style="color:#000 !important">
                    <th>S/N</th>
                    <th>Products Name</th>
                    <th style="text-align:center">Qty</th>
                    <th style="text-align:center">Price</th>
                    <th style="text-align:center">PV</th>
                      <th style="text-align:center">Total Pv</th>
                  
                    <th  style="text-align:center">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total_price = 0;
                $total_point = 0;
                @endphp
                @foreach($order->order_detail as $key => $detail)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $detail->product_id ? $detail->product->name : '' }}</td>
                    <td style="text-align:center">{{ $detail->qty }}</td>
                    <td style="text-align:center">{{ getAmount($detail->product->main_price ?? 0) }}</td>
                    <td style="text-align:center">{{ $detail->product->point ?? 0 }}</td>
                    <td style="text-align:center">{{ $detail->qty * ($detail->product->point ?? 0) }}</td>
                    
                    <td  style="text-align:center">{{ getAmount($detail->qty * ($detail->product->main_price ?? 0)) }}</td>
                </tr>
                @php
                $total_price += ($detail->product->main_price ?? 0) * $detail->qty;
                $total_point += ($detail->product->point ?? 0) * $detail->qty;
                @endphp
                @endforeach
            </tbody>
            <tfoot style="background:#e3e3e3">
                <tr>
                    <td colspan="2" style="font-weight:900;text-align: left;color:blue">Total Points = {{ $total_point }} </td>
                    
                   {{--- <td colspan="0"  style="text-align:center"><strong style="font-style:italic" >{{ $total_point }}</strong></td>---}}
                    
                    <td colspan="5" style="font-weight:900;text-align: right;color:blue"> Total  Amount = {{ $total_price }}</td>
                  {{---  <td    style="text-align:center"><strong style="font-style:italic" >{{ $total_price }}</strong></td>---}}
                </tr>
            </tfoot>
        </table>
        
        <br><br><br>
        <div class="w-100 mt-4" style="text-align: right">
            <h6 class="d-inline-block ml-auto" style="width:150px;color:#7674746b;">Signature</h6>
        </div>
    </div>
</body>
</html>
