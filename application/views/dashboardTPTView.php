 <?php
error_reporting(0);
$this->load->view('inc/header');
?>
<script type="text/javascript">
$(document).ready(function(){ 
var table =$('#myTable').DataTable( {
"lengthMenu": [[ -1, 10, 25, 50], [ "All", 10, 25, 50]],
"order": [[ 8, "desc" ]],
fixedHeader: true,
"searching": true,
"paging":   true,
"ordering": true,
"bInfo": true,
dom: 'Blfrtip',
buttons: [
      'colvis', 
      
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'Pendings',
className: 'btn-info',
exportOptions: {
modifier: { page: 'current'}
}
},
{
extend: 'copyHtml5',
footer: 'true',
text:"<i class='fs-14 pg-note'></i> Copy",
titleAttr: 'Copy'
},
{
extend: 'print',
text:"<i class='fs-14 pg-ui'></i> Print",
titleAttr: 'Print',
footer: 'true',
title:"Pendings",
message:"Delivery Express <br> System Developer M.Saim <br>  Pending Report<br>"
}
]       
});
 
});
</script> 
 <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START JUMBOTRON -->
          <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0" style="background-color: #575757 !important; color:white">
              <div class="inner">
                <marquee  class="font-montserrat fs-13 all-caps p-t-3">This Will Show Delex News Update. http://www.delex.com.pk</marquee>
                </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->

<div class="row">
  
 <div class="col-md-3 m-b-10">
<div class="widget-9 card no-border bg-primary no-margin widget-loader-bar" style="background-image:linear-gradient(45deg, #1f3953, #6d5eac)">
<div class="full-height d-flex flex-column">
<div class="card-header ">
<div class="card-title text-white">
<span class="font-montserrat fs-11 all-caps">Pending Pickup<i class="fa fa-chevron-right"></i>
</span>
</div>
<div class="card-controls">
<ul>
<li><a href="#" class="card-refresh text-black" data-toggle="refresh"><i class="card-icon card-icon-refresh"></i></a>
</li>
</ul>
</div>
</div>
<div class="p-l-20">
<h3 class="no-margin p-b-5 text-white"><?php echo $pendings_pickup_count; ?></h3>
<a href="#" class="btn-circle-arrow text-white"><i class="pg-arrow_minimize"></i>
</a>
<a href="<?php echo base_url();?>Home/pending_pickups"><span class="small hint-text text-white">Click here for more detail</span></a>
</div>
</div>
</div>
</div>  

<div class="col-md-3 m-b-10">
<div class="widget-9 card no-border bg-info no-margin widget-loader-bar" style="background-image:linear-gradient(45deg, #1f3953, #949AEF)">
<div class="full-height d-flex flex-column">
<div class="card-header ">
<div class="card-title text-white">
<span class="font-montserrat fs-11 all-caps">OK Data <i class="fa fa-chevron-right"></i>
</span>
</div>
<div class="card-controls">
<ul>
<li><a href="#" class="card-refresh text-black" data-toggle="refresh"><i class="card-icon card-icon-refresh"></i></a>
</li>
</ul>
</div>
</div>
<div class="p-l-20">
<h3 class="no-margin p-b-5 text-white">All Delivered</h3>
<a href="<?php echo base_url();?>home/all_ok" class="btn-circle-arrow text-white"><i class="pg-arrow_minimize"></i>
</a>
<a href="<?php echo base_url();?>home/all_ok" target="_blank"><span class="small hint-text text-white">Click here for more detail</span></a>
</div>
</div>
</div>
</div>



<div class="col-md-3 m-b-10">
<div class="widget-9 card no-border bg-success no-margin widget-loader-bar" style="background-image:linear-gradient(45deg, #1f3953, #28a745)">
<div class="full-height d-flex flex-column">
<div class="card-header ">
<div class="card-title text-white">
<span class="font-montserrat fs-11 all-caps">Pending Sheets <i class="fa fa-chevron-right"></i>
</span>
</div>
<div class="card-controls">
<ul>
<li><a href="#" class="card-refresh text-black" data-toggle="refresh"><i class="fa fa-search"></i></a>
</li>
</ul>
</div>
</div>
<div class="p-l-20">
<h3 class="no-margin p-b-5 text-white"><?php echo $pendings_dd_count; ?></h3>
<a href="#" class="btn-circle-arrow text-white"><i class="pg-arrow_minimize"></i>
</a>
<a href="<?php echo base_url();?>home/pending_sheets"><span class="small hint-text text-white">Click here for more detail</span></a>
</div>
</div>
</div>
</div>


<div class="col-md-3 m-b-10">
<div class="widget-9 card no-border bg-danger no-margin widget-loader-bar" style="background-image:linear-gradient(45deg, #1f3953, #a01c21);">
<div class="full-height d-flex flex-column">
<div class="card-header ">
<div class="card-title text-white">
<span class="font-montserrat fs-11 all-caps">Return Data <i class="fa fa-chevron-right"></i>
</span>
</div>
<div class="card-controls">
<ul>
<li><a href="<?php echo base_url();?>home/all_rtd" class="card-refresh text-black" data-toggle="refresh"><i class="card-icon card-icon-refresh"></i></a>
</li>
</ul>
</div>
</div>
<div class="p-l-20">
<h3 class="no-margin p-b-5 text-white">All RTD</h3>
<a href="<?php echo base_url();?>home/all_rtd" class="btn-circle-arrow text-white"><i class="pg-arrow_minimize"></i>
</a>
<a href="<?php echo base_url();?>home/all_rtd"><span class="small hint-text text-white">Click here for more detail</span></a>
</div>
</div>
</div>
</div>




            </div>

<div class="row">
<div class="col-md-12 m-b-10"> 
<div class="card">
<div class="card-header">
<div class="card-title text-black">Pending Data
<a href="http://delex.com.pk/welcome/pending_date" target="blank" class='btn btn-info btn-xs'>Old Portal Pending</a>
</div>
 <div class="card-body no-padding">
     <?php //if(!empty($pending_data)){ ?>
     <div class='table-responsive'>
    <table class="table table-bordered" id='myTable'>
      <thead>
      <tr>
                          <th>No #</th>
                          <th>CN</th>
                          <th>Status</th>
                          <th>Destination </th>
                          <th>Origin </th>
                          <th>Weight</th>
                          <th>COD</th>
                          <th>Hand Over Date</th>
                          <th>Last Activity Date</th>
                          </tr>  
                          </thead>
                          <?php if(!empty($pending_data)){
                          $i=0;  
                          foreach($pending_data as $rows){
                          $i=$i+1; 
                          echo("<tr>");
                          echo("<td><center>".$i."</td>");
                          echo("<td><center>".$rows->agent_order_code."</td>");
                          echo("<td><center>".$rows->agent_status."</td>");
                          echo("<td><center>".$rows->destination_name."</td>");
                          echo("<td><center>".$rows->origin_name."</td>");
                          echo("<td><center>".$rows->agent_weight."</td>");
                          echo("<td><center>".number_format($rows->agent_cod)."</td>");
                          echo("<td><center>".$rows->handover_date."</td>");
                          echo("<td><center>".$rows->last_activity_date."</td>");
                          echo("</tr>"); 
                         }}?>
                         
                         </tbody>  
    </table>         
         
     </div>
     <?php// } ?>
</div>
  <div class="card-header  separator">
                        <div class="card-title" name="1-success-message" id="1-success-message">
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