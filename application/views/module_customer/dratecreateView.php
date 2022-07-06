<?php
error_reporting(0);
$this->load->view('inc/header');
?>


<script type="text/javascript">
$(document).ready(function(){
function hideSelected(value) {
  if (value && !value.selected) {
    return $('<span>' + value.text + '</span>');
  }
}    
$('#data_panel').saimtech();
$('#origin').select2();
$('#destination').select2({
  allowClear: true,
    placeholder: {
      id: "",
      placeholder: "Leave blank to ..."
    },
    minimumResultsForSearch: -1,
    templateResult: hideSelected,
  });  
      

$('#pending_panel').saimtech();
//$('.multiselect-ui').multiselect({
//includeSelectAllOption: true
//});
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
                  <li class="breadcrumb-item">Customer</li>
                  <li class="breadcrumb-item">Add Rate</li>
                  <li class="breadcrumb-item">Rate</li>
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
     <div class="card-title">Add New Rate</div>
      </div>
   <div class="card-body">
<form role="form">
<div class="form-group">
<label>Service Type</label>
<select class="form-control" name="service_type" id="service_type" tabindex=1>
<?php if(!empty($service_data)){foreach($service_data as $rows){if($service_type==$rows->service_id){echo("<option value=".$rows->service_id.">".$rows->service_name."</option>");}}}?>
</select>    
</div>
<div class="form-group">
<input type="hidden" id="customer_id" name="customer_id" value="<?php echo $customer_id; ?>">    
<label>Origin</label>
<select class="form-control" name="origin" id="origin" tabindex=1>
<option value="">Select Origin</option>
<?php if(!empty($city_data)){foreach($city_data as $rows){echo("<option value=".$rows->city_id.">".$rows->city_name."</option>");}}?>
</select>    
</div>
<div class="form-group">
<label>Destination</label>
<select class="form-control" name="destination" id="destination" multiple="multiple"  tabindex=2>
<option value="">Select Destination</option>
<option value="ex_punjab">All Punjab</option>
<option value="ex_sindh">All Sindh</option>
<option value="ex_kpk">All KPK</option>

<?php if(!empty($city_data)){foreach($city_data as $rows){echo("<option value=".$rows->city_id.">".$rows->city_name." (".strtoupper(substr($rows->mixture,3)).")</option>");}}?>
</select>    
</div>
<div class="card" style="border-color:#6f42c1">
<div class="card-header  separator">
<div class="card-title">City Rate</div>
</div>    
<div class="card-body">
<div class="row">
<div class="col-md-6">    
<div class="form-group">
<label>Weight 1</label>
<input type="number" id="wgt_1" name="wgt_1" class="form-control"  tabinde="1">
</div>
</div>
<div class="col-md-6">    
<div class="form-group">
<label>Rate 1</label>
<input type="number" id="rate_1" name="rate_1" class="form-control"  tabinde="2">
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">    
<div class="form-group">
<label>Weight 2</label>
<input type="number" id="wgt_2" name="wgt_2" class="form-control"  tabinde="3">
</div>
</div>
<div class="col-md-6">    
<div class="form-group">
<label>Rate 2</label>
<input type="number" id="rate_2" name="rate_2" class="form-control"  tabinde="4">
</div>
</div>
</div>
<div class="row">
<div class="col-md-6">    
<div class="form-group">
<label>Additional Weight</label>
<input type="number" id="add_wgt" name="add_wgt" class="form-control"  tabinde="5">
</div>
</div>
<div class="col-md-6">    
<div class="form-group">
<label>Additional Rate</label>
<input type="number" id="add_rate" name="add_rate" class="form-control"  tabinde="6">
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="form-group">
<label>GST</label>
<input type="number" id="gst" name="gst" class="form-control"  tabinde="7">
</div>
</div>
</div>
</div>
</div>






</div>
</form>

<div class="card-footer">
<button class="btn btn-info pull-right" onclick="add_rate()">Save Destination Wise Rate</button>

</div>

</div>
</div>


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
         <th style="border-color:#6f42c1">Service Type</th>
         <th style="border-color:#007bff">Origin</th>
         <th style="border-color:#007bff">Destination</th>
         <th style="border-color:#17a2b8">Wgt1</th>
         <th style="border-color:#17a2b8">Rate1</th> 
         <th style="border-color:#17a2b8">Wgt2</th>
         <th style="border-color:#17a2b8">Rate2</th>
         <th style="border-color:#17a2b8">Add Wgt</th>
         <th style="border-color:#17a2b8">Add Rate</th>
         <th style="border-color:#17a2b8">GST</th>
         <th>Status</th>
        </tr>
        
      </thead>
      <tbody id="autoload">
     <?php if(!empty($destination_data)){
        foreach($destination_data as $rows){
        echo("<tr>");
        echo("<td>".$rows->Service."</td>");
        echo("<td>".$rows->Origin."</td>");
        echo("<td>".$rows->Destination."</td>");
        echo("<td>".$rows->city_wgt1."</td>");
        echo("<td>".$rows->city_rate1."</td>");
        echo("<td>".$rows->city_wgt2."</td>");
        echo("<td>".$rows->city_rate2."</td>");
        echo("<td>".$rows->city_add_wgt."</td>");
        echo("<td>".$rows->city_add_rate."</td>");
        echo("<td>".$rows->city_gst."</td>");
        if($rows->wenable==1){
        echo("<td class='bg-success text-white'>Active</td>");
        } else {
        echo("<td class='bg-danger text-white'>Blocked</td>");}
        echo("</tr>");
        }} ?>
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
 

function add_rate(){
var service_type=""; 
var customer_id=""; 
var origin="";
var destination="";
var wgt_1="";
var rate_1="";
var wgt_2="";
var rate_2="";
var add_wgt="";
var add_rate="";
var gst="";
var check="Pass";
//------------GST
if($("#gst").val()>0){
gst=$("#gst").val();
$("#gst").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#gst").css("border-color", "red"); 
$("#gst").focus();
check="Fail";
}
//--------------------------------End
//------------WGT 1
if($("#wgt_1").val()>0){
wgt_1=$("#wgt_1").val();
$("#wgt_1").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#wgt_1").css("border-color", "red"); 
$("#wgt_1").focus();
check="Fail";
}
//--------------------------------End
//------------RATE 1
if($("#rate_1").val()>0){
rate_1=$("#rate_1").val();
$("#rate_1").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#rate_1").css("border-color", "red"); 
$("#rate_1").focus();
check="Fail";
}
//--------------------------------End
//------------WGT 2
if($("#wgt_2").val()>0){
wgt_2=$("#wgt_2").val();
$("#wgt_2").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#wgt_2").css("border-color", "red"); 
$("#wgt_2").focus();
check="Fail";
}
//--------------------------------End
//------------RATE 2
if($("#rate_2").val()>0){
rate_2=$("#rate_2").val();
$("#rate_2").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#rate_2").css("border-color", "red"); 
$("#rate_2").focus();
check="Fail";
}
//--------------------------------End
//------------ADD WGT 
if($("#add_wgt").val()>0){
add_wgt=$("#add_wgt").val();
$("#add_wgt").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#add_wgt").css("border-color", "red"); 
$("#add_wgt").focus();
check="Fail";
}
//--------------------------------End
//------------ADD RATE 
if($("#add_rate").val()>0){
add_rate=$("#add_rate").val();
$("#add_rate").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#add_rate").css("border-color", "red"); 
$("#add_rate").focus();
check="Fail";
}
//--------------------------------End
///------------Service Type 
if($("#service_type").val()!=""){
service_type=$("#service_type").val();
$("#service_typet").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#service_type").css("border-color", "red"); 
$("#service_type").focus();
check="Fail";
}
//--------------------------------End
//------------Service Type 
if($("#customer_id").val()!=""){
customer_id=$("#customer_id").val();
$("#customer_id").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
check="Fail";
}
//------------Origin 
if($("#origin").val()!=""){
origin=$("#origin").val();
$("#origin").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
check="Fail";
}
//------------Destination 
if($("#destination").val()!=""){
destination=$("#destination").val();
$("#destination").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
check="Fail";
}
//--------------------------------End
if(check!="Fail"){  
var mydata={
service_type           :service_type,
customer_id            :customer_id,
origin                 :origin,
destination            :destination,
gst                    :gst,
wgt1                   :wgt_1,
rate1                  :rate_1,
wgt2                   :wgt_2,
rate2                  :rate_2,
addwgt                 :add_wgt,
addrate                :add_rate,
};
$.ajax({
url: "<?php echo base_url(); ?>Customer/destination_wise_rate",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
$("#destination").select2("val", "");
//=====Zone A
$("#wgt_1").val("");
$("#gst").val("");
$("#rate_1").val("");
$("#wgt_2").val("");
$("#rate_2").val("");
$("#add_wgt").val("");
$("#add_rate").val("");
}
});
}    
}

</script>




</div>
</div>
<?php
$this->load->view('inc/footer');
?>      