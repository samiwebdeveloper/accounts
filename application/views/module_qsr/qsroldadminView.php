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
extend: 'excelHtml5',
text:"<i class='fs-14 pg-form'></i> Excel",
titleAttr: 'Excel',
sheetName:'QSR <?php echo $start_date." To ".$end_date; ?>',
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
message:"Delivery Express <br> System Developer M.Saim <br>Date:<?php echo $start_date." To ".$end_date; ?> <br>  QSR Report<br>"
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
                  <li class="breadcrumb-item">OLD QSR Report</li>
                  
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
                        <div class="card-title">OLD QSR Report
                        </div>
                      </div>
                      <div class="card-body">
                        <div class='pull-right'><a href="<?php echo base_url(); ?>Home/admin_qsr"><button class='btn btn-primary'>New Portal Admin QSR</button></a></div>
                      <div class="row clearfix">
                        
                        <div class="col-md-5">
                         
                        </div>
                      </div>
                     <br>
                      
                     
                      <div class="row">
                        <div class="col-xl-3 col-lg-3">
                          <div class="card card-default bg-info">
                              <div class="card-header  separator">
                                <div class="card-title text-white">OLD QSR Conditions
                                  </div>
                                  
                                </div>
                            <div class="card-body text-white">
                              <h3 class="text-white">
                                <span class="semi-bold text-white">Apply</span> Conditions</h3>
<form role="form" action="<?php echo base_url();?>Home/submit_old_admin_qsr" method="post">
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
                          
                          <div class='col-md-4 col-lg-4 col-sm-12 col-xm-12'>
           <div class="card">
             <div class="card-header  ">
                          <div class="card-title text-black">Summary Graph
                          </div>
                          
                        </div>
                    <div class="card-body no-padding">
                       

                        <div class="card-body">
                         <H1>Shipments Status Wise</H1>
                          <div class="chart">
                           <canvas id="pieChart" ></canvas>
                         </div>
                        </div>
                  
                    </div>
                    <div class="card-footer">
  
  </div>
                  </div>
      </div>
                          
                <?php } ?>          
                          
                         
                          </div>
                          <div class="row">
                        <?php if(!empty($qsr_data)){?>
                        <div class="col-xl-12 col-lg-12">  
                        <div class="table-responsive">
  					            <table class='table table-bordered' id="myTable">
                        <thead>
                          <tr>
                          <th>No #</th>
                          <th>Customer</th>
                          <th>CN</th>
                          <th>Manual CN</th>
                          <th>Status</th>
                          <th>Consignee Mobile No</th>
                          <th>Consignee Email</th>
                          <th>Consignee </th>
                          <th>Consignee Address</th>
                          <th>Destination </th>
                          <th>Origin </th>
                          <th>Weight (Kg)</th>
                          <th>Pieces</th>
                          <th>COD</th>
                          <th>Customer Reference No</th>
                          <th>Service Type</th>
                          <th>Handling Charges</th>
                          <th>Cash Handling Charges</th>
                          <th>Product Detail</th>
                          <th>Order Date</th>
                          <th>Booking Date</th>
                          <th>Arrival Date</th>
                          <th>OnRuote Date</th>
                          <th>Last Activity Date</th>
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
                          echo("<td>".$rows->customer_name."</td>");
                          echo("<td>".$rows->cn."</td>");
                          echo("<td>".$rows->manual_cn."</td>");
                          echo("<td>".$rows->status."</td>");
                          echo("<td>".$rows->consignee_mobile_no."</td>");
                          echo("<td>".$rows->consignee_email."</td>");
                          echo("<td>".$rows->consignee_name."</td>");
                          echo("<td>".$rows->consignee_address."</td>");
                          echo("<td>".$rows->destination."</td>");
                          echo("<td>".$rows->origin."</td>");
                          echo("<td>".$rows->weight."</td>");
                          echo("<td>".$rows->pieces."</td>");
                          echo("<td>".number_format($rows->cod)."</td>");
                          echo("<td>".$rows->refer."</td>");
                          echo("<td>COD</td>");
                          echo("<td>0</td>");
                          echo("<td>0</td>");
                          echo("<td>".$rows->product_detail."</td>");
                          echo("<td>".$rows->order_date."</td>");
                          echo("<td>".$rows->booking_date."</td>");
                          echo("<td>".$rows->arrival_date."</td>");
                          echo("<td>".$rows->onroute_date."</td>");
                          echo("<td>".$rows->last_activity_date."</td>");
                          if($rows->invoice_id==0){
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
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

  

   //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
 <?php if(!empty($summary_qsr_data)){foreach($summary_qsr_data as $rows){ ?>                        
      {
        value: <?php echo $rows->shipments; ?>,
        color: '<?php echo '#' . substr(str_shuffle('ABCDEF0123456789'), 0, 6);?>',
        
        highlight: "#6d5eac",
        label: "<?php echo $rows->order_status; ?>"
      },
     
  <?php } } ?>
  

    ];
    var pieOptions = {
      //Boolean - Whether we should show a stroke on each segment
      segmentShowStroke: true,
      //String - The colour of each segment stroke
      segmentStrokeColor: "#fff",
      //Number - The width of each segment stroke
      segmentStrokeWidth: 2,
      //Number - The percentage of the chart that we cut out of the middle
      percentageInnerCutout: 50, // This is 0 for Pie charts
      //Number - Amount of animation steps
      animationSteps: 100,
      //String - Animation easing effect
      animationEasing: "easeOutBounce",
      //Boolean - Whether we animate the rotation of the Doughnut
      animateRotate: true,
      //Boolean - Whether we animate scaling the Doughnut from the centre
      animateScale: true,
      //Boolean - whether to make the chart responsive to window resizing
      responsive: true,
      // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
      maintainAspectRatio: true,
      //String - A legend template
      legendTemplate: "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<segments.length; i++){%><li><span style=\"background-color:<%=segments[i].fillColor%>\"></span><%if(segments[i].label){%><%=segments[i].label%><%}%></li><%}%></ul>"
    };
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    pieChart.Doughnut(PieData, pieOptions);
  });
</script>

<?php
$this->load->view('inc/footer');
?>      