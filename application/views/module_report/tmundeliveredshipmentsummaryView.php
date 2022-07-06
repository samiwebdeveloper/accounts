<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
var table =$('#myTable').DataTable( {
/* "footerCallback": function ( row, data, start, end, display ) {
            var api = this.api(), data;
 
            // Remove the formatting to get integer data for summation
            var intVal = function ( i ) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '')*1 :
                    typeof i === 'number' ?
                        i : 0;
            };
 
            // Total over all pages
            total = api
                .column( 7 )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Total over this page
            pageTotal = api
                .column( 7, { page: 'current'} )
                .data()
                .reduce( function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0 );
 
            // Update footer
            $( api.column( 7 ).footer() ).html(
                'PKR '+new Intl.NumberFormat('ja-JP').format(pageTotal) +' ( PKR '+  Intl.NumberFormat('ja-JP').format(total) +')'
            );
        } ,  */ 
    
    
    
    
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
title:"TM UN Delivered Shipments Summary Report",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"Delivery Express\n  Powered By SaimTech \n Date:<?php echo ''.$start_date." - ".$end_date; ?> \n TM UN Delivered Shipments Summary Report \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'TM UN Delivered Shipments Summary Report<?php echo ''.$start_date." - ".$end_date; ?>',
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
title:"TM UN Delivered Shipments Summary Report",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo ''.$start_date." - ".$end_date; ?> <br>  <br>TM Shipments UN Delivered Summary Report<br>"
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
                  <li class="breadcrumb-item">TM UN Delivered Shipments Report</li>
                  <li class="breadcrumb-item"><mark><?php echo ''.$start_date." - ".$end_date; ?></mark></li>
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
  
<div class="col-md-4">
    <div class="card-header  separator">
    <div class="card-title">
      
    <h1>TM UN Delivered Shipments Report</h1>
   
    </div>

    </div>


<div class="card-body">

<div class="card card-default">
<div class="card-body bg-info">

<form role="form" method="post" action="<?php echo base_url(); ?>Tm/tm_undelivered_summary_submit">
<div class="form-group">
<label class="text-white">Month Name</label>
<select class="form-control" required="" id="month" name="month">
<option value="">Select Month</option>
<option value='01'>Jan(01)</option>
<option value='02'>Feb(02)</option>
<option value='03'>Mar(03)</option>
<option value='04'>Apr(04)</option>
<option value='05'>May(05)</option>
<option value='06'>Jun(06)</option>
<option value='07'>Jul(07)</option>
<option value='08'>Aug(08)</option>
<option value='09'>Sep(09)</option>
<option value='10'>Oct(10)</option>
<option value='11'>Nov(11)</option>
<option value='12'>Dec(12)</option>
</select>
</div>
<div class="form-group">
<label class="text-white">Year</label>
<select class="form-control" required="" id="year" name="year">
<option value="">Select Year</option>
<option value='2019'>2019</option>
<option value='2020'>2020</option>
<option value='2021'>2021</option>
<option value='2022'>2022</option>
<option value='2023'>2023</option>
</select>

</div>
<div class="form-group">
<input type="submit"  value="GO" class='btn btn-danger' >
</div>

</form>
</div>
</div>
</div>

</div>




<div class="card-body">     
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Sr</th>
    <th>Month</th>
    <th>Person</th>
    <th>CNs</th>
    <th>COD</th>
    <th>COMM</th>

    <th>Balance</th>
    </thead>
  <tbody>
  <?php 
  $i=0;
  $total_blc=0;
  $BLC=0;
  if(!empty($report_data)){
  $total_blc=0;
  $BLC=0;
  foreach($report_data as $rows){ 
  if($rows->cp!="Oshaq(SKZ)(0310-5881704,0306-2177986)" && $rows->cp!="Abdul Qadeer(HHD)(0313-3515046)" && $rows->cp!="Hassan(SLT) (03006477949)"){        
  $i=$i+1;  
  $BLC=(($rows->BLC));
  $total_blc=(($total_blc)+($BLC));
  $date=$month.$year;
  echo("<tr>");
  echo("<td>".$i."</td>");
  echo("<td><center>".$month."-".$year."</center></td>");
  echo("<td>".$rows->cp."</center></td>");
  echo("<td><center>".$rows->cns."</center></td>");
  echo("<td><center>".number_format($rows->COD)."</center></td>");
  echo("<td><center>".number_format($rows->Comm)."</center></td>");
  echo("<td><center>".number_format($BLC)."</center></td>");
  echo("</tr>");
   }}}
  echo("<tr>");
  echo("<td>".$date."</td>");
  echo("<td></td>");
  echo("<td></td>");
  echo("<td></td>");
  echo("<td></td>");
  echo("<td></td>");
  echo("<td><center><b>".number_format($total_blc)."</b></center></td>"); 
  echo("</tr>"); ?>
  </tbody>
  <tfoot>

  </tfoot>
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