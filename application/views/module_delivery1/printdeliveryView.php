<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Delivery Sheet</title>
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
         p.bodyText {font-size:60px}
      }   

      @media print {
    .pagebreak {
        clear: both;
        page-break-after: always;
    }
}
    </style>
</head>
<?php 
$sheet_code="";
$sheet_date="";
$sheet_rider="";
$sheet_rider_name="";
$sheet_route="";
$sheet_route_name="";
if(!empty($sheet_data)){
foreach($sheet_data as $rows){
$sheet_code       = $rows->delivery_code;
$sheet_date       = $rows->delivery_date;
$sheet_rider      = $rows->rider_code;
$sheet_rider_name = $rows->rider_name;
$sheet_route      = $rows->route_code;
$sheet_route_name = $rows->route_name;
$user_name        = $rows->oper_user_name;
$account_no       = $rows->oper_account_no;
$origin           = $rows->city_name;
}} ?>
<body onload="window.print()">
 <img src="<?php echo base_url(); ?>assets/img/tmlogo1.png" width="165" height="95"><img src="<?php echo base_url(); ?>assets/barcode/sheet/<?php echo $sheet_code; ?>.png" width="182" height="80" style="margin-left: 80%"><center><h1>Delivery Sheet Phase I</h1></center>

 <h4 style="margin-left:55px;margin-top:20px">

 Sheet Code           : <?php echo $sheet_code; ?><br>
 Date & Time          : <?php echo $sheet_date; ?><br>
 Rider                : <?php echo $sheet_rider." - ".$sheet_rider_name; ?><br>
 Route                : <?php echo $sheet_route." - ".$sheet_route_name; ?><br>
 Origin               : <?php echo $origin; ?>
</h4>
</h4>
<br>

<center><table width=90% border=1>
 <thead>
 <tr>
  <th><center>Sr.</center></th>
  <th><center>Consigee</center></th>
  <th><center>Detail</center></th>
  <th><center>Receiver Name</center></th>
  <th><center>Sign/Comment</center></th>
</tr> 
</thead>
<tbody>
<?php if(!empty($sheet_data)){
$i=0;
$total_weight=0;
$total_cod=0;
$total_pieces=0;
foreach($sheet_data as $rows){
$i=$i+1;
$total_weight = $total_weight +  $rows->weight;
$total_pieces = $total_pieces +  $rows->pcs;
if($rows->order_pay_mode=='ToPay' || $rows->order_pay_mode=='Topay'){
$total_cod = $total_cod +  $rows->COD;
} else {
$total_cod = $total_cod +  0;    
}
echo("<tr>");
echo("<td><center>".$i."</center></td>");
echo("<td><center>".$rows->order_code."<br>".$rows->manual." <br>".$rows->name."(".$rows->phone.")<br>".$rows->address."</center></td>");
echo("<td><center><b>Pieces&nbsp;</b>".$rows->pcs."<br><b>Weight&nbsp;</b>".$rows->weight." KG<br>");
if($rows->order_pay_mode=='ToPay' || $rows->order_pay_mode=='Topay'){
    echo("<b>FOD&nbsp;&nbsp;&nbsp;&nbsp;</b>");
    echo $rows->COD;
    } else {
  echo("<center>".""."</center></td>");
}

echo("<td><center>&nbsp</center></td>");
echo("<th><center>&nbsp</center></th>");
}} ?>
</tbody>
</table>
<br>

<table width=100% border=1>
 <thead>
 <tr>
  <th>Created By</th>
  <td><center><?php echo $user_name; ?></center></td>
  <th>Total Shipments</th>
  <td><center><?php echo $i;?></center></td>
  </tr>

  <tr>
  <th>Employee Code</th>
  <td><center><?php echo $account_no; ?></center></td>
  <th>Total Weight(Kg)</th>
  <td><center><?php echo $total_weight;?></center></td>
  </tr>
  <tr>
  <th>Employee Code</th>
  <td><center><?php echo $account_no; ?></center></td>
  <th>Total Pieces</th>
  <td><center><?php echo $total_pieces;?></center></td>
  </tr>
 
  <tr>
  <th>Operation Signature</th>
  <td></td>
  <th>Total FOD</th>
  <td><center>PKR <?php echo number_format($total_cod);?>/-</center></td>
  </tr>

</thead>
</table>
</center>
</body>
</html>