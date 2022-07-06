 <?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$("#myTable").saimtech();
$("#mmyTable").saimtech();
});
</script>

 <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START JUMBOTRON -->
          <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0" style="background-image:linear-gradient(45deg, #1f3953, #2B6A94);color:white">
              <div class="inner">
                <!-- START BREADCRUMB -->
                 <ol class="breadcrumb">
                  <li class="breadcrumb-item">Booking</li>
                  <li class="breadcrumb-item">Incomplete Detail</li>
                  
                </ol>
                <!-- END BREADCRUMB --> 
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->

<div class="row">
   
           <div class="pgn-wrapper" data-position="top" style="top: 48px;" id="msg_div"></div>

                  <div class="col-xl-12 col-lg-12 ">

             
                <div class="card m-t-10">
              <div class="card-header  separator">
                        <div class="card-title"><h2>
                          Manage Incomplete Detail               
                          </h2>  
                          
                        </div>
                          </div>
                      <div class="card-body">

                      <div class="row clearfix">
                        
                        <div class="col-md-5">
                         
                        </div>
                      </div>
                     <br>
                                           
                      <div class="row">

                       <div class="col-md-12"> 

                        <div class="table-responsive">

                     <table class='table table-bordered' id="myTable">
                        <thead>
                          <tr>
                            <th style="color:rgb(9, 17, 62)">Sr</th>
                            <th style="color:rgb(9, 17, 62)">Electron ID</th>
                            <th style="color:rgb(9, 17, 62)">Manaul CN</th>
                            <th style="color:rgb(9, 17, 62)">Origin</th>
                            <th style="color:rgb(9, 17, 62)">Weight</th>
                            <th style="color:rgb(9, 17, 62)">Pices</th>
                            <th style="color:rgb(9, 17, 62)">Order Date</th>
                            <th style="color:rgb(9, 17, 62)">Booking Date</th>
                            <th style="color:rgb(9, 17, 62)">Arrival Date</th>
                             <th style="color:rgb(9, 17, 62)">Action</th>
                          </tr>
                        </thead>   
                         <tbody id="resultTable1">
                         <?php if(!empty($order_data)){ $i=0;
                               foreach($order_data as $rows){ $i=$i+1; ?>
<tr>
<td style="font-size:12px;padding-top:15px"><center><?php echo $i; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->order_code; ?></center></td>
<td style="font-size:10px;padding-top:15px"><center><?php echo $rows->manual_cn; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->origin_city_name; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->weight; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->pieces; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->order_date; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->order_booking_date; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->order_arrival_date; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><a href='<?php echo base_url(); ?>Booking/Booking/<?php echo $rows->order_id;?>' class='btn btn-danger btn-xs'>Update Info</a></center></td>
</td>   
</tr>
                       <?php } }?>  
                         </tbody>  
                       </table>
                    </div>
                  </div>

















                      </div>
                     
                
                  </div>
                   <div class="card-header  separator">
                        <div class="card-title" name="1-success-message" id="1-success-message">
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



<div id="myModal" class="modal fade stick-up"   tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg fill-in">
    <div class="modal-content" style="background-color:white">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Create New Load Sheet</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
       <div class="modal-footer">
        <button type="button" class="btn btn-info" id="create-btn-load-sheet">Create Load Sheet</button>
      </div>
      <div class="modal-body">
       <div class='row'>
        <div class='col-md-12'>
         
          <div class="table-responsive">
          <table class='table table-bordered' id="mmyTable"  style="overflow-y: auto";    /* Trigger vertical scroll >
          <thead>
          <tr>
          <th><div class="checkbox check-info checkbox-circle">
          <input type="checkbox" onclick="select_all_function()" id="checkbox">
          <label for="checkbox">CN</label></div></th>
          <th>Ref#</th>
          <th>Destination</th>
          <th>Weight(KG)</th>
          <th>COD</th>
          <th>Action</th>
          </tr>
          </thead>   
          <tbody id="resultTable">
          <?php if(!empty($col1_data)){
          foreach($col1_data as $rows){ 
          echo("<tr>");
          echo("<td><div class='checkbox check-info checkbox-circle'>");
          echo("<input type='checkbox' onclick='select_function(".$rows->order_code.")' value='".$rows->order_code."' id='checkbox".$rows->order_code."'>");
          echo("<label for='checkbox".$rows->order_code."'>".$rows->order_code."</label>");
          echo("</div></td>");
          echo("<td style='font-size:12px;padding-top:16px'><center>".$rows->customer_reference_no."</center></td>");
          echo("<td style='font-size:12px;padding-top:16px'><center>".$rows->destination_city_name."</center></td>");
          echo("<td style='font-size:12px;padding-top:16px'><center>".$rows->weight."</center></td>");
          echo("<td style='font-size:12px;padding-top:16px'><center>".number_format($rows->cod_amount)."</center></td>"); 
          echo("<td style='font-size:12px;padding-top:16px'>");
          echo("<button class='btn btn-danger btn-xs' data-toggle='modal' data-target='#exampleModal' onclick='cancel_shipment(".$rows->order_code.",".$rows->cod_amount.",".$rows->order_id.")'>Cancel</button>");
          ?>
          <a href="<?php echo base_url();?>Editbooking/index/<?php echo $rows->order_id; ?>" target="_blank"><button class="btn btn-info btn-xs">Edit</button></a> 
          <?php
          echo("</td>");   
          echo("</tr>");
          } }?>
            </tbody>  
          </table>
                    </div>
        </div>
        <br>
        <br>
      </div>
      </div>
  
      <br>
      <br>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-info" id="create-btn-load-sheet1">Create Load Sheet</button>
      </div>
   </div>
</div>
</div>
 

<!-- Modal -->
<div class="modal fade stick-up" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
  <div class="modal-dialog modal-sm" role="document" >
    <div class="modal-content" style="background-color: black; color:white">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel1" style="color:white">Are you sure to cancel ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body-data">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-info" onclick="yes_cancel_shipment()">Yes, Cancel</button>
      </div>
    </div>
  </div>
</div>
 


<script type="text/javascript">


function cancel_shipment(cn,cod,id){
$("#exampleModalLabel1").html("Are you sure to cancel?"); 
$("#body-data").html("<input type='hidden' id='cancel_id' value='"+id+"'><div><table class='table'><tr><th>CN</td><th>"+cn+"</td></tr><tr><th>COD</th><th>PKR "+cod+"/-</th></tr></table></div>");
}

function yes_cancel_shipment(){
var order_id=$("#cancel_id").val();
var mydata={
id :order_id
};
$.ajax({
url: "<?php echo base_url(); ?>Booking/ls_cancel_shipment",
type: "POST",
data: mydata,        
success: function(data) {
$("#resultTable").html(data);
$('#exampleModal').modal('hide'); 
}
});
}


function select_function(cn){
var cnn = cn;  
if($('#checkbox'+cn).prop("checked") == true){
var mydata={
cn :cnn
};
$.ajax({
url: "<?php echo base_url(); ?>Booking/insert_temp_ls",
type: "POST",
data: mydata,        
success: function(data) {
$("#create-btn-load-sheet").html("<a href='<?php echo base_url(); ?>Booking/create_load_sheet' style='color:white'><font style='font-size:13px'>"+ data + " Create Load Sheet</font></a>"); 
$("#create-btn-load-sheet1").html("<a href='<?php echo base_url(); ?>Booking/create_load_sheet' style='color:white'><font style='font-size:13px'>"+ data + " Create Load Sheet</font></a>");
}
});
} 
else if($('#checkbox'+cn).prop("checked") == false){
var mydataa={
cn :cnn
};
$.ajax({
url: "<?php echo base_url(); ?>Booking/delete_temp_ls_by_cn",
type: "POST",
data: mydataa,        
success: function(data) {
if(data==0){  
$("#create-btn-load-sheet").html("Create Load Sheet");
$("#create-btn-load-sheet1").html("Create Load Sheet");
$("input:checkbox").prop("checked", false);
} else { $("#create-btn-load-sheet").html("<a href='<?php echo base_url(); ?>Booking/create_load_sheet' style='color:white'><font style='font-size:13px'>"+ data + " Create Load Sheet</font></a>");
$("#create-btn-load-sheet1").html("<a href='<?php echo base_url(); ?>Booking/create_load_sheet' style='color:white'><font style='font-size:13px'>"+ data + " Create Load Sheet</font></a>");

 }  
}
});  
}  
}

function select_all_function(){
if($('#checkbox').prop("checked") == true){
$("input:checkbox").prop("checked", true);
var mydata={
cn :1
};
$.ajax({
url: "<?php echo base_url(); ?>Booking/all_insert_temp_ls",
type: "POST",
data: mydata,        
success: function(data) {
$("#create-btn-load-sheet").html("<a href='<?php echo base_url(); ?>Booking/create_load_sheet' style='color:white'><font style='font-size:13px'>"+ data + " Create Load Sheet</font></a>"); 
$("#create-btn-load-sheet1").html("<a href='<?php echo base_url(); ?>Booking/create_load_sheet' style='color:white'><font style='font-size:13px'>"+ data + " Create Load Sheet</font></a>"); 
}
});
} 
else if($('#checkbox').prop("checked") == false){
$("input:checkbox").prop("checked", false);
var mydataa={
cn :1
};
$.ajax({
url: "<?php echo base_url(); ?>Booking/all_delete_temp_ls_by_cn",
type: "POST",
data: mydataa,        
success: function(data) {
if(data==0){  
$("#create-btn-load-sheet").html("Create Load Sheet");
$("#create-btn-load-sheet1").html("Create Load Sheet");
$("input:checkbox").prop("checked", false);
} else { $("#create-btn-load-sheet").html("<a href='<?php echo base_url(); ?>Booking/create_load_sheet' style='color:white'><font style='font-size:13px'>"+ data + " Create Load Sheet</font></a>"); 
$("#create-btn-load-sheet1").html("<a href='<?php echo base_url(); ?>Booking/create_load_sheet' style='color:white'><font style='font-size:13px'>"+ data + " Create Load Sheet</font></a>"); 
}  
}
});  
}  
}

function selected_print(){
$("input:checkbox").prop("checked", false);
$("[data-toggle='tooltip']").tooltip('hide');
$("#fixedbutton").html("<i class='pg-printer'></i>");
}

</script>     
<?php
$this->load->view('inc/footer');
?>      