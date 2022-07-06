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
                        <div class="card-title">Shipments Count Datewise Report
                        </div>
                      </div>
                      <div class="card-body">
                        <!--<div class='pull-right'><a href="<?php echo base_url(); ?>Home/old_admin_qsr"><button class='btn btn-primary'>Old Portal Admin QSR</button></a></div>--->
                      <div class="row clearfix">
                        
                        <div class="col-md-5">
                         
                        </div>
                      </div>
                     <br>
                      
                     
                      <div class="row" >
                        <div class="col-xl-4 col-lg-4" >
                          <div class="card card-default bg-primary" style="background-image: linear-gradient(to right, #16222A , #3A6073);">
                              <div class="card-header  separator">
                                <div class="card-title text-white">Shipments Count Datewise
                                  </div>
                                  
                                </div>
                            <div class="card-body text-white">
                              <h3 class="text-white">
                                <span class="semi-bold text-white">Apply</span> Conditions</h3>
<form role="form" action="<?php echo base_url();?>Home/submit_admin_opslhe" method="post">
<div class="form-group">
<label>Start Date</label>
<span class="help text-white">e.g. "2021-01-01"</span>
<input type="date" class="form-control" value="<?php echo $start_date; ?>" required="" name="start_date" id="start_date">
</div>
<div class="form-group">
<label>End Date</label>
<span class="help text-white">e.g. "2021-07-30"</span>
<input type="date" class="form-control" value="<?php echo $end_date; ?>"  required="" name="end_date" id="end_date">
</div>
<div class="form-group">
<label>Customer</label>
<span class="help text-white">e.g. "Shopping Asaan"</span>
<select  class="form-control" data-init-plugin="select2"  required="" name="customer_id" id="customer_id" >
<?php if(!empty($customer_id)){
if(!empty($customer_data)){
foreach($customer_data as $rows){
if($rows->customer_id==$customer_id){
echo("<option value='".$rows->customer_id."'>".$rows->customer_name."</option>");     
}}}} ?>
<option value=0>All</option>    

<?php if(!empty($customer_data)){
foreach($customer_data as $rows){
if($rows->customer_id!=$customer_id){    
echo("<option value='".$rows->customer_id."'>".$rows->customer_name."</option>");    
}}
} ?>    
</select>
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
                
                

                          <?php if(!empty($qsr_data)){?> 
                          <div class='col-md-4 col-lg-4 col-sm-12 col-xm-12'>
           <div class="card">
             <div class="card-header  ">
                          <div class="card-title text-black">Shipments Count
                          </div>
                          
                        </div>
                    <div class="card-body no-padding">
                       

                        <div class="card-body">
                             <?php if(!empty($qsr_data)){?>
                        <div class="col-xl-12 col-lg-12">  
                        <div class="table-responsive">
  					      <table class='table table-bordered'>
                                                
                         <tbody id="resultTable">
                          <?php if(!empty($qsr_data)){
                          $i=0;  
                          foreach($qsr_data as $rows){
                              
                          echo("<tr>");
                          echo("<td Style='font-weight: bold; table table-bordered border:2px solid #8c363d font-size:15px; color:white; background: linear-gradient(to right, #23074d 0%, #cc5333 100%);'>"."Total Shipments"."</td>");
                          echo("<td Style='font-weight: bold; table table-bordered border:2px solid #8c363d font-size:16px; color:white; background: linear-gradient(to right, #cc5333 0%, #23074d 100%);'>".$rows->TShip."</td>");
                          echo("</tr>");
                          
                          echo("<tr>");
                          echo("<td Style='font-weight: bold; table table-bordered border:2px solid #8c363d font-size:15px; color:white; background: linear-gradient(to right, #23074d 0%, #cc5333 100%);'>"."Total Pieces"."</td>");;
                          echo("<td Style='font-weight: bold; table table-bordered border:2px solid #8c363d font-size:16px; color:white; background: linear-gradient(to right, #cc5333 0%, #23074d 100%);'>".$rows->TP."</td>");
                          echo("</tr>");
                          
                          echo("<tr>");
                          echo("<td Style='font-weight: bold; table table-bordered border:2px solid #8c363d font-size:15px; color:white; background: linear-gradient(to right, #23074d 0%, #cc5333 100%);'>"."Total Weight"."</td>");
                          echo("<td Style='font-weight: bold; table table-bordered border:2px solid #8c363d font-size:16px; color:white; background: linear-gradient(to right, #cc5333 0%, #23074d 100%);'>".$rows->TW."</td>");
                          echo("</tr>");
                                }}?>
                         
                         </tbody>  
                       </table>
                    </div>
                  </div>
                <?php } ?>
                        </div>
                  
                    </div>
                    <div class="card-footer">
  
  </div>
                  </div>
      </div>
                          
                <?php } ?>
                
                
                
                          


                          <?php if(!empty($summary_archive_qsr_data)){?>
                          
                          <div class='col-md-4 col-lg-4 col-sm-12 col-xm-12'>
           <div class="card">
             <div class="card-header">
                          <div class="card-title text-black">Archive Summary Graph
                          </div>
                          
                        </div>
                    <div class="card-body no-padding">
                       

                        <div class="card-body">
                         <H1>Shipments Status Wise</H1>
                          <div class="chart">
                           <canvas id="pieChart1" ></canvas>
                         </div>
                        </div>
                  
                    </div>
                    <div class="card-footer">
  
  </div>
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



 $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */

  

   //-------------
    //- PIE CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var pieChartCanvas = $("#pieChart1").get(0).getContext("2d");
    var pieChart = new Chart(pieChartCanvas);
    var PieData = [
 <?php if(!empty($summary_archive_qsr_data)){foreach($summary_archive_qsr_data as $rows){ ?>                        
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