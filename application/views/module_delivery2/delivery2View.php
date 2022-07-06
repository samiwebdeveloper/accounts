<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$('#sheet_code').focus();    
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
                  <li class="breadcrumb-item">Delivery Phase 2 (Update DD)</li>
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
    <div class="card-title"><input type="text" placeholder="Enter Delivery Sheet No" class="form-control" id="sheet_code" name="sheet_code" style='border-color:blue'>
    </div>
    </div>
<div class="card-body">                       
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Action</th>
    <th>CN</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Address</th>
    <th>Weight</th>
    <th>FOD</th>
    <th>Date</th>
    
  </thead>
  <tbody id="autoload">
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
<input type="hidden" id="sheet_code_nd">
<label>Select Reason</label>
<select class="form-control" name="status" id="status">
  <option value="">Select Reason</option>
  <option value="RTS">RTS</option>
  <option value="Refused">Refused</option>
  <option value="Return">Return</option>
  <option value="RTO">RTO</option>
  <option value="Short Received">Short Received</option>
  <option value="ICA">ICA (Incomplete Address)</option>
  <option value="CA">CA (Close Address)</option>
  <option value="CNA">CNA (Consignee Not Available)</option>
  <option value="UL">UL (Un Located)</option>
  <option value="HIO">HIO (Hold in Operations)</option>
  <option value="NSA">NSA (Non Service Area)</option>
  <option value="OSA">OSA (Out of Service Area)</option>
  <option value="HFC">HFC (Hold For Collection)</option>
  <option value="NSC">NSC (No Such Consignee At Given Address)</option>
  <option value="SD">SD (Stop Delivery On Customer Advised)</option>
  <option value="SFC">SFC (Friday/Saturday Closed)</option>
  <option value="NCI">NCI (Undelivered shipment hold in operation for shipper/origin advice )</option>
  <option value="MR">MR (Miss Routed)</option>
  <option value="EBA">EBA (Entry Banned Area)</option>
  <option value="PI">PI (Payment Issue)</option>
  <option value="CN">CN (Cash Not Available )</option>
    
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
<input type="hidden"   id="sheet_code_d">
<input type="text" class="form-control"  name="received_by" id="received_by">
</div>
<div class="form-group">
<label>I swear or affrim that i received payment of this shipment.</label>
<label>میں تسلیم کرتا ہوں کہ میں نے اس پارسل کی ادائیگی وصول کی۔</label>
<center><h2>PKR <mark id='cod'></mark>/-</h2></center>
      </div>
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-warning" onclick="yes_delivered()">Yes, I Recevied Payment</button>
      </div>
    </div>
  </div>
</div>


<script>
$('#sheet_code').keypress(function(e) {
if (e.keyCode == 13) {
var check="Pass";
var delivery_sheet_code="";
//------------Sheet Code
if($("#sheet_code").val()!=""){
delivery_sheet_code=$("#sheet_code").val();
$("#sheet_code").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#sheet_code").css("border-color", "red"); 
$("#sheet_code").focus();
check="Fail";
}
//--------------------------------End  
if(check!="Fail"){  
var mydata={
sheet_code : delivery_sheet_code
};
$.ajax({
url: "<?php echo base_url(); ?>Delivery2/delivery_sheet_data",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
}
});

}
}
});  


function fill_deliverd_model(id,topay){
var mydata={
sheet_code : id
};
$.ajax({
url: "<?php echo base_url(); ?>Delivery2/Get_Data_For_Model/"+id,
type: "POST",
data: mydata,        
success: function(data) {
var data2 = $.parseJSON(data); 
$('#order_code').val(data2.cn);
$('#detail_id').val(data2.detail_id);
$('#sheet_code_d').val(data2.sheet_code);
$('#cn').html(data2.cn); 
if(topay==1){
$('#cod').html(data2.cod);
} else {
$('#cod').html("<code>NA</code>");
}
}
});
}



function fill_not_delivered_model(id){
var mydata={
sheet_code : id
};
$.ajax({
url: "<?php echo base_url(); ?>Delivery2/Get_Data_For_Model/"+id,
type: "POST",
data: mydata,        
success: function(data) {
var data2 = $.parseJSON(data);  
$('#order_code_nd').val(data2.cn);
$('#detail_id_nd').val(data2.detail_id);
$('#cn_nd').html(data2.cn);
$('#sheet_code_nd').val(data2.sheet_code);
}
});
}

function yes_not_delivered(){
var check="Pass";
var delivery_sheet_code=$('#sheet_code_nd').val();
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
sheet  : delivery_sheet_code,
remark  : order_remark,
status : status
};
$.ajax({
url: "<?php echo base_url(); ?>Delivery2/not_delivered",
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
var delivery_sheet_code=$('#sheet_code_d').val();
var detail_id=$('#detail_id').val();
var order_code=$('#order_code').val();;
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
sheet       : delivery_sheet_code,
received_by : received_by
};
$.ajax({
url: "<?php echo base_url(); ?>Delivery2/delivered",
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


</div>

</div>

<?php
$this->load->view('inc/footer');
?>      