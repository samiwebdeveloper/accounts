 <?php
error_reporting(0);
$this->load->view('inc/header');
?>
<script type="text/javascript">
$(document).ready(function(){ 
 
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
                  <li class="breadcrumb-item">Settings</li>
                  
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
                        <div class="card-title">Settings
                        </div>
                      </div>
                      <div class="card-body">

                      <div class="row clearfix">
                        
                        <div class="col-md-5">
                         
                        </div>
                      </div>
                     <br>
                      
                     
                      <div class="row">
                        <div class="col-xl-3 col-lg-3">
                          <div class="card card-default bg-danger" style="background-color: #575757 !important">
                              <div class="card-header  separator">
                                <div class="card-title text-white">Manage Settings
                                  </div>
                                </div>
                            <div class="card-body text-white">
                              <h3 class="text-white">
<span class="semi-bold text-white">Change</span> Password</h3>
<?php echo $msg; ?>
<form role="form" action="<?php echo base_url();?>Home/submit_setting" method="post">
<div class="form-group">
<label>Old Password</label>
<span class="help text-white"></span>
<input type="password" placeholder="Enter Old Password" class="form-control"  required="" name="old_password" id="old_password">
</div>
<div class="form-group">
<label>New Password</label>
<span class="help text-white"></span>
<input type="password" placeholder="Enter New Password" class="form-control" required="" name="new_password" id="new_password">
</div>
<div class="form-group">
<label>Retype Password</label>
<span class="help text-white"></span>
<input type="password"  placeholder="Enter Retype Password" class="form-control" required="" name="retype_password" id="retype_date">
</div>

</div>
<div class="card-footer">
  <button class="btn btn-danger pull-right" type="submit">Change</button>
  </div>
  </form>

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

<?php
$this->load->view('inc/footer');
?>      