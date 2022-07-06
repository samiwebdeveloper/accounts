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
                  <li class="breadcrumb-item">Direct DD Update (by CS)</li>
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
<div class="form-group" id="d_date_div">
<label>Date</label>
<span class="help">e.g. "2019-08-23"</span>
<input type="datetime-local" max="2019-02-17T14:30" class="form-control" id="d_date" name="d_date">
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
<option value="RTS">RTS</option>
<!--<optgroup label="De Manifest">
<option value="De Manifest">De Manifest</option>-->
</select>    
</div>
<div class="form-group" id="receive_by_div">
<label>Receive By</label>
<span class="help">e.g. "M.Saim"</span>
<input type="text" class="form-control" required="" id="receive_by" name="receive_by">
</div>
<div class="form-group" id="cn_div">
<label>CN</label>
<span class="help">e.g. "14202000001"</span>
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
window.onload = function() {
    var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0 so need to add 1 to make it 1!
var yyyy = today.getFullYear();
if(dd<10){
  dd='0'+dd
} 
if(mm<10){
  mm='0'+mm
} 
var date = yyyy+'-'+mm+'-'+dd+'T14:30';

document.getElementById("d_date").setAttribute("max", date);   
}    


$('#cn').keypress(function(e) {
if (e.keyCode == 13) {
$("#msg_div").html("<center><img src='<?php echo base_url();?>assets/ajax-loader.gif'></center>");      
var check="Pass";
var rider="";
var cn="";
var order_status="";
var delivery_date="";

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
//------------Delivery Date
if($("#d_date").val()!=""){
delivery_date=$("#d_date").val();
$("#d_date_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#d_date_div").css("border-color", "red"); 
$("#d_date").focus();
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
//------------receive_by
if($("#receive_by").val()!=""){
receive_by=$("#receive_by").val();
$("#receive_by_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#receive_by_div").css("border-color", "red"); 
$("#receive_by").focus();
check="Fail";
}
//--------------------------------End
//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
rider              :rider,
order_status       :order_status,
cn                 :cn,
receive_by         :receive_by,
delivery_date      :delivery_date
};
$.ajax({
url: "<?php echo base_url(); ?>Direct/cs_direct_process",
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
// var date = Date.now();
// var today = date.split('T')[0];
// document.getElementsByName("d_date")[0].setAttribute('min', today);
var today = new Date().toISOString();
document.getElementById("d_date").min = '2019-02-17T10:38';

</script>




</div>
</div>
<?php
$this->load->view('inc/footer');
?>      