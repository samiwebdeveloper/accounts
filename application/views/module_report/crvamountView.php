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
title:"Cr Report",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"Delivery Express\n  Powered By SaimTech \n Date:<?php echo ''.$cr_date; ?> \n Cr Report \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'Cr Report',
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
title:"Cr Report",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo ''.$cr_date; ?> <br>  <br>CrV Report<br>"
}
]       
});



var table =$('#mmyTable').DataTable( {
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
title:"Cr Report",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"Delivery Express\n  Powered By SaimTech \n Date:<?php echo ''.$cr_date; ?> \n CrV Report \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'Cr Report',
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
title:"Cr Report",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo ''.$cr_date; ?> <br>  <br>Cr Report<br>"
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
                  <li class="breadcrumb-item">CRV Amount Data</li>
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
  
<div class="col-md-12">
    <div class="card-header  separator">
    <div class="card-title">
      
    <h1>CRV Amount Data</h1>
   
    </div>

    </div>


<div class="card-body">

<div class="card card-default">
<div class="card-body bg-info">

<form role="form" method="post" action="<?php echo base_url(); ?>Archive/crv_report_submit">
<div class="form-group">
<label class="text-white">Date</label>
<span class="help text-white">e.g. "2020-05-23"</span>
<input type="date" class="form-control" id="cr_date" value="<?php echo $cr_date; ?>" name="cr_date" required="">
</div>
<div class="form-group">
<input type="hidden"  value="<?php echo $_SESSION['origin_id'];?>" id="cr_origin" name="cr_origin" required="">
</div>

<div class="form-group">
<input type="submit"  value="GO" class='btn btn-danger' >
</div>

</form>
</div>
</div>
</div>

</div>

<div class="col-md-12">
<div class="card-body">     
<a href="<?php echo base_url(); ?>Archive/">Post Cash Receive Entery</a>
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="mmyTable">
  <thead>
    <th>Sr</th>
    <th>Sheet Code</th>
    <th>Destination</th>
    <th>CNs</th>
    <th>Delivery Date</th>
    <th>On Route Date</th>
    <th>COD</th>
    <th>Action</th>
    </thead>
  <tbody>
  <?php 
  $i=0;
  if(!empty($summary_data)){
  foreach($summary_data as $rows){ 
  $i=$i+1;  
  if($rows->deliverdate!=$rows->RouteDate){
  echo("<tr class='bg-danger text-white'>");
  echo("<td class='bg-danger text-white'>".$i."</td>");
  echo("<td class='bg-success text-white' style='font-size:15px'><center>".$rows->on_route_id."</center></td>");
  echo("<td class='bg-danger text-white'>".$rows->city."</td>");
  echo("<td class='bg-info text-white' style='font-size:15px'><center>".$rows->cns."</center></td>");
  echo("<td class='bg-danger text-white'>".$rows->deliverdate."</td>");
  echo("<td class='bg-danger text-white'>".$rows->RouteDate."</td>");
  echo("<td class='bg-info text-white' style='font-size:15px'><center>".number_format($rows->amount)."</center></td>");
  if($rows->is_crv==0){
  echo("<td><center><a href='".base_url()."Archive/crv_submit/".$rows->on_route_id."/".$rows->deliverdate."/".$rows->RouteDate."/".$rows->destination_city."' class='btn btn-primary btn-xs'>Receive Amount</a></center></td>");
  } else {
  echo("<td><center><code>Right Now</code></center></td>");}
  echo("</tr>");  
  } else {
   echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td class='bg-success text-white' style='font-size:15px'><center>".$rows->on_route_id."</center></td>");
  echo("<td>".$rows->city."</td>");
  echo("<td class='bg-info text-white' style='font-size:15px'><center>".$rows->cns."</center></td>");
  echo("<td>".$rows->deliverdate."</td>");
  echo("<td>".$rows->RouteDate."</td>");
  echo("<td class='bg-info text-white' style='font-size:15px'><center>".number_format($rows->amount)."</center></td>");
    if($rows->is_crv==0){
  echo("<td><center><a href='".base_url()."Archive/crv_submit/".$rows->on_route_id."/".$rows->deliverdate."/".$rows->RouteDate."/".$rows->destination_city."' class='btn btn-primary btn-xs'>Receive Amount</a></center></td>");

        
    } else {
  echo("<td><center><code>Right Now</code></center></td>");}
  echo("</tr>");      
  }
  }} ?>
  </tbody> 
 </table> 
</div>
</div>
</div>




<div class="card-body">     
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Sheet Code</th>
    <th>Destination</th>
    <th>CN</th>
    <th>Delivery Date</th>
    <th>On Route Date</th>
    <th>COD</th>
    </thead>
  <tbody>
  <?php 
  $i=0;
  if(!empty($cn_data)){
  foreach($cn_data as $rows){ 
  $i=$i+1;  
  echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td>".$rows->on_route_id."</td>");
  echo("<td>".$rows->city."</td>");
  echo("<td>".$rows->shipments."</td>");
  echo("<td>".$rows->deliverdate."</td>");
  echo("<td>".$rows->RouteDate."</td>");
  echo("<td>".$rows->amount."</td>");
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

<script>
function collector(sheet){
alert(sheet);

    
}    
</script>

<?php
$this->load->view('inc/footer');
?>      