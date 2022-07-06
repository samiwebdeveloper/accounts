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
<h1>New Rider </h1>
<table>
<thead>
<th>Sr</th>
<th>Rider Code</th>
<th>Rider Name</th>
<th>Rider CNIC</th>
<th>Rider EmpCode</th>
<th>Origin</th>
<th>Status</th>
<th>Action</th>
</thead>
<?php	
if(!empty($rider_data)){$i=0;   
foreach($rider_data as $rows){
$i=$i+1;    
echo("<tr>");
echo("<td>".$i."</td>");
echo("<td>".$rows->rider_code."</td>");
echo("<td>".$rows->rider_name."</td>");
echo("<td>".$rows->rider_cnic."</td>");
echo("<td>".$rows->rider_empcode."</td>");
echo("<td>".$rows->rider_reporting_station."</td>");
if($rows->is_enable==1){
echo("<td class='bg-success' >Active</td>");
echo("<td><button class='btn btn-danger btn-xs' onclick='update_status(0)'>Deactive</button></td>");  
} else if($rows->is_enable==0){
echo("<td class='bg-danger' >Deactive</td>");
echo("<td><button class='btn btn-success btn-xs' onclick='update_status(1)'>Active</button></td>");  
    }
echo("</tr>"); }}; ?>  
</table>

</body>
</html>