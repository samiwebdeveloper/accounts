<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Arrival Sheet</title>
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
$total_weight="";
$total_pieces="";
if(!empty($sheet_data)){
foreach($sheet_data as $rows){
$sheet_code      = $rows->arrival_sheet_code;
$sheet_date      = $rows->arrival_date;
$user_name      = $rows->oper_user_name;
$account_no      = $rows->oper_account_no;
}} ?>
<body onload="window.print()">
 <img src="<?php echo base_url(); ?>assets/img/logo.png" width="172" height="85"><img src="<?php echo base_url(); ?>assets/barcode/arrivalscan/<?php echo $sheet_code; ?>.png" width="182" height="80" style="margin-left: 80%"><center><h1>Operations Arrival</h1></center>

 <h4 style="margin-left:55px;margin-top:20px">

 Arrival ID           : <?php echo $sheet_code; ?><br>
 Arrival Date & Time  : <?php echo $sheet_date; ?></h4>
<br>

<center><table width=90% border=1>
 <thead>
 <tr>
  <th><center>Sr.</center></th>
  <th><center>CN</center></th>
  <th><center>Refer#</center></th>
  <th><center>Pieces</center></th>
  <th><center>Weight</center></th>
  <th><center>Destination</center></th>
  <th><center>Date & Time</center></th>
 </tr> 
</thead>
<tbody>
<?php if(!empty($sheet_data)){
$i=0;
$total_weight=0; 
$total_pieces=0; 
foreach($sheet_data as $rows){
$i=$i+1;
$total_weight=$total_weight + $rows->order_weight;
$total_pieces=$total_pieces + $rows->order_pieces;
echo("<tr>");
echo("<td><center>".$i."</center></td>");
echo("<td><center>".$rows->order_code."</center></td>");
echo("<td><center>".$rows->customer_reference_no."</center></td>");
if($rows->new_pieces==0 ){
echo("<td><center>".$rows->pieces."</center></td>");
} else {
echo("<td><center>".$rows->new_pieces."</center></td>");
}
if($rows->new_weight==0 ){
echo("<td><center>".$rows->weight."</center></td>");
} else {
echo("<td><center>".$rows->new_weight."</center></td>");
}
echo("<td><center>".$rows->destination_city_name."</center></td>");
echo("<td><center>".$rows->order_arrival_date."</center></td>");    
}} ?>
</tbody>
</table>
<br>

<table width=90% border=1>
 <thead>
 <tr>
  <th>User Name</th>
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
  <th>Signature</th>
  <td></td>
  <th>Total Pieces</th>
  <td><center><?php echo $total_pieces; ?></center></td>
  </tr> 
 

</thead>
</table>
</center>
</body>
</html>