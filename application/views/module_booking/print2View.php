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
    <div style="width:92%; border:1px solid black">
    <table style="width:100%;border-bottom:1px solid black">
        <td style="width:17%;border-right:1px solid black"><center><img src="<?php echo base_url(); ?>assets/img/logo.png" width="172" height="85"></center></td>
        <td style="width:60%">
        <table style="width:100%;border-top:1px solid black" class="table-bordered">
        <tr>
            <th style="width:14%;border-right:1px solid black">&nbsp;Date</th>
            <?php $time = new DateTime($rows->order_date);
                  $date = $time->format('Y-m-d');
                  $time = $time->format('H:i');
            ?>
            <td style="width:32%;"><?php echo $date; ?></td>
            <th style="width:22%;">&nbsp;Time</th>
            <td style="width:32%;"><?php echo $time; ?></td>
            
        </tr> 

     
         <tr>
            <th>&nbsp;Service</th>
            <td><?php echo $rows->service_name; ?></td>
            <th>&nbsp;Origin</th>
            <td><?php echo $rows->origin_city_name; ?></td>
        </tr> 
         <tr>
            <th>&nbsp;Shipper</th>
            <td><?php $name=substr($rows->customer_name, 0, 4);
            if($name!="SAIM"){
            echo $result = $rows->customer_name; 
            } else {
            echo $result = "Shopping Asaan"; 
            }
            ?></td>
            <th>&nbsp;Destination</th>
            <td><?php echo $rows->destination_city_name; ?></td>
        </tr> 
         <tr>
            <th>&nbsp;Pieces</th>
            <td><?php echo $rows->pieces; ?></td>
            <th>&nbsp;Weight (Kg)</th>
            <td><?php echo $rows->weight; ?></td>
        </tr>
         <tr>
            <th>&nbsp;COD</th>
            <td><?php echo $rows->cod_amount; ?></td>
            <th>&nbsp;Customer Ref</th>
            <td><?php echo $rows->customer_reference_no; ?></td>
        </tr>    
        </table>    
        </td>
        <td style="width:17%;border-left:1px solid black"><center><img src="<?php echo base_url(); ?>assets/barcode/cn/<?php echo $rows->order_code; ?>.png"  width="155" height="61"></center></td>
    </table> 
       <table style="width:100%">
        <tr style="height:100px">
        <th style="width:18.9%;border-right:1px solid black"><center>Consignee</center></th>
        <td style="width:61.5%">&nbsp;<?php echo $rows->consignee_name; ?><br>&nbsp;<?php echo $rows->consignee_address; ?><br>&nbsp;<?php echo $rows->consignee_mobile; ?></td>
        <td style="width:21.5%"><center><img src="<?php echo base_url(); ?>assets/Delex.pk.png"  width="80" height="80"></center></td>
        </tr>
        </table>  

        <table style="width:100%;border-top:1px solid black">
        <th style="width:18.8%;border-right:1px solid black"><center>Product Detail</center></th>
        <td style="width:30%">&nbsp;<?php echo $rows->product_detail; ?></td>
        <th style="width:10%;border-left:1px solid black"><center>Remarks</center></th>
        <td style="width:40%;border-left:1px solid black">&nbsp;<?php echo $rows->order_remark; ?></td>
        </table>  
        <?php if($_SESSION['customer_id']=='412'){ ?>
        <table style="width:100%">
        <th style="width:100%;border-top:1px solid black"><center>Shipper Address : F-441 A , near girls degree college , Site Area, Karachi (02138402072)</center></th>
        </table>  
        <?php } ?>
        <table style="width:100%">
        <th style="width:100%;border-top:1px solid black"><center>Please don't accept if shippment is not intact. Before paying the COD, shippment can not be opened.</center></th>
        </table>  
    </div>
 </center>
<hr>
<?php if($i==4){ ?>
<div class="pagebreak"></div>   
<?php $i=0;} } } ?>
</body>
</html>