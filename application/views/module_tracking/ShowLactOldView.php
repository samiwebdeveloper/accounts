<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<title>Tracking</title>
     <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap1.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />



<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/search2.js" type="text/javascript"></script>

</head>
<script type="text/javascript">
$(document).ready(function(){ 
$("#myTable").saimtech();
});
</script>
<body  style="background-color:#fff">

<table style="width:100%" id="myTable">

<tr bgcolor=#FFFEFF>
<td width=20% bgcolor=#6d5eac style='color:white;font-size:13px'><center><?php echo $status; ?></center></td>
<td width=50%><center><code>Your Shipment Status is <?php echo $status; ?>. (OLD Portal)</code></center></td>
<td width=30% bgcolor=#6d5eac style='color:white;font-size:13px'><center><?php echo $date; ?></font></center></td>
</tr>
<tr bgcolor=#212529>
<td><div style="height:5px"></div></td>
<td><div style="height:5px"></div></td>
<td><div style="height:5px"></div></td>
</tr>

</table>
</body>
</html>