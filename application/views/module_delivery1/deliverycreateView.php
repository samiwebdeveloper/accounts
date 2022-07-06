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
                  <li class="breadcrumb-item">Delivery Phase 1 (On Route)</li>
                  <li class="breadcrumb-item">Create Sheet</li>
                  <li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:s'); ?></mark></li>
                   <li class="breadcrumb-item"><mark><?php echo $delivery_sheet_code; ?></mark></li>
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
     <div class="card-title">Create Delivery Phase 1 (On Route)</div>
      </div>
   <div class="card-body">
<h5>Scan Shipments</h5>
<form role="form">
<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2021-02-17"</span>
<input type="text" value="<?php echo date('Y-m-d h:i:s'); ?>" class="form-control"  readonly="" >
</div>
<div class="form-group">
<label>Delivery Sheet Code</label>
<span class="help">e.g. "<?php echo $delivery_sheet_code; ?>"</span>
<input type="text" value="<?php echo $delivery_sheet_code; ?>" class="form-control"  readonly="" >
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
<div class="form-group" id="route_div">
<label>Route</label>
<span class="help">e.g. "OPS"</span>
<select class="form-control" data-init-plugin="select2" id="route" name="route">
<?php if($delivery_route_id!=""){ 
echo("<option value='".$delivery_route_id."'>".$delivery_route_code." - ".$delivery_route_name."</option>");  
 }?>    
<option value="">Select Route</option>
<?php if(!empty($route_data)){
  foreach($route_data as $rows){
  echo("<option value='".$rows->route_id."'>".$rows->route_code." - ".$rows->route_name."</option>");  
  }}?>
</select>
</div>
<div class="form-group" id="cn_div">
<label>CN</label>
<span class="help">e.g. "4201900001"</span>
<input type="text" class="form-control" required="" id="cn" name="cn">
</div>
</form>
</div>
</div>
</div>


<div class="col-md-8">
    <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Data Panel</div>
     <div class="card-controls">
<ul>

<li>
</li>
</ul>
</div>
      </div>
    <div class="card-body">
      <mark id="countsss"></mark>    
      <a href="<?php echo base_url(); ?>Delivery/complete_sheet/<?php echo $delivery_sheet_code; ?>" class="pull-right"><Button class='btn btn-primary'>Complete Sheet</Button></a>
      <div class="table-responsive">
      <table class="table table-bordered" id="data_panel">
        <thead>
        <tr>
         <th>CN</th>
         <th>Manual CN</th>
         <th>Name</th>
         <th>Phone</th>
         <th>Address</th>
         <th>COD</th>
         <th>Weight</th>
         <th>Date</th>        
         <th>DD Code</th>
         <th>Action</th>
        </tr>
      </thead>
      <tbody id="autoload">
         <?php if(!empty($delivery_sheet_data)){
             foreach($delivery_sheet_data as $rows){
             echo("<tr>");
             echo("<input type='hidden' value='".$rows->Sheet."' id='sheet_code'>");
             echo("<td>".$rows->cn."</td>");
             echo("<td>".$rows->manual."</td>");
             echo("<td>".$rows->name."</td>");
             echo("<td>".$rows->phone."</td>");
             echo("<td>".$rows->address."</td>");
             echo("<td>".$rows->cod."</td>");
             echo("<td>".$rows->weight."</td>");
             echo("<td>".$rows->date."</td>");
             echo("<td>".$rows->Sheet."</td>");
             echo("<td><button class='btn btn-xs btn-danger' onclick='remove(".$rows->cn.")'>Remove</button></td>");
             echo("</tr>");  
        }}  ?>
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
 
function remove(cn){
//-------Checking Conditions---------
var mydata={
cn          :cn
};
$.ajax({
url: "<?php echo base_url(); ?>Delivery/remove_cn",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
}
});

}



$('#cn').keypress(function(e) {
if (e.keyCode == 13) {
$("#autoload").html("<center><img src='<?php echo base_url();?>assets/ajax-loader.gif'></center>");      
var check="Pass";
var rider="";
var route="";
var cn="";
var delivery_sheet_code="";
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

//------------Route
if($("#route").val()!=""){
route=$("#route").val();
$("#route_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#route_div").css("border-color", "red"); 
$("#route").focus();
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
rider                      :rider,
route                      :route,
cn                         :cn,
delivery_sheet_code        :<?php echo "'".$delivery_sheet_code."'"; ?>
};
$.ajax({
url: "<?php echo base_url(); ?>Delivery/delivery_process",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
$.ajax({
url: "<?php echo base_url(); ?>Delivery/Get_Delivery_Sheet_By_Code_Nums",
type: "POST",
data: mydata,        
success: function(data) {
$("#countsss").html(data);
}
});
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