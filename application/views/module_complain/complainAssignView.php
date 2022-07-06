<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$('#d_city').select2();
$('#o_city').select2();
$('#customer_id').select2();
$('#nature').select2();
$('#status').select2();
$('#assign_id').select2();
$('#type_div').select2();
 $('input[type="number"]').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    });
  
    $('input[type="date"]').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    });
  
  

  $('input[type="text"]').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    }); 


    $('input[type="email"]').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    }); 
  
    
  
  
  $('checkbox').keydown(function(e){
        if(e.keyCode==13){      
            if($(':input:eq(' + ($(':input').index(this) + 1) + ')').attr('type')=='submit'){// check for submit button and submit form on enter press
             return true;
            }
            $(':input:eq(' + ($(':input').index(this) + 1) + ')').focus();
            return false;
        }
    });
 });
</script>
      <div class="page-content-wrapper">
        <!-- START PAGE CONTENT -->
        <div class="content">
          <!-- START JUMBOTRON -->
          <div class="jumbotron" data-pages="parallax">
            <div class=" container-fluid container-fixed-lg sm-p-l-0 sm-p-r-0" style="background-image:linear-gradient(45deg, #1f3953, #795548);color:white">
              <div class="inner">
                <!-- START BREADCRUMB -->
                 <ol class="breadcrumb">
                  <li class="breadcrumb-item">Assign Complain</li>
                  <li class="breadcrumb-item"><?php echo date('Y-m-d H:i:s'); ?></li>
                </ol>

                <!-- END BREADCRUMB --> 
              </div>
            </div>
          </div>
          <!-- END JUMBOTRON -->
          <!-- START CONTAINER FLUID -->
          <div class="container-fluid container-fixed-lg" >
            <!-- BEGIN PlACE PAGE CONTENT HERE -->
<div class="pgn-wrapper " data-position="top" style="top: 48px;" id="msg_div">

</div>
<div class="row" >
         

                  <div class="col-xl-12 col-lg-12" >

                <!-- START card -->
               
                    
               <div class=" container-fluid   container-fixed-lg bg-white"   >
<div class="row">

<div class="col-md-12">

<div class="card card-transparent">
<div class="card-body">
<p><strong>Complain Detail</strong></p>
<?php if(!empty($complain_data)){
foreach($complain_data as $rows){?>
<div class="form-group-attached">
<div class="row clearfix">
<div class="col-md-6">    
<div class="form-group form-group-default " aria-required="true" id="ticket_no_div">
<label>Ticket Number:</label>
<p><?php echo $rows['ticket_no']; ?></p>    
</div>
</div>    
 <div class="col-md-6">    
<div class="form-group form-group-default " aria-required="true" id="shipment_type_div">
<label>Shipment Number:</label>
<form  action="<?php echo base_url(); ?>Complain/update_complain_assign/<?php echo $rows['complain_id']; ?>" method="post">
<p><?php echo $rows['cn']; ?></p>    
</div>
</div>
</div>

<div class="row clearfix">
<div class="col-md-6">
<div class="form-group form-group-default " aria-required="true" id="nature_div">
<label>Nature of Complain:</label>
<p><?php echo $rows['complain_name']; ?></p>
</div>
</div>    
<div class="col-md-6">
<div class="form-group form-group-default  " aria-required="true" >
<label>Type of Complain:</label>
<p><?php echo $rows['type_name']; ?></p>
</div>
</div>
</div>
<div class="row clearfix">
<div class="col-md-6">
<div class="form-group form-group-default " aria-required="true" id="nature_div">
<label>Complain Status:</label>
<p><?php echo $rows['status']; ?></p>
</div>
</div>
<div class="col-md-6">
<div class="form-group form-group-default " aria-required="true"  id="c_name_div">
<label>Remarks:<i class="fa fa-info text-complete m-l-5"></i>
</label>
<p><?php echo $rows['remarks']; ?></p>
</div>    
</div>
</div>
<div class="row clearfix">
<div class="col-md-12">
<div class="form-group form-group-default required" aria-required="true" id="assign_div">
<label>Assign To:</label>
<select  class="form-control "  name="assign_id" id="assign_id" required="required" tabindex="9">
<option value="" >Select</option>    
<?php if(!empty($cs_data)){
foreach($cs_data as $data){?> 
<option value="<?php echo $data->oper_user_id; ?>" ><?php echo $data->oper_user_name; ?></option>
<?php }}?>
</select>
</div>
</div>
</div>
</div>

<p class="m-t-10"><strong>Complainant Detail</strong></p>
<div class="form-group-attached">

<div class="row clearfix">
<div class="col-md-6">
<div class="form-group form-group-default" aria-required="true" id="name_div">
<label>Complainant Name:</label>
<p><?php echo $rows['complainant_name']; ?></p>
 </div>
</div>
<div class="col-md-6">
<div class="form-group form-group-default " id="number_div">
<label>Mobile Number:</label>
<p><?php echo $rows['complainant_phone']; ?></p>
</div>
</div>
</div>
</div>
<div class="row clearfix">
<div class="col-md-12">
<div class="form-group form-group-default " id="comp_remarks_div">
<label>Complainant Remarks</label>
<p><?php echo $rows['complainant_remarks']; ?></p>
</div>
</div>
</div>

 <br>
 <div class="text-right">
     <button class="btn btn-info">Submit</button>
 </div>
</form>
<!--<button class="btn btn-default"><i class="pg-close"></i> Clear</button>-->
</div>
</div>
<?php }}?>
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
 
                <!-- END card -->
              
        <!-- END PAGE CONTENT -->
<script type="text/javascript">
$(document).ready(function(){
$("#nature").change(function(){
  if($("nature").val()!=""){
    var mydata={nature: $('#nature').val()};
    $(".type").html("....Loading");
      //alert("ok");
      $.ajax({
url: "<?php echo base_url(); ?>Complain/Complain_type_By_Nature_Id",
type: "POST",
data: mydata, 
success: function(data) {
$("#type_div").html(data);
$('#type_div').select2();
}
});

}      
});    
  $("#cn_no").change(function() {
        setTimeout(function() {$('#error').fadeOut();});
        setTimeout(function() {$('#success').fadeOut();});
        var add = "<?php echo base_url(); ?>Tracking/index/";
        var cn = $('#cn_no').val();
        var url = add.concat(cn);
        $('#someFrame').prop('src', url);
});

});

</script>

<?php
$this->load->view('inc/footer');
?>      