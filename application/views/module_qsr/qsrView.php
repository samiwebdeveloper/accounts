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
title:"Branch QSR <?php echo $start_date." To ".$end_date; ?>",
text:"<i class='fs-14 pg-download'></i> PDF",
titleAttr: 'PDF',
message:"Delivery Express\n  Powered By SaimTech \n Date:<?php echo $start_date." To ".$end_date; ?> \n Branch QSR Report \n "
},
{
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'Branch QSR <?php echo $start_date." To ".$end_date; ?>',
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
title:"Branch QSR <?php echo $start_date." To ".$end_date; ?>",
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo $start_date." To ".$end_date; ?> <br>  Branch QSR Report<br>"
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
                  <li class="breadcrumb-item">Dashboard</li>
                  <li class="breadcrumb-item">QSR Report</li>
                  
                </ol>
                <!-- END BREADCRUMB --> 
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg">
            <!-- BEGIN PlACE PAGE CONTENT HERE -->

<div class="row">
   
           

                  <div class="col-xl-12 col-lg-12 ">
                <div class="card m-t-10">
              <div class="card-header  separator">
                        <div class="card-title">QSR Report
                        </div>
                      </div>
                      <div class="card-body">

                      <div class="row clearfix">
                        
                        <div class="col-md-5">
                         
                        </div>
                      </div>
                     <br>
                      
                     
                      <div class="row">
                        <div class="col-xl-3 col-lg-3">
                          <div class="card card-default bg-primary">
                              <div class="card-header  separator">
                                <div class="card-title text-white">QSR Conditions
                                  </div>
                                </div>
                            <div class="card-body text-white">
                              <h3 class="text-white">
                                <span class="semi-bold text-white">Apply</span> Conditions</h3>
<form role="form" action="<?php echo base_url();?>Home/submit_branch_qsr" method="post">
<div class="form-group">
<label>Start Date</label>
<span class="help text-white">e.g. "2019-07-01"</span>
<input type="date" class="form-control" value="<?php echo $start_date; ?>" required="" name="start_date" id="start_date">
</div>
<div class="form-group">
<label>Password</label>
<span class="help text-white">e.g. "2019-07-30"</span>
<input type="date" class="form-control" value="<?php echo $end_date; ?>"  required="" name="end_date" id="end_date">
</div>
</div>
<div class="card-footer">
  <button class="btn btn-deflaut pull-right" type="submit">GO</button>
  </div>
  </form>
<?php echo $msg; ?>
</div>
                          </div>
                        <?php if(!empty($qsr_data)){?>
                        <div class="col-xl-9 col-lg-9">  
                        <div class="table-responsive">
  					            <table class='table table-bordered' id="myTable">
                        <thead>
                          <tr>
                          <th>No #</th>
                          <th>Consignment Number</th>
                          <th>Manual CN</th>
                          <th>Consignee Mobile No</th>
                          <th>Consignee Email</th>
                          <th>Consignee Name</th>
                          <th>Consignee Address</th>
                          <th>Destination City</th>
                          <th>Origin City</th>
                          <th>Weight (Kg)</th>
                          <th>Pieces</th>
                          <th>COD Amount</th>
                          <th>Customer Reference No</th>
                          <th>Service Type</th>
                          <th>Handling Charges</th>
                          <th>Cash Handling Charges</th>
                          <th>Product Detail</th>
                          <th>Status</th>
                          <th>Remarks</th>
                          <th>Order Date</th>
                          <th>Booking Date</th>
                          <th>Arrival Date</th>
                          <th>Delivery Date</th>
                          <th>Load Sheet</th>
                          <th>Is Invoice</th>
                          </tr>
                        </thead>   
                         <tbody id="resultTable">
                          <?php if(!empty($qsr_data)){
                          $i=0;  
                          foreach($qsr_data as $rows){
                          $i=$i+1; 
                          echo("<tr>");
                          echo("<td>".$i."</td>");
                          echo("<td>".$rows->order_code."</td>");
                          echo("<td>".$rows->manual_cn."</td>");
                          echo("<td>".$rows->consignee_mobile."</td>");
                          echo("<td>".$rows->consignee_email."</td>");
                          echo("<td>".$rows->consignee_name."</td>");
                          echo("<td>".$rows->consignee_address."</td>");
                          echo("<td>".$rows->destination_city_name."</td>");
                          echo("<td>".$rows->origin_city_name."</td>");
                          echo("<td>".$rows->weight."</td>");
                          echo("<td>".$rows->pieces."</td>");
                          echo("<td>".number_format($rows->cod_amount)."</td>");
                          echo("<td>".$rows->customer_reference_no."</td>");
                          echo("<td>".$rows->service_name."</td>");
                          echo("<td>".$rows->order_sp_handling_rate."</td>");
                          echo("<td>".$rows->order_cash_handling_rate."</td>");
                          echo("<td>".$rows->product_detail."</td>");
                          echo("<td>".$rows->order_status."</td>");
                          echo("<td>".$rows->order_remark."</td>");
                          echo("<td>".$rows->order_date."</td>");
                          echo("<td>".$rows->order_booking_date."</td>");
                          echo("<td>".$rows->order_arrival_date."</td>");
                          echo("<td>".$rows->prder_delivery_date."</td>");
                          echo("<td>".$rows->load_sheet_id."</td>");
                          if($rows->is_invoice==0){
                          echo("<td>No</td>"); 
                          } else {
                          echo("<td>".$rows->invoice_id."</td>");   
                          }
                          echo("</tr>"); 
                                }}?>
                         
                         </tbody>  
                       </table>
                    </div>
                  </div>
                <?php } ?>
                      </div>
                     
                
                  </div>
                   <div class="card-header  separator">
                        <div class="card-title" name="1-success-message" id="1-success-message">
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

<?php
$this->load->view('inc/footer');
?>      