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
                  <li class="breadcrumb-item">Operations</li>
                  <li class="breadcrumb-item">Direct DD Update (by IT)</li>
                  <li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:s'); ?></mark></li>
                   </ol>
                <!-- END BREADCRUMB --> 
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
<div class="pgn-wrapper" data-position="top" style="top: 48px;"></div>
<div class="row">
   
           

                  <div class="col-xl-12 col-lg-12" >

                <!-- START card -->
               
                    
               <div class=" container-fluid   container-fixed-lg bg-gray"  >
<div class="row">

<div class="col-md-4">
  <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Direct DD Update</div>
      </div>
   <div class="card-body">
<h5>Scan Shipments</h5>
<form role="form">
<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2021-07-15"</span>
<input type="datetime-local" min="2019-02-17T14:30"  id="d_date" name="d_date" class="form-control"   >
</div>
<div class="form-group" id="status_div">
<label>Order Status</label>
<span class="help">e.g.  Return, Refused, CNA, HIO, RTS</span>
<select class="form-control" required="" id="order_status" name="order_status">
<option value="">Select Status</option>
<option value="Refused">Refused</option>
<option value="Return">Return</option>
<option value="HIO">HIO</option>
<option value="OSA">OSA</option>
<option value="CNA">CNA</option>
<option value="NSA">NSA</option>
<!--<optgroup label="De Manifest">
<option value="De Manifest">De Manifest</option>-->
</select>    
</div>
<div class="form-group" id="cn_div">
<label>CN</label>
<span class="help">e.g. "14202000001"</span>
<input type="text" class="form-control"  id="cn" name="cn">
</div>
<div class="form-group" id="msg_div">
</div>
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

<script>
 



$('#cn').keypress(function(e) {
if (e.keyCode == 13) {
$("#msg_div").html("<center><img src='<?php echo base_url();?>assets/ajax-loader.gif'></center>");      
var check="Pass";
var cn="";
var order_status="";
var delivery_date ="";
//------------Delivery Date
if($("#d_date").val()!=""){
delivery_date=$("#d_date").val();
$("#d_date_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#d_date_div").css("border-color", "red"); 
$("#d_date").focus();
check="Fail";
}
//------------Order Status
if($("#order_status").val()!=""){
order_status=$("#order_status").val();
$("#status_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#status_div").css("border-color", "red"); 
$("#order_status").focus();
check="Fail";
}
//--------------------------------End
//------------cn
if($("#cn").val()!=""){
cn=$("#cn").val();
$("#cn_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#cn_div").css("border-color", "red"); 
$("#cn").focus();
check="Fail";
}
//--------------------------------End

//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
delivery_date   :delivery_date,    
order_status    :order_status,
cn              :cn
};
$.ajax({
url: "<?php echo base_url(); ?>Direct/direct_process",
type: "POST",
data: mydata,        
success: function(data) {
$("#msg_div").html(data);
}
});
$("#cn").val("");
}
}
});




</script>




</div>
</div>
<?php
$this->load->view('inc/footer');
?>      