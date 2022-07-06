<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Cow Card</title>
     <!-- Bootstrap core CSS -->
        <link href="<?php echo base_url();?>assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url();?>assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />



<script src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>
  <?php
  if(!empty($animal_data)){
    //----Get Values----------  
     $vrem=$animal_data[0]['VREM'];
     $mast=$animal_data[0]['MAST'];
     $xmast=$animal_data[0]['XMAST'];
     $tbrd=$animal_data[0]['TBRD'];
     $xbrd=$animal_data[0]['XBRD'];
     $tpg=$animal_data[0]['TPG'];
     $lact=$animal_data[0]['LACT'];
     $xpg=$animal_data[0]['XPG'];
     $tgnrh=$animal_data[0]['TGNRH'];
     $xgnrh=$animal_data[0]['XGNRH'];
     $tabrt=$animal_data[0]['TABRT'];
     $xabrt=$animal_data[0]['XABRT'];
     $drystatus=$animal_data[0]['drystatus'];
     $date_of_withdrawal=$animal_data[0]['date_of_withdrawal'];
     $last_hosptial_date =$animal_data[0]['last_hosptial_date'];
     $last_dry_date =$animal_data[0]['last_dry_date'];
     $last_lact_change_date =$animal_data[0]['last_lact_change_date'];
     $last_bred_date =$animal_data[0]['last_bred_date'];
     $previous_last_bred_date =$animal_data[0]['previous_lact_bred_date'];
     $dih="-";

     if($last_hosptial_date!="" && $last_hosptial_date!="0000-00-00"){
     $edate = strtotime(date('Y-m-d'));
     $hdate = strtotime($last_hosptial_date);
     $dih = $edate - $hdate;  
     } else { $dih="-"; }
    

     $last_lact_date=$animal_data[0]['last_lact_change_date'];
     $previous_last_lact_date=$animal_data[0]['previous_lact_change_date'];
     $cit ="-";
     if($lact>0 && $last_lact_date!="" && $last_lact_date!="0000-00-00" &&  $previous_last_lact_date!="" && $previous_last_lact_date!="0000-00-00"){
     $edate = strtotime(date('Y-m-d'));
     $ldate = strtotime($last_lact_date);
     $cit = $edate - $ldate;    
     }else { $cit ="-";}
    



     $rpro=$animal_data[0]['RPRO'];
      $DUEDAT="-";
     if($rpro=="PREG" && $last_bred_date!="" && $last_bred_date!="0000-00-00"){
     $DUEDAT=date('Y-m-d', strtotime($last_bred_date. ' + 270 days'));    
     } else {
      $DUEDAT="-";   
     }
     

     $DUEDRY="-";
     if($drystatus=="Y" && $rpro=="PREG" && $last_dry_date!="" && $last_dry_date!="0000-00-00" && $last_bred_date!="" && $last_bred_date!="0000-00-00"){
    $DUEDRY=date('Y-m-d', strtotime($last_bred_date. ' + 200 days'));    
     } else {
     $DUEDRY="-";   
     }


     $pdopn ="-";
     if($lact>0 && $previous_last_lact_date!="" && $previous_last_lact_date!="0000-00-00" && $previous_last_bred_date!="0000-00-00" && $previous_last_bred_date!=""){
     $ldate = strtotime($previous_last_lact_date);
     $bdate = strtotime($previous_last_bred_date);
     $pdopn = $bdate - $ldate;    
     }else { $pdopn ="-";}


     $pdcc ="-";
     if($lact>0 && $last_lact_change_date!="" && $last_lact_change_date!="0000-00-00" && $previous_last_bred_date!="0000-00-00" && $previous_last_bred_date!=""){
     $ldate = strtotime($last_lact_change_date);
     $bdate = strtotime($previous_last_bred_date);
     $pdcc = $ldate - $bdate;    
     }else { $pdcc ="-";}
    }
    ?>

<table class="table table-bordered">
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>MAST</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $mast!=0 ){ echo $mast; } else { echo("-");}?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>XMAST</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $xmast!=0 ){ echo $xmast; } else { echo("-");}?><center></td>
</tr>
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>TBRD</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $tbrd!=0 ){ echo $tbrd; } else { echo("-");}?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>XTBRD</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $xbrd!=0 ){ echo $xbrd; } else { echo("-");}?><center></td>
</tr>
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>TPG</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $tpg!=0 ){ echo $tpg; } else { echo("-");}?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>XPG</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $xpg!=0 ){ echo $xpg; } else { echo("-");}?><center></td>
</tr>
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>TGNRH</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $tgnrh!=0 ){ echo $tgnrh; } else { echo("-");}?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>XGNRH</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $xgnrh!=0 ){ echo $xgnrh; } else { echo("-");}?><center></td>
</tr>
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>TABRT</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $tbrd!=0 ){ echo $tbrd; } else { echo("-");}?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>XABRT</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $xbrd!=0 ){ echo $xbrd; } else { echo("-");}?><center></td>
</tr>
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>DIH</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php echo $dih;?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>VREM</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php echo $vrem;?><center></td>
</tr>
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>PDCC</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php echo $pdcc; ?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>PDOPN</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php echo $pdopn; ?><center></td>
</tr>
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>CIT</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php echo $cit;?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>FDAT</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php if( $last_lact_date!="" && $last_lact_date!="0000-00-00"){ echo $last_lact_date; } else { echo("-");}?><center></td>
</tr>
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>DUEDAT</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php echo $DUEDAT;?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>DUEDRY</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php echo $DUEDRY;?><center></td>
</tr>
<tr style='border:1px solid #dee2e600'>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>FDAT</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php echo $last_lact_change_date;?><center></td>
<th width=12% bgcolor=#C0C0C0 style='border:1px solid #dee2e600'><center>Withdrawal</center></th>
<td width=13% bgcolor=#fff style='border:1px solid #C0C0C0'><center><?php echo $date_of_withdrawal;?><center></td>
</tr>
</table>
</head>
<body style="background-color:#60668b">
	



	
	
	

    <script src="<?php echo base_url();?>assets/plugins/jquery/jquery-3.2.1.min.js" type="text/javascript"></script>



    <!-- END VENDOR JS -->
    <!-- BEGIN CORE TEMPLATE JS -->
    <script src="<?php echo base_url();?>assets/pages/js/pages.min.js" type="text/javascript"></script>
    <!-- END CORE TEMPLATE JS -->
    
</body>
</html>