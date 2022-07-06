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
{
extend: 'pdfHtml5',
orientation: 'Portrait',
pageSize: 'A4',
footer: 'true',
title:"Pendings Pickup",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"Delivery Express\n  Powered By SaimTech \n Date:<?php echo ''.date('Y-m-d'); ?> \n Pendings Pickup \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'Pendings Pickup',
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
title:"Pendings Pickup",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo ''.date('Y-m-d'); ?> <br>  <br>Pendings Pickup<br>"
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
                  <li class="breadcrumb-item">Dashborad</li>
                  <li class="breadcrumb-item">Pendings Pickup</li>
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
      
    <h1>Pendings Pickup</h1>
   
    </div>

    </div>


<div class="card-body">


             
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Shipper</th>
    <th>Load Sheet</th>
    <th>Origin</th>
    <th>Booking Date</th>
    <th>Pickup Address</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Shipments</th>
  </thead>
  <tbody>
  <?php 
  $i=0;
  if(!empty($pending_pickups_data)){
  foreach($pending_pickups_data as $rows){ 
  $i=$i+1;  
  echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td>".$rows->Shipper."</td>");
  echo("<td>".$rows->LoadSheet."</td>");
  echo("<td>".$rows->Origin."</td>");
  echo("<td>".$rows->BookingDate."</td>");
  echo("<td>".$rows->Pickup_Address."</td>");
  echo("<td>".$rows->Name."</td>");
  echo("<td>".$rows->Phone."</td>");
  echo("<td>".$rows->Shipments."</td>");
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




</div>

</div>

<?php
$this->load->view('inc/footer');
?>      