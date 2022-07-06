<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<?php
if(!empty($invoice_data)){
$flyer_bulk=0;    
$osa=0;
$osa=0;
$other=0;
$remark=0;
$permission=0;
$id=0;
$invoice_code=0;
$date="";
foreach($invoice_data as $row){
$flyer_bulk     =$row->bulk_flyer_amount;    
$osa            =$row->osa_amount;
$other          =$row->other_amount;
$remark         =$row->invoice_remark;
$permission     =$row->invoice_permission;
$id             =$row->invoice_id;
$invoice_code   =$row->invoice_code;    
$date           =$row->invoice_date;   
}    
}



?>
 <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START JUMBOTRON -->
          <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
              <div class="inner">
                <!-- START BREADCRUMB -->
                 <ol class="breadcrumb">
                  <li class="breadcrumb-item">Accounts</li>
                  <li class="breadcrumb-item">Invoice</li>
                  <li class="breadcrumb-item">Create Invoice</li>
                  <li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:s'); ?></mark></li>
                   <li class="breadcrumb-item"><mark><?php echo $invoice_code; ?></mark></li>
                </ol>
                <!-- END BREADCRUMB --> 
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
<div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
<div class="row">
   
           

                  <div class="col-xl-12 col-lg-12" >

                <!-- START card -->
               
                    
               <div class=" container-fluid   container-fixed-lg bg-gray"  >
<div class="row">

<div class="col-md-3">
  <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Edit Invoice</div>
      </div>
   <div class="card-body">
<h5>Invoice Module</h5>
<form role="form" method="post" action="<?php echo base_url(); ?>Invoice/edit_invoice">
<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2019-08-23"</span>
<input type="text" value="<?php echo $date; ?>" class="form-control"  readonly="" >
</div>
<div class="form-group">
<label>Invoice Code</label>
<span class="help">e.g. "<?php echo $invoice_code; ?>"</span>
<input type="text" value="<?php echo $invoice_code; ?>" class="form-control"  readonly="" >
<input type="text" id="invoice_id" name="invoice_id" value="<?php echo $id; ?>" class="form-control"  readonly="" required="required">
</div>
<div class="form-group" id="rider_div">
<label>Permission</label>
<span class="help">With Service Charges</span>
<select class="form-control"  id="permission" name="permission" required="required">
<?php  if($permission=="SC"){
echo("<option value='SC'> With Service Charges</option>");
} else {
echo("<option value='COD'> With Out Services Charges</option>");
}   ?> 
<option value="SC"> With Service Charges</option>
<option value="COD"> With Out Services Charges</option>
</select>
</div>
<div class="form-group">
<label>Bulk Flyer</label>
<span class="help">if any (Optional)</span>
<input type="text" name="bulk_flyer" id="bulk_flyer" value="<?php echo $flyer_bulk; ?>" class="form-control"  required="required">
</div>
<div class="form-group">
<label>OSA Amount</label>
<span class="help">if any (Optional)</span>
<input type="text" name="osa_amount" id="osa_amount" value="<?php echo $osa; ?>"  class="form-control"  required="required">
</div>
<div class="form-group">
<label>Other Amount </label>
<span class="help">if any (Optional)</span>
<input type="text" name="other_amount"  id="other_amount" value="<?php echo $other; ?>"  class="form-control" required="required">
</div>
<div class="form-group">
<label>Remark</label>
<span class="help">if any (Optional)</span>
<input type="text" name="remark" id="remark" class="form-control" value="<?php echo $remark; ?>"   required="required" >
</div>
<button type="submit" class='btn btn-info'>Update Invoice Info</button>
</form>
</div>
</div>
</div>





         <!-- END card -->
              </div>

            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->




</div>
</div>
<?php
$this->load->view('inc/footer');
?>      