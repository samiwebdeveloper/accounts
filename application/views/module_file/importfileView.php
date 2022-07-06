 <?php
error_reporting(0);
$this->load->view('inc/header');
?>


<script type="text/javascript">
$(document).ready(function(){ 
var table =$('#myTable').DataTable( {
"lengthMenu": [[ -1, 10, 25, 50], [ "All", 10, 25, 50]],     
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
sheetName:'Thrid Party',
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
title:"QSR <?php echo $start_date." To ".$end_date; ?>",
message:"Delivery Express <br> System Developer M.Saim <br>  Thrid Party<br>"
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
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0">
              <div class="inner">
                <!-- START BREADCRUMB -->
                 <ol class="breadcrumb">
                  <li class="breadcrumb-item">Manage</li>
                  <li class="breadcrumb-item">Thrid Party Shipments</li>
                  
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
  
    <div class="card-title">Manage Thrid Party Shipment Download CSV File Format <a href='<?php echo base_url(); ?>assets/TM.csv'>Click Here</a>

    </div>
    </div>
<div class="card-body">            
  <?php if($_SESSION['user_power']!="TM"){  ?>    
  <button class="btn btn-primary" data-toggle="modal" data-target="#myModal"><i class="pg-plus"></i> Add New</button>
      <?php } ?>
<BR>
  <a href="<?php echo base_url(); ?>IT/tm_api" target="blank"><button class="btn btn-info"> Update N/A FTP</button></a>
  <a href="<?php echo base_url(); ?>IT/b_tm_api" target="blank"><button class="btn btn-info"> Update N/A BCK</button></a>
  <a href="<?php echo base_url(); ?>IT/tm_api_booked" target="blank"><button class="btn btn-success">Update Booked FTP</button></a>
  <a href="<?php echo base_url(); ?>IT/tm_api_b_booked" target="blank"><button class="btn btn-info">Update Booked BCK </button></a>
  <a href="<?php echo base_url(); ?>IT/tm_api_refused" target="blank"><button class="btn btn-default">Update Refused FTP</button></a>
  <a href="<?php echo base_url(); ?>IT/tm_api_b_refused" target="blank"><button class="btn btn-info">Update Refused BCK</button></a>
  <a href="<?php echo base_url(); ?>IT/tm_api_ras" target="blank"><button class="btn btn-primary">Update RAS FTP</button></a>
  <a href="<?php echo base_url(); ?>IT/tm_api_b_ras" target="blank"><button class="btn btn-info">Update RAS BCK</button></a>
  <a href="<?php echo base_url(); ?>IT/tm_api_Transit" target="blank"><button class="btn btn-warning">Update Transit FTP</button></a>
  <a href="<?php echo base_url(); ?>IT/tm_api_b_Transit" target="blank"><button class="btn btn-info">Update Transit BCK</button></a>
  <a href="<?php echo base_url(); ?>IT/tm_api_delivered" target="blank"><button class="btn btn-danger">Update Delivered FTP</button></a>
  <a href="<?php echo base_url(); ?>IT/b_tm_api_delivered" target="blank"><button class="btn btn-info">Update Delivered BCK</button></a>




<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Arrival Date</th>
    <th>Shipper</th>
    <th>DELEX CN</th>
    <th>DELEX Status</th>
    <th>Destiantion</th>
    <th>COD</th>
    <th>Third Company CN</th>
    <th>Third Company Status</th>
    <th>Name</th>
    <th>Address</th>
    </thead>
  <tbody id="autoload">
   <?php  if(!empty($tm_data)){$i=0;
    foreach($tm_data as $rows){
    $i=$i+1;        
    echo("<tr>");
    echo("<td>".$i."</td>");
    echo("<td>".$rows->order_arrvial_date."</td>");
    echo("<td>".$rows->customer_name."</td>");
    echo("<td>".$rows->order_code."</td>");
    echo("<td>".$rows->order_status."</td>");
    echo("<td>".$rows->destination_city_name."</td>");
    echo("<td>".$rows->cod_amount."</td>");
    echo("<td>".$rows->thrid_party_cn."</td>");
    echo("<td>".$rows->thrid_party_status."</td>");
    echo("<td>".$rows->consignee_name." (".$rows->consignee_mobile.")</td>");
    echo("<td>".$rows->consignee_address."</td>");
    echo("</tr>");
    }} ?>
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
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Upload Thrid Party Shipment.  </h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p id="msg_show">Add Shipment File.</p>
       <p>Download CSV File Format <a href='<?php echo base_url(); ?>assets/TM.csv'>Click Here</a></p>

        <div class="form-group-attached" style="border-color: black">
 <form method="post" enctype="multipart/form-data" action="<?php echo base_url(); ?>Importfile/submit_import_file">
<div class="form-group form-group-default required" id="file_path_div">
<label>File</label>
<input type="file" class="form-control"  name="file" id="file"  tabindex="2" >
</div>
</div>
<center><div id="target"></div></center>

      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" >Update Document</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
</form>
    </div>
  </div>
</div> 

<script>


</script>


</div>

</div>

<?php
$this->load->view('inc/footer');
?>      