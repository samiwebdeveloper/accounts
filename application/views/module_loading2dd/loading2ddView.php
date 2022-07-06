<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$('#myTable').saimtech();
    
    
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
                  <li class="breadcrumb-item">Menifest2DD</li>
                  <li class="breadcrumb-item"><mark><?php echo date('Y-m-d H:i:s'); ?></mark></li>
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
                        <div class="card-title">Manifest 2 DD
                        </div>
                          <div class="form-group-attached">



</div>
                      </div>
                      <div class="card-body">
                       
<div class="table-responsive m-t-10">

 <table class="table table-bordered" id="myTable">
  <thead>
    <tr>
<th><center>Sr#</center></th>
<th><center>Date</center></th>    
<th><center>Dest</center></th>   
<th><center>Manifiest Code</center></th> 
<th><center>CN. No</center></th>    
<th><center>Pieces</center></th>
<th><center>Weight</center></th>
<th><center>Shipper</center></th>
<th><center>Consignee</center></th>
<th><center>To Pay</center></th>
<th><center>Deliver</center></th>
<th><center>Return</center></th>
</tr>
  </thead>
  <tbody id="autoload">
  <?php 
  $i=0;
  if(!empty($pending_un_loading_sheets)){
  foreach($pending_un_loading_sheets as $rows){ 
  $i=$i+1;  
  echo("<tr>");  
echo("<td><center>".$i."</center></td>");
echo("<td><center>".$rows->tDate."</center></td>");  
echo("<td><center>".$rows->ActaulD."</center></td>");
echo("<td><center>".$rows->loading_id."</center></td>");
echo("<td><center>".$rows->transit_cn." / ".$rows->manual_cn."</center></td>");
echo("<td><center>".$rows->pieces."</center></td>");
echo("<td><center>".$rows->weight."</center></td>");
echo("<td><center>".$rows->transit_shipper."</center></td>");
echo("<td><center>".$rows->consignee_detail."</center></td>");
echo("<td><center>".$rows->cod_amount."</center></td>");
echo("<td><button class='btn btn-xs btn-primary' data-toggle='modal' data-target='#exampleModal'  onclick='fill_delivered_model(".$rows->transit_detail_id.")'>Delivered</button></td>");
echo("<td><button class='btn btn-xs btn-danger' data-toggle='modal' data-target='#exampleModal2'  onclick='fill_not_delivered_model(".$rows->transit_detail_id.")'>Not Deliverd</button></td>");
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




</div>

</div>
<!-- Modal -->
<div class="modal fade stick-up" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-sm" role="document" >
    <div class="modal-content" style="background-color: #b41f25; color:white">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1" style="color:white">Why <span id="cn_nd"></span>  Not Delivered ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body-data">
        <div class="form-group">
          <label></label>
<input type="hidden" id="order_code_nd">
<input type="hidden" id="detail_id_nd">
<label>Select Reason</label>
<select class="form-control" name="status" id="status">
  <option value="">Select Reason</option>
  <option value="Return">Return</option>
  <option value="RTS">RTS</option>
</select></div>
 <div class="form-group">

<label>Reason Remark (if any)</label>
<input type="text" class="form-control" name="remark" id="remark"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-warning" onclick="yes_not_delivered()">Yes, Not Delivered</button>
      </div>
    </div>
  </div>
</div>
 <!-- Modal -->
<div class="modal fade stick-up" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-sm" role="document" >
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1">Are You Sure <span id="cn"></span> is Delivered ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body-data">
      <div class="form-group">
<label>Shipment Received By</label>
<input type="hidden" id="order_code">
<input type="hidden" id="detail_id">
<input type="text" class="form-control"  name="received_by" id="received_by">
</div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-warning" onclick="yes_delivered()">Yes, Delivered</button>
      </div>
    </div>
  </div>
</div>


<script>


function fill_delivered_model(id){
var mydata={
sheet_code : id
};
$.ajax({
url: "<?php echo base_url(); ?>Loading2DD/fill_model/"+id,
type: "POST",
data: mydata,        
success: function(data) {
var data2 = $.parseJSON(data); 
$('#order_code').val(data2.cn);
$('#detail_id').val(data2.detail_id);
$('#cn').html(data2.cn); 
}
});
}

function fill_not_delivered_model(id){
var mydata={
sheet_code : id
};
$.ajax({
url: "<?php echo base_url(); ?>Loading2DD/fill_model/"+id,
type: "POST",
data: mydata,        
success: function(data) {
var data2 = $.parseJSON(data); 
$('#order_code_nd').val(data2.cn);
$('#detail_id_nd').val(data2.detail_id);
$('#cn_nd').html(data2.cn); 
}
});
}


function yes_not_delivered(){
var check="Pass";
var detail_id=$('#detail_id_nd').val();
var order_code=$('#order_code_nd').val();
var order_remark=$('#remark').val();
var status="";
//------------Status
if($("#status").val()!=""){
status=$("#status").val();
$("#status").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#status").css("border-color", "red"); 
$("#status").focus();
check="Fail";
}
//--------------------------------End
if(check!="Fail"){  
var mydata={
id     : detail_id,
cn     : order_code,
remark  : order_remark,
status : status
};
$.ajax({
url: "<?php echo base_url(); ?>Loading2DD/not_delivered",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
$('#exampleModal2').modal('hide');
}
});

}  
}



function yes_delivered(){
var check="Pass";
var detail_id=$('#detail_id').val();
var order_code=$('#order_code').val();
var received_by="";
//------------received_by
if($("#received_by").val()!=""){
received_by=$("#received_by").val();
$("#received_by").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#received_by").css("border-color", "red"); 
$("#received_by").focus();
check="Fail";
}
//--------------------------------End
if(check!="Fail"){  
var mydata={
id          : detail_id,
cn          : order_code,
received_by : received_by
};
$.ajax({
url: "<?php echo base_url(); ?>Loading2DD/delivered",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
$('#exampleModal').modal('hide');
}
});

}  
}

</script>

<?php
$this->load->view('inc/footer');
?>      