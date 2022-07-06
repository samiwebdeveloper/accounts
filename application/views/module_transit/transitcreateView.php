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
                  <li class="breadcrumb-item">Manifest</li>
                  <li class="breadcrumb-item">Create Sheet</li>
                  <li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:s'); ?></mark></li>
                   <li class="breadcrumb-item"><mark><?php echo $loading_sheet_code; ?></mark></li>
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
     <div class="card-title">Create Manifest</div>
      </div>
   <div class="card-body">
<h5>Scan Shipments</h5>
<form role="form">
<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2021-01-14"</span>
<input type="text" value="<?php echo date('Y-m-d h:i:s'); ?>" class="form-control"  readonly="" >
</div>
<div class="form-group">
<label>Manifest Sheet Code</label>
<span class="help">e.g. "<?php echo $loading_sheet_code; ?>"</span>
<input type="text" value="<?php echo $loading_sheet_code; ?>" class="form-control"  readonly="" >
</div>
<div class="form-group" id="seal_no_div">
<label>Manifest Seal No</label>
<input type="text" name="seal_no" id="seal_no" class="form-control"  onblur="check_seal()">
<input type="hidden" name="chk_seal_no" id="chk_seal_no">
</div>
<div class="form-group" id='staff_name_div'>
<label>Staff / Driver</label>
<span class="help">e.g. "Muhammad Saim"</span>   
<input type="text" name="staff_name" id="staff_name" placeholder="Staff/ Driver/ Name"  class="form-control" >
</div>
<div class="form-group" id='staff_number_div'>
<label>Staff / Driver Phone</label>
<span class="help">e.g. "03334616162"</span>   
<input type="text" name="staff_number"  id="staff_number" placeholder='Staff/ Driver/ Mobile' class="form-control" >
</div>
<div class="form-group" id='vehicle_no_div'>
<label>Vehicle No / Tracking Number</label>
<span class="help">e.g. "LEK-17-1155"</span>    
<input type="text" name="vehicle_no" id="vehicle_no" placeholder='Van/Truck/Car Number' class="form-control" >
</div>
<div class="form-group" id="route_div">
<label>Route</label>
<span class="help">e.g. "LHE-KHI"</span>
<select class="form-control" data-init-plugin="select2" id="route" name="route">
<option value=0>Select Route</option>
<?php
if(!empty($route_data)){
foreach($route_data as $rows){
if($_SESSION['origin_id']==$rows->route_origin_id){    
echo("<option value='".$rows->route_list_id."'>".$rows->route_name."</option>");    
}}} 
?>
</select>
</div>
<div class="form-group" id="cn_div">
<label>CN</label>
<span class="help">e.g. "14201900001"</span>
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

