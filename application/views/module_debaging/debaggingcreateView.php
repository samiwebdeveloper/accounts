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
                  <li class="breadcrumb-item">DeBagging</li>
                  <li class="breadcrumb-item">Create Sheet</li>
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
     <div class="card-title">Create Debagging</div>
      </div>
   <div class="card-body">
<h5>Scan Shipments</h5>
<form role="form">
<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2019-08-23"</span>
<input type="text" value="<?php echo date('Y-m-d h:i:s'); ?>" class="form-control"  readonly="" >
</div>

<div class="form-group">
<label>Bagging Seal/Bag </label>
<input type="text" name="bag_code" id="bag_code" class="form-control"  onblur="check_bag()">
<input type="hidden" name="chk_bag" id="chk_bag">
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


<div class="col-md-6">
    <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Data Panel</div>

      </div>
    <div class="card-body">
      <a href="<?php echo base_url(); ?>debagging/complete_sheet" class="card-collapse"><Button class='btn btn-primary pull-right'>Complete Sheet</Button></a>
      <div class="table-responsive">
      <table class="table table-bordered" id="data_panel">
        <thead>
        <tr>
         <th>CN</th>
         <th>Bag Code</th>        
         <th>Bag Seal</th>
         </tr>
      </thead>
      <tbody id="autoload">
       </tbody>
      </table>
    </div>

</div>
</div>
</div>






<div class="col-md-2">
    <div class="card m-t-10 bg-warning text-black">
    <div class="card-header  separator">
     <div class="card-title">Shipment Inside</div>
    </div>
    <div class="card-body">
    <center><h1  id="short_excess"></h1></center>     
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
$("#autoload").html("<center><img src='<?php echo base_url();?>assets/ajax-loader.gif'></center>");      
var check="Pass";
var bag_code="";
var chk_bag=$("#chk_bag").val();
var cn="";
//------------BAG_CODE
if(chk_bag=="Y"){
if($("#bag_code").val()!=""){
bag_code=$("#bag_code").val();
$("#bag_code").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#bag_code").css("border-color", "red"); 
$("#bag_code").focus();
check="Fail";
}
} else{
check="Pass";  
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
bag_code            :bag_code,
cn                  :cn
};
$.ajax({
url: "<?php echo base_url(); ?>debagging/debagging_process",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
$.ajax({
url: "<?php echo base_url(); ?>debagging/debagging_short_excess",
type: "POST",
data: mydata,        
success: function(data) {
$('#short_excess').html(data);  
}
});
}
});
$("#cn").val("");
}

}
});


$('#bag_code').keypress(function(e) {
if (e.keyCode == 13) {  
if($("#bag_code").val()!=""){
 check_bag(); 
}
}
});

function check_bag(){
var bag_code     = "";
var check       = "Pass";
$("#chk_bag").val("N");
//------------Rider
if($("#bag_code").val()!=""){
bag_code=$("#bag_code").val();
$("#bag_code").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#bag_code").css("border-color", "red"); 
check="Fail";
}
//--------------------------------End
if(check!="Fail"){  
var mydata={
bag_code    : bag_code
};
$.ajax({
url: "<?php echo base_url(); ?>debagging/check_bag",
type: "POST",
data: mydata,        
success: function(data) {
//-------------------
if(data==1){
$("#chk_bag").val("Y");
$("#bag_code").css("border-color", "green");
$("#cn").focus();
$.ajax({
url: "<?php echo base_url(); ?>debagging/debagging_short_excess",
type: "POST",
data: mydata,        
success: function(data) {
$('#short_excess').html(data);  
}
}); 
$.ajax({
url: "<?php echo base_url(); ?>debagging/redraw_table/"+bag_code,
type: "POST",
data: mydata,        
success: function(data) {
$('#autoload').html(data);  
}
}); 
} 
else if(data==0){
$("#chk_bag").val("N");
$("#bag_code").css("border-color", "red");}  
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