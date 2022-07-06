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
                  <li class="breadcrumb-item">AI Support</li>
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
     <div class="card-title">AI Support Center</div>
       </div>
   <div class="card-body">
<h5>Scan Shipments</h5>

<div class="form-group" id="cn_div">
<label>CN</label>
<select class="form-control" data-init-plugin="select2" id="cn" name="cn">
<option value="">Select CN</option>
<?php if(!empty($cn_data)){
  foreach($cn_data as $rows){
  echo("<option value='".$rows->order_code."'>".$rows->order_code."</option>");  
  }}?>
</select>
</div>
<div class="form-group" id="status_div">
<label>Order Status</label>
<span class="help">Refused, CNA, ICA</span>
<select class="form-control" required="" id="order_status" name="order_status">
<option value="">Select Status</option>
<optgroup label="Not Delivered">
<option value="Refused">Refused</option>
<option value="CNA">CNA</option>
<option value="ICA">ICA</option>
</select>    
</div>
<button class='btn btn-info' onclick="update_correct_status()">Update Status</button>
<div class="form-group" id="msg_div">
</div>

</div>
</div>
</div>





<div class="col-md-4"><div class="card m-t-10 bg-warning"><div class="card-header  separator">
     <div class="card-title">AI Support Center Notice</div>
       </div>
   <div class="card-body">  <h1><center>  
ہمیں آپ سے اس کی توقع نہیں تھی
</center></h1><h1><center>  
برائے مہربانی اپنا کام احتیاط سے کریں
</center></h1></div></div></div>


         <!-- END card -->
              </div>

            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->

<script>
 



function update_correct_status(){
$("#msg_div").html("<center><img src='<?php echo base_url();?>assets/ajax-loader.gif'></center>");      
var check="Pass";
var rider="";
var cn="";
var order_status="";
//------------Order Status
if($("#order_status").val()!=""){
order_status=$("#order_status").val();
$("#status_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#status_div").css("border-color", "red"); 
$("#order_status").focus();
$("#msg_div").html("<center><p class='alert alert-danger'>Select Order status</p></center>");      
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
$("#msg_div").html("<center><p class='alert alert-danger'>Select Order Code</p></center>"); 
check="Fail";
}
//--------------------------------End
//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
order_status    :order_status,
cn              :cn
};
$.ajax({
url: "<?php echo base_url(); ?>Direct/support_process",
type: "POST",
data: mydata,        
success: function(data) {
$("#msg_div").html(data);
}
});
}

};




</script>




</div>
</div>
<?php
$this->load->view('inc/footer');
?>      