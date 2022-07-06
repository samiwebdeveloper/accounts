<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
   $('#myTable thead span').each( function () {
        var title = $(this).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'"  />' );
    } );    
var table =$('#myTable').DataTable( {
"lengthMenu": [[ -1, 10, 25, 50], [ "All", 10, 25, 50]],     
"fixedHeader": true,
"searching": true,
"paging":   true,
"ordering": false,
"bInfo": true,
dom: 'Blfrtip',


buttons: [
 
{
extend: 'pdfHtml5',
orientation: 'landscape',
pageSize: 'A3',
footer: 'true',
title:"Payment Verfication Report",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"Delivery Express\n  Powered By SaimTech \n Date:<?php echo ''.date('Y-m-d'); ?> \n Payment Verfication Report \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'Payment Verfication Report',
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
title:"Payment Verfication Report",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo ''.date('Y-m-d'); ?> <br>  <br>Invoices List<br>"
}
]       
});

 table.columns().every( function () {
        var that = this;
 
        $( 'input', this.header() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );
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
                  <li class="breadcrumb-item">Invoices Payment</li>
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
    <div class="card-title"><a href="<?php echo base_url(); ?>Invoice/create_invoice" class='btn btn-primary'>New Invoice</a>
    </div>
     <div class="form-group-attached">

<div class="row clearfix">

<div class="col-sm-3">
<div class="form-group form-group-default required" id="user_name_div">
    <form action="<?php echo base_url(); ?>Invoice/in_payment_submit" method="post">
<label>Start Date</label>
<input type="date" class="form-control" id="start_date" name="start_date" required="" value="<?php echo $startdate; ?>">
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required">
<label>End Date</label>
<input type="date" class="form-control" id="end_date" name="end_date" required="" value="<?php echo $enddate; ?>">
</div>
</div>
<div class="col-sm-3">
<button type="submit" class="btn btn-primary" style="height:100%">GO</button>    
</form>
</div>    
</div>


</div>
    </div>
<div class="card-body">                       
<div class="table-responsive m-t-10">
 <table class="table table-bordered" id="myTable">
  <thead>
    <th>Amount</th>
    <th>BankName</th>
    <th>BeneficiaryAccountNumber</th>
    <th>BeneficiaryName</th>
    <th>BeneficiaryCode</th>
    <th>ReferenceField1</th>
    <th>ReferenceField2</th>
    <th>BeneficiaryEmail</th>
    <th>BeneficiaryNumber</th>
    
    
  </thead>
  <tbody>
  <?php 
  $i=0;
  if(!empty($invoice_data)){
  foreach($invoice_data as $rows){ 
  $i=$i+1;  
  echo("<tr>");
   echo("<td class='bg-info text-white'>".round($SUM= (($rows->invoice_amount)-($rows->bulk_flyer_amount + $rows->invoice_gst + $rows->invoice_sc + round(($rows->invoice_fuel*16)/100) + (($rows->bulk_flyer_amount*16)/100) + (($rows->invoice_sp_handling*16)/100) + (($rows->invoice_cash_handling*16)/100) + $rows->osa_amount + round(($rows->osa_amount*16)/100) + $rows->other_amount + $rows->invoice_fuel + $rows->invoice_sp_handling)))."</td>");
   echo("<td>".$rows->customer_bank."</td>");
   echo("<td>".$rows->customer_iban."</td>");
   echo("<td>".$rows->customer_bank_account_title."</td>");
   echo("<td></td>");
   echo("<td>Payment</td>");
   echo("<td>".date('M-y')."</td>");
   echo("<td>".$rows->customer_contact2."</td>");
   echo("<td>".$rows->customer_contact."</td>");
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