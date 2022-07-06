<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Address Label</title>
     <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
    <style>
     @media screen {
         p.bodyText {font-family:verdana, arial, sans-serif;}
      }

      @media print {
         p.bodyText {font-family:georgia, times, serif;}
      }
      @media screen, print {
         p.bodyText {font-size:40px}
      }   

      @media print {
    .pagebreak {
        clear: both;
        page-break-after: always;
    }
}
    </style>
</head>
<body onload="window.print()">
    <?php  if(!empty($print_data)){$i=0;
    foreach($print_data as $rows){ $i=$i+1; ?>
    <hr>
    <center>
 
 <!------------------------------1st Row Start-------------------------->
 
      
    <div style="width:97%; border:1px solid black">
    <table style="width:100%;border-bottom:2px solid black;">
        <tr>
            <th style="width:100%;font-size: 22px;font-family: 'Times New Roman', Times, serif;"><center><img src="https://tmdelex.com/cargo/assets/img/print_logo.png" width="100" height="52">T.M Cargo & Logistics</center></th>
        </tr>
<!-------------------------1st Row End----------------------------------->            
        <table style="width:100%;border-top:1px solid black;" class="table-bordered">
<!-------------------------2nd Row Start--------------------------------->        
        <tr>
            <td colspan="3" rowspan="2" style="width:32%;font-size: 25px;border:2px solid black;border-bottom:1px solid black;"><img  src="https://tmdelex.com/cargo/assets/barcode/cn/<?php echo $rows->order_code; ?>.png"  width="170" height="71"></td>
            
            <td  colspan="3"  style="width:32%;font-size: 15px;border-right:1px solid black;border-top:1px solid black;text-align:left;font-family: 'Times New Roman', Times, serif;" ><strong>Manual C.N #</strong></td>
        </tr>
        <tr>
           <td colspan="1"  style="width:40%;font-size: 18px;border-right:1px solid black;border-bottom:2px solid black;"><?php echo $rows->manual_cn; ?></td>
        </tr>
<!-------------------------2nd Row End----------------------------------->
<!-------------------------3rd Row Start--------------------------------->        
        <tr>
            <td colspan="3" rowspan="2" style="width:32%;font-size: 15px;border:2px solid black;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>&nbsp;Consignee Name</strong><br><span style="font-size: 25px; padding-left:10px;"><?php echo $rows->consignee_name; ?></span></td>
            
            <td colspan="3" style="width:32%;font-size: 15px;border-right:1px solid black;border-top:1px solid black;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>Destination</strong></td>
        </tr>
        <tr>
           <td colspan="1"  style="width:32%;font-size: 25px;border-bottom:2px solid black;font-family: 'Times New Roman', Times, serif;border-right:1px solid black;"><?php echo $rows->destination_city_name; ?></td>
        </tr>
<!-------------------------3rd Row End----------------------------------->
<!-------------------------4th Row Start--------------------------------->        
        <tr>
            <td colspan="3" rowspan="2" style="width:32%;border:2px solid black;font-size: 15px;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>&nbsp;<strong>Consignor Name</strong></strong><br><span style="font-size: 25px; padding-left:10px;"><?php echo $rows->shipper_name; ?></span></td>
            
            <td colspan="3" style="width:32%;font-size: 15px;text-align:left;font-family: 'Times New Roman', Times, serif;border-right:1px solid black;"><strong>Origin</strong></td>
        </tr>
        <tr>
           <td colspan="1"  style="width:32%;font-size: 25px;border-bottom:2px solid black;border-top:1px solid black;font-family: 'Times New Roman', Times, serif;border-right:1px solid black;"><?php echo $rows->origin_city_name; ?></td>
        </tr>
<!-------------------------4th Row End----------------------------------->
<!-------------------------5th Row Start--------------------------------->        
       <tr>
            <td   style="width:32%;font-size: 15px;border:2px solid black;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>&nbsp;NO. of Pcs</strong><br><span style="font-size: 25px; padding-left:10px;"><?php echo $rows->pieces; ?></span></td>
            <td  style="width:32%;font-size: 15px;border:2px solid black;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>Weight</strong><br><span style="font-size: 25px; padding-left:10px;"><?php echo $rows->weight; ?></span></td>
            <?php $time = new DateTime($rows->order_date);
                  $date = $time->format('Y-M-d');
                  $time = $time->format('H:i');
            ?>
            <td colspan="2" style="width:28%;font-size: 15px;border:2px solid black;border-top:1px solid black;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>Booking Date</strong><br><span style="font-size: 18px; padding-left:10px;"><?php echo $date; ?></span></td>
        </tr>
<!-------------------------5th Row End----------------------------------->
<!-------------------------6th Row Start--------------------------------->        
        <tr>
            <td colspan="3" rowspan="2" style="width:32%;font-size: 15px;border:2px solid black;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>&nbsp;Mode of Payment</strong><br><span style="font-size: 18px; padding-left:10px;"><?php echo $rows->order_pay_mode; ?></span></td>
            
            <td colspan="3" style="width:32%;font-size: 15px;border-right:1px solid black;border-top:1px solid black;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>COD</strong></td>
        </tr>
        <tr>
           <td colspan="1"  style="width:32%;font-size: 20px;border-bottom:2px solid black;border-right:1px solid black;"><?php echo $rows->cod_amount; ?></td>
        </tr>
<!-------------------------6th Row End----------------------------------->
<!-------------------------7th Row Start--------------------------------->        
        <tr>
            <td colspan="3" rowspan="2" style="width:32%;border:2px solid black;font-size: 15px;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>&nbsp;Service Type</strong><br><span style="font-size: 18px; padding-left:10px;"><?php echo $rows->service_name; ?></span></td>
            
            <td colspan="3" style="width:32%;font-size: 15px;border-right:1px solid black;border-top:1px solid black;text-align:left;font-family: 'Times New Roman', Times, serif;"><strong>Booking Person</strong></td>
        </tr>
        <tr>
           <td colspan="1"  style="width:32%;font-size: 18px;border-bottom:2px solid black;border-right:1px solid black;font-family: 'Times New Roman', Times, serif;"><?php echo $rows->createdby; ?></td>
        </tr>
<!-------------------------7th Row End----------------------------------->

        
        </table>    
    
         </table> 
        <table style="width:100%">
        <th style="width:100%;border:2px solid black;font-size: 14px;font-family: 'Times New Roman', Times, serif;"><center>The consignment is booked on shipper risk. Please don't accept if shippment is not intact.</center></th>
        </table>  
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
 </center>
<hr>
<hr>
    <center>
 <!------------------------------2nd Print End------------------------------------------>
<?php if($i==1){ ?>
<div class="pagebreak"></div>   
<?php $i=0;} } } ?>
</body>
</html>