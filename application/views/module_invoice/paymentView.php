<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$('#data_panel').saimtech();
$('#pending_panel').saimtech();
 });
</script>
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

<div class="col-md-6">
  <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Update Payment Detail</div>
      </div>
   <div class="card-body">
<h5>Invoice Module</h5>
<form role="form" method="post" action="<?php echo base_url(); ?>Invoice/submit_payment">
<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2019-08-23"</span>
<input type="text" id="payment_date" name="payment_date" value="<?php echo date('Y-m-d h:i:s'); ?>" class="form-control" >
<input type="hidden" value="<?php echo $id; ?>" id="invoice_id" name="invoice_id" class="form-control"  readonly="" >
</div>
<div class="form-group">
<label>Payment Mode</label>
<span class="help">Bank, Cash, Cheque, Combine</span>
<select  name="payment_mode" id="payment_mode" class="form-control"  >
<option value="">Select Mode</option>
<option value='Bank'>Bank</option>
<option value='Cash'>Cash</option>
<option value='Cheque'>Cheque</option>
<option value='Combine'>Combine (if payment is partial)</option>
<!--<option value='Online'>Bank</option>
<option value='Check'>Cash</option>
<option value='Deposit'>Cheque</option>
<option value='Transfer'>Transfer</option>-->
</select>    
</div>
<div class="form-group">
<label>Transaction ID</label>
<span class="help">TMDE1-38-10702, C-6394414, CASH00001</span>
<input type="text" name="tid" id="tid" class="form-control">
</div>
<button type="submit" class='btn btn-primary'>Update Payment Detail</button>
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