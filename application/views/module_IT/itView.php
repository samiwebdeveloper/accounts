 <?php
error_reporting(0);
$this->load->view('inc/header');
?>

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
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
              <div class="inner">
                <!-- START BREADCRUMB -->
                 <ol class="breadcrumb">
                  <li class="breadcrumb-item">Tool</li>
                  <li class="breadcrumb-item">Special Powers</li>
                  
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
<div class="col-lg-4">

<div class="card card-default">
<div class="card-header ">
<div class="card-title">Boost Up Things
</div>
</div>
<div class="card-body">
<p id="boost_up_msg">Optimization of Operations & Booking Module.</p>
<br>
<button onclick="order_archive()" class="btn btn-block btn-info" type="button">
<span class="pull-left"><?php echo $order_archive_num; ?>
</span>
<span class="bold">Create Order Archive</span>
</button>
<button onclick="arrival_archive()" class="btn btn-block btn-primary" type="button">
<span class="pull-left"><?php echo $arrival_archive_num; ?>
</span>
<span class="bold">Create Arrival Archive</span>
</button>
<button onclick="bagging_archive()" class="btn btn-block btn-danger" type="button">
<span class="pull-left"><?php echo $bagging_archive_num; ?>
</span>
<span class="bold">Create Bagging Archive</span>
</button>
<button onclick="loading_archive()" class="btn btn-block btn-info" type="button">
<span class="pull-left"><?php echo $loading_archive_num; ?>
</span>
<span class="bold">Create Loading Archive</span>
</button>
<button onclick="delivery_archive()" class="btn btn-block btn-primary" type="button">
<span class="pull-left"><?php echo $delivery_archive_num; ?>
</span>
<span class="bold">Create Delivery Archive</span>
</button>
</div>
</div>

</div>
<div class="col-lg-4">

<div class="card card-default">
<div class="card-header ">
<div class="card-title">System Correctness 
</div>
</div>
<div class="card-body">
<p id="con_msg">Rating, Delivery Riders, Pickups Riders</p>
<br>
<button class="btn btn-block btn-info" onclick="cheezmall_rating()" type="button">
<span class="pull-left" >T
</span>
<span class="bold">(ToSharing) Cheezmall Rating</span>
</button>
<button class="btn btn-block btn-primary" onclick="all_rating()" type="button">
<span class="pull-left">R
</span>
<span class="bold">All Customer Rating</span>
</button>
<button class="btn btn-block btn-danger" onclick="delivery_rider()" type="button">
<span class="pull-left">D
</span>
<span class="bold">Refresh Delivery Rider Data</span>
</button>
<button class="btn btn-block btn-info" onclick="pickup_rider()" type="button">
<span class="pull-left">P
</span>
<span class="bold">Refresh Pickup Rider Data</span>
</button>
<button onclick="not_deliverd_cn()" class="btn btn-block btn-primary" type="button">
<span class="pull-left">M
</span>
<span class="bold">Mail (Not Deliveried CNs)</span>
</button>

<a href="<?php echo base_url(); ?>IT/deliverd_cns" class="btn btn-block btn-success" >
<span class="pull-left">M
</span>
<span class="bold">Mail (Deliveried CNs)</span>
</a>

<a href="<?php echo base_url(); ?>IT/daily_arrival_cns" class="btn btn-block btn-info" >
<span class="pull-left">A
</span>
<span class="bold">Mail (Daily Arrival MIS)</span>
</a>



<a href="<?php echo base_url(); ?>Direct" class="btn btn-block btn-danger" type="button">
<span class="pull-left">D
</span>
<span class="bold">IT DD Control</span>
</a>
</div>
</div>

</div>

<div class="col-lg-4">

<div class="card card-default">
<div class="card-header ">
<div class="card-title">Sys With Old Portal 
</div>
</div>
<div class="card-body">
<p id="sys-msg">Take Backup From Old Portal And Insert Into New Portal</p>
<br>
<button onclick="full_backup()" class="btn btn-block btn-info" type="button">
<span class="pull-left">F
</span>
<span class="bold">Full Back UP</span>
</button>
<button onclick="day_backup()" class="btn btn-block btn-primary" type="button">
<span class="pull-left">D
</span>
<span class="bold">Day Back UP</span>
</button>

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

