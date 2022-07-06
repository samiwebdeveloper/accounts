<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$('#data_panel').saimtech();
$('#pending_panel').saimtech();
$('#o_city').saimtech();
$('input[type="number"]').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
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
                  <li class="breadcrumb-item">Customers</li>
                  <li class="breadcrumb-item">Destinations</li>
                  <li class="breadcrumb-item">Add Rates</li>
                </ol>
                <!-- END BREADCRUMB --> 
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
<!--<div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>-->
<div class="row">
   
           

                  <div class="col-xl-12 col-lg-12" >

                <!-- START card -->
               
                    
               <div class=" container-fluid   container-fixed-lg bg-gray"  >
<div class="row">

<div class="col-md-8" >
  <div class="card m-t-10">
    <div class="card-header ">
     <div class="card-title">Zone Wise Rate Rates</div>

   <table>
       <thead>
                <form method="post" action="<?php echo base_url(); ?>index.php/Dest_Rate/Add_Zone_Rate">
                <input type='hidden' value='<?php echo $customer_id;?>' name="zone_customer_id"  id="zone_customer_id">
           <tr>
               <th style="text-align: center;">Zone A</th>
               <th style="text-align: center;">A GST</th>
               <th style="text-align: center;">Zone B</th>
               <th style="text-align: center;">B GST</th>
               <th style="text-align: center;">Zone C</th>
               <th style="text-align: center;">C GST</th>
               <th style="text-align: center;">Zone D</th>
               <th style="text-align: center;">D GST</th>
               <th style="text-align: center;">Service Type</th>
               <th style="text-align: center;">Action</th>
           </tr>
            <tr class="filters">
               <th><input style="background-color:#e1f3fa;" type="number" class="form-control" name="zone_a" id="zone_a" required=""  tabindex="1" aria-required="true"></th>
               <th><input style="background-color:#e1f3fa;" type="number" class="form-control" name="zone_a_gst" id="zone_a_gst" required="" tabindex="2" aria-required="true"></th>
               <th><input style="background-color: #faf2e1;" type="number" class="form-control" name="zone_b" id="zone_b" required="" tabindex="3" aria-required="true"></th>
               <th><input style="background-color: #faf2e1;" type="number" class="form-control" name="zone_b_gst" id="zone_b_gst" required="" tabindex="4" aria-required="true"></th>
               <th><input style="background-color: #c8cbe6" type="number" class="form-control" name="zone_c" id="zone_c" required="" tabindex="5" aria-required="true"></th>
               <th><input style="background-color: #c8cbe6" type="number" class="form-control" name="zone_c_gst" id="zone_c_gst" required="" tabindex="6" aria-required="true"></th>
               <th><input style="background-color: #c8e6cd;" type="number" class="form-control" name="zone_d" id="zone_d" required="" tabindex="7" aria-required="true"></th>
               <th><input style="background-color: #c8e6cd;" type="number" class="form-control" name="zone_d_gst" id="zone_d_gst" required="" tabindex="8" aria-required="true"></th>
               <th width=12%;><select class='form-control' name="zone_service_type" id="zone_service_type" tabindex="9">
