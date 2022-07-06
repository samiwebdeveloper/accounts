 <?php
error_reporting(0);
$this->load->view('inc/header');
?>
<style>
    @media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
    
}

thead { display: table-header-group; }
</style>


<!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START JUMBOTRON -->
          <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
              <div class="inner">
                <!-- START BREADCRUMB -->
                 <ol class="breadcrumb no-print">
                  <li class="breadcrumb-item">Dashboard</li>
                  <li class="breadcrumb-item">Paid Invoice Report</li>
                  
                </ol>
                <!-- END BREADCRUMB --> 
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->

<div class="row">
   
   <?php 
   $customer_name="";
   $customer_address="";
   $customer_bank="";
   $customer_account="";
   $customer_account_title="";
   $invoice_date="";
   $invoice_sp_handling="";
   $invoice_cash_handling="";
   $invoice_fuel="";
   $invoice_code="";
   $invoice_amount="";
   $invoice_sc="";
   $invoice_gst="";
   $invoice_flyer=0;
   $invoice_osa=0;
   $invoice_amount=0;
   $IBAN_number=0;
   $invoice_remark="";
   $invoice_osa_gst =0;
   $invoice_flyer_gst=0; 
   $invoice_fuel_gst=0;
   $invoice_cash_handling_gst=0;
   $invoice_sp_handling_gst=0;
   $invoice_permission="";
   $rate_gst="";
   if(!empty($sheet_data)){
   foreach($sheet_data as $rows){
   $rate_gst=$rows->gsst;       
   $customer_name=$rows->customer_name;
   $customer_bank=$rows->customer_bank;
   $customer_account=$rows->customer_bank_account_no;
   $customer_title=$rows->customer_bank_account_title;
   $customer_address=$rows->customer_address;
   $customer_contact=$rows->customer_contact;
   $IBAN_number=$rows->customer_iban;
   $invoice_date=$rows->invoice_date;
   $invoice_code=$rows->invoice_code;
   $invoice_amount=$rows->invoice_amount;
   $invoice_sp_handling=$rows->invoice_sp_handling;
   $invoice_cash_handling=$rows->invoice_cash_handling;
   $invoice_fuel=$rows->invoice_fuel;
   $invoice_sc=$rows->invoice_sc;
   $invoice_gst=$rows->invoice_gst;
   $invoice_flyer=$rows->bulk_flyer_amount;
   $invoice_osa=$rows->osa_amount;
   $invoice_other=$rows->other_amount;
   $invoice_remark=$rows->invoice_remark; 
   $invoice_permission=$rows->invoice_permission;
   $is_payment=$rows->ispayment; 
   $payment_mode = $rows->paymentmode; 
   $payment_tid = $rows->paymenttid;
   }}
   $old_date = $invoice_date;              // returns Saturday, January 30 10 02:06:34
   $old_date_timestamp = strtotime($old_date);
   $new_date = date('Y-m-d', $old_date_timestamp); 
   ?>

                  <div class="col-xl-12 col-lg-12 ">
              
                     
        <div class="col-md-12">
  <div class="card m-t-10">
              <div class="card-header  separator">
                        <div class="card-title">
                          <span class='pull-right  m-t-10'><img src="https://delex.pk/assets/img/logo.png" alt="logo" data-src="https://delex.pk/assets/img/logo.png" data-src-retina="https://delex.pk/assets/img/logo.png" width="155" height="61"></span>

                        </div>
                      </div>
                      <div class="card-body">
