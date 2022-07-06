<?php
error_reporting(0);
$this->load->view('inc/header');
?>
<?php 
$sheet_code="";
$sheet_date="";
$sheet_customer_name="";
$sheet_type="";
$sheet_payment="";
$sheet_tid="";
$total_fuel="";
$total_sc="";
$total_gst="";
$sheet_id="";
$other_amount="";
$remark="";
if(!empty($sheet_data)){
foreach($sheet_data as $rows){
$sheet_code     = $rows->invoice_code;
$other_name     = $rows->other_name;
$other_amount     = $rows->other_amount;
$sheet_id       = $rows->invoice_id;
$sheet_date       = $rows->invoice_date;
$origin           = $rows->city_name;
$sheet_customer_name  =$rows->customer_name;
$sheet_customer_address  =$rows->customer_address;
$sheet_customer_note  =$rows->customer_note;
$sheet_type  =$rows->invoice_permission;
$sheet_payment  =$rows->payment_mode;
$sheet_tid  =$rows->payment_tid;
$total_sc   =$rows->invoice_sc;
$total_gst  =$rows->invoice_gst;
$total_fuel =$rows->fuel_surcharge;
$discounSSt_amount   =$rows->DC;
$remark     =$rows->invoice_remark;
}} ?>


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













<div class="card card-default m-t-20">
              <div class="card-body">
                <div class="invoice padding-40 sm-padding-10">
                  <div>
                    <div class="pull-left">
                    <?php if($sheet_type=="Yes"){ ?>
                    <img width="235" height="160" alt="" class="invoice-logo" data-src-retina="<?php echo base_url();?>assets/gst.png" data-src="<?php echo base_url();?>assets/gst.png" src="<?php echo base_url();?>assets/gst.png">
                    <?php } else { ?>
                    <img width="235" height="160" alt="" class="invoice-logo" data-src-retina="<?php echo base_url();?>assets/gst.png" data-src="<?php echo base_url();?>assets/not_gst.png" src="<?php echo base_url();?>assets/not_gst.png">
                    <?php } ?>
                      <address class="no-padding m-l-30">
                                   Office # 4 Ground Floor Ali Plaza Behind U.B.L Bank 3، Mozang Rd, Mozang Chungi, 
                                    <br>Lahore, Punjab 54000.
                                    <br>
                                </address>
                    </div>
                    <div class="pull-right sm-m-t-20">
                      <h2 class="font-montserrat all-caps hint-text">Invoice <img src="<?php echo base_url(); ?>assets/barcode/invoice/<?php echo $sheet_code; ?>.png" width="140" height="50"></h2>
                    </div>
                    <div class="clearfix"></div>
                  </div>
                  <br>
                  <br>
                  <div class="col-12">
                    <div class="row">
                      <div class="col-lg-9 col-sm-height sm-no-padding">
                        <p class="small no-margin">Invoice to</p>
                        <h5 class="semi-bold m-t-0"><?php echo $sheet_customer_name; ?></h5>
                       
                      </div>
                      <div class="col-lg-3 sm-no-padding sm-p-b-20 d-flex align-items-end justify-content-between">
                        <div>
                          <div class="font-montserrat bold all-caps">Invoice No :</div>
                          <div class="font-montserrat bold all-caps">Invoice date :</div>
                          <div class="clearfix"></div>
                        </div>
                        <div class="text-right">
                          <div class=""><?php echo $sheet_code; ?></div>
                          <?php $date=date_create($sheet_date); ?>
                          <div class=""><?php echo date_format($date,"M-d-Y"); ?></div>
                          <div class="clearfix"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive table-invoice">
                    <table class="table table-bordered m-t-40">
                      <thead>
                        <tr>
                          <th class="">Shipments</th>
                          <th class="text-center">Conignee</th>
                          <th class="text-center">Origin</th>
                          <th class="text-center">Destination</th>
                          <th class="text-center">Pcs</th>
                          <th class="text-center">Weight</th>
                          <th class="text-center">Rate</th>
                          <th class="text-right">Amount</th>
                        </tr>
                      </thead>
                      <tbody>
                         <?php if(!empty($sheet_data)){
                         foreach($sheet_data as $rows){ ?> 
                        <tr>
                          <td class="">
                            <p class="text-black"><?php if($rows->manual_cn!=""){echo $rows->manual_cn;} else {echo $rows->cn;}; ?></p>
                          </td>
                          <td class="text-center"><?php echo $rows->consignee_detail; ?></td>
                          <td class="text-center"><?php echo $rows->origin; ?></td>
                          <td class="text-center"><?php echo $rows->destination_name; ?></td>
                          <td class="text-center"><?php echo $rows->pcs; ?></td>
                          <td class="text-center"><?php echo $rows->weight; ?></td>
                          <td class="text-center"><?php echo $rows->rate; ?></td>
                          <td class="text-right"><?php echo number_format($rows->sc); ?></td>
                        </tr>
                      
                        <?php }} ?>
                       
                    
                  
                          <tr>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <th>Total Amount</th>
                          <td class="text-right"><?php echo number_format($total_sc); ?></td>
                          </tr>
                          <tr>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <th >Total GST</th>
                          <?php if($sheet_type=="Yes"){ ?>
                          <td class="text-right"><?php echo number_format($total_gst); ?></td>
                          <?php } else { ?>
                          <td class="text-right"> <?php echo number_format(0); ?></td>
                          <?php } ?>
                          </tr>
                          <tr>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <?php if($other_name==""){ ?>
                          <th>Total Other</th>
                          <td class="text-right">0</td>
                          <?php } else { ?> 
                          <th><?php echo $other_name; ?></th>
                          <td class="text-right"><?php echo number_format($other_amount); ?></td>
                              
                          <?php } ?> 
                          </tr>
                          <tr>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <th>Total Fuel</th>
                          <td class="text-right"><?php echo number_format($total_fuel); ?></td>
                          </tr>
                          <?php if($discounSSt_amount!=0){ ?>
                          <tr>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <th>Discount Amount</th>
                          <td class="text-right"><?php echo number_format($discounSSt_amount); ?></td>
                          </tr>
                          <?php } ?>
                           <tr>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <td style="border:0px;background-color:white"></td>
                          <th >Net Amount</th>
                           <?php if($sheet_type=="Yes"){ ?>
                          <th class="text-right"><?php echo number_format(($total_sc + $total_gst + $total_fuel + $other_amount)-$discounSSt_amount); ?></th>
                          <?php } else {?>
                          <th class="text-right"><?php echo number_format(($total_sc + $total_fuel + $other_amount)-$discounSSt_amount); ?></th>
                          <?php } ?>
                          </tr>
                        </tbody>
                    </table>
                  </div>
                  <br>
                  <br>
                
                  <p class="small hint-text">Note:<?php echo $remark; ?></p>
                  <hr>
                  <p class="small hint-text">Note: Payment within 15 days through cash or crossed cheque in favour of <u><?php if($sheet_type=="Yes"){ echo "TM CARGO & Logistics"; } else {echo "TM CARGO & Services"; }?></u> service charges at the rate of 2.5%/month will be charged on overdues balances. </p>
                  <p class="small hint-text">For any query do contact at accounts@tmcargo.net within 6 days</p><br>
                  
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
<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Deduction <?php echo $sheet_code; ?></h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <p id="msg_show">Manage Invoice Deductions.</p>
 <div class="form-group-attached" style="border-color: black">
