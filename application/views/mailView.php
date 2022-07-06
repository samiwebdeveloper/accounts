<html>
<head>    
<title>Daily Booking Report <?php  $date_raw=date('Y-m-d');
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
<h1>Not Delivered CNS <?php echo $rdate; ?></h1>
<table>
<tr>
<th>CN</th>
<th>Status</th>
<th>COD</th>
<th>Name</th>
<th>Phone</th>
<th>Destination</th>
<th>Delivery Sheet</th>
<?php
$total_orders=0;
$total_cod=0;
foreach($report_data as $rows){
$total_orders=$total_orders + 1;
$total_cod=$rows->amount + $total_cod;
echo("<tr>");
echo("<td>".$rows->order_code."</td>");
echo("<td>".$rows->order_status."</td>");
echo("<td>".number_format($rows->amount)."/-</td>");
echo("<td>".$rows->consignee_name."</td>");
echo("<td>".$rows->consignee_mobile."</td>");
echo("<td>".$rows->city."</td>");
echo("<td>".$rows->on_route_id."</td>");
echo("</tr>");
}
echo("<tr>");
echo("<td>$total_orders</td>");
echo("<th></th>");
echo("<th>".number_format($total_cod)."/-</th>");
echo("<th></th>");
echo("<th></th>");
echo("<th></th>");
echo("<th></th>");
echo("</tr>"); ?>
</table>




</body>
</html>