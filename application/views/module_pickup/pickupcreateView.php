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
                  <li class="breadcrumb-item">Pickup</li>
                  <li class="breadcrumb-item">Create Resquest</li>
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
<div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
<div class="row">
   
           

                  <div class="col-xl-12 col-lg-12" >

                <!-- START card -->
               
                    
               <div class=" container-fluid   container-fixed-lg bg-gray"  >
<div class="row">

<div class="col-md-4">
  <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Pickup Request</div>
      </div>
   <div class="card-body">
<h5>Enter Detail</h5>

<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2019-08-23"</span>
<input type="text" value="<?php echo date('Y-m-d h:i:s'); ?>" class="form-control"  readonly="" >
</div>

<div class="form-group">
<label>Shipper </label>
<select class="form-control" required="" id="pcustomer" name="pcustomer" tabindex='1'>
<option value="">Select Shipper</option>
<?php if(!empty($customer_data)){
foreach($customer_data as $rows){
echo("<option value=".$rows->customer_id.">".$rows->customer_name."</option>");    
}}?>
</select>
</div>

<div class="form-group" id="time_div">
<label>Pickup Time</label>
<input type="datetime-local" class="form-control" required="" id="ptime" name="ptime" tabindex='2'>
</div>
<div class="form-group" id="address_div">
<label>Pickup Address</label>
<span class="help">e.g. "Township, Lahore"</span>
<input type="text" class="form-control" required="" id="paddress" name="paddress" tabindex='3'>
</div>
<div class="form-group" id="remark_div">
<label>Pickup Remark</label>
<span class="help">phone,city etc</span>
<input type="text" class="form-control" required="" id="premark" name="premark" tabindex='4'>
</div>

<button class='btn btn-info pull-right' tabindex='5' onclick="add_pickup_alert()">Save Record</button>
</div>
</div>
</div>
<!----INSERT INTO `saimtech_pickup_request`(`pickup_request_id`, `customer_id`, `pickup_time`, `pickup_date`, `pickup_address`, `pickup_remark`, `origin_id`, `created_by`, `created_date`, `modify_by`, `modify_date`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11])-->

<div class="col-md-8">
    <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Data Panel</div>

      </div>
    <div class="card-body">
      <div class="table-responsive">
      <table class="table table-bordered" id="data_panel">
        <thead>
        <tr>
         <th>Sr#</th>
         <th>Shipper</th>        
         <th>Time</th>
         <th>Address</th>
         <th>Remark</th>
         <th>Action</th>
         </tr>
      </thead>
      <tbody id="autoload">
         <?php if(!empty($pickup_data)){$i=0;   
    foreach($pickup_data as $rows){
    $i=$i+1;    
  //  INSERT INTO `saimtech_pickup_request`(`pickup_request_id`, `customer_id`, `pickup_time`, `pickup_date`, `pickup_address`, `pickup_remark`, `origin_id`, `created_by`, `created_date`, `modify_by`, `modify_date`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11])
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->customer_name."</td>");
    echo("<td>".$rows->pickup_time." - ".$rows->pickup_DATE."</td>");
    echo("<td>".$rows->pickup_address."</td>");
    echo("<td>".$rows->pickup_remark."</td>");
    echo("<td><button class='btn btn-danger btn-xs' onclick='remove(".$rows->pickup_request_id.")'>Remove</button></td>");  
    echo("</tr>"); }}   ?>
       </tbody>
      </table>
    </div>

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
 
function remove(id){
if(id!=""){
var mydata={
id:id};
$.ajax({
url: "<?php echo base_url(); ?>Pickup/remove/"+id,
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
}
});
    
}    
}


function add_pickup_alert(){
$("#autoload").html("<center><img src='<?php echo base_url();?>assets/ajax-loader.gif'></center>");      
var check="Pass";
var customer="";
var address="";
var remark="";
var time="";
//------------Customer
if($("#pcustomer").val()!=""){
customer=$("#pcustomer").val();
$("#pcustomer").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#pcustomer").css("border-color", "red"); 
$("#pcustomer").focus();
check="Fail";
}
//--------------------------------End
//------------Time
if($("#ptime").val()!=""){
time=$("#ptime").val();
$("#ptime").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#ptime").css("border-color", "red"); 
$("#ptime").focus();
check="Fail";
}
//--------------------------------End
//------------Address
if($("#paddress").val()!=""){
address=$("#paddress").val();
$("#address_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#address_div").css("border-color", "red"); 
$("#paddress").focus();
check="Fail";
}
//--------------------------------End
//------------Remark
if($("#premark").val()!=""){
remark=$("#premark").val();
$("#remark_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#remark_div").css("border-color", "red"); 
}
//--------------------------------End
//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
customer        :customer,
address         :address,
time            :time,
remark          :remark
};
$.ajax({
url: "<?php echo base_url(); ?>Pickup/add_pickup_request",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
}
});
$("#paddress").val("");
$("#premark").val("");
$("#ptime").val("");
}


}




  
</script>




</div>
</div>
<?php
$this->load->view('inc/footer');
?>      