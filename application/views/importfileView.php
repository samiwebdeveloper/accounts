<?php
error_reporting(0);
$this->load->view('inc/header');
?>
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
                  <li class="breadcrumb-item">Status</li>
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
<h3 style="color: #911717;" class="text no-margin"><b>Import Status</b></h3>
<br>
<p>Download CSV File.
  <br>
  Insert Data.
  <br>
  Then Upload CSV File
</p>
<br>
                          <form method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>Importfile/submit_import_file">
                          <div class="form-group form-group-default"  id="event_file_div">
                            <label>CSV File</label>
                            <input type="file" required="required" class="form-control"  name="file" id="file" class="form-control"  accept=".csv" >
                          </div>
                     
                      
                      <div class="clearfix"></div>
                      <button type="submit"  class="btn btn-danger pull-right"  tablindex="3"><i class="pg-form"></i> Upload File</button>
<div id="1-success-message"></div>
</div>
</div>

</div>
<div class="col-md-7">

<div class="card card-default">
<div class="card-body">
<p class="sm-p-t-20">You can also make multiple status by uplaoding csv file.  <a href="<?php echo base_url();?>assets/ImportStatus.csv">Click here for download csv format.</a> 
</p>
<div class="row">
 <div class="table-responsive">
  
 <a href="<?php echo base_url();?>assets/ImportStatus.csv"><img src='<?php echo base_url();?>assets/importstatus.JPG' class='img img-responsive' ></a> 


 </div>
                        


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