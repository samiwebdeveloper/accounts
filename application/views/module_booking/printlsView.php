<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Shipments Load Sheet</title>
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
$customer="";
$customer_phone="";
$customer_address="";
if(!empty($print_data)){
foreach($print_data as $rows){
$sheet_code      = $rows->load_sheet_id;
$sheet_date      = $rows->order_booking_date;
$customer        = $rows->customer_name;
$customer_phone  = $rows->customer_contact;
$customer_address= $rows->customer_address;
  } } ?>
<body onload="window.print()">
 <img src="<?php echo base_url(); ?>assets/img/logo.png" width="172" height="85"><img src="<?php echo base_url(); ?>assets/barcode/loadsheet/<?php echo $sheet_code; ?>.png" width="182" height="80" style="margin-left: 80%"><center><h1>Shipments Load Sheet</h1></center>
<br>
<table style="width:42%;margin-left: 24px; font-size:24px">
  <tr>
  <th>Load Sheet ID</th>
  <td>: <?php echo $sheet_code; ?></td>
</tr>
<tr>
  <th>Shipper</th>
  <td>: <?php echo $customer; ?></td>
</tr>
<tr>
  <th>Load Sheet Date</th>
  <td>: <?php echo $sheet_date; ?></td>
</tr>
</table>

<br>
<h3 style="margin-left:24px">Following Goods/Shipments have been received</h3>
<table style="width:95%; border:1px solid black; margin-left: 24px; font-size:20px" border=1>
  <tr>
  <th><center>Sr</center></th>
  <th><center>Booking Date</center></th>
  <th><center>Consignment</center></th>
  <th><center>C-Ref</center></th>
  <th><center>Destination</center></th>
  <th><center>Weight</center></th>
  <th><center>Pieces</center></th>
  <th><center>COD</center></th>
</tr>
<?php if(!empty($print_data)){
 $i=0; 
 $tcod=0;
 $twgt=0;
 $tpie=0; 
foreach($print_data as $rows){ 
$i=$i+1;
$tcod=$tcod+$rows->cod_amount;
$twgt=$twgt+$rows->weight;
$tpie=$tpie+$rows->pieces;
?>

<tr>
  <td><center><?php echo $i; ?></center></td>
  <td><center><?php echo $rows->order_booking_date; ?></center></td>
  <td><center><?php echo $rows->order_code; ?></center></td>
  <td><center><?php echo $rows->customer_reference_no; ?></center></td>
  <td><center><?php echo $rows->destination_city_name; ?></center></td>
  <td><center><?php echo $rows->weight; ?></center></td>
  <td><center><?php echo $rows->pieces; ?></center></td>
  <td><center><?php echo number_format($rows->cod_amount); ?>/-</center></td>
</tr>
<?php } } ?>
<tr>
  <th colspan="7"><center><font style="margin-left:520px">TOTAL COD Amount</font></center></th>
  <th><center><?php echo number_format($tcod); ?>/-</center></th>
</tr>
<tr>
  <th colspan="7"><center><font style="margin-left:520px">TOTAL Weight(KG)</font></center></th>
  <th><center><?php echo $twgt; ?></center></th>
</tr>
<tr>
  <th colspan="7"><center><font style="margin-left:520px">TOTAL Pieces</font></center></th>
  <th><center><?php echo number_format($tpie); ?></center></th>
</tr>
<tr>
  <th colspan="7" ><center><font style="margin-left:520px">TOTAL Consignments</font></center></th>
  <th><center><?php echo number_format($i); ?></center></th>
</tr>
</table>
<br>
<h3 style="margin-left:24px">Disclaimer:</h3>
<p style="margin-left:24px"><?php echo $customer; ?> is to ensure that address labels are pasted on the items handed over to "Delivery Express" pick-up staff.
<?php echo $customer; ?> is responsible for the content packed inside the shipment.
Booked weight may vary from invoice / billing weight. Actual weight will be treated as final weight
</p>
<table style="width:95%; border:1px solid black; margin-left: 24px; font-size:20px" border=1>
  <tr>
    <th style="width:50%" colspan='2'><center>Customer</center></th>
    <th colspan='2'><center>Delivery Express Pick UP Staff</center></th>
  </tr>
  <tr>
    <td> &nbsp;Contact No</td>
    <td><center><?php echo $customer_phone; ?></center></td>
    <td> &nbsp;Courier</td>
    <td><center>&nbsp;____________________</center></td>
  </tr>
   <tr>
    <td> &nbsp;Address</td>
    <td><?php echo $customer_address; ?><br><center><?php echo $_SESSION['origin_name']; ?></center></td>
    <td> &nbsp;Courier Code</td>
    <td><center>&nbsp;</center></td>
  </tr>
  <tr>
    <th colspan="2"><center>Hand Over By</center></th>
    <td> &nbsp;Shipment Count</td>
    <td><center>&nbsp;</center></td>
  </tr>
  <tr>
    <td> &nbsp;Name</td>
    <td><center></center></td>
    <td> &nbsp;Pieces</td>
    <td><center></center></td>
  </tr>
  <tr>
    <td> &nbsp;Designation</td>
    <td><center></center></td>
    <td> &nbsp;Signature</td>
    <td><center></center></td>
  </tr>
  <tr>
    <td> &nbsp;Sign and Stamp</td>
    <td><center></center></td>
    <td> &nbsp;Date & Time</td>
    <td><center></center></td>
  </tr>
</table>
</body>
</html>