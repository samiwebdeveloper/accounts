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
                  <li class="breadcrumb-item"><a style="color:white;" href="<?php echo base_url();?>complain">Complain</a></li>
                  <li class="breadcrumb-item"><a style="color:white;" href="<?php echo base_url();?>complain/report">Complain list</a></li>
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
<div class="col-md-8">
<div class="card card-transparent">

<div class="card-body">   
<iframe src="" id="someFrame" style="height: 500px; width: 100%; border-radius:0px;"></iframe>
</div>
</div>

</div>
<div class="col-md-4">

<div class="card card-transparent">
<div class="card-body">
<p><strong>Complain Detail</strong></p>

<?php if ($this->session->flashdata('tick_no')) 
 $ticket_no = $this->session->flashdata('tick_no');
  ?> 
 <?php if ($this->session->flashdata('cn_chk')) 
 $cn_check = $this->session->flashdata('cn_chk');
  ?>
<div class="form-group-attached">
<div class="form-group form-group-default required" aria-required="true" id="shipment_type_div">
<label>Shipment Number</label>
<form  action="<?php echo base_url(); ?>Complain/Insert_Complain" method="post">
<input  type="number" class="form-control"  name="cn_no" id="cn_no" tabindex="1" required="" aria-required="true">
</div>
<div class="form-group form-group-default required" aria-required="true" id="nature_div">
<label>Nature of Complain</label>
<select  class="form-control " name="nature" id="nature" required="required" tabindex="9">
<option value="" >Select Nature</option>    
<?php if(!empty($nature_data)){
foreach($nature_data as $data){
echo"<option value=".$data->nature_id.">".$data->complain_name."</option>";    
}}?>     
</select>
</div>
<div class="row clearfix">
<div class="col-md-12">
<div class="form-group form-group-default required " aria-required="true" >
<label>Type of Complain</label>
<select  class="form-control " name="types" required="required" id="type_div" tabindex="9">
    
</select>    
</div>
</div>

</div>
<div class="form-group form-group-default " aria-required="true"  id="c_name_div">
<label>Remarks <i class="fa fa-info text-complete m-l-5"></i>
</label>
<input type="text" class="form-control" name="remarks" id="remarks">
</div>
</div>

<p class="m-t-10"><strong>Complainant Detail</strong></p>
<div class="form-group-attached">

<div class="row clearfix">
<div class="col-md-12">
<div class="form-group form-group-default required" aria-required="true" id="name_div">
<label>Name</label>
<input  type="text" class="form-control date" name="name" id="name" required="" aria-required="true">
 </div>
</div>
</div>
<div class="row clearfix">
<div class="col-md-12">
<div class="form-group form-group-default required" id="number_div">
<label>Mobile Number</label>
<input type="number" class="form-control email"  name="number" id="number" autocomplete="on" required="" aria-required="true">
</div>
</div>
</div>
<div class="row clearfix">
<div class="col-md-12">
<div class="form-group form-group-default " id="comp_remarks_div">
<label>Remarks</label>
<input type="text" class="form-control email"  name="complainant_remarks" id="number" autocomplete="on"  aria-required="true">
</div>
</div>
</div>

</div>

 <br>
<button id="submit" class="btn btn-info">Launch Complain</button>
</form>
<!--<button class="btn btn-default"><i class="pg-close"></i> Clear</button>-->
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
if(('<?php echo $ticket_no;?>'!="")&& ('<?php echo $cn_check;?>'=="fail")){
  Swal.fire({
  icon: 'error',
  title: 'Oops!',
  html:'You Already Have a complain with ticket# <code><?php echo $ticket_no?></code>',
  text: ' ',
})
}
if(('<?php echo $ticket_no;?>'!="")&& ('<?php echo $cn_check;?>'=="pass")){
  Swal.fire({
  icon: 'success',
  title: 'Ticket# <?php echo $ticket_no?>',
  text: ' Complain Registered Successfully!',
})
} 

});

</script>

<?php
$this->load->view('inc/footer');
?>      