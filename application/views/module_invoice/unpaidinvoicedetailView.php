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
extend: 'pdfHtml5',
orientation: 'landscape',
pageSize: 'A3',
footer: 'true',
title:"Invoices Detail List",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"Delivery Express\n  Powered By SaimTech \n Date:<?php echo ''.date('Y-m-d'); ?> \nUnpaid Invoices Detail List \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'Invoices Detail List',
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
title:"Invoices Detail List",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo ''.date('Y-m-d'); ?> <br>  <br>Unpaid Invoices Detail List<br>"
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
                  <li class="breadcrumb-item">Accounts</li>
                  <li class="breadcrumb-item">Manage Invoices</li>
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
  <div class='card'>
<div class="card-body">                       
<div class="table-responsive m-t-10">
    <h1>Detail Report</h1>
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Shipper</th>
    <th>CN</th>
    <th>COD</th>
    <th>GST</th>
    <th>SC</th>
    <th>NET</th>
    <th>RESULTDATE</th>
    
  </thead>
  <?php
  $gst=0;$sc=0;$cn=0;
  if(!empty($deliverd_data)){$i=0;$gst=0;$sc=0;$cn=0;
  foreach($deliverd_data as $del){
  $i=$i+1;$gst=0;$sc=0;$cn=0;
  echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td>".$del->customer_name."</td>");
  echo("<td>".$del->Cn."</td>");
  echo("<td>".number_format($del->COD)."</td>");
  echo("<td>".number_format($del->GST)."</td>");
  echo("<td>".number_format($del->SC)."</td>");
  echo("<td>".number_format($del->COD-($del->SC+$del->GST))."</td>");
  echo("<td>".date('d/m/Y',strtotime($del->ResultDate))."</td>");
  echo("</tr>");
  }}
  if(!empty($rts_data)){
  foreach($rts_data as $del){
   $i=$i+1; 
  echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td>".$del->customer_name."</td>");
  echo("<td>".$del->Cn."</td>");
  echo("<td>".number_format($del->COD)."</td>");
  echo("<td>".number_format($del->GST)."</td>");
  echo("<td>".number_format($del->SC)."</td>");
  echo("<td>".number_format(0-($del->SC+$del->GST))."</td>");
  echo("<td>".date('d/m/Y',strtotime($del->ResultDate))."</td>");
  echo("</tr>");
  }} ?>
  <tbody>
  </tbody> 
 </table> 
</div>


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