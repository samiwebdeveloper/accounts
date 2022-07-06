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
                  <li class="breadcrumb-item">Arrival</li>
                  <li class="breadcrumb-item">Create Sheet</li>
                  <li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:s'); ?></mark></li>
                   <li class="breadcrumb-item"><mark><?php echo $arrival_sheet_code; ?></mark></li>
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
     <div class="card-title">Create Arrival</div>
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
<label>Arrival Sheet Code</label>
<span class="help">e.g. "<?php echo $arrival_sheet_code; ?>"</span>
<input type="text" value="<?php echo $arrival_sheet_code; ?>" class="form-control"  readonly="" >
</div>
<div class="form-group" id="rider_div">
<label>Rider</label>
<span class="help">e.g. "101 Saim"</span>
<select class="form-control" data-init-plugin="select2" id="rider" name="rider">
<option value="">Select Rider</option>
<?php if(!empty($rider_data)){
  foreach($rider_data as $rows){
  echo("<option value='".$rows->rider_id."'>".$rows->rider_code." - ".$rows->rider_name."</option>");  
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


<div class="col-md-6">
    <div class="card m-t-10">
    <div class="card-header  separator">
     <div class="card-title">Data Panel</div>
     <div class="card-controls">
<ul>

<li><a href="<?php echo base_url(); ?>Arrival/complete_sheet/<?php echo $arrival_sheet_code; ?>" class="card-collapse"><Button class='btn btn-primary'>Complete Sheet</Button></a>
</li>
</ul>
</div>
      </div>
    <div class="card-body">
      <div class="table-responsive">
      <table class="table table-bordered" id="data_panel">
        <thead>
        <tr>
         <th>CN</th>
         <th>Weight</th>
         <th>Pieces</th>
         <th>Date</th>        
         <th>AR Code</th>
         <th>Action</th>
        </tr>
      </thead>
      <tbody id="autoload">
       <?php if(!empty($arrival_sheet_data)){
             foreach($arrival_sheet_data as $rows){
             echo("<tr>");
             echo("<input type='hidden' value='".$rows->Sheet."' id='sheet_code'>");
             echo("<td>".$rows->cn."</td>");
             if($rows->new_weight!=0){
             echo("<td><input type=number value='".$rows->new_weight."'  name='weight-".$rows->d_id."' id='weight-".$rows->d_id."' onblur='update_weight(".$rows->d_id.")'></td>"); 
             } else {
             echo("<td><input type=number value='".$rows->weight."'  name='weight-".$rows->d_id."' id='weight-".$rows->d_id."' onblur='update_weight(".$rows->d_id.")'></td>");  
             }
             if($rows->new_pieces!=0){
             echo("<td><input type=number value='".$rows->new_pieces."'  name='pieces-".$rows->d_id."' id='pieces-".$rows->d_id."' onblur='update_pieces(".$rows->d_id.")'></td>"); 
             } else {
             echo("<td><input type=number value='".$rows->pieces."' name='pieces-".$rows->d_id."' id='pieces-".$rows->d_id."' onblur='update_pieces(".$rows->d_id.")'></td>");  
             }
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



<div class="col-md-2">
    <div class="card m-t-10 card-default bg-warning text-black">
    <div class="card-header  separator">
     <div class="card-title">Scan Shipmnets</div>
     
      </div>
    <div class="card-body" >
      
      <center><h1 id="short_excess"></h1></center>
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