<script>

function order_archive(){
$('#boost_up_msg').html("<center><p class='alert alert-primary'>[Order] Please Wait...! We are getting up things for you.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "<?php echo base_url(); ?>Archive/cp",
type: "POST",
data: mydata,        
success: function(data) {
$('#boost_up_msg').html(data);
}
});
}

function arrival_archive(){
$('#boost_up_msg').html("<center><p class='alert alert-primary'>[Arrival] Please Wait...! We are getting up things for you.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "<?php echo base_url(); ?>Arrival/cp",
type: "POST",
data: mydata,        
success: function(data) {
$('#boost_up_msg').html(data);
}
});
}

function bagging_archive(){
$('#boost_up_msg').html("<center><p class='alert alert-primary'>[Bagging] Please Wait...! We are getting up things for you.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "<?php echo base_url(); ?>Bagging/cp",
type: "POST",
data: mydata,        
success: function(data) {
$('#boost_up_msg').html(data);
}
});
}

function loading_archive(){
$('#boost_up_msg').html("<center><p class='alert alert-primary'>[Loading] Please Wait...! We are getting up things for you.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "<?php echo base_url(); ?>Loading/cp",
type: "POST",
data: mydata,        
success: function(data) {
$('#boost_up_msg').html(data);
}
});
}


function delivery_archive(){
$('#boost_up_msg').html("<center><p class='alert alert-primary'>[Delivery] Please Wait...! We are getting up things for you.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "<?php echo base_url(); ?>Delivery/cp",
type: "POST",
data: mydata,        
success: function(data) {
$('#boost_up_msg').html(data);
}
});
}

function full_backup(){
$('#sys-msg').html("<center><p class='alert alert-primary'>[Full Backup] Please Wait...! We are getting up things for you.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "https://delex.pk/Remote/get_json_object",
type: "POST",
data: mydata,        
success: function(data) {
$('#sys-msg').html(data);
}
});
}


function day_backup(){
$('#sys-msg').html("<center><p class='alert alert-primary'>[Day Backup] Please Wait...! We are getting up things for you.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "https://delex.pk/Remote/get_json_object_date",
type: "POST",
data: mydata,        
success: function(data) {
$('#sys-msg').html(data);
}
});
}

function cheezmall_rating(){
$('#con_msg').html("<center><p class='alert alert-primary'>[Cheezmall Rating] Please Wait...! We are getting up things for you.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "https://delex.pk/Rate/cheezmall_rating",
type: "POST",
data: mydata,        
success: function(data) {
$('#con_msg').html(data);
}
});
}

function all_rating(){
$('#con_msg').html("<center><p class='alert alert-primary'>[All Rating] Please Wait...! We are getting up things for you.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "https://delex.pk/Rate/cal_all_rating",
type: "POST",
data: mydata,        
success: function(data) {
$('#con_msg').html(data);
}
});
}

function delivery_rider(){
$('#con_msg').html("<center><p class='alert alert-primary'>Please Wait...! </p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "<?php echo base_url(); ?>/IT/delivery_rider",
type: "POST",
data: mydata,        
success: function(data) {
$('#con_msg').html(data);
}
});
}

function pickup_rider(){
$('#con_msg').html("<center><p class='alert alert-primary'>Please Wait...! </p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "<?php echo base_url(); ?>/IT/pickup_rider",
type: "POST",
data: mydata,        
success: function(data) {
$('#con_msg').html(data);
}
});
}

function not_deliverd_cn(){
$('#con_msg').html("<center><p class='alert alert-primary'>Please Wait...! Sending Emails.</p></center>");
var mydata={ orderid : 1 };
$.ajax({
url: "<?php echo base_url(); ?>/IT/not_deliverd_cns",
type: "POST",
data: mydata,        
success: function(data) {
$('#con_msg').html(data);
}
});
}



</script>


</div>

</div>

<?php
$this->load->view('inc/footer');
?>      