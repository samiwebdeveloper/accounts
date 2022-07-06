<?php
error_reporting(0);
$this->load->view('inc/header');
?>


 <!-- START PAGE CONTENT WRAPPER -->
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START JUMBOTRON -->
          
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
<?php 
$sheet_code="";
$sheet_date="";
$total_weight="";
$total_pieces="";
if(!empty($sheet_data)){
foreach($sheet_data as $rows){
$sheet_code      = $rows->arrival_sheet_code;
$sheet_date      = $rows->arrival_date;
$user_name      = $rows->oper_user_name;
$account_no      = $rows->oper_account_no;
}} ?>
<div class="col-md-12">
  <div class="card m-t-10">
              <div class="card-header  separator">
                        <div class="card-title">
                          <center>Operations Arrival  <img src="<?php echo base_url(); ?>assets/barcode/arrivalscan/<?php echo $sheet_code; ?>.png" width="100" height="50"></center>

                        </div>
                      </div>
                      <div class="card-body">
                       




 Arrival ID           : <?php echo $sheet_code; ?><br>
 Arrival Date & Time  : <?php echo $sheet_date; ?>
<br>

<center><table width=100% border=1>
 <thead>
 <tr>
  <th><center>Sr.</center></th>
  <th><center>CN</center></th>
  <th><center>Refer#</center></th>
  <th><center>Pieces</center></th>
  <th><center>Weight</center></th>
  <th><center>Destination</center></th>
  <th><center>Date & Time</center></th>
 </tr> 
</thead>
<tbody>
<?php if(!empty($sheet_data)){
$i=0;
$total_weight=0; 
$total_pieces=0; 
foreach($sheet_data as $rows){
$i=$i+1;
$total_weight=$total_weight + $rows->order_weight;
$total_pieces=$total_pieces + $rows->order_pieces;
echo("<tr>");
echo("<td><center>".$i."</center></td>");
echo("<td><center>".$rows->order_code."</center></td>");
echo("<td><center>".$rows->customer_reference_no."</center></td>");
if($rows->new_pieces==0 ){
echo("<td><center>".$rows->pieces."</center></td>");
} else {
echo("<td><center>".$rows->new_pieces."</center></td>");
}
if($rows->new_weight==0 ){
echo("<td><center>".$rows->weight."</center></td>");
} else {
echo("<td><center>".$rows->new_weight."</center></td>");
}
echo("<td><center>".$rows->destination_city_name."</center></td>");
echo("<td><center>".$rows->order_arrival_date."</center></td>");    
}} ?>
</tbody>
</table>
<br>

<table width=100% border=1>
 <thead>
 <tr>
  <th>User Name</th>
  <td><center><?php echo $user_name; ?></center></td>
  <th>Total Shipments</th>
  <td><center><?php echo $i;?></center></td>
  </tr>

  <tr>
  <th>Employee Code</th>
  <td><center><?php echo $account_no; ?></center></td>
  <th>Total Weight(Kg)</th>
  <td><center><?php echo $total_weight;?></center></td>
  </tr> 
 
   <tr>
  <th>Signature</th>
  <td></td>
  <th>Total Pieces</th>
  <td><center><?php echo $total_pieces; ?></center></td>
  </tr> 
 

</thead>
</table>


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