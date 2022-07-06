<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$('#d_city').select2();
$('#pick_point').select2();
$('#o_city').select2();
$('#customer_id').select2();
 $('input[type="number"]').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    });
  
  
  
    $('input[type="date"]').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    });
  
  

  $('input[type="text"]').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    }); 


    $('input[type="email"]').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    }); 
  
    
  
  
  $('checkbox').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    });
 });
</script>
 <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START JUMBOTRON -->
          <!-- <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0" style="background-image:linear-gradient(45deg, #1f3953, #2B6A94);color:white">
              <div class="inner">
                <!-- START BREADCRUMB -->
                <!--  <ol class="breadcrumb">
                  <li class="breadcrumb-item">Booking</li>
                  <li class="breadcrumb-item">Single Booking</li>
                  <li class="breadcrumb-item"><mark><?php echo date('Y-m-d H:i:s'); ?></mark></li>
                </ol>
                <!-- END BREADCRUMB --> 
             <!--  </div>
            </div>
          </div>------>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg" >
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
<div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>
<div class="row" >
   
           

                  <div class="col-xl-12 col-lg-12" >

                <!-- START card -->
               
                    
               <div class=" container-fluid   container-fixed-lg bg-white"   >
<div class="row">



<!--------------Right Side End----------->
<div class="col-md-12">
<div class="card card-transparent">
<div class="card-body">
<!--------Start Shipment Detail------->
<input type="hidden" name="order_id" id="order_id">
<p><strong>Shipment Detail</strong></p>
<div class="form-group-attached">
<div class="row clearfix">
<div class="col-md-3">
<div class="form-group form-group-default required" aria-required="true" id="customer_id_div">
<label>Select Customer</label>
<select  class="form-control" name="customer_id" id="customer_id" tabindex="1" required="" onchange="cusotmer_mode()" aria-required="true">
<option value=""> Select Customer</option>
<?php if(!empty($customer_data)){
        foreach($customer_data as $types){
        echo("<option value='".$types->customer_id."'>[".$types->customer_account_no."] ".$types->customer_note."</option>");    
        }
      }
  ?>    
</select>
</div>
</div>
<div class="col-md-3">
<div class="form-group form-group-default" aria-required="true" id="manual_cn_div">
<label>Manual CN</label>
<input  type="text" class="form-control" onblur="auto_fill_MCN(), check_mcn();" name="manual_cn" id="manual_cn" tabindex="2" aria-required="true">
</div>
</div>
<div class="col-md-3">
<div class="form-group form-group-default required" aria-required="true" id="order_date_div">
<label>Booking Date</label>
<input type="text" class="form-control"  name="order_date" id="order_date"  tabindex="3" value="<?php echo date('Y-m-d'); ?>" readonly="">
</div>
</div>
<div class="col-md-3">
<div class="form-group form-group-default" id="reference_no_div">
<label>Reference No</label>
<input type="text" class="form-control"  name="reference_no" id="reference_no">
</div>
</div>
</div>
</div>
<!--------End Shipment Detail------->

<!--------End Consignor Detail------>
<p class="m-t-10"><strong>Consignor Detail</strong></p>
<div class="form-group-attached">
<div class="row clearfix">
<div class="col-md-3">
<div class="form-group form-group-default required" aria-required="true" id="o_city_div">
<label>Consignor Origin City</label>
<select class='form-control' name="o_city" id="o_city" tabindex="4" >
<option value="">Select Origin City</option>
<?php if(!empty($cities_data)){
foreach($cities_data as $rows){
echo("<option value='".$rows->city_id."'>(".$rows->city_code.") (".$rows->city_short_code.") ".$rows->city_name."</option>");    
}}?>     
</select>
</div>
</div>
<div class="col-md-3">
<div class="form-group form-group-default required" aria-required="true" id="s_name_div">
<label>Consignor Name <i class="fa fa-info text-complete m-l-5"></i>
</label>
<input type="text" class="form-control" name="s_name" id="s_name" tabindex="5">
</div>
</div>
<div class="col-md-3">
<div class="form-group form-group-default required" aria-required="true"  id="s_phone_div">
<label>Consignor Phone</label>
<input id="s_phone" type="text" class="form-control" name="s_phone" required="" tabindex="6" aria-required="true">
</div>
</div>
<div class="col-md-3">
<div class="form-group form-group-default" id="s_email_div">
<label>Consignor Email</label>
<input type="email" class="form-control email" value="test@test.com" name="s_email" tabindex="7" id="s_email" autocomplete="on">
</div>
</div>
</div>
<div class="row clearfix">
<div class="col-md-12">
<div class="form-group form-group-default" id="s_address_div">
<label>Consignor Address</label>
<input class="form-control" name="s_address" id="s_address" tabindex="8">
</div>
</div>
</div>
</div>
<!--------End Consignor Detail------->

<!--------Start Consignee Detail----->
<div class="form-group-attached">
<p class="m-t-10"><strong>Consignee Detail</strong></p>
<div class="row clearfix">
<div class="col-md-3">
<div class="form-group form-group-default required" aria-required="true" id="d_city_div">
<label>Consignee Destination City</label>
<select class='form-control' name="d_city" id="d_city"  tabindex="9">
<option value="">Select Destination City</option>
<?php if(!empty($cities_data)){
foreach($cities_data as $rows){
echo("<option value='".$rows->city_id."'>(".$rows->city_code.") (".$rows->city_short_code.") ".$rows->city_name."</option>");    
}}?>     
</select>
</div>
</div>
<div class="col-md-3">    
<div class="form-group form-group-default required" aria-required="true"  id="c_name_div">
<label>Consignee Name <i class="fa fa-info text-complete m-l-5"></i>
</label>
<input type="text" class="form-control" name="c_name" id="c_name" onblur="auto_fill();" tabindex="10">
</div>
</div>
<div class="col-md-3">
<div class="form-group form-group-default required" aria-required="true" id="c_phone_div">
<label>Consignee Phone</label>
<input id="c_phone" type="text" class="form-control date" name="c_phone" required="" tabindex="11" aria-required="true">
</div>
</div>
<div class="col-md-3">
<div class="form-group form-group-default" id="c_email_div">
<label>Consignee Email</label>
<input type="email" class="form-control email" value="test@test.com" name="c_email" id="c_email" tabindex="12" autocomplete="on">
</div>
</div>
</div>
<div class="row clearfix">
<div class="col-md-12">
<div class="form-group form-group-default" id="c_address_div">
<label>Consignee Address</label>
<input type="text" class="form-control" name="c_address" id="c_address" tabindex="13" autocomplete="on">
</div>
</div>
</div>
</div>
<!--------End Consignee Detail------->

<!--------Start Shipment Detail------>
<p class="m-t-10"><strong>Shipment Detail</strong></p>
<div class="form-group-attached">
<div class="row clearfix">
<div class="col-md-2">
<div class="form-group form-group-default required" aria-required="true" id="product_detail_div">
<label>Product Type</label>
<input type="text" class="form-control" name="product_detail" id="product_detail" tabindex="14">

</div>
</div>
<div class="col-md-2">
<div class="form-group form-group-default required" aria-required="true" id="pay_mode_div">
<label>Pay Mode</label>
<select class='form-control' name="pay_mode" onchange="emode();" id="pay_mode" tabindex="15">
<option value="">Select Pay  Mode</option>
</select>
</div>
</div>
<div class="col-md-2">
<div class="form-group form-group-default required" aria-required="true" id="service_type_div">
<label>Service Type</label>
<select class='form-control' name="service_type" id="service_type" tabindex="16">
<?php if(!empty($shipment_types)){ 
foreach($shipment_types as $type){
echo("<option value=".$type->service_id.">".$type->service_name."</option>");}}?>    
</select>
</div>
</div>
<div class="col-md-2">
<div class="form-group form-group-default required" aria-required="true" id="packing_type_div">
<label>Packing Type</label>
<select class='form-control' name="packing_type" id="packing_type" tabindex="17">
<option value="Carton">Carton</option>
<option value="Sack">Sack</option>
<option value="Container">Container</option>
<option value="Open/Loose">Open/Loose</option>
</select>
</div>
</div>
<div class="col-md-2">
<div class="form-group form-group-default required" aria-required="true" id="order_piece_div">
<label>Pieces</label>
<input type="number" class="form-control"  name="order_piece" id="order_piece" tabindex="18">
</div>
</div>
<div class="col-md-2">
<div class="form-group form-group-default required" id="order_weight_div">
<label>Weight(KG)</label>
<input type="number" class="form-control" name="order_weight" id="order_weight" tabindex="19">
</div>
</div>
</div>
<input type="hidden" id="cod_hidden" name="cod_hidden">
<div class="row clearfix" id="result_div">
<div class="col-md-4" id="cod_div_div">
<div class="form-group form-group-default required" id="cod_div">
<label>COD/CASH</label>
<input type="number" class="form-control" value=0 name="cod" id="cod" autocomplete="on" tabindex="20">
</div>
</div>
<div class="col-md-8" id="remark_div_div">
<div class="form-group form-group-default" id="remark_div">
<label>Description</label>
<input type="text" class="form-control" name="remark" id="remark" autocomplete="on" tabindex="21">
</div>
</div>
</div>
</div>
<br>
<input type='hidden' id="is_cod" name="is_cod">

<div class="form-group-attached">
<div class="row clearfix">
<button class="btn btn-info" onclick="add_shipment()" tabindex="22" id="book-save">Book Shipment</button>
<button class="btn btn-default"><i class="pg-close"></i> Clear</button>
</div>
</div>


</div>
</div>
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
<script type="text/javascript">
function cusotmer_mode(){
    
$("#customer_pay_mode").val("");
var customer=$("#customer_id").val();    
if(customer!=""){
var mydata={customer_id : customer}    
$.ajax({
url: "<?php echo base_url(); ?>Booking/Booking/get_pay_mode",
type: "POST",
data: mydata,        
success: function(data) {
if(data!=""){
var myArr = JSON.parse(data);    
$("#customer_pay_mode").val(myArr.pay_mode);
$("#s_phone").val(myArr.phone);
$("#s_email").val(myArr.email);
$("#s_name").val(myArr.name);
$("#product_detail").val(myArr.product_type);
$("#s_address").val(myArr.address);
$("#o_city").val(myArr.city).change();
//==========Service Type
if(myArr.service_type=="1"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='1'>Over Night</option></select>";
$("#service_type_div").html(uhtml);  
}  else if(myArr.service_type=="2"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='2'>Over Land</option></select>";
$("#service_type_div").html(uhtml);  
}  else if(myArr.service_type=="3"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='3'>Detain</option></select>";
$("#service_type_div").html(uhtml);     
}  else if(myArr.service_type=="4"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='4'>Air Frieght</option></select>";
$("#service_type_div").html(uhtml);
}  else if(myArr.service_type=="5"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='1'>Over Night</option><option value='2'>Over Land</option></select>";
$("#service_type_div").html(uhtml);
}  else if(myArr.service_type=="6"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='1'>Over Night</option><option value='3'>Detain</option></select>";
$("#service_type_div").html(uhtml);
}  else if(myArr.service_type=="7"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='1'>Over Night</option><option value='4'>Air Frieght</option></select>";
$("#service_type_div").html(uhtml);
}  else if(myArr.service_type=="8"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='2'>Over Land</option><option value='3'>Detain</option></select>";
$("#service_type_div").html(uhtml);
}  else if(myArr.service_type=="9"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='2'>Over Land</option><option value='4'>Air Frieght</option></select>";
$("#service_type_div").html(uhtml);
}  else if(myArr.service_type=="10"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='3'>Detain</option><option value='4'>Air Frieght</option></select>";
$("#service_type_div").html(uhtml);    
}  else if(myArr.service_type=="11"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='1'>Over Night</option><option value='3'>Detain</option><option value='4'>Air Frieght</option></select>";
$("#service_type_div").html(uhtml);    
}  else if(myArr.service_type=="12"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='1'>Over Night</option><option value='2'>Over Land</option><option value='3'>Detain</option><option value='4'>Air Frieght</option></select>";
$("#service_type_div").html(uhtml);
}  else if(myArr.service_type=="13"){
uhtml="<label>Service Type</label><select class='form-control' name='service_type' id='service_type' tabindex='16'><option value='1'>Over Night</option><option value='2'>Over Land</option><option value='3'>Detain</option></select>";
$("#service_type_div").html(uhtml);
}

if(myArr.pay_mode=="1"){
$("#is_cod").val("Deactive");
var myhtml="<div class='col-md-12' id='remark_div_div'><div class='form-group form-group-default' id='remark_div'><label>Description</label><input type='text' class='form-control' name='remark' id='remark' autocomplete='on' tabindex='21'></div></div>";
$("#result_div").html(myhtml);
//var selecthtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='Account'>Account</option><option value='ToPay'>To Pay</option><option value='Cash'>Cash</option><option value='FOC'>FOC</option></select>";
myhtmml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='Account'>Account</option></select>";    
$("#pay_mode_div").html(myhtmml); 





//$("#pay_mode_div").html(selecthtml);
} else {
$("#is_cod").val("Active");
var myhtml="<div class='col-md-4' id='cod_div_div'><div class='form-group form-group-default required' id='cod_div'><label>COD/CASH</label><input type='number' class='form-control' name='cod' id='cod' autocomplete='on' tabindex='20'></div></div><div class='col-md-8' id='remark_div_div'><div class='form-group form-group-default' id='remark_div'><label>Description</label><input type='text' class='form-control' name='remark' id='remark' autocomplete='on' tabindex='21'></div></div>";
$("#result_div").html(myhtml);
var selecthtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value="+myArr.pay_mode+">"+myArr.pay_mode+"</option><option value='Account'>Account</option><option value='ToPay'>To Pay</option><option value='Cash'>Cash</option><option value='FOC'>FOC</option></select>";
 if(myArr.pay_mode==2){
myhtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='ToPay'>FOD</option></select>";    
$("#pay_mode_div").html(myhtml);      
} else if(myArr.pay_mode==3){
myhtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='Account'>Account</option><option value='Topay'>FOD</option></select>";    
$("#pay_mode_div").html(myhtml);
$("#is_cod").val("Deactive");
var myhtml="<div class='col-md-12' id='remark_div_div'><div class='form-group form-group-default' id='remark_div'><label>Description</label><input type='text' class='form-control' name='remark' id='remark' autocomplete='on' tabindex='21'></div></div>";
$("#result_div").html(myhtml);
} else if(myArr.pay_mode==4){
myhtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='Cash'>Cash</option></select>";    
$("#pay_mode_div").html(myhtml);      
} else if(myArr.pay_mode==5){
myhtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='FOC'>FOC</option></select>";    
$("#pay_mode_div").html(myhtml);      
    
} 
var codh=$("#cod_hidden").val();
$("#cod").val(codh);
//$("#pay_mode_div").html(selecthtml);
}    
}
}
});
    
}
}





function check_mcn(){
var codh=$("#cod_hidden").val();
$("#cod").val(codh);
var manual_cn=$("#manual_cn").val();     
if(manual_cn!=""){
var mydata={manual_cn : manual_cn}    
$.ajax({
url: "<?php echo base_url(); ?>Booking/Booking/check_manual_cn_e_all",
type: "POST",
data: mydata,        
success: function(data) {
if(data==0){
$("#manual_cn_div").css("border-color", "green");  
$("#book-save").show();
    
} else {
$("#manual_cn_div").css("border-color", "red");   
$("#manual_cn").focus();   
$("#book-save").hide();
}
}
});    
}
}



function auto_fill(){
var customer=$("#customer_id").val(); 
var destination=$("#d_city").val();
var name=$("#c_name").val();
if(customer!="" && destination!="" && name!=""){
var mydata={
customer : customer,
destination : destination,
name : name
}    
$.ajax({
url: "<?php echo base_url(); ?>Booking/Booking/get_cong_detail",
type: "POST",
data: mydata,        
success: function(data) {
if(data!=""){
var codh=$("#cod_hidden").val();
$("#cod").val(codh);  
var myArr = JSON.parse(data);    

var paymodeid=myArr.pay_mode_id;    
if(paymodeid==1){
myhtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='Account'>Account</option></select>";    
$("#pay_mode_div").html(myhtml);    
} else if(paymodeid==2){
myhtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='ToPay'>FOD</option></select>";    
$("#pay_mode_div").html(myhtml);      
} else if(paymodeid==3){
myhtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='Account'>Account</option><option value='Topay'>FOD</option></select>";    
$("#pay_mode_div").html(myhtml);      
} else if(paymodeid==4){
myhtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='Cash'>Cash</option></select>";    
$("#pay_mode_div").html(myhtml);      
} else if(paymodeid==5){
myhtml="<label>Pay Mode</label><select class='form-control' name='pay_mode' onchange='emode();' id='pay_mode' tabindex='15'><option value='Cash'>FOC</option></select>";    
$("#pay_mode_div").html(myhtml);      
    
} 
    

if($("#c_phone").val()==""){
$("#c_phone").val(myArr.phone);
$("#c_phone").select();
}
if(myArr.email!=""){
$("#c_email").val(myArr.email);
} else {
$("#c_email").val("test@test.com");    
} 
$("#c_address").val(myArr.address);
}
}
});
}
}

function auto_fill_MCN(){
    
var manual_cn=$("#manual_cn").val(); 
if(manual_cn!=""){
var mydata={
manual_cn : manual_cn
}    
$.ajax({
url: "<?php echo base_url(); ?>Booking/Booking/auto_fill_MCN_all",
type: "POST",
data: mydata,        
success: function(data) {
if(data!=""){
var myArr = JSON.parse(data);    
$("#c_phone").val(myArr.consignee_mobile);
$("#c_name").val(myArr.consignee_name);
$("#c_email").val(myArr.consignee_email);
$("#c_address").val(myArr.consignee_address);
$("#s_phone").val(myArr.shipper_name);
$("#s_email").val(myArr.shipper_email);
$("#s_address").val(myArr.shipper_address);
$("#s_phone").val(myArr.shipper_phone);
$("#s_name").val(myArr.shipper_name);
$("#o_city").val(myArr.origin_city).change();
$("#d_city").val(myArr.destination_city).change(); 
$("#order_weight").val(myArr.weight);
$("#order_piece").val(myArr.pieces);
$("#order_date").val(myArr.order_date);
$("#reference_no").val(myArr.customer_reference_no);
$("#pay_mode").val(myArr.order_pay_mode).change();
$("#packing_type").val(myArr.order_packing_type).change();
$("#customer_id").val(myArr.customer_id).change();
$("#order_piece").val(myArr.pieces);
$("#order_date").val(myArr.order_date);
$("#cod").val(myArr.cod_amount);
$("#cod_hidden").val(myArr.cod_amount);
$("#remark").val(myArr.order_remark);
$("#product_detail").val(myArr.product_detail);
$("#order_id").val(myArr.order_id);
var codh=$("#cod_hidden").val();
$("#cod").val(codh);
}
}
});
}
}













function emode(){
//var codh=$("#cod_hidden").val();
//$("#cod").val(codh);      
var mode=$("#pay_mode").val();    
if(mode=="Account"){
$("#is_cod").val("Deactive");
var myhtml="<div class='col-md-12' id='remark_div_div'><div class='form-group form-group-default' id='remark_div'><label>Description</label><input type='text' class='form-control' name='remark' id='remark' autocomplete='on' tabindex='21'></div></div>";
$("#result_div").html(myhtml);
} else if(mode!="Account" && mode!="" ){   
$("#is_cod").val("Active");
var myhtml="<div class='col-md-4' id='cod_div_div'><div class='form-group form-group-default required' id='cod_div'><label>COD/CASH</label><input type='number' class='form-control' name='cod' id='cod' autocomplete='on' tabindex='20'></div></div><div class='col-md-8' id='remark_div_div'><div class='form-group form-group-default' id='remark_div'><label>Description</label><input type='text' class='form-control' name='remark' id='remark' autocomplete='on' tabindex='21'></div></div>";
$("#result_div").html(myhtml);
}    
}


function add_shipment(){
var check="Pass";
var shipment_type="";
var order_date="";
var order_piece="";
var order_weight="";
var cod_amount="";
var customer_reference_no="";
var s_name="";
var s_phone="";
var s_email="";
var s_address="";
var c_name="";
var c_phone="";
var c_email="";
var manual_cn="";
var d_city="";
var o_city="";
var c_address = "";
var remark="";
var sp_handling="";
var product_detail="";
var payment_mode="";
var packing_type="";
//------------Shipment Type
if($("#service_type").val()!=""){
service_type=$("#service_type").val();
$("#service_type").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#service_type_div").css("border-color", "red"); 
$("#service_type").focus();
check="Fail";
}
//--------------------------------End
//------------Order Date-----------
if($("#order_date").val()!="" ){
order_date=$("#order_date").val();
$("#order_date").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#order_date_div").css("border-color", "red");  
$("#order_date").focus();
check="Fail";
}
//--------------------------------End
//---------order_weight----
if($("#order_weight").val()!="" && $("#order_weight").val()>0){
order_weight=$("#order_weight").val();
$("#order_weight_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#order_weight_div").css("border-color", "red"); 
$("#order_weight").focus();
check="Fail";
}
//--------------------------------End
//---------order_piece----
if($("#order_piece").val()!=""){
order_piece=$("#order_piece").val();
$("#order_piece_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#order_piece_div").css("border-color", "red"); 
$("#order_piece").focus();
check="Fail";
}
//--------------------------------End
//---------cod_amount----
if($("#cod").val()!=""){
cod_amount=$("#cod").val();
$("#cod_div_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#cod_div_div").css("border-color", "red"); 
$("#cod").focus();
check="Fail";
}
//--------------------------------End
//---------product_detail----
if($("#product_detail").val()!=""){
product_detail=$("#product_detail").val();
$("#product_detail_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#product_detail_div").css("border-color", "red"); 
$("#product_detail").focus();
check="Fail";
}
//--------------------------------End
//---------customer_reference_no----
customer_reference_no=$("#reference_no").val();
//--------------------------------End
//---------customer_Name----
if($("#c_name").val()!=""){
c_name=$("#c_name").val();
$("#c_name_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#c_name_div").css("border-color", "red"); 
$("#c_name").focus();
check="Fail";
}
//--------------------------------End
//---------customer_Phone----
if($("#c_phone").val()!=""){
c_phone=$("#c_phone").val();
$("#c_phone_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#c_phone_div").css("border-color", "red"); 
$("#c_phone").focus();
check="Fail";
}
//--------------------------------End
//---------customer_Email----
if($("#c_email").val()!=""){
c_email=$("#c_email").val();
$("#c_email_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#c_email_div").css("border-color", "red"); 
$("#c_email").focus();
check="Fail";
}
//--------------------------------End
//---------customer_Cities----
if($("#d_city").val()!=""){
d_city=$("#d_city").val();
$("#d_city_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#d_city_div").css("border-color", "red"); 
$("#d_city").focus();
check="Fail";
}
//--------------------------------End
//---------address----
if($("#c_address").val()!=""){
c_address=$("#c_address").val();
$("#c_address_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#c_address_div").css("border-color", "red"); 
$("#c_address").focus();
check="Fail";
}
//--------------------------------End
//---------shipper_Name----
if($("#s_name").val()!=""){
s_name=$("#s_name").val();
$("#s_name_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#s_name_div").css("border-color", "red"); 
$("#s_name").focus();
check="Fail";
}
//--------------------------------End
//---------shipper_Phone----
if($("#s_phone").val()!=""){
s_phone=$("#s_phone").val();
$("#s_phone_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#s_phone_div").css("border-color", "red"); 
$("#s_phone").focus();
check="Fail";
}
//--------------------------------End
//---------shipper_Email----
if($("#s_email").val()!=""){
s_email=$("#s_email").val();
$("#s_email_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#s_email_div").css("border-color", "red"); 
$("#s_email").focus();
check="Fail";
}
//--------------------------------End
//---------customer_Cities----
if($("#o_city").val()!=""){
o_city=$("#o_city").val();
$("#o_city_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#o_city_div").css("border-color", "red"); 
$("#o_city").focus();
check="Fail";
}
//--------------------------------End
//---------address----
if($("#s_address").val()!=""){
s_address=$("#s_address").val();
$("#s_address_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#s_address_div").css("border-color", "red"); 
$("#s_address").focus();
check="Fail";
}
//--------------------------------End
//---------Remark----
if($("#remark").val()!=""){
remark=$("#remark").val();
$("#remark_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#remark_div").css("border-color", "red"); 
//$("#remark").focus();
//check="Fail";
}
//--------------------------------End


//---------Payment_mode----
if($("#pay_mode").val()!=""){
payment_mode=$("#pay_mode").val();
$("#pay_mode").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#pay_mode_div").css("border-color", "red"); 
$("#pay_mode").focus();
check="Fail";
}
//--------------------------------End
//---------Packing_type--------------
if($("#packing_type").val()!=""){
packing_type=$("#packing_type").val();
$("#packing_type").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#packing_type_div").css("border-color", "red"); 
$("#packing_type").focus();
check="Fail";
}
//--------------------------------End
//---------Manaul_cn--------------
if($("#manual_cn").val()!=""){
manual_cn=$("#manual_cn").val();
$("#manual_cn").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#manual_cn_div").css("border-color", "red"); 
$("#manual_cn").focus();
check="Fail";
}
//--------------------------------End
//---------Customer_id--------------
if($("#customer_id").val()!=""){
customer_id=$("#customer_id").val();
$("#customer_id").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#customer_id_div").css("border-color", "red"); 
$("#customer_id").focus();
check="Fail";
}
//--------------------------------End
//-------Checking Conditions---------
if(check!="Fail"){  
$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>Please Wait</strong> We Are Getting Up Things For You.</div></div>");    
var mydata={
shipment_type           : service_type,
order_id                : $("#order_id").val(),
manual_cn               : manual_cn,
order_date              : order_date,
order_piece             : order_piece,
order_weight            : order_weight,
cod_amount              : cod_amount,
customer_reference_no   : customer_reference_no,
product_detail          : product_detail,
return_shipment         : 'No',
c_name                  : c_name,
c_phone                 : c_phone,
c_email                 : c_email,
s_name                  : s_name,
s_phone                 : s_phone,
s_email                 : s_email,
d_city                  : d_city,
o_city                  : o_city,
c_address               : c_address,
s_address               : s_address,
remark                  : remark,
sp_handling             : 'No',
payment_mode            : payment_mode,
packing_type            : packing_type,
manual_cn               : manual_cn,
customer_id             : customer_id
};
$.ajax({
url: "<?php echo base_url(); ?>Booking/Booking/edit_shipment_all",
type: "POST",
data: mydata,        
success: function(data) {
//var objJSON = $.parseJSON(data); 
//$("#msg_show").html(objJSON.notification);
$("#msg_div").html(data);
}
});

}
}      
</script>

<?php
$this->load->view('inc/footer');
?>      