<option value="">Select</option>
<?php if(!empty($shipment_types)){ 
foreach($shipment_types as $type){
echo("<option value=".$type->service_id.">".$type->service_name."</option>");}}?>    
</select></th>
               <th><button  type="submit" class="btn btn-info" tabindex="10">Add</button></th>
           </tr>
           
           <?php if(!empty($zone_data)){
			foreach($zone_data as $rows)
				{
					?>
					
           echo ("<tr style="border: 1px solid 	#b8a9a9; text-align:center;>")
          
           <td></td>
           <td onclick="fill_destination_form()"><?php echo $rows->zone_a_rate; ?></td>
           <td><?php echo $rows->zone_a_gst; ?></td>
           <td><?php echo $rows->zone_b_rate; ?></td>
           <td><?php echo $rows->zone_b_gst; ?></td>
           <td><?php echo $rows->zone_c_rate; ?></td>
           <td><?php echo $rows->zone_c_gst; ?></td>
           <td><?php echo $rows->zone_d_rate; ?></td>
           <td><?php echo $rows->zone_d_gst; ?></td>
           <td><?php echo $rows->service_name; ?></td>
           <td><button  type="submit" class="btn btn-info btn-xs"  tabindex="50">Edit</button></td>
           </tr>
           <?php 
										 
										 }
										 }
										 ?>
              </form>
      </thead>
   </table>



</div>
</div>
</div>

<div style="margin-left:-15px;" class="col-md-4">
  <div class="card m-t-10">
    <div class="card-header">
     <div class="card-title">Destination wise Rates</div>
     <table>
         <thead>
             <form method="post" action="<?php echo base_url(); ?>index.php/Dest_Rate/Add_Destination_Rate">
                 <input type='hidden' value='<?php echo $customer_id;?>' name="dest_customer_id">
             <tr>
                 <th style="text-align: center;">Origin</th>
                 <th style="text-align: center;">Destination</th>
                 <th style="text-align: center;">Rate</th>
                 <th style="text-align: center;">Add Rate</th>
                 <th style="text-align: center;">Action</th>
             </tr>
             <tr>
                  <td width=22%;><select class='form-control' name="origin_city_id" id="origin_city_id"  tabindex="11">
<option value="">Select</option>
<?php if(!empty($cities_data)){
foreach($cities_data as $rows){
echo("<option value='".$rows->city_id."'> ".$rows->city_name."</option>");    
}}?>     
</select></td>
                 <td width=22%;><select class='form-control' name="origin_city_id" id="origin_city_id"  tabindex="11">
<option value="">Select</option>
<?php if(!empty($cities_data)){
foreach($cities_data as $rows){
echo("<option value='".$rows->city_id."'> ".$rows->city_name."</option>");    
}}?>     
</select></td>
<input type="hidden"  name="d_zone_name" id="d_zone_name" required=""  >
<input type="hidden"  name="d_zone_service" id="d_zone_service" required=""  >
<input type="hidden"  name="d_zone_rate_id" id="d_zone_rate_id" required=""  >
        <td><input type="number" class="form-control" name="rate" id="rate" required=""  tabindex="12"  aria-required="true"></td>
        <td><input  type="number" class="form-control date" name="additional_rate" id="additional_rate" required="" tabindex="13" aria-required="true"></td>
        
        <td><button  type="submit" class="btn btn-info" tabindex="15">Add</button></td>
             </tr>
             
             <?php if(!empty($dest_data)){
			foreach($dest_data as $rows)
				{
					?>
					
           echo ("<tr style="border: 1px solid 	#b8a9a9; text-align:center;>")
          
           <td></td>
           <td><?php echo $rows->origin_city_id; ?></td>
           <td><?php echo $rows->dest_city_id; ?></td>
           <td><?php echo $rows->rate; ?></td>
           <td><?php echo $rows->additional_rate; ?></td>
           <td><button  type="submit" class="btn btn-info btn-xs"  tabindex="50">Edit</button></td>
           </tr>
           <?php 
										 
										 }
										 }
										 ?>
             
             </form>
         </thead>
     </table>

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
url: "<?php echo base_url(); ?>Arrival/remove_cn",
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
var cn="";
var arrival_sheet_code="";
//----------------------------Start--------------------------------------------------------------------p
//------------Zone A-------
if($("#zone_a").val()!=""){
rider=$("#zone_a").val();
$("#zone_a").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#zone_a").css("border-color", "red"); 
$("#zone_a").focus();
check="Fail";
}
//--------------------------------End
//------------Zone A GST-------
if($("#zone_a_gst").val()!=""){
rider=$("#zone_a_gst").val();
$("#zone_a_gst").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#zone_a_gst").css("border-color", "red"); 
$("#zone_a_gst").focus();
check="Fail";
}
//--------------------------------End
//------------Zone B-------
if($("#zone_b").val()!=""){
rider=$("#zone_b").val();
$("#zone_b").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#zone_b").css("border-color", "red"); 
$("#zone_b").focus();
check="Fail";
}
//--------------------------------End
//------------Zone B GST-------
if($("#zone_b_gst").val()!=""){
rider=$("#zone_b_gst").val();
$("#zone_b_gst").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#zone_b_gst").css("border-color", "red"); 
$("#zone_b_gst").focus();
check="Fail";
}
//--------------------------------End
//------------Zone C-------
if($("#zone_c").val()!=""){
rider=$("#zone_c").val();
$("#zone_c").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#zone_c").css("border-color", "red"); 
$("#zone_c").focus();
check="Fail";
}
//--------------------------------End
//------------Zone C GST-------
if($("#zone_c_gst").val()!=""){
rider=$("#zone_c_gst").val();
$("#zone_c_gst").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#zone_c_gst").css("border-color", "red"); 
$("#zone_c_gst").focus();
check="Fail";
}
//--------------------------------End
//------------Zone D-------
if($("#zone_d").val()!=""){
rider=$("#zone_d").val();
$("#zone_d").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#zone_d").css("border-color", "red"); 
$("#zone_d").focus();
check="Fail";
}
//--------------------------------End
//------------Zone D GST-------
if($("#zone_d_gst").val()!=""){
rider=$("#zone_d_gst").val();
$("#zone_d_gst").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#zone_d_gst").css("border-color", "red"); 
$("#zone_d_gst").focus();
check="Fail";
}
//--------------------------------End
//------------Zone Service Type-------
if($("#zone_service_type").val()!=""){
rider=$("#zone_service_type").val();
$("#zone_service_type").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#zone_service_type").css("border-color", "red"); 
$("#zone_service_type").focus();
check="Fail";
}
//--------------------------------End
//---------Destination_Cities----
if($("#dest_city").val()!=""){
o_city=$("#dest_city_id").val();
$("#dest_city_id").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#dest_city_id").css("border-color", "red"); 
$("#dest_city_id").focus();
check="Fail";
}
//--------------------------------End
//------------Rate-------
if($("#rate").val()!=""){
rider=$("#rate").val();
$("#rate").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#rate").css("border-color", "red"); 
$("#rate").focus();
check="Fail";
}
//--------------------------------End
//------------Add. Rate-------
if($("#additional_rate").val()!=""){
rider=$("#additional_rate").val();
$("#additional_rate").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#additional_rate").css("border-color", "red"); 
$("#additional_rate").focus();
check="Fail";
}
//--------------------------------End
//------------Destination Service Type-------
if($("#service_type_id").val()!=""){
rider=$("#service_type_id").val();
$("#service_type_id").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#service_type_id").css("border-color", "red"); 
$("#service_type_id").focus();
check="Fail";
}
//--------------------------------End
//---------------------------------------------END----------------------------------------------------------------------

//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
rider                      :rider,
cn                         :cn,
arrival_sheet_code        :<?php echo "'".$arrival_sheet_code."'"; ?>
};
$.ajax({
url: "<?php echo base_url(); ?>Arrival/arrival_process",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
$.ajax({
url: "<?php echo base_url(); ?>Arrival/sheet_count/<?php echo $arrival_sheet_code; ?>",
type: "POST",
data: mydata,        
success: function(data) {
$("#short_excess").html(data);
}
});
}
});
$("#cn").val("");
}

}
});




