 <?php
error_reporting(0);
$this->load->view('inc/header');
?>
<style>
#fixedbutton { 
bottom: 15px;
box-shadow: 4px 4px 4px gray;    
border-radius:50%;
margin: 4px 2px;
padding: 20px;
position: fixed;
right: 5px; 
font-size: 20px;
text-align: center;
text-decoration: none; 
background-color:black;
}
#Allfixedbutton { 
bottom: 95px;
box-shadow: 4px 4px 4px gray;    
border-radius:50%;
margin: 4px 2px;
padding: 20px;
position: fixed;
right: 5px; 
font-size: 20px;
text-align: center;
text-decoration: none;
background-color:black; 
}    
#B1fixedbutton { 
top: 325px;
box-shadow: 4px 4px 4px gray;    
border-radius:50%;
margin: 4px 2px;
padding: 20px;
position: fixed;
right: 5px; 
font-size: 20px;
text-align: center;
text-decoration: none;
background-color:#1f3953; 
}    
</style>  
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
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0" style="background-image:linear-gradient(45deg, #1f3953, #795548);color:white">
              <div class="inner">
                <!-- START BREADCRUMB -->
                 <ol class="breadcrumb">
                  <li class="breadcrumb-item">Booking</li>
                  <li class="breadcrumb-item">Address Labels</li>
                  
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
                        <div class="card-title"><h2>Manage Address Lables</h2>
                        </div>
                      </div>
                      <div class="card-body">

                      <div class="row clearfix">
                        
                        <div class="col-md-5">
                         
                        </div>
                      </div>
                     <br>
                                            
                      <div class="row">
                        <div class="table-responsive">

                        <a href="<?php echo base_url(); ?>Addresslable/Get_All_Address_Label" target="_blank" data-toggle="tooltip" data-original-title="Print Selected Labels" id="fixedbutton" onclick="selected_print()" class='btn btn-primary btn-lg'><i class='pg-printer'></i></a>
                        <a href="<?php echo base_url(); ?>Addresslable/Get_All_Address_Label" target="_blank" data-toggle="tooltip" data-original-title="Print All Labels" id="Allfixedbutton" class='btn btn-primary btn-lg tip'><i class='fa fa-files-o'></i></a>
                        <!---<a href="<?php echo base_url(); ?>Booking/print_address_label" target="_blank" data-toggle="tooltip" data-original-title="Print Selected Labels One By One" id="B1fixedbutton" onclick="selected_print_one_by_one()" class='btn btn-primary btn-lg'>3<i class='pg-printer'></i></a>-->
                        

                       <table class='table table-bordered' id="myTable">
                        <thead>
                          <tr>
                            <th><div class="checkbox check-info checkbox-circle">
                            <input type="checkbox" onclick="select_all_function()" id="checkbox">
                            <label for="checkbox" style="color:rgb(9, 17, 62)">CN</label></div></th>
                            <th style="color:rgb(9, 17, 62)">COD</th>
                            <th style="color:rgb(9, 17, 62)">Customer Ref#</th>
                            <th style="color:rgb(9, 17, 62)">Date</th>
                            <th style="color:rgb(9, 17, 62)">Destination</th>
                            <th style="color:rgb(9, 17, 62)">Origin</th>
                            <th style="color:rgb(9, 17, 62)">Pieces</th>
                            <th style="color:rgb(9, 17, 62)">Status</th>
                            <th style="color:rgb(9, 17, 62)">Weight(KG)</th>
                            <th style="color:rgb(9, 17, 62)">Action</th>
                          </tr>
                        </thead>   
                         <tbody id="resultTable">
                         <?php if(!empty($orders_data)){
                               foreach($orders_data as $rows){ ?>
<tr>
<td><div class="checkbox check-info checkbox-circle">
<input type="checkbox" onclick="select_function(<?php echo $rows->order_code; ?>)" value="<?php echo $rows->order_code; ?>" id="checkbox<?php echo $rows->order_code; ?>">
<label for="checkbox<?php echo $rows->order_code; ?>"><?php echo $rows->order_code; ?></label>
</div></td>
<td style="font-size:13px;padding-top:18px"><center><?php echo $rows->cod_amount; ?></center></td>
<td style="font-size:13px;padding-top:18px"><center><?php echo $rows->customer_reference_no; ?></center></td>
<td style="font-size:13px;padding-top:18px"><center><?php echo $rows->order_date; ?></center></td>
<td style="font-size:13px;padding-top:18px"><center><?php echo $rows->destination_city_name; ?></center></td>
<td style="font-size:13px;padding-top:18px"><center><?php echo $rows->origin_city_name; ?></center></td>
<td style="font-size:13px;padding-top:18px"><center><?php echo $rows->pieces; ?></center></td>
<td style="font-size:13px;padding-top:18px"><center><?php echo $rows->order_status; ?></center></td>
<td style="font-size:13px;padding-top:18px"><center><?php echo $rows->weight; ?></center></td><td style="font-size:13px;padding-top:18px">
<a href="<?php echo base_url();?>Trackingo/index/<?php echo $rows->order_code; ?>" target="_blank"><button class="btn btn-info btn-xs">View</button></a> 
<a href="<?php echo base_url();?>Editbooking/index/<?php echo $rows->order_id; ?>" target="_blank"><button class="btn btn-info btn-xs">Edit</button></a> 
<button class="btn btn-danger btn-xs" data-toggle="modal" data-target="#exampleModal" onclick="cancel_shipment(<?php echo $rows->order_code; ?>,<?php echo $rows->cod_amount; ?>,<?php echo $rows->order_id; ?>)">Cancel</button>
</td>   
</tr>
                       <?php } }?>  
                         </tbody>  
                       </table>
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


<!-- Modal -->
<div class="modal fade stick-up" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content" style="background-color: black; color:white">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel" style="color:white">Are you sure to cancel ?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="body-data">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">No</button>
        <button type="button" class="btn btn-danger" onclick="yes_cancel_shipment()">Yes, Cancel</button>
      </div>
    </div>
  </div>
</div>
 
<script type="text/javascript">


function cancel_shipment(cn,cod,id){
$("#exampleModalLabel").html("Are you sure to cancel?"); 
$("#body-data").html("<input type='hidden' id='cancel_id' value='"+id+"'><div><table class='table'><tr><th>CN</td><th>"+cn+"</td></tr><tr><th>COD</th><th>PKR "+cod+"/-</th></tr></table></div>");
}

function yes_cancel_shipment(){
var order_id=$("#cancel_id").val();
var mydata={
id :order_id
};
$.ajax({
url: "<?php echo base_url(); ?>Booking/cancel_shipment",
type: "POST",
data: mydata,        
success: function(data) {
$("#resultTable").html(data);
$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-info'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button><strong>Your shipment has been cancelled successfully</strong></div></div>");
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
url: "<?php echo base_url(); ?>Addresslable/Get_All_Address_Label",
type: "POST",
data: mydata,        
success: function(data) {
$("#fixedbutton").html("<a href='<?php echo base_url(); ?>Booking/print_address_label' target='_blank' style='color:white'><font style='font-size:13px'>"+ data + " <i class='pg-printer'></i></font></a>"); 
//$("#B1fixedbutton").html("<a href='<?php echo base_url(); ?>Booking/print_address_label_one_by_one' style='color:white'><font style='font-size:13px'>"+ data + " <i class='pg-printer'></i></font></a>"); 

    
}
});
} 
else if($('#checkbox'+cn).prop("checked") == false){
var mydataa={
cn :cnn
};
$.ajax({
url: "<?php echo base_url(); ?>Booking/delete_temp_print_by_cn",
type: "POST",
data: mydataa,        
success: function(data) {
if(data==0){  
$("#fixedbutton").html("<i class='pg-printer'></i>");
$("input:checkbox").prop("checked", false);
} else { 
$("#fixedbutton").html("<a href='<?php echo base_url(); ?>Addresslable/Get_All_Address_Label' target='_blank' style='color:white'><font style='font-size:13px'>"+ data + " <i class='pg-printer'></i></font></a>");
//$("#B1fixedbutton").html("<a href='<?php echo base_url(); ?>Booking/print_address_label_one_by_one' style='color:white'><font style='font-size:13px'>"+ data + " <i class='pg-printer'></i></font></a>"); 
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
url: "<?php echo base_url(); ?>Addresslable/Get_All_Address_Label",
type: "POST",
data: mydata,        
success: function(data) {
$("#fixedbutton").html("<a href='<?php echo base_url(); ?>Addresslable/Get_All_Address_Label' target='_blank' style='color:white'><font style='font-size:13px'>"+ data + " <i class='pg-printer'></i></font></a>"); 
//$("#B1fixedbutton").html("<a href='<?php echo base_url(); ?>Booking/print_address_label_one_by_one' style='color:white'><font style='font-size:13px'>"+ data + " <i class='pg-printer'></i></font></a>"); 

}
});
} 
else if($('#checkbox').prop("checked") == false){
$("input:checkbox").prop("checked", false);
var mydataa={
cn :1
};
$.ajax({
url: "<?php echo base_url(); ?>Booking/all_delete_temp_print_by_cn",
type: "POST",
data: mydataa,        
success: function(data) {
if(data==0){  
$("#fixedbutton").html("<i class='pg-printer'></i>");
$("#B1fixedbutton").html("<i class='pg-printer'></i>");
$("input:checkbox").prop("checked", false);
} else { $("#fixedbutton").html("<a href='<?php echo base_url(); ?>Addresslable/Get_All_Address_Label' target='_blank' style='color:white'><font style='font-size:13px; color:white;'>"+ data + " <i class='pg-printer'></i></font></a>"); }  
}
});  
}  
}

function selected_print(){
$("input:checkbox").prop("checked", false);
$("[data-toggle='tooltip']").tooltip('hide');
$("#fixedbutton").html("<i class='pg-printer'></i>");
}

function selected_print_one_by_one(){
$("input:checkbox").prop("checked", false);
$("[data-toggle='tooltip']").tooltip('hide');
$("#B1fixedbutton").html("<i class='pg-printer'></i>");
}

</script>     
<?php
$this->load->view('inc/footer');
?>      