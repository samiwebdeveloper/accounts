 <?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$("#myTable").saimtech();   
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
                  <li class="breadcrumb-item">Manage</li>
                  <li class="breadcrumb-item">Shipment File</li>
                  
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

<div class="col-md-12">
  <div class="card m-t-10">
    <div class="card-header  separator">
    <div class="card-title">Manage Shipment File
    </div>
    </div>
<div class="card-body">            
  <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="pg-plus"></i> Add New</button>
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>CN</th>
    <th>File</th>
    <th>Action</th>
    </thead>
  <tbody id="autoload">
   <?php  if(!empty($file_data)){$i=0;
    foreach($file_data as $rows){
    $i=$i+1;        
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->order_code."</td>");
    echo("<td><a href='".base_url()."/assets/cn_files/".$rows->file_path."' class='btn btn-info btn-xs'>View</a></td>");
    echo("<td><button onclick='remove_file(".$rows->order_id.")' class='btn btn-danger btn-xs'>Remove</button></td>");
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
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Shipment File</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p id="msg_show">Add Shipment File.</p>
        <div class="form-group-attached" style="border-color: black">

<div class="form-group form-group-default required" aria-required="true" id="order_code_div">
<label>Order Code</label>
<input type="text" class="form-control" placeholder="Enter Order Code" name="order_code" id="order_code" tabindex="1">
</div>
<div class="form-group form-group-default required" id="file_path_div">
<label>File</label>
<input type="file" class="form-control"  name="filename" id="filename"  tabindex="2" >
</div>
</div>
<center><div id="target"></div></center>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="imp_file_upload()">Update Document</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div> 

<script>

function imp_file_upload(){
$('#target').html("<center><p class='alert alert-primary'>Please Wait...</p></center>");
order_code="";
check="Pass";
//------------Order Code-----------
if($("#order_code").val()!="" ){
order_code=$("#order_code").val();
$("#order_code_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#order_code_div").css("border-color", "red");  
$("#order_code_div").focus();
check="Fail";
}
//--------------------------------End 
//------------File Name-----------
if($('#filename').val()!=""){
$("#file_path_div").css("border-color", "#20c997");  
} else{
$("#file_path_div").css("border-color", "red");
check="Fail";
}
//-------Checking Conditions---------
if(check!="Fail"){  
var inputFile    = $('input[name=filename]'); 
var fileToUpload = inputFile[0].files[0];  
var order_code   = order_code;
var formData     = new FormData()
formData.append("file" ,fileToUpload);
formData.append("cn" ,order_code);
$.ajax({
url: "<?php echo base_url(); ?>Route/submit_import_file",
type: "POST",
data: formData, 
contentType: false,
processData: false,         
success: function(data) {
$('#autoload').html(data);
$('#target').html(data);
}
});
}   
}


function remove_file(id){
var mydata={
orderid : id
};
$.ajax({
url: "<?php echo base_url(); ?>Route/remove_file/"+id,
type: "POST",
data: mydata,        
success: function(data) {
$('#autoload').html(data);
}
});
}






</script>


</div>

</div>

<?php
$this->load->view('inc/footer');
?>      