<html>
<head>    
<title>Complain <?php  $date_raw=date('Y-m-d');
echo $date_raw; ?></title> 
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
<h1>New Complain </h1>
<table>
<thead>
<th>Sr</th>
<th>Ticket#</th>
<th>Cn</th>
<th>Nature</th>
<th>Type</th>
<th>Complainant Name</th>
<th>Phone No</th>
<th>Remarks</th>
</thead>
<?php	
if(!empty($complain_data)){$i=0;   
foreach($complain_data as $rows){
$i=$i+1;    
echo("<tr>");
echo("<td>".$i."</td>");
echo("<td>".$rows['ticket_no']."</td>");
echo("<td>".$rows['cn']."</td>");
echo("<td>".$rows['complain_name']."</td>");
echo("<td>".$rows['type_name']."</td>");
echo("<td><center>".$rows['complainant_name']."</center></td>");
echo("<td>".$rows['complainant_phone']."</td>");
echo("<td>".$rows['complainant_remarks']."</td>");
echo("</tr>");
}}; ?> 
</table>

</body>
</html>