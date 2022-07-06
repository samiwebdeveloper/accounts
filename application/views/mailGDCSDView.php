<html>
<head>    
<title>Daily Delivered CN Report <?php  $date_raw=date('Y-m-d');
echo date('Y-m-d', strtotime('-1 day', strtotime($date_raw))); ?></title> 
<style>
table, td, th {  
  border: 1px solid #ddd;
  text-align: left;
}

table {
  border-collapse: collapse;
  width: 90%;
}

th, td {
  padding: 10px;
}
</style>
</head>
<body>
<h1>New Delivered CNS <?php echo $rdate; ?></h1>
<table>
<tr>
<th style="width:33%">Destination</th>
<th style="width:33%">Shipments</th>
<th style="width:33%">COD</th>
<?php
$total_orders=0;
$total_cod=0;
foreach($report_data as $rows){
$total_orders=$rows->shipments + $total_orders;
$total_cod=$rows->amount + $total_cod;
echo("<tr>");
echo("<td>".$rows->city."</td>");
echo("<td>".$rows->shipments."</td>");
echo("<td>".number_format($rows->amount)."/-</td>");
echo("</tr>");
}
echo("<tr>");
echo("<td></td>");
echo("<td>".$total_orders."</td>");
echo("<th>".number_format($total_cod)."/-</th>");
echo("</tr>"); ?>
</table>
<h1>Old Delivered CNS <?php echo $rdate; ?></h1>
<table>
<tr>
<th style="width:33%">Destination</th>
<th style="width:33%">Shipments</th>
<th style="width:33%">COD</th>
<?php
$ototal_orders=0;
$ototal_cod=0;
foreach($old_report_data as $rows){
$ototal_orders=$rows->Shipment + $ototal_orders;
$ototal_cod=$rows->Amount + $ototal_cod;
echo("<tr>");
echo("<td>".$rows->City."</td>");
echo("<td>".$rows->Shipment."</td>");
echo("<td>".number_format($rows->Amount)."/-</td>");
echo("</tr>");
}
echo("<tr>");
echo("<td></td>");
echo("<td>".$ototal_orders."</td>");
echo("<th>".number_format($ototal_cod)."/-</th>");
echo("</tr>"); ?>
</table>
<table>
<tr>
<th style="width:33%">Destination</th>
<th style="width:33%"><?php echo ($ototal_orders + $total_orders);?></th>
<th style="width:33%"><?php echo number_format($ototal_cod + $total_cod);?>/-</th>
</tr>
</table>



</body>
</html>