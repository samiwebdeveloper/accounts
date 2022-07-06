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
                  <li class="breadcrumb-item">Raise OSA Alert</li>
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

<div class="col-md-3">
  <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Add OSA Charges</div>
      </div>
   <div class="card-body">
<h5>Scan Shipments</h5>
<form role="form">
<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2021-06-23"</span>
<input type="text" value="<?php echo date('Y-m-d h:i:s'); ?>" class="form-control"  readonly="" >
</div>
<div class="form-group" id="osa_div">
<label>OSA</label>
<span class="help">e.g. "Enter OSA amount"</span>
<input type="number" min="0" class="form-control"  id="osa" name="osa">
</div>
<div class="form-group" id="sdelivery_div">
<label>Special Delivery</label>
<span class="help">e.g. "Enter Special Delivery amount"</span>
<input type="number" min="0" class="form-control" id="sdelivery" name="sdelivery">
</div>
<div class="form-group" id="cn_div">
<label>CN</label>
<span class="help">e.g. "142021000001"</span>
<input type="text" class="form-control" required="" id="cn" name="cn">
</div>
<div class="form-group" id="msg_div">
</div>
</form>
</div>
</div>
</div>






<div class="col-md-6"><div class="card m-t-10"><div class="card-header  separator">
     <div class="card-title text-white">OSA Today Log</div>
       </div>
   <div class="card-body"><center>
    <table class='table table-bordered'>     
    <tr>
    <th>Shipment</th>    
    <th>OSA Charges</th> 
    <th>Special Delivery</th> 
    <th>Accounts Authentication</th>    
    <th>Action</th>    
    </tr>
    <tbody id="tableload">
    <?php if(!empty($detail)){
	foreach($detail as $rows){
    echo("<tr>");
	echo("<td>".$rows->order_code."</td>");
	echo("<td>".$rows->osa_amount."</td>");
	echo("<td>".$rows->special_delivery."</td>");
	if($rows->refused==0 && $rows->post==0){
	echo("<td>Pending</td>");
	} else if($rows->refused==1 && $rows->post==1){
	echo("<td>Shipper Rejected</td>");
	} else if($rows->post==1 && $rows->refused==0){
	echo("<td>Shipper Aproved</td>");
	}
	if($rows->post==0 && $_SESSION['user_power']=='SE' || $_SESSION['user_id']==2){
	echo("<td><a href='".base_url()."Direct/osa_delete/".$rows->osa_id."' onclick='return checkDelete()' class='btn btn-danger btn-xs'>Remove</a>&nbsp;&nbsp;<a href='".base_url()."Direct/osa_aproved/".$rows->osa_id."/".$rows->order_code."/".$rows->customer_id."/".$rows->total_amount."' class='btn btn-success btn-xs'>Aproved On Call</a></td>");    
	} else {
	echo("<td><code>No Rights</code></td>");}
	echo("</tr>");
	}} ?>
	</tbody>
    </table>
</center></div></div></div>

<div class="col-md-3"><div class="card m-t-10 bg-info"><div class="card-header  separator">
     <div class="card-title text-white">Activities Monitor By AI Center</div>
       </div>
   <div class="card-body"><center>
    <table class='table table-bordered'>     
    <tr><th class="text-white">Your Sys ID</th><td><code><?php echo $_SESSION['user_id'];?></code></td></tr>
    <tr><th class="text-white">Your Department</th><td><code><?php echo $_SESSION['user_power'];?></code></td></tr>
    <tr><th class="text-white">Your Name</th><td><code><?php echo $_SESSION['user_name'];?></code></td></tr>
    <tr><th class="text-white">Your IP</th><td><code><?php echo $ip;?></code></td></tr>
    <tr><th class="text-white">Today Date</th><td><code><?php echo date('Y-m-d');?></code></td></tr>
    </table>
</center></div></div></div>
         <!-- END card -->
              </div>

            </div>
            <!-- END PLACE PAGE CONTENT HERE -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->

<script>
 
function checkDelete(id){
    return confirm('Are you sure? This data will be deleted Permanantly');
}


$('#cn').keypress(function(e) {
if (e.keyCode == 13) {
$("#msg_div").html("<center><img src='<?php echo base_url();?>assets/ajax-loader.gif'></center>");      
var check="Pass";
var osa_amount="";
var sdelivery="";
var cn="";
//------------OSA Amount
if(($("#osa").val()!="" && $("#osa").val()>0) ||($("#sdelivery").val()!="" && $("#sdelivery").val()>0)){
osa=$("#osa").val();
sdelivery=$("#sdelivery").val();
$("#osa_div").css("border-color", "rgba(0, 0, 0, 0.07)"); 
$("#sdelivery_div").css("border-color", "rgba(0, 0, 0, 0.07)"); 
} else {
$("#osa_div").css("border-color", "red"); 
$("#osa").focus();
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
osa :osa,
sdelivery :sdelivery,
cn  :cn
};
$.ajax({
url: "<?php echo base_url(); ?>Direct/osa_process",
type: "POST",
data: mydata,        
success: function(data) {
$("#msg_div").html("");         
$("#tableload").html(data);

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