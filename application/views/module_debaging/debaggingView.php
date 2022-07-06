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
title:"DE Bagging Lists",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"Delivery Express\n  Powered By SaimTech \n Date:<?php echo ''.date('Y-m-d'); ?> \n DE Bagging Lists \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'DE Bagging Lists',
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
title:"DE Bagging Lists",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo ''.date('Y-m-d'); ?> <br>  <br>De Bagging Lists<br>"
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
                  <li class="breadcrumb-item">DE Bagging</li>
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
                        <div class="card-title"><a href="<?php echo base_url(); ?>Debagging/create_debagging_sheet_view" class='btn btn-primary'>Create De Bagging List</a>
                        </div>
                                   <div class="form-group-attached">

<div class="row clearfix">

<div class="col-sm-3">
<div class="form-group form-group-default required" id="user_name_div">
<form action="<?php echo base_url(); ?>Debagging/date_range" method="post">
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
    <th>Bagging Code</th>
    <th>Seal No</th>
    <th>Barcode</th>
    <th>Destination</th>
    <th>Complete</th>
    <th>Short</th>
    <th>Date</th>
    <th>Stamp</th>
    <th>Action</th>
  </thead>
  <tbody>
  <?php 
  $i=0;
  if(!empty($debagging_sheets)){
  foreach($debagging_sheets as $rows){ 
  $i=$i+1;  
  echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td>".$rows->bagging_code."</td>");
  echo("<td>".$rows->bagging_seal."</td>");
  echo("<td>".$rows->bagging_barcode."</td>");
  echo("<td>".$rows->city_name."</td>");
  if($rows->is_complete==1){
  echo("<td>Complete</td>");
  } else {
  echo("<td>Pendding</td>");  
  }
  echo("<td>".$rows->debagging_short."</td>"); 
  echo("<td>".$rows->debagging_date."</td>"); 
  echo("<td>".$rows->oper_user_name."</td>");
   if($rows->is_debagging_complete==1){
  echo("<td><a href='".base_url()."debagging/print_debagging_sheet/".$rows->bagging_code."' target='_blank' class='btn btn-primary btn-xs'>Print</a> <a href='".base_url()."debagging/view_debagging_sheet/".$rows->bagging_code."' target='_blank' class='btn btn-info btn-xs'>View</a></td>");
  } else {
  echo("<td>Pendding</td>");  
  }
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