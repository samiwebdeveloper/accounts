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
$sheet_rider="";
$sheet_rider_name="";
$sheet_route="";
$sheet_route_name="";
if(!empty($sheet_data)){
foreach($sheet_data as $rows){
$sheet_code       = $rows->delivery_code;
$sheet_date       = $rows->delivery_date;
$sheet_rider      = $rows->rider_code;
$sheet_rider_name = $rows->rider_name;
$sheet_route      = $rows->route_code;
$sheet_route_name = $rows->route_code;
$user_name        = $rows->oper_user_name;
$account_no       = $rows->oper_account_no;
$origin           = $rows->city_name;
}} ?>
<div class="col-md-12">
  <div class="card m-t-10">
              <div class="card-header  separator">
                        <div class="card-title">
                          <center>Delivery Sheet Phase I  <img src="<?php echo base_url(); ?>assets/barcode/sheet/<?php echo $sheet_code; ?>.png" width="100" height="50"></center>

                        </div>
                      </div>
                      <div class="card-body">
                       




 
 Sheet Code           : <?php echo $sheet_code; ?><br>
 Date & Time          : <?php echo $sheet_date; ?><br>
 Rider                : <?php echo $sheet_rider." - ".$sheet_rider_name; ?><br>
 Route                : <?php echo $sheet_route." - ".$sheet_route_name; ?><br>
 Origin               : <?php echo $origin; ?><br.

<center><table width=100% border=1>
 <thead>
 <tr>
  <th><center>Sr.</center></th>
  <th><center>Consigee</center></th>
  <th><center>Detail</center></th>
  <th><center>Receiver Name</center></th>
  <th><center>Sign/Comment</center></th>
</tr> 
</thead>
<tbody>
<?php if(!empty($sheet_data)){
$i=0;
$total_weight=0;  
foreach($sheet_data as $rows){
$i=$i+1;
$total_weight = $total_weight +  $rows->weight;
echo("<tr>");
echo("<td><center>".$i."</center></td>");
echo("<td><center>".$rows->order_code." (".$rows->phone.")<br>".$rows->name."<br>".$rows->address."</center></td>");
echo("<td><center><b>COD&nbsp;&nbsp;&nbsp;&nbsp;</b>".number_format($rows->cod)."/-<br><b>Weight&nbsp;</b>".$rows->weight." KG</center></td>"); 
echo("<td><center>&nbsp</center></td>");
echo("<th><center>&nbsp</center></th>");
}} ?>
</tbody>
</table>
<br>

<table width=100% border=1>
 <thead>
 <tr>
  <th>Created By</th>
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
  <th>Operation Signature</th>
  <td></td>
  <th>Rider Signature</th>
  <td><center>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</center></td>
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