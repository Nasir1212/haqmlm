<!doctype html>
<html lang="en">
  <head>
    <title>Report</title>
    <!-- Required meta tags -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <style>
        <?php include public_path() . '/assets/frontend/css/bootstrap.min.css'; ?>
       td,th{
            padding: 0px !important;
            font-size: 11px;
        }

        .table2 tr:last-child {
    /* border-bottom: none; */
    border-color: white;
    border-top: 2px solid black;
}

        .setting_company_second_rpt{
            margin-bottom: 0rem;
            padding-bottom: 0rem;
        }
        .company_address{
            font-size: 12px
        }
        @media screen and (max-width: 480px) {
            .setting_company_second_rpt{
                font-size: 16px;
            }

            .company_address{
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 0rem
            }

            .help_line{
                font-size: 11px;
            }

            .custom_justify_content_between{
                justify-content: space-between;
            }
            .invoice_title2{
                font-size: 12px;
            }
   
}

.print-button {
      background-color: #007bff; /* Primary blue color */
      border: none;
      color: white;
      padding: 5px 10px;
      font-size: 12px;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      box-shadow: 0 2px 4px rgba(0,0,0,0.2);
    }
    
    .print-button:hover {
      background-color: #0056b3; /* Darker blue on hover */
    }

    @media print {
      .print-button {
        display: none !important;
      }
    }
    </style>
    
  </head>
  <body class="container">
    <button class="print-button" onclick="window.print();">Print Page</button>
    <div class="w-80 m-auto border p-3 ">
        <div class="d-flex custom_justify_content_between">
        <div class="text-justify">
            <h1 style="margin-bottom: 0rem;
    padding-bottom: 0rem;">{{ $setting->company_name }}</h1>
            <h5 class="setting_company_second_rpt">{{ $setting->company_second_rpt}}</h5>
            <h6 class="company_address">{{ $setting->company_address}}</h6>
            <h6 class="help_line">Help Line : {{ $setting->company_helpline}}</h6>
        </div>
        <div>
            <img style="width: 45px;height: 45px; margin-left: 20px;" src="{{url('/storage/uploads/users/sq-logo.png')}}" alt="">
        </div>
        </div>
            <table class="table 1st_table">
                <tr>
                    <td  style="width: 112px;">
                        Username
                    </td>
                    <td  style="width:10px;">
        :
                    </td>
                    <td>
                          {{ $user->username }}
                    </td>
                </tr>
                <tr>
                    <td >
                        Name
                    </td>
                    <td  style="width:10px;">
                        :
                    </td>
                    <td>
                        {{ $user->name }}
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 10px;">
                        SP Username
                    </td>
                    <td style="width:10px;">
                        :
                    </td>
                    <td style="font-size: 10px;">
                          @isset($refer->id)
                        {{ $refer->username }}
                        @endisset 
                    </td>
                </tr>
                <tr>
                    <td style="font-size: 10px;">
                        SP Name
                    </td>
                    <td  style="width:10px;">
                        :
                    </td>
                    <td style="font-size: 10px;">
                        @isset($refer->id)
                        {{ $refer->name }}
                        @endisset 
                    </td>
                </tr>
                
            </table>
        <h6 class="text-center" style="font-size: 12px;font-weight:bold"> Affiliate Bonus Summery : {{   $ddt }}</h6>
            <table class="table table2">
                <thead>
                    <tr style="font-size: 25px; border:1px solid black">
                        <th>
                            Earning Type 
                        </th>
                       
                        <th style="transform: translateX(-10px);">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td  style="width:83%;">
                            Cashback Bonus
                        </td>
                        
                        <td>{{ RgetAmount(($monthly_income['DirectBonusTransaction']/0.90),2)}}</td>
                    </tr>
                    <tr>
                        <td  style="width:83%">
                            Sponsor  Bonus
                        </td>
                       
                        <td>{{ RgetAmount(($monthly_income['SpbTransaction']/0.90),2)}}</td>
                    </tr> 
                    <tr>
                        <td  style="width:60%;">
                            Working  Bonus
                        </td>
                        
                        <td>{{ RgetAmount(($monthly_income['WgbTransaction']/0.90),2)}}</td>
                    </tr> 
                    {{-- <tr>
                        <td>
                            Non working Generation Bonus
                        </td>
                        <td></td>
                        <td>{{ RgetAmount(($monthly_income['NwmtgTransaction']/0.90),2)}}</td>
                    </tr>  --}}
                    <tr>
                        <td  style="width:60%;">
                            Non Working Bonus
                        </td>
                      
                        <td>{{ RgetAmount(($monthly_income['NwmtbTransaction']/0.90),2)}}</td>
                    </tr> 
                    <tr>
                        <td  style="width:60%;">
                            CQY Bonus
                        </td>
                      
                        <td>0</td>
                    </tr>
                    <tr>
                        <td  style="width:60%;">
                           LQY Bonus
                        </td>
                       
                        <td>0</td>
                    </tr>
                    <tr>
                        <td  style="width:60%;">
                           OPP Achievement
                        </td>
                       
                        <td>0</td>
                    </tr>
                    <tr>
                        <td  style="width:60%;">
                           CRA Achievement
                        </td>
                       
                        <td>0</td>
                    </tr>
                    <tr>
                        <td  style="width:60%;">
                           Life Time Achievement 
                        </td>
                       
                        <td>0</td>
                    </tr>
                    <tr style="">
                        <td  style="width:60%;">
                         <div class="d-flex justify-content-between" style="width: 96%">
                            <p>
                               
                                 Charged  {{formatAmount(setting()->income_charge)}}%
                            </p>
                            <p><b style="font-size: 13px;"> Received :</b></p>
                         </div>
                        </td>
                       
                        <td><p style="width: 3rem; margin-bottom: 0;">                           
                            <strong style="font-size: 13px;">
                               {{calculateDiscountedValue(RgetAmount(($monthly_income['DirectBonusTransaction']/0.90),2)+ RgetAmount(($monthly_income['SpbTransaction']/0.90),2)+RgetAmount(($monthly_income['WgbTransaction']/0.90),2)+RgetAmount(($monthly_income['NwmtbTransaction']/0.90),2), setting()->income_charge) }}
                            </strong>
                            </p>
                             </td>
                    </tr>
                </tbody>
            </table>

            <table class="ml-4">
                <tr>
                    <td class="w-25 ml-2">
                        <table class="table ">
                            <tr style="">
                                <th>
                                    LSP
                                </th>
                            </tr>
                            <tr>
                               
                                <td class="text-center">@isset($pointhistory->point)
                                    {{ formatAmount($pointhistory->point) }}
                                @endisset  </td>
                            </tr>
                        </table>
                    </td>
                    <td></td>
                </tr>
            </table>

            <table class="w-100" style="transform: translateY(-48px);">
                <tr>
                    <td class="w-75"></td>
                  
                    <td class="w-25">
                        {{-- <hr> --}}
                        <h6 class="text-center" style="color: gray;">AC/Signature</h6>
                    </td>
                </tr>
            </table>
            <h5 class="text-center mt-4 lls invoice_title2">
              Use products from HMS  - Turn spending into income 
            </h5>
            <hr>
    </div>

    <script src="{{ asset('assets/backend/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/backend/js/bootstrap.bundle.min.js') }}"></script>
  </body>
</html>