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
                  <li class="breadcrumb-item">De Manifest (by IT)</li>
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
     <div class="card-title">De Manifest</div>
      </div>
   <div class="card-body">
<h5>Scan Shipments</h5>
<form role="form">
<div class="form-group">
<label>Date</label>
<span class="help">e.g. "2021-02-10"</span>
<input type="text" value="<?php echo date('Y-m-d h:i:s'); ?>" class="form-control"  readonly="" >
</div>
<div class="form-group" id="manifest_div">
<label>De Manifest Number</label>
<span class="help">e.g. "MANI2000001231"</span>
<input type="text" required="" id="manifest" onblur="debagging()" name="manifest" class="form-control" >
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


<div class="col-md-6">
    <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Data Panel</div>

      </div>
    <div class="card-body">
    <!--  <a href="<?php echo base_url(); ?>debagging/complete_sheet" class="card-collapse"><Button class='btn btn-primary pull-right'>Complete Sheet</Button></a>-->
      <div class="table-responsive">
      <table class="table table-bordered" id="data_panel">
        <thead>
        <tr>
         <th>Sr</th>    
         <th>CN</th>
         <th>Manual CN</th>        
         <th>Unload Date</th>
         <th>Transit Date</th>
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
 
function debagging(){
if($("#manifest").val()!=""){
var mani = $("#manifest").val();  
var mydata={manifest      :mani};
$.ajax({
url: "<?php echo base_url(); ?>Demanifest/manifest_summary",
type: "POST",
data: mydata,        
success: function(data) {
$("#short_excess").html(data);

}
});
}
}

$('#cn').keypress(function(e) {
if (e.keyCode == 13) {
$("#autoload").html("<center><img src='<?php echo base_url();?>assets/ajax-loader.gif'></center>");      
var check="Pass";
var manifest="";
var cn="";
//------------Manifest
if($("#manifest").val()!=""){
manifest=$("#manifest").val();
$("#manifest").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#manifest").css("border-color", "red"); 
$("#manifest").focus();
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
cn             :cn,
manifest       :manifest    
};
$.ajax({
url: "<?php echo base_url(); ?>Demanifest/manifest_process",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
$.ajax({
url: "<?php echo base_url(); ?>Demanifest/manifest_summary",
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




</script>




</div>
</div>
<?php
$this->load->view('inc/footer');
?>      