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
                  <li class="breadcrumb-item">Direct Weight & Destination Update (by IT)</li>
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
     <div class="card-title">Direct Weight & Destination Update</div>
      </div>
   <div class="card-body">
<h5>Scan Shipments</h5>
<form role="form">
<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2019-08-23"</span>
<input type="text" value="<?php echo date('Y-m-d h:i:s'); ?>" class="form-control"  readonly="" >
</div>
<div class="form-group" id="rider_div">
<label>Rider</label>
<span class="help">e.g. "101 Saim"</span>
<select class="form-control" data-init-plugin="select2" id="rider" name="rider">
<?php if($delivery_rider_id!=""){ 
echo("<option value='".$delivery_rider_id."'>".$delivery_rider_code." - ".$delivery_rider_name."</option>");  
 }?>  
<option value="">Select Rider</option>
<?php if(!empty($rider_data)){
  foreach($rider_data as $rows){
  echo("<option value='".$rows->rider_id."'>".$rows->rider_code." - ".$rows->rider_name."</option>");  
  }}?>
</select>
</div>
<div class="form-group" id="status_div">
<label>Order Status</label>
<span class="help">e.g. Deliverd, Return, Refused, CNA, HIO, RTS</span>
<select class="form-control" required="" id="order_status" name="order_status">
<option value="">Select Status</option>
<optgroup label="Delivered">
<option value="Deliverd">Deliverd</option>
<optgroup label="Not Delivered">
<option value="Return">Return</option>
<option value="Refused">Refused</option>
<option value="CNA">CNA</option>
<option value="ICA">ICA</option>
<option value="OSA">OSA</option>
<option value="NSA">NSA</option>
<option value="RTS">RTS</option>
<optgroup label="Operation">
<option value="REFWD">Re Forward</option>    
<option value="De Bagging">De Bagging</option>
<option value="Return De Bagging">Return De Bagging</option>
</select>    
</div>
<div class="form-group" id="cn_div">
<label>CN</label>
<span class="help">e.g. "4201900001"</span>
<input type="text" class="form-control" required="" id="cn" name="cn">
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
var rider="";
var cn="";
var order_status="";
//------------Rider
if($("#rider").val()!=""){
rider=$("#rider").val();
$("#rider_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#rider_div").css("border-color", "red"); 
$("#rider").focus();
check="Fail";
}
//--------------------------------End
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
rider           :rider,
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