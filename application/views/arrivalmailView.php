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
<h1>Daily Arrival Report <?php  $date_raw=date('Y-m-d');
echo date('Y-m-d', strtotime('-1 day', strtotime($date_raw))); ?></h1>
<table>
<tr>
<th>Date</th>    
<th>City</th>
<th>Arrival CN</th>
<th>SC</th>
<th>COD</th>
<th></th>
<th>Tilldate CN</th>
<th>Tilldate SC</th>
<th>Tilldate COD</th>
<?php
$total_current_arrival=0;
$total_current_sc=0;
$total_current_cod=0;
$total_arrival=0;
$total_cod=0;
$total_sc=0;
foreach($report_data as $rows){
$total_current_arrival=$total_current_arrival + $rows->Arrival;
$total_current_sc=$total_current_sc + $rows->SC;
$total_current_cod=$total_current_cod + $rows->COD;
$total_arrival=$total_arrival + $rows->TodayDateCN;
$total_cod=$total_cod + $rows->TodayDateCOD;
$total_sc=$total_sc + $rows->TodayDateSC;
echo("<tr>");
echo("<td>".$rows->Date."</td>");
echo("<td>".$rows->Origin."</td>");
echo("<td>".$rows->Arrival."</td>");
echo("<td>".number_format($rows->SC)."/-</td>");
echo("<td>".number_format($rows->COD)."/-</td>");
echo("<td></td>");
echo("<td>".$rows->TodayDateCN."</td>");
echo("<td>".number_format($rows->TodayDateSC)."/-</td>");
echo("<td>".number_format($rows->TodayDateCOD)."/-</td>");
echo("</tr>");
}
echo("<tr>");
echo("<td></td>");
echo("<td></td>");
echo("<th>".$total_current_arrival."</th>");
echo("<th>".number_format($total_current_sc)."/-</th>");
echo("<th>".number_format($total_current_cod)."/-</th>");
echo("<th></th>");
echo("<th>".$total_arrival."</th>");
echo("<th>".number_format($total_sc)."/-</th>");
echo("<th>".number_format($total_cod)."/-</th>");
echo("</tr>"); ?>
</table>








</body>
</html>