 <?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$("#myTable").saimtech();
$("#barcode_scan").focus();
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
                  <li class="breadcrumb-item">Create Load Sheet(Barcode)</li>
                  
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

                  <div class="col-xl-6 col-lg-6 ">

             
                <div class="card m-t-10">
              <div class="card-header  separator">
                        <div class="card-title"><h2>
                          Eligiable For Load Sheet </h2>  
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
                            <th style="color:rgb(9, 17, 62)">CN</th>
                            <th style="color:rgb(9, 17, 62)">Weight</th>
                            <th style="color:rgb(9, 17, 62)">OrderDate</th>
                            <th style="color:rgb(9, 17, 62)">Origin</th>
                            <th style="color:rgb(9, 17, 62)">Destination</th>
                            <th style="color:rgb(9, 17, 62)">OrderStatus</th>
                            </tr>
                        </thead>   
                         <tbody id="resultTable1">
                         <?php if(!empty($order_data)){ $i=0;
                               foreach($order_data as $rows){ $i=$i+1; ?>
<tr>
<td style="font-size:12px;padding-top:15px"><center><?php echo $i; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->order_code; ?></center></td>
<td style="font-size:10px;padding-top:15px"><center><?php echo $rows->weight; ?>KG</center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->order_date; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->origin_city_name; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->destination_city_name; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->order_status; ?></center></td>
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
               <div class="col-xl-6 col-lg-6 ">

             
                <div class="card m-t-10">
              <div class="card-header  separator">
                        <div class="card-title"><h2>
                          Scan Barcode <span id="count-bar"></span></h2>
                       
                        </div>
                           <button type='submit' class='btn btn-info pull-right text-white' id='create-btn-load-sheet'>Create Load Sheet</button>
                      </div>
                      <div class="card-body">

                      <div class="row clearfix">
                        
                        <div class="col-md-5">
                         
                        </div>
                      </div>
                     <br>
                                           
                      <div class="row">

                       <div class="col-md-12"> 
                        <center><img src="<?php echo base_url(); ?>assets/scaner.png" width="240px"></center>
                        
                        
                        <div class="table-responsive">
                       <div class="form-group form-group-default required" aria-required="true" id="product_detail_div">
                       <label>Barcode Scan</label>
                       <input type="text" class="form-control" name="barcode_scan" id="barcode_scan" required="required" tabindex="1">
                        </div>
                    
                    
                    <table class='table table-bordered'>
                        <thead>
                          <tr>
                            <th style="color:rgb(9, 17, 62)">Sr</th>
                            <th style="color:rgb(9, 17, 62)">CN</th>
                            <th style="color:rgb(9, 17, 62)">Weight</th>
                            <th style="color:rgb(9, 17, 62)">OrderDate</th>
                            <th style="color:rgb(9, 17, 62)">Origin</th>
                            <th style="color:rgb(9, 17, 62)">Destination</th>
                            <th style="color:rgb(9, 17, 62)">OrderStatus</th>
                            </tr>
                        </thead>   
                         <tbody id="resultTable2">
                         <?php if(!empty($col1_data)){ $i=0;
                               foreach($col1_data as $rows){ $i=$i+1; ?>
<tr>
<td style="font-size:12px;padding-top:15px"><center><?php echo $i; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->order_code; ?></center></td>
<td style="font-size:10px;padding-top:15px"><center><?php echo $rows->weight; ?>KG</center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->order_date; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->origin_city_name; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center><?php echo $rows->destination_city_name; ?></center></td>
<td style="font-size:12px;padding-top:15px"><center>Selected For LoadSheet</center></td>
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




 


<script type="text/javascript">


$('#barcode_scan').keypress(function(e) {
if (e.keyCode == 13) {
var cn= $('#barcode_scan').val();
if(cn!=""){
var mydata={ cn :cn };    
$.ajax({
url: "<?php echo base_url(); ?>Booking2/insert_temp_ls",
type: "POST",
data: mydata,        
success: function(data) {
$('#barcode_scan').val("");  
$("#barcode_scan").focus();
$("#create-btn-load-sheet").html("<a href='<?php echo base_url(); ?>Booking/create_load_sheet' style='color:white'><font style='font-size:13px;color:white'>"+ data + " Create Load Sheet</font></a>"); 
$("#count-bar").html(data);
//----------Redraw Eligiable Table
$.ajax({
url: "<?php echo base_url(); ?>Booking2/draw_eligi_ls_table",
type: "POST",
data: mydata,        
success: function(data) {
$("#resultTable1").html(data);
}
});
//--------------------------------

//----------Redraw Selected Table
$.ajax({
url: "<?php echo base_url(); ?>Booking2/draw_temp_ls_table",
type: "POST",
data: mydata,        
success: function(data) {
$("#resultTable2").html(data);
}
});
//--------------------------------
}
});    
}    
}
});



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


</script>     
<?php
$this->load->view('inc/footer');
?>      