 <?php
error_reporting(0);
$this->load->view('inc/header');
?>
<script type="text/javascript">
//$(document).ready(function(){
//$("#typeTable").saimtech();
//$("#pickupTable").saimtech();
//$("#destinationTable").saimtech(); 
//$("#eeror").hide(); 
//});


// // function imp_file_upload(){  
// if($('#file_upload').val()!=""){
// $("#eeror").show();     
// $("#event_file_div").css("border-color", "#20c997");  
// var inputFile = $('input[name=filename]'); 
// var fileToUpload = inputFile[0].files[0];  
// var formData     = new FormData()
// formData.append("file" ,fileToUpload);                        
// $.ajax({
// url: "<?php echo base_url(); ?>Booking/submit_import_file",
// type: "POST",
// data: formData, 
// contentType: false,
// processData: false,         
// success: function(data) {
// $("#1-success-message").html(data);
// }
// });
// } else{
// $("#event_file_div").css("border-color", "red");  
// }
// }   

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
                  <li class="breadcrumb-item">Upload Status</li>
                  <li class="breadcrumb-item">Import Status</li>
                  
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
<div class="col-md-5">

<div class="card card-transparent">
<div class="card-header ">
<div class="card-title">
Upload CSV file for multiple Status 
</div>
</div>
<div class="card-body">
<h3 class="text-info no-margin">Import Status</h3>
<br>
<p>Download CSV File.
  <br>
  Insert Data.
  <br>
  Then Upload CSV File
</p>
<br>

                          <div class="form-group form-group-default"  id="event_file_div">
                            <label>CSV File</label>
                            <input type="file" class="form-control" name="filename" id="file_upload" class="form-control"  accept=".csv" >
                          </div>
                     
                      
                      <div class="clearfix"></div>
                      <button type="button" onclick="imp_file_upload()" class="btn btn-info pull-right"  tablindex="3"><i class="pg-form"></i> Upload File</button>

<div id="error-message"></div>
<!--<a href='<?php echo base_url();?>Booking/error_data' id='eeror'>(Click Here For View Error)</a>-->
<div id="1-success-message"></div>


</div>
</div>

</div>
<div class="col-md-7">

<!--<div class="card card-default">
<div class="card-body">
<p class="sm-p-t-20">You can also make multiple bookings by uplaoding csv file.  <a href="<?php echo base_url();?>assets/Import_booking.csv">Click here for download csv format.</a> 
</p>
<div class="row">
 <div class="table-responsive">
  
 <a href="<?php echo base_url();?>assets/Import_booking.csv"><img src='<?php echo base_url();?>assets/import_booking.PNG' class='img img-responsive' ></a> 


 </div>-->
                        


                
                        
      


                        



                  </div>                  
</div>
</div>
</div>

</div>
</div>








            <!-- END PLACE PAGE CONTENT HERE -->
          </div>
          <!-- END CONTAINER FLUID -->
        </div>
        <!-- END PAGE CONTENT -->
<?php
$this->load->view('inc/footer');
?>      