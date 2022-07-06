<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<style>
    @media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
</style>
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
                 <ol class="breadcrumb no-print">
                  <li class="breadcrumb-item">Operations</li>
                  <li class="breadcrumb-item">RR Sheet</li>
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
    <div class="card-title">
    <input type="text" placeholder="Enter Delivery Sheet No" class=" m-t-5 form-control no-print" id="sheet_code" name="sheet_code">
    </div>
    </div>
<div class="card-body">                       
<div class="table-responsive m-t-10">
<img src="https://tmdelex.com/cargo/ops_tm/assets/img/tmlogo.png" alt="logo" data-src="https://tmdelex.com/cargo/ops_tm/assets/img/tmlogo.png" data-src-retina="https://tmdelex.com/cargo/ops_tm/assets/img/tmlogo.png" width="150" height="100">    
<CENTER><h1> RR SHEET</h1></CENTER>
<button onclick="myFunction()" class="btn btn-primary no-print pull-right" >Print RR Sheet</button>
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Sheet Code</th>
    <th>CN</th>
    <th>Rider Name</th>
    <th>Route Name</th>
    <th>Sheet Date</th>
    <th>Deliver Date</th>
    <th>COD Amount</th>
    <th>Received Amount</th>
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
url: "<?php echo base_url(); ?>RR/rr_sheet_data",
type: "POST",
data: mydata,        
success: function(data) {
$("#autoload").html(data);
}
});

}
}
});  


function myFunction() {
  window.print();
}

</script>


</div>

</div>

<?php
$this->load->view('inc/footer');
?>      