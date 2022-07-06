<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>T.M Cargo | Manifest</title>
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
$transit_code="";
$staff_name="";
$staff_number="";
$date="";
if(!empty($sheet_data)){
foreach($sheet_data as $rows){
$transit_code=$rows->transit_code; 
$staff_name=$rows->staff_name;
$vehicle_no=$rows->vehicle_no;
$staff_number=$rows->staff_number;
$date=$rows->tDate;
}} ?>
<body style='margin-left:3px'>
    <br>
<table style="width:100%">
<td style="width:20%"><img src='<?php echo base_url();?>assets/img/tmlogo.png' width="150px"></td>
<td style="width:60%"><center><h1>T.M Cargo Manifest</h1></center></td>
<td style="width:20%;"><strong><u><?php echo $transit_code; ?></u></strong></td>
</table>
<table style="width:55%;margin-left:3px">
<tr>
<th style="width:40%">Driver Detail</th>
<td style="width:60%;border-bottom: 1px solid black;"><?php echo $staff_name." / ".$staff_number; ?></th>
</tr>
<tr>
<th style="width:40%">Vehicle  Detail</th>
<td style="width:60%;border-bottom: 1px solid black;"><?php echo $vehicle_no." / ".$date; ?></th>
</tr>
<tr>
<th style="width:40%">Transit / Loading Date</th>
<td style="width:60%;border-bottom: 1px solid black;"><?php echo $date; ?></th>
</tr>
</table>

<table style='width:95%;margin-left:3px;margin-top:15px' border=1>
<tr>
<th><center>Sr#</center></th>
<th><center>From</center></th>    
<th><center>To</center></th>    
<th><center>CN. No</center></th>    
<th><center>Pieces</center></th>
<th><center>Weight</center></th>
<th><center>Shipper</center></th>
<th><center>Remarks</center></th>
</tr>
<?php if(!empty($sheet_data)){
$i=0;    
$tweight=0;
$tpieces=0;
foreach($sheet_data as $rows){
$i=$i+1;
$tweight=$tweight+$rows->weight;
$tpieces=$tpieces+$rows->pieces;
echo("<tr>");  
echo("<td><center>".$i."</center></td>");
echo("<td><center>".$_SESSION['origin_name']."</center></td>");  
echo("<td><center>".$rows->city_name."</center></td>");
echo("<td><center>".$rows->transit_cn."</center></td>");
echo("<td><center>".$rows->pieces."</center></td>");
echo("<td><center>".$rows->weight."</center></td>");
echo("<td><center>".$rows->transit_shipper."</center></td>");
echo("<td><center>__________________</center></td>");
echo("</tr>");   
}} ?>

</table>
<br>
<br>
<table style="width:95%;margin-left:3px">
<tr>
<th style="width:10%"><center>No. of Bags</center></th>
<td style="width:20%;border-bottom: 1px solid black;"><center><?php echo $i; ?> </center></th>
<td style="width:2%"></th>
<th style="width:10%"><center>No. of Pieces</center></th>
<td style="width:20%;border-bottom: 1px solid black;"><center><?php echo $tpieces; ?> </center></th>
<td style="width:2%"></th>
<th style="width:10%"><center>Signature</center></th>
<td style="width:22%;border-bottom: 1px solid black;"></th>

</tr>
</table>
</body>
</html>