<div class="row clearfix">
<div class="col-md-12">
<div class="form-group form-group-default required" aria-required="true" id="name_div">
<label>Deduction Name</label>
<input type="text"   class="form-control" name="name" id="name" tabindex="1">
<input type="hidden" value="<?php echo $sheet_id; ?>" name="code" id="code" >
</div>
</div>
</div>
<div class="row clearfix">
<div class="col-md-12 m-t-10">
<div class="form-group form-group-default required" id="amount_div">
<label>Deduction Amount</label>
<input type="phone" class="form-control" name="amount" id="amount" tabindex="2">
</div>
</div>
</div>
</div>
        
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="add_deduction()">Save Deduction</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div> 
<script type="text/javascript">
function add_deduction(){
var check="Pass";
var name="";
var amount="";
var code=<?php echo $sheet_id; ?>;
//------------Name
if($("#name").val()!=""){
name=$("#name").val();
$("#name_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#name_div").css("border-color", "red"); 
$("#name").focus();
check="Fail";
}
//--------------------------------End
//------------Amount-----------
if($("#amount").val()!="" ){
amount=$("#amount").val();
$("#amount_div").css("border-color", "rgba(0, 0, 0, 0.07)");  
} else {
$("#amount_div").css("border-color", "red");  
$("#amount").focus();
check="Fail";
}
//--------------------------------End
//-------Checking Conditions---------
if(check!="Fail"){  
var mydata={
name              :name,
amount            :amount,
code              :code
};
$.ajax({
url: "<?php echo base_url(); ?>Invoice/add_deduction",
type: "POST",
data: mydata,        
success: function(data) {
$("#msg_show").html(data);
}
});
$("#name").val("");
$("#amount").val("");
$("#name").focus("");
}
}
</script>
<?php
$this->load->view('inc/footer');
?>      