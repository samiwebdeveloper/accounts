<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
var table =$('#myTable').DataTable( {
"lengthMenu": [[ -1, 10, 25, 50], [ "All", 10, 25, 50]],   

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
title:"Complain List",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"Delivery Express\n  Powered By SaimTech \n Date:<?php echo ''.date('Y-m-d'); ?> \n Complain List \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'complain List',
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
title:"Complain List",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo ''.date('Y-m-d'); ?> <br>  <br>Complain List<br>"
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
                  <li class="breadcrumb-item"><a href="<?php echo base_url();?>complain">Complains</a></li>
                  <li class="breadcrumb-item">Complains list</li>
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
     <a href="<?php echo base_url(); ?>complain" class='btn btn-primary'>Register Complain</a>
    </div>
     <div class="form-group-attached">

<div class="row clearfix">

<div class="col-sm-3">
<div class="form-group form-group-default required" id="user_name_div">
<form action="<?php echo base_url(); ?>complain/report_date_range" method="post">
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
</form>
</div>


</div>
</div>


<div class="card-body">


             
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Ticket #</th>
    <th>CN</th>
    <th>Nature</th>
    <th>Type</th>
    <th>Name</th>
    <th>Number</th>
    <th>Remarks</th>
    <th>Assign To</th>
    <th>Date</th>
    <th>Status</th>
    <th>Complete Date</th>
    <th>CS Remarks</th>
    <th>Action</th>
  </thead>
  <tbody>
  <?php 
  $i=0;
  if(!empty($complain_list)){
  foreach($complain_list as $rows){ 
  $i=$i+1;  
  echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td>".$rows->ticket_no."</td>");
  echo("<td>".$rows->cn."</td>");
  echo("<td>".$rows->complain_name."</td>");
  echo("<td>".$rows->type_name."</td>");
  echo("<td><center>".$rows->complainant_name."</center></td>");
  echo("<td>".$rows->complainant_phone."</td>");
  echo("<td>".$rows->complainant_remarks."</td>");
  if(!empty($rows->oper_user_name)){
  echo("<td>".$rows->oper_user_name."</td>");
  }
  else{
  echo("<td>N/A</td>");
  }
  echo("<td>".$rows->date."</td>");
  echo("<td>".$rows->status."</td>");
  echo("<td>".$rows->is_complete_date."</td>"); 
  echo("<td>".$rows->remarks."</td>");
  if($rows->is_complete==0){
  echo("<td style='white-space: nowrap'>");
   if(($rows->assign_to > 0)){
   echo ("<a href='".base_url()."Complain/complain_status/".$rows->complain_id."/".$rows->nature_id."' class='btn btn-info btn-xs'>Close</a>");
  }
   elseif(($rows->assign_to< 0) AND (($_SESSION['user_power']=='SE') OR ($_SESSION['user_id']== 3))){
  echo (" <a href='".base_url()."Complain/complain_assign/".$rows->complain_id."/".$rows->nature_id."' class='btn btn-primary btn-xs' >Assign</a>");
  }
  else{
    echo("N/A");  
  }
  echo("</td>");
  } else {
  echo("<td>N/A</td>");  
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

