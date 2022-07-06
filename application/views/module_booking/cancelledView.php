 <?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 

$("#myTable").saimtech();


  $('#create_excel').click(function(){  
  alert($('#auto-load').html());
           var excel_data = $('#auto-load').html();  
           var page = "<?php echo base_url(); ?>assets/excel.php?data=" + excel_data;  
           window.location = page;  
      });  



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
          <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
              <div class="inner">
                <!-- START BREADCRUMB -->
                 <ol class="breadcrumb">
                  <li class="breadcrumb-item">Dashboard</li>
                  <li class="breadcrumb-item">Manage Cancelled</li>
                  
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
   
           

                  <div class="col-xl-12 col-lg-12 ">

                <div class="card m-t-10">
              <div class="card-header  separator">
                        <div class="card-title">Manage Cancelled CN
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
					             <table class='table table-bordered' id="myTable">
                        <thead>
                          <tr>
                            <th>CN</th>
                            <th>COD</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Origin</th>
                            <th>Destination</th> 
                            <th>Status</th>
                            <th>Action</th>
                          </tr>
                        </thead>   
                         <tbody id="resultTable">
                          <?php if(!empty($cancelled_data)){
                                foreach($cancelled_data as $rows){
                                echo("<tr>");
                                echo("<td>".$rows->order_code."</td>");
                                echo("<td>".number_format($rows->cod_amount)."/-</td>");
                                echo("<td>".$rows->consignee_name."</td>");
                                echo("<td>".$rows->consignee_mobile."</td>");
                                echo("<td>".$rows->consignee_email."</td>");
                                echo("<td>".$rows->origin_city_name."</td>");
                                echo("<td>".$rows->destination_city_name."</td>");
                                echo("<td>".$rows->order_status."</td>");
                                echo("<td><a href='".base_url()."home/re_order/".$rows->order_id."' class='btn btn-danger btn-xs'>Re-Order</a>") ;?>
                                <a href="<?php echo base_url();?>Editbooking/index/<?php echo $rows->order_id; ?>" target="_blank"><button class="btn btn-danger btn-xs">Edit</button></a> 
                                <?php 
                                echo("</td>");
                                echo("</tr>"); 
                                }}?>
                         
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
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add New Pickup Point</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p id="msg_show">Create multiple pick pionts.</p>
        <div class="form-group-attached" style="border-color: black">
<div class="row clearfix">
<div class="col-md-6">
<div class="form-group form-group-default required" aria-required="true" id="name_div">
<label>Name</label>
<input type="text" class="form-control" name="name" id="name" tabindex="1">
</div>
</div>
<div class="col-md-6" >
<div class="form-group form-group-default required" id="phone_div">
<label>Phone</label>
<input type="phone" class="form-control" name="phone" id="phone" tabindex="2">
</div>
</div>
</div>
<div class="row clearfix">
<div class="col-md-6" >
<div class="form-group form-group-default" >
<label>Email</label>
<input type="email" class="form-control" name="email" id="email" tabindex="3">
</div>
</div>
<div class="col-md-6" >
<div class="form-group form-group-default required" id="city_div">
<label>City</label>
<select class="form-control" name="city" id="city" tabindex="4">
<option value="">Select City</option>
<?php if(!empty($pick_up_cities)){
foreach($pick_up_cities as $rows){
if($_SESSION['account_type']=='LW' && $_SESSION['origin_id']==$rows->city_id){  
echo("<option value='".$rows->city_id."'>(".$rows->city_code.") ".$rows->city_name.", ".$rows->country_name."</option>");  
} else if($_SESSION['account_type']=='NW'){  
echo("<option value='".$rows->city_id."'>(".$rows->city_code.") ".$rows->city_name.", ".$rows->country_name."</option>"); 
}
}
} ?>
</select>
</div>
</div>
</div>
<div class="form-group form-group-default required" aria-required="true" id="address_div">
<label>Address</label>
<textarea class="form-control" name="address"  id="address" tabindex="5"  rows=100 tabindex="5"></textarea>
</div>
<div class="form-group form-group-default">
<label>Google Map URL</label>
<input type="url" class="form-control" name="map_url" id="map_url" tabindex="6">
</div>
</div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="add_pick_up_point()">Save Location</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div> 
<script type="text/javascript">
function add_pick_up_point(){
var check="Pass";
var name="";
var phone="";
var city_id="";
var address = "";
var google_map_url = $("#map_url").val();
var email=$("#email").val();
//------------Name
if($("#name").val()!=""){
name=$("#name").val();
$("#name_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#name_div").css("border-color", "red"); 
$("#name").focus();
check="Fail";
}
//--------------------------------End
//------------Phone-----------
if($("#phone").val()!="" ){
phone=$("#phone").val();
$("#phone_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#phone_div").css("border-color", "red");  
$("#phone").focus();
check="Fail";
}
//--------------------------------End
//---------city----
if($("#city").val()!=""){
city_id=$("#city").val();
$("#city_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#city_div").css("border-color", "red"); 
$("#city").focus();
check="Fail";
}
//--------------------------------End
//---------address----
if($("#address").val()!=""){
address=$("#address").val();
$("#address_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#address_div").css("border-color", "red"); 
$("#address").focus();
check="Fail";
}
//--------------------------------End
//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
name              :name,
phone             :phone,
city_id           :city_id,
address           :address,
email             :email,
google_map_url    :google_map_url
};
$.ajax({
url: "<?php echo base_url(); ?>Pickpoint/add_new_record",
type: "POST",
data: mydata,        
success: function(data) {
var objJSON = $.parseJSON(data); 
$("#msg_show").html(objJSON.notification);
$.ajax({
url: "<?php echo base_url(); ?>Pickpoint/redraw_table",
type: "POST",
data: mydata,        
success: function(data) {
$("#resultTable").html(data);
}
});
}
});
$("#name").val("");
$("#phone").val("");
$("#city").val("");
$("#email").val("");
$("#address").val("");
$("#address").val("");
$("#name").focus("");
}
}


function delete_record(pickupid){
var mydata={
event_id         :eventid
};
$.ajax({
url: "<?php echo base_url(); ?>Pickpoint/delete_record",
type: "POST",
data: mydata,        
success: function(data) {
$("#resultTable").html(data);
}
});
}

</script>     
<?php
$this->load->view('inc/footer');
?>      