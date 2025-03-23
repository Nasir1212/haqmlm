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
                <td>   <h1> Haq Multishop </h1>
                    <h3> Dhaka, Dhaka, Bangladesh</h3> </td>
                <td style="text-align: right">  
                    <img src="{{ asset('/assets/logo.png') }}" alt="">
                </td>
            </tr>
           </table>

     
        
       <table class="w-100">
        <tr>
            <td> <h5>Help-line:01963448468/01300901472</h5> </td>
            <td style="text-align: right">  
                <h5>Date:9/28/2023</h5> 
            </td>
        </tr>
       </table>
    

       <table class="w-100 mb-2">
        <tr>
            <td>  <div class="">Id: 05365</div>
                <div class="">Name: Haq</div>
                <div class="">Address: bogura</div></td>
            <td style="text-align: right">  
                <div class="">&nbsp;</div>
                    <div class="">Sponsor: mamun</div>
                    <div class="">call:025345523</div>
            </td>
        </tr>
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