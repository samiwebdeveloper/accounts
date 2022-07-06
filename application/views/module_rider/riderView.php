<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$("#myTable").saimtech();   
$("#rider_cnic").inputmask();
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
                  <li class="breadcrumb-item">Rider</li>
                  
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
    <div class="card-title">Manage Rider
    </div>
    </div>
<div class="card-body">            
  <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="pg-plus"></i> Add New</button>
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Rider Code</th>
    <th>Rider Name</th>
    <th>Rider CNIC</th>
    <th>Rider EmpCode</th>
    <th>Status</th>
    <th>Action</th>
    </thead>
  <tbody id="autoload">
     <?php if(!empty($rider_data)){$i=0;   
    foreach($rider_data as $rows){
    $i=$i+1;    
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->rider_code."</td>");
    echo("<td>".$rows->rider_name."</td>");
    echo("<td>".$rows->rider_cnic."</td>");
    echo("<td>".$rows->rider_empcode."</td>");
    if($rows->is_enable==1){
    echo("<td class='bg-success text-black' ><center>Active</center></td>");
    echo("<td><button class='btn btn-danger btn-xs' onclick='update_status(0,".$rows->rider_id.")'>Deactive</button></td>");  
    } else if($rows->is_enable==0){
    echo("<td class='bg-danger text-black' ><center>Deactive</center></td>");
    echo("<td><button class='btn btn-success btn-xs' onclick='update_status(1,".$rows->rider_id.")'>Active</button></td>");  
    }
    echo("</tr>"); }}  ?>
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
        <h4 class="modal-title">Add New Rider</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p id="msg_show">Add New Rider.</p>
        <div class="form-group-attached" style="border-color: black">

<div class="form-group form-group-default required" aria-required="true" id="rider_name_div">
<label>Rider Name</label>
<input type="text" class="form-control" placeholder="Enter Rider Name" name="rider_name" id="rider_name" tabindex="1">
</div>
<div class="form-group form-group-default required" id="rider_cnic_div">
<label>Rider CNIC</label>
<input type="text" class="form-control" placeholder="Enter Rider CNIC" name="rider_cnic" id="rider_cnic"  data-inputmask="'mask': '99999-9999999-9'"  tabindex="2">
</div>
</div>


      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="add_rider()">Create Rider</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div> 

<script>
function add_rider(){
var check="Pass";
var name="";
var cnic="";
//------------Rider Name
if($("#rider_name").val()!=""){
name=$("#rider_name").val();
$("#rider_name_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#rider_name_div").css("border-color", "red"); 
$("#rider_name").focus();
check="Fail";
}
//--------------------------------End
//------------Rider CNIC-----------
if($("#rider_cnic").val()!="" ){
cnic=$("#rider_cnic").val();
$("#rider_cnic_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#rider_cnic_div").css("border-color", "red");  
$("#rider_cnic").focus();
check="Fail";
}
//--------------------------------End    
//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
name              :name,
cnic              :cnic
};
$.ajax({
url: "<?php echo base_url(); ?>Rider/add_rider",
type: "POST",
data: mydata,        
success: function(data) {
if(data==1){    
$("#msg_show").html("<p class='alert alert-danger'>Something Went Wrong Please Try Again.</p>");
} else if(data==0){ 
$("#msg_show").html("<p class='alert alert-success'>Rider successfully add in Data Base.</p>");
} else if(data==2){
$("#msg_show").html("<p class='alert alert-danger'>Duplicate CNIC Try with Different CNIC.</p>");
}
$.ajax({
url: "<?php echo base_url(); ?>Rider/redraw_table",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
}
});
}
});
$("#rider_name").val("");
$("#rider_cnic").val("");
}
}

function update_status(status,id){
var mydata={
status : status
};
$.ajax({
url: "<?php echo base_url(); ?>Rider/update_status/"+status+"/"+id,
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