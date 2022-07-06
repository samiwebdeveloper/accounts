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
<h1>New Route </h1>
<table>
<thead>
<th>Sr</th>
<th>Route Code</th>
<th>Route Name</th>
<?php	
if(!empty($route_data)){$i=0;   
foreach($route_data as $rows){
$i=$i+1;    
echo("<tr>");
echo("<td>".$i."</td>");
echo("<td>".$rows->route_code."</td>");
echo("<td>".$rows->route_name."</td>");
echo("</tr>"); }}; ?>  
</table>

</body>
</html>