function update_pieces(id){
var pieces= 0; 
var check='Pass';
var sheet=$("#sheet_code").val();
//------------Rider
if($("#pieces-"+id).val()!="" && $("#pieces-"+id).val()!=0){
pieces=$("#pieces-"+id).val();
$("#pieces-"+id).css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#pieces-"+id).css("border-color", "red"); 
$("#pieces-"+id).focus();
check="Fail";
}
//--------------------------------End
//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
pieces                     :pieces,
id                         :id,
sheet                      :sheet  
};
$.ajax({
url: "<?php echo base_url(); ?>Arrival/update_pieces",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
}
});
}

}

function fill_destination_form(){
var zone_name="";
var zone_rate_id="";
var service_type="";
var customer_id=$("#zone_customer_id").val();
alert("saim");

}


function destination_submit(){
var zone_name="";
var zone_rate_id="";
var service_type="";
var customer_id=$("#zone_customer_id").val();   
}

function update_weight(id){
var weight= 0; 
var check='Pass';
var sheet=$("#sheet_code").val();
//------------Rider
if($("#weight-"+id).val()!="" && $("#weight-"+id).val()!=0){
weight=$("#weight-"+id).val();
$("#weight-"+id).css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#weight-"+id).css("border-color", "red"); 
$("#weight-"+id).focus();
check="Fail";
}
//--------------------------------End
//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
weight                     :weight,
id                         :id,
sheet                      :sheet  
};
$.ajax({
url: "<?php echo base_url(); ?>Arrival/update_weight",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
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