<li ><a href="<?php echo base_url(); ?>Loading/complete_sheet/<?php echo $loading_sheet_code; ?>" style="opacity:100%;"><Button class='btn btn-primary'>Complete Sheet</Button></a>
</li>
</ul>
</div>
      </div>
    <div class="card-body">
      <div class="table-responsive">
      <table class="table table-bordered" id="data_panel">
        <thead>
        <tr>
         <th>Sr</th>    
         <th>CN</th>
         <th>manual</th> 
         <th>Pieces</th>        
         <th>Weight</th>
         <th>COD</th>
         <th>Destination</th>
         <th>Route</th>
         <th>Date</th>
         <th>Action</th>
        </tr>
      </thead>
      <tbody id="autoload">
       <?php if(!empty($loading_sheet_data)){
             $i;
             foreach($loading_sheet_data as $rows){
            $i=$i+1;      
             echo("<tr>");
             echo("<input type='hidden' value='".$rows->transit_code."' id='sheet_code'>");
             echo("<td>".$i."</td>");
             echo("<td>".$rows->transit_cn."</td>");
             echo("<td>".$rows->manual_cn."</td>");
             echo("<td>".$rows->pieces."</td>");
             echo("<td>".$rows->$rows->weight."</td>");
             if($rows->order_pay_mode=='ToPay' || $rows->order_pay_mode=='Topay'){
  echo("<td><center>".$rows->cod_amount."</center></td>");
    } else {
  echo("<td><center>"."0"."</center></td>");
    }
             echo("<td>".$rows->ActualD."</td>");
             echo("<td>".$rows->route_name."</td>");
             echo("<td>".$rows->tDate."</td>");
             echo("<td><button class='btn btn-xs btn-danger' onclick='remove(".$rows->transit_cn.")'>Remove</button></td>");
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
url: "<?php echo base_url(); ?>Loading/remove_cn",
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
var seal="";
var route="";
var staff_name="";
var staff_number="";
var chk_seal=$("#chk_seal_no").val();
var cn="";
var loading_sheet_code="<?php echo $loading_sheet_code; ?>";
//------------Seal_no
if(chk_seal=="Y"){
if($("#seal_no").val()!=""){
seal=$("#seal_no").val();
$("#seal_no").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#seal_no").css("border-color", "red"); 
$("#seal_no").focus();
check="Fail";
}
} else{
check="Pass";  
} 
//--------------------------------End
//------------Seal_no
if($("#seal_no").val()!=""){
seal=$("#seal_no").val();
$("#seal_no").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#seal_no").css("border-color", "red"); 
$("#seal_no").focus();
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
//------------route
if($("#route").val()!=0){
route=$("#route").val();
$("#route").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#route_div").css("border-color", "red"); 
$("#route").focus();
check="Fail";
}
//--------------------------------End
//------------Staff Name
if($("#staff_name").val()!=""){
staff_name=$("#staff_name").val();
$("#staff_name").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#staff_name").css("border-color", "red"); 
$("#staff_name").focus();
check="Fail";
}
//--------------------------------End
//------------Staff Number
if($("#staff_number").val()!=""){
staff_number=$("#staff_number").val();
$("#staff_number").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#staff_number").css("border-color", "red"); 
$("#staff_number").focus();
check="Fail";
}
//--------------------------------End
//------------Vehicle No
if($("#vehicle_no").val()!=""){
vehicle_no=$("#vehicle_no").val();
$("#vehicle_no").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#vehicle_no").css("border-color", "red"); 
$("#vehicle_no").focus();
check="Fail";
}
//--------------------------------End

//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
seal_no             :seal,
cn                  :cn,
loading_sheet_code  :loading_sheet_code,
route               :route,
staff_name          :staff_name,
staff_number        :staff_number,
vehicle_no          :vehicle_no    
};
$.ajax({
url: "<?php echo base_url(); ?>Loading/Loading_process",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
$("#seal_no").prop("readonly",true);
$("#loading_sheet_code").prop("readonly",true);
$('#route').select2({disabled: true});
$("#staff_name").prop("readonly",true);
$("#staff_number").prop("readonly",true);
$("#vehicle_no").prop("readonly",true);
}
});
$("#cn").val("");
}

}
});


function check_seal(){
var seal_no     = "";
var check       = "Pass";
$("#chk_seal_no").val("N");
//------------Rider
if($("#seal_no").val()!=""){
seal_no=$("#seal_no").val();
$("#seal_no").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#seal_no").css("border-color", "red"); 
check="Fail";
}
//--------------------------------End
if(check!="Fail"){  
var mydata={
seal_no    : seal_no
};
$.ajax({
url: "<?php echo base_url(); ?>Loading/loading_seal",
type: "POST",
data: mydata,        
success: function(data) {
//-------------------
if(data==1){
$("#chk_seal_no").val("N");
$("#seal_no").css("border-color", "red");} 
else if(data==0){
$("#chk_seal_no").val("Y");
$("#seal_no").css("border-color", "green");}  
}
//-------------------
});
}
}


  
</script>




</div>
</div>
<?php
$this->load->view('inc/footer');
?>      