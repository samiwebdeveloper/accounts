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
title:"Manifest Lists",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"TM Cargo\n  Powered By SaimTech \n Date:<?php echo ''.date('Y-m-d'); ?> \n Manifest Lists \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'Manifest Lists',
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
title:"Manifest Lists",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo ''.date('Y-m-d'); ?> <br>  <br>Manifest Lists<br>"
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
                  <li class="breadcrumb-item">Operations</li>
                  <li class="breadcrumb-item">Manifest</li>
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
                        <div class="card-title"><a href="<?php echo base_url(); ?>Loading/create_loading_sheet_view" class='btn btn-primary'>Create New Manifest</a>
                        </div>
                          <div class="form-group-attached">

<div class="row clearfix">

<div class="col-sm-3">
<div class="form-group form-group-default required" id="user_name_div">
    <form action="<?php echo base_url(); ?>Loading/date_range" method="post">
<label>Start Date</label>
<input type="date" class="form-control" id="start_date" name="start_date" required="" value="<?php if(!empty($start_date)){ echo $start_date; } ?>">
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required">
<label>End Date</label>
<input type="date" class="form-control" id="end_date" name="end_date" required="" value="<?php if(!empty($end_date)){ echo $end_date; } ?>">
</div>
</div>
<div class="col-sm-3">
<button type="submit" class='btn btn-primary' style="height:100%">GO</button>    
</div>    
</div>
</form>

</div>
                      </div>
                      <div class="card-body">
                       
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Manifest Code</th>
    <th>Route Name</th>
    <th>Vehicle#</th>
    <th>Staff Detail</th>
    <th>Origin</th>
    <th>Date</th>
    <th>Status</th>
    <th>Stamp</th>
    <th>Action</th>
  </thead>
  <tbody>
  <?php 
  $i=0;
  if(!empty($loading_sheets)){
  foreach($loading_sheets as $rows){ 
  $i=$i+1;  
  echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td>".$rows->transit_code."</td>");
  echo("<td>".$rows->route_name."</td>");
  echo("<td>".$rows->vehicle_no."</td>");
  echo("<td>".$rows->staff_name.", ".$rows->staff_number."</td>");
  echo("<td>".$rows->city_name."</td>");
  echo("<td>".$rows->transit_date."</td>"); 
  if($rows->transit_origin==$rows->current_location){
  echo("<td><center><code>Start (".$rows->Current.")</code></center></td>");      
  } else if($rows->route_destination==$rows->current_location){
  echo("<td><center><code>Complete (".$rows->Current.")</code></center></td>");      
  } else if($rows->route_destination!=$rows->current_location){
  echo("<td><center><code>Running (".$rows->Current.")</code></center></td>");}
  echo("<td>".$rows->oper_user_name."</td>");
  echo("<td><a href='".base_url()."Loading/loading_print/".$rows->transit_list_id."' class='btn btn-info btn-xs'>Print</a> <a href='".base_url()."Loading/loading_print_all/".$rows->transit_list_id."' class='btn btn-info btn-xs'>Print All</a><a href='".base_url()."Loading/export_manifest_detail/".$rows->transit_list_id."' style='margin-left:3px;' class='btn btn-info btn-xs'>Excel</a></td>");
  
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