<?php if($invoice_permission=="SC"){    ?>                   
<span class='pull-right'>Invoice  <img src="https://delex.pk/ops_delex/assets/barcode/invoice/<?php echo $invoice_code; ?>.png" width="140" height="50"></span>
<table width="30%" border="1" class="pull-left m-t-10" >
 <thead>
 <tr>
  <th>Invoice Code</th>
  <td><center><?php echo($invoice_code); ?></center></td>
  </tr>
 <tr>
  <th>Brand Name</th>
  <td><center><?php echo($customer_name); ?></center></td>
  </tr>
   <tr>
  <th>Bank  Name</th>
  <td><center><?php echo($customer_bank); ?></center></td>
  </tr>
   <tr>
  <th>Bank  Account No</th>
  <td><center><?php echo($customer_account); ?></center></td>
  </tr>
   <tr>
  <th>Bank  Account Title</th>
  <td><center><?php echo($customer_title); ?></center></td>
  </tr>
  <tr>
  <th>IBAN Number</th>
  <td><center><?php echo($IBAN_number); ?></center></td>
  </tr>
   <tr>
  <th>Invoice Date</th>
  <td><center><?php echo($new_date); ?></center></td>
  </tr>
  <?php if($is_payment!=0){ ?>
  <tr>
  <th>Payment Mode</th>
  <td><center><?php echo($payment_mode); ?></center></td>
  </tr>
  <tr>
  <th>Payment Transaction</th>
  <td><center><?php echo($payment_tid); ?></center></td>
  </tr>
  <?php  } ?>
   
</thead>
</table>
<br>
<center><table width="100%" border="1" class='m-t-5' id="tblData">
 <thead>

  <th><center>Sr.</center></th>
  <th><center>CN</center></th>
  <th><center>Consigee</center></th>
  <th><center>Reference No</center></th>
  <th><center>Pieces</center></th>
  <th><center>Weight</center></th>
  <th><center>Origin</center></th>
  <th><center>Destination</center></th>
  <th><center>Status</center></th>
  <th><center>COD</center></th>
  <th><center>Service Charges</center></th>
  <th><center>GST</center></th>
  <th><center>SP Handling</center></th>
  <th><center>Cash Handling</center></th>
  <th><center>Fuel</center></th>
  <th><center>NET Payment</center></th>

</thead>
<tbody>
<?php
if(!empty($sheet_data)){
$i=0;    
foreach($sheet_data as $rows){
$i=$i+1;    
echo("<tr>");
echo("<td><center>".$i."</center></td>");
echo("<td><center>".$rows->order_code."</center></td>");
echo("<td><center>".$rows->consignee_name."</center></td>");
echo("<td><center>".$rows->customer_reference_no."</center></td>");
echo("<td><center>".$rows->pieces."</center></td>");
echo("<td><center>".$rows->weight."</center></td>");
echo("<td><center>".$rows->origin_city_name."</center></td>");
echo("<td><center>".$rows->destination_city_name."</center></td>");
echo("<td><center>".$rows->order_status."</center></td>");
if($rows->order_status!="RTS"){
echo("<td><center>".number_format($rows->cod,2)."/-</center></td>");
} else {
echo("<td><center>0</center></td>");    
}
echo("<td><center>".number_format($rows->sc,2)."/-</center></td>");
echo("<td><center>".number_format($rows->gst,2)."/-</center></td>");
echo("<td><center>".number_format($rows->sp_handling,2)."/-</center></td>");
echo("<td><center>".number_format($rows->cash_handling,2)."/-</center></td>");
echo("<td><center>".number_format($rows->fuel,2)."/-</center></td>");
if($rows->order_status!="RTS"){
echo("<td><center>".number_format(($sum=$rows->cod-($rows->sc + $rows->gst + $rows->sp_handling + $rows->cash_handling + $rows->fuel)),2)."/-</center></td>");
} else {
echo("<td><center>".number_format(-($rows->sc + $rows->gst + $rows->sp_handling + $rows->cash_handling + $rows->fuel),2)."/-</center></td>");    
}
echo("<tr>");
    
}}
?>
</tbody>
</table>
<br>


<table width="30%" border="1" class="pull-right">

 <tr>
  <th>Total COD</th>
  <td><center><?php echo  number_format($invoice_amount); ?>/-</center></td>
  </tr>
 
 <tr>
  <th>Service Charges</th>
  <td><center><?php echo  number_format($invoice_sc); ?>/-</center></td>
 </tr>
 
<tr>
  <th>Sp Handling Charges</th>
  <td><center><?php echo  number_format($invoice_sp_handling); ?>/-</center></td>
 </tr>
 
 <tr style="display:none;">
  <th >Sp Handling GST</th>
  <td><center><?php echo  number_format($invoice_sp_handling_gst=(($invoice_sp_handling*$rate_gst)/100)); ?>/-</center></td>
 </tr>
 
 
<tr >
  <th>Cash Handling Charges</th>
  <td><center><?php echo  number_format($invoice_cash_handling); ?>/-</center></td>
 </tr>
 
 <tr style="display:none;">
  <th>Cash Handling GST</th>
  <td><center><?php echo  number_format($invoice_cash_handling_gst=(($invoice_cash_handling*$rate_gst)/100)); ?>/-</center></td>
 </tr>
 
 
  <tr>
  <th>Fuel Amount</th>
  <td><center><?php echo  number_format($invoice_fuel); ?>/-</center></td>
  </tr>
  
  <tr style="display:none;">
  <th>Fuel GST</th>
  <td><center><?php echo  number_format($invoice_fuel_gst=(($invoice_fuel * $rate_gst)/100)); ?>/-</center></td>
 </tr>

  <tr>
  <th>Flyer Amount</th>
  <td><center><?php echo  number_format($invoice_flyer); ?>/-</center></td>
  </tr>
  
  
  <tr style="display:none;">
  <th>Flyer GST</th>
  <td><center><?php echo  number_format($invoice_flyer_gst=(($invoice_flyer * $rate_gst)/100)); ?>/-</center></td>
  </tr>
 
  <tr>
  <th>OSA Amount</th>
  <td><center><?php echo  number_format($invoice_osa); ?>/-</center></td>
  </tr>
  
   <tr style="display:none;">
  <th>OSA GST</th>
  <td><center><?php echo  number_format($invoice_osa_gst=(($invoice_osa * $rate_gst)/100)); ?>/-</center></td>
  </tr>
 
   <tr>
  <th>Other Amount</th>
  <td><center><?php echo  number_format($invoice_other); ?>/-</center></td>
  </tr>
      <tr>
  <th>Total GST</th>
  <td><center><?php echo  number_format($invoice_gst + $invoice_flyer_gst + $invoice_osa_gst + $invoice_fuel_gst + $invoice_cash_handling_gst + $invoice_sp_handling_gst); ?>/-</center></td>
  </tr>
  <tr>
  <th>Net Payment</th>
  <th><center><?php echo number_format(round($sum=($invoice_amount-($invoice_gst+ $invoice_sc+$invoice_flyer+ $invoice_flyer_gst+ $invoice_osa+$invoice_other +$invoice_fuel + $invoice_sp_handling +$invoice_cash_handling + $invoice_osa_gst + $invoice_fuel_gst + $invoice_cash_handling_gst + $invoice_sp_handling_gst)))); ?>/-</center></th>
  </tr>
  
  


</table>
<?php if($invoice_remark!=""){ echo("<h3 class='pulll-left'>Note</h3><p class='pulll-left'>*".$invoice_remark."</p>"); } ?>
<?php } else if($invoice_permission=="COD"){    ?>
<span class='pull-right'>Invoice  <img src="https://delex.pk/ops_delex/assets/barcode/invoice/<?php echo $invoice_code; ?>.png" width="140" height="50"></span>

<table width="30%" border="1" class="pull-left m-t-10" >
 <thead>
 <tr>
  <th>Invoice Code</th>
  <td><center><?php echo($invoice_code); ?></center></td>
  </tr>
 <tr>
  <th>Brand Name</th>
  <td><center><?php echo($customer_name); ?></center></td>
  </tr>
   <tr>
  <th>Bank  Name</th>
  <td><center><?php echo($customer_bank); ?></center></td>
  </tr>
   <tr>
  <th>Bank  Account No</th>
  <td><center><?php echo($customer_account); ?></center></td>
  </tr>
   <tr>
  <th>Bank  Account Title</th>
  <td><center><?php echo($customer_title); ?></center></td>
  </tr>
  <tr>
  <th>IBAN Number</th>
  <td><center><?php echo($IBAN_number); ?></center></td>
  </tr>
   <tr>
  <th>Invoice Date</th>
  <td><center><?php echo($new_date); ?></center></td>
  </tr>
  <?php if($is_payment!=0){ ?>
  <tr>
  <th>Payment Mode</th>
  <td><center><?php echo($payment_mode); ?></center></td>
  </tr>
  <tr>
  <th>Payment Transaction</th>
  <td><center><?php echo($payment_tid); ?></center></td>
  </tr>
  <?php  } ?>
   
</thead>
</table>
<br>
<br>
<center><table width="100%" border="1" class='m-t-10'>
 <thead>
 <tr>
  <th><center>Sr.</center></th>
  <th><center>CN</center></th>
  <th><center>Consigee</center></th>
  <th><center>Reference No</center></th>
  <th><center>Pieces</center></th>
  <th><center>Weight</center></th>
  <th><center>Status</center></th>
  <th><center>COD</center></th>
  </tr> 
</thead>
<tbody>
<?php
if(!empty($sheet_data)){
$i=0;    
foreach($sheet_data as $rows){
$i=$i+1;    
echo("<tr>");
echo("<td><center>".$i."</center></td>");
echo("<td><center>".$rows->order_code."</center></td>");
echo("<td><center>".$rows->consignee_name."</center></td>");
echo("<td><center>".$rows->customer_reference_no."</center></td>");
echo("<td><center>".$rows->pieces."</center></td>");
echo("<td><center>".$rows->weight."</center></td>");
echo("<td><center>".$rows->order_status."</center></td>");
if($rows->order_status!="RTS"){
echo("<td><center>".number_format($rows->cod,2)."/-</center></td>");
} else {
echo("<td><center>0</center></td>");    
}
echo("<tr>");
    
}}
?>
</tbody>
</table>
<br>
<table width="30%" border="1" class="pull-right">
  <tr>
  <th>Total COD</th>
  <td><center><?php echo  number_format($invoice_amount); ?>/-</center></td>
  </tr>
  <th>Net Payment</th>
  <th><center><?php echo  number_format($invoice_amount); ?>/-</center></th>
  </tr>
</table>
<?php } ?>
</center></div>

</div>

</div>       
			

            </div>


</div>





            <!-- END PLACE PAGE CONTENT HERE -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->

<?php
$this->load->view('inc/footer');
?>      