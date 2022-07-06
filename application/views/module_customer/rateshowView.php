<?php
error_reporting(0);
$this->load->view('inc/header');
?>

<script type="text/javascript">
$(document).ready(function(){ 
$('#data_panel').saimtech();
$('#pending_panel').saimtech();
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
                  <li class="breadcrumb-item">Customer</li>
                  <li class="breadcrumb-item">Edit Customer</li>
                  <li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:s'); ?></mark></li>
                  
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
     <div class="card-title">Data Panel</div>
     <div class="card-controls">
<ul>

</ul>
</div>
      </div>
    <div class="card-body">
    
    
    <div class=" container-fluid   container-fixed-lg">
<div class="row row-same-height">
<div class="col-md-7 b-r b-dashed b-grey ">
<div class="padding-30 sm-padding-5 sm-m-t-15 m-t-50">
<?php if(!empty($message)){ echo("<p class='alert alert-success'>".$message."</p>"); } ?>    
<table class="table table-success table-striped">
<thead>
    
    <th>Origin</th>
    <th>Destination</th>
    <th>Service</th>
    <th>Wgt1</th>
    <th>Rate1</th>
    <th>Wgt2</th>
    <th>Rate2</th>
    <th>Add Wgt</th>
    <th>Add Wgt</th>
    <th>Gst</th>
</thead>
<tbody>


    
<?php if(!empty($dest_data)){
foreach($dest_data as $rows)
{
?>
<tr>
    <td><?php echo $rows->Origin; ?></td>
    <td><?php echo $rows->Destination; ?></td>
    <td><?php echo $rows->Service; ?></td>
    <td><?php echo $rows->w1; ?></td>
    <td><?php echo $rows->r1; ?></td>
    <td><?php echo $rows->w2; ?></td>
    <td><?php echo $rows->r2; ?></td>
    <td><?php echo $rows->aw; ?></td>
    <td><?php echo $rows->ar; ?></td>
    <td><?php echo $rows->gst; ?></td>
</tr>
<?php 
}
}?>

 
    
</tbody>
</table>
</div>
</div>
<div class="col-md-5">
<div class="padding-30 sm-padding-5">
<form role="form" method="post" action="edit_customer">
<p>Cutomer Rates</p>
<br>
<p>Zone A</p>
<div class="form-group-attached">
<div class="row clearfix">
<div class="col-sm-2">
<div class="form-group form-group-default required" id="wc_wgt1_div">
<label>WGT1</label></label>
<input type="text" class="form-control" name="wc_wgt1" id="wc_wgt1" value="<?php echo $rate_data[0]['sc_wgt1']; ?>" placeholder="Weight 1" required="" tabindex=19>
</div>
</div>

<div class="col-sm-2">
<div class="form-group form-group-default required" id="wc_rate1_div">
<label>RATE1</label></label>
<input type="number" class="form-control" name="wc_rate1" id="wc_rate" value="<?php echo $rate_data[0]['sc_rate1']; ?>" placeholder="Rate 1" required="" tabindex=20>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="wc_wgt2_div">
<label>WGT2</label></label>
<input type="text" class="form-control" name="wc_wgt2" id="wc_wgt2" value="<?php echo $rate_data[0]['sc_wgt2']; ?>" placeholder="Weight 2" required="" tabindex=21>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="wc_rate2_div">
<label>RATE2</label></label>
<input type="number" class="form-control" name="wc_rate2" id="wc_rate2"  value="<?php echo $rate_data[0]['sc_rate2']; ?>" placeholder="Rate 2" required="" tabindex=22>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="wc_awgt_div">
<label>AWGT</label></label>
<input type="text" class="form-control" name="wc_awgt" id="wc_awgt"  value="<?php echo $rate_data[0]['sc_add_wgt']; ?>" placeholder="Addition" required="" tabindex=23>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="wc_arate_div">
<label>ARATE</label></label>
<input type="number" class="form-control" name="wc_arate" id="wc_arate" value="<?php echo $rate_data[0]['sc_add_rate']; ?>" placeholder="ADD Rate" required="" tabindex=24>
</div>
</div>
</div>



<div class="row clearfix">
<div class="col-sm-3">
<div class="form-group form-group-default required" id="wc_gst_div">
<label>Gst Formula</label>
<select class="form-control" name='wc_gst_formula' id='wc_gst_formula'   required tabindex=25>
<option value='PER'>PER</option>
</select>
</div>
</div>

<div class="col-sm-3">
<div class="form-group form-group-default required" id="wc_gst_rate_div">
<label>GST Rate</label>
<input type="number" class="form-control" name="wc_gst_rate" id="wc_gst_rate" value="<?php echo $rate_data[0]['sc_gst_rate']; ?>" placeholder="GST" required="" tabindex=26>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="wc_sp_handling_formula_div">
<label>SPH Formula</label>
<select class="form-control" name='wc_sp_handling_formula' id='wc_sp_handling_formula' required tabindex=27>
<option value='<?php echo $rate_data[0]['sc_sp_handling_formula']; ?>'><?php echo $rate_data[0]['sc_sp_handling_formula']; ?></option>
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="wc_sp_handling_rate_div">
<label>SP Handing</label></label>
<input type="number" class="form-control" name="wc_sp_handling_rate" id="wc_sp_handling_rate" value="<?php echo $rate_data[0]['sc_sp_handling_rate']; ?>" placeholder="SP Handling" required="" tabindex=28>
</div>
</div>
</div>

<div class="row clearfix">
<div class="col-sm-3">
<div class="form-group form-group-default required" id="wc_return_formula_div">
<label>Re Formula</label></label>
<select class="form-control" name='wc_return_formula' id='wc_return_formula'  required tabindex=29>
<option value='<?php echo $rate_data[0]['sc_return_formula']; ?>'><?php echo $rate_data[0]['sc_return_formula']; ?></option>
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="wc_return_rate_div">
<label>Retunn </label></label>
<input type="number" class="form-control" name="wc_return_rate" value='<?php echo $rate_data[0]['sc_return_rate']; ?>' id="wc_return_rate" placeholder="Rate" required="" tabindex=30>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="wc_fuel_formula_div">
<label>F Formula</label></label>
<select class="form-control" name='wc_fuel_formula' id='wc_fuel_formula'  required tabindex=31>
<option value='<?php echo $rate_data[0]['sc_fuel_formula']; ?>'><?php echo $rate_data[0]['sc_fuel_formula']; ?></option>    
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="wc_fuel_rate_div">
<label>Fuel Rate</label>
<input type="number" class="form-control" name="wc_fuel_rate" id="wc_fuel_rate" value='<?php echo $rate_data[0]['sc_fuel_rate']; ?>' placeholder="ADD Rate" required="" tabindex=32>
</div>
</div>
</div>
</div>


<br>
<p>Zone B</p>
<div class="form-group-attached">
<div class="row clearfix">
<div class="col-sm-2">
<div class="form-group form-group-default required" id="sz_wgt1_div">
<label>WGT1</label></label>
<input type="text" class="form-control" name="sz_wgt1" id="sz_wgt1" value="<?php echo $rate_data[0]['sz_wgt1']; ?>"  placeholder="Weight 1" required="" tabindex=33>
</div>
</div>

<div class="col-sm-2">
<div class="form-group form-group-default required" id="sz_rate1_div">
<label>RATE1</label></label>
<input type="number" class="form-control" name="sz_rate1" id="sz_rate2" value="<?php echo $rate_data[0]['sz_rate1']; ?>" placeholder="Rate 1" required="" tabindex=34>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="sz_wgt2_div">
<label>WGT2</label></label>
<input type="text" class="form-control" name="sz_wgt2" id="sz_wgt2" value="<?php echo $rate_data[0]['sz_wgt2']; ?>" placeholder="Weight 2" required="" tabindex=35>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="sz_rate2_div">
<label>RATE2</label></label>
<input type="number" class="form-control" name="sz_rate2" id="sz_rate2" value="<?php echo $rate_data[0]['sz_rate2']; ?>" placeholder="Rate 2" required="" tabindex=36>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="sz_awgt_div">
<label>AWGT</label></label>
<input type="text" class="form-control" name="sz_awgt" id="sz_awgt" value="<?php echo $rate_data[0]['sz_add_wgt']; ?>" placeholder="Addition" required="" tabindex=37>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="sz_arate_div">
<label>ARATE</label></label>
<input type="number" class="form-control" name="sz_arate" id="sz_arate" value="<?php echo $rate_data[0]['sz_add_rate']; ?>" placeholder="ADD Rate" required="" tabindex=38>
</div>
</div>
</div>



<div class="row clearfix">
<div class="col-sm-3">
<div class="form-group form-group-default required" id="sz_gst_formula_div">
<label>Gst Formula</label>
<select class="form-control" name='sz_gst_formula' id='sz_gst_formula'  required tabindex=39>
<option value='PER'>PER</option>
</select>
</div>
</div>

<div class="col-sm-3">
<div class="form-group form-group-default required" id="sz_gst_rate_div">
<label>GST Rate</label>
<input type="number" class="form-control" name="sz_gst_rate" id="sz_gst_rate" value="<?php echo $rate_data[0]['sz_gst_rate']; ?>" placeholder="Rate 1" required="" tabindex=40>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="sz_sp_handling_formula_div">
<label>SPH Formula</label>
<select class="form-control" name='sz_sp_handling_formula' id='sz_sp_handling_formula' value="<?php echo $rate_data[0]['sz_sp_handling_formula']; ?>"   required tabindex=41>
<option value='<?php echo $rate_data[0]['sz_sp_handling_formula']; ?>'><?php echo $rate_data[0]['sz_sp_handling_formula']; ?></option>
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="sz_sp_handling_rate_div">
<label>SP Handing</label></label>
<input type="number" class="form-control" name="sz_sp_handling_rate" id="sz_sp_handling_rate" value="<?php echo $rate_data[0]['sz_sp_handling_rate']; ?>" placeholder="Handling" required="" tabindex=42>
</div>
</div>
</div>

<div class="row clearfix">
<div class="col-sm-3">
<div class="form-group form-group-default required" id="sz_return_formula_div">
<label>Re Formula</label></label>
<select class="form-control" name='sz_return_formula' id='sz_return_formula'  required tabindex=43>
<option value='<?php echo $rate_data[0]['sz_return_formula']; ?>'><?php echo $rate_data[0]['sz_return_formula']; ?></option>
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="sz_return_rate">
<label>Return </label></label>
<input type="number" class="form-control" name="sz_return_rate" id="sz_return_rate"  value="<?php echo $rate_data[0]['sz_return_rate']; ?>" placeholder="return" required="" tabindex=44>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="sz_fuel_formula_div">
<label>F Formula</label></label>
<select class="form-control" name='sz_fuel_formula' id='sz_fuel_formula'  required tabindex=45>
<option value='<?php echo $rate_data[0]['sz_fuel_formula']; ?>'><?php echo $rate_data[0]['sz_fuel_formula']; ?></option>    
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="sz_fuel_rate">
<label>Fuel Rate</label>
<input type="number" class="form-control" name="sz_fuel_rate" id="sz_fuel_rate"  value="<?php echo $rate_data[0]['sz_fuel_rate']; ?>" placeholder="Fuel" required="" tabindex=46>
</div>
</div>
</div>
</div>


<br>
<p>Zone C</p>
<div class="form-group-attached">
<div class="row clearfix">
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_wgt1_div">
<label>WGT1</label></label>
<input type="text" class="form-control" name="dz_wgt1" id="dz_wgt1" value="<?php echo $rate_data[0]['dz_wgt1']; ?>" placeholder="Weight 1" required="" tabindex=47>
</div>
</div>

<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_rate1_div">
<label>RATE1</label></label>
<input type="number" class="form-control" name="dz_rate1" id="dz_rate1" value="<?php echo $rate_data[0]['dz_rate1']; ?>" placeholder="Rate 1" required="" tabindex=48>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_wgt2_div">
<label>WGT2</label></label>
<input type="text" class="form-control" name="dz_wgt2" id="dz_wgt2" value="<?php echo $rate_data[0]['dz_wgt2']; ?>" placeholder="Weight 2" required="" tabindex=49>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_rate2_div">
<label>RATE2</label></label>
<input type="number" class="form-control" name="dz_rate2" id="dz_rate2" value="<?php echo $rate_data[0]['dz_rate2']; ?>" placeholder="Rate 2" required="" tabindex=50>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_awgt_div">
<label>AWGT</label></label>
<input type="text" class="form-control" name="dz_awgt" id="dz_awgt"  value="<?php echo $rate_data[0]['dz_add_wgt']; ?>" placeholder="Addition" required="" tabindex=51>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_arate_div">
<label>ARATE</label></label>
<input type="number" class="form-control" name="dz_arate" id="dz_arate" value="<?php echo $rate_data[0]['dz_add_rate']; ?>" placeholder="ADD Rate" required="" tabindex=52>
</div>
</div>
</div>



<div class="row clearfix">
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_gst_formula_div">
<label>Gst Formula</label>
<select class="form-control" name='dz_gst_formula' id='dz_gst_formula'  required tabindex=53>
<option value='PER'>PER</option>
</select>
</div>
</div>

<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_gst_rate_div">
<label>GST Rate</label>
<input type="number" class="form-control" name="dz_gst_rate" id="dz_gst_rate" value="<?php echo $rate_data[0]['dz_gst_rate']; ?>" placeholder="Rate 1" required="" tabindex=54>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="user_name_div">
<label>SPH Formula</label>
<select class="form-control" name='dz_sp_handling_formula' id='dz_sp_handling_formula'  required tabindex=55>
<option value='<?php echo $rate_data[0]['dz_sp_handling_formula']; ?>'><?php echo $rate_data[0]['dz_sp_handling_formula']; ?></option>
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_sp_handling_rate_div">
<label>SP Handing</label></label>
<input type="number" class="form-control" name="dz_sp_handling_rate" id="dz_sp_handling_rate" value="<?php echo $rate_data[0]['dz_sp_handling_rate']; ?>"   value="<?php echo $rate_data[0]['dz_sp_handling_rate']; ?>"  placeholder="Handling" required="" tabindex=56>
</div>
</div>
</div>

<div class="row clearfix">
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_return_formula_div">
<label>Re Formula</label></label>
<select class="form-control" name='dz_return_formula' id='dz_return_formula'  required tabindex=57>
<option value='<?php echo $rate_data[0]['dz_return_formula']; ?>'><?php echo $rate_data[0]['dz_return_formula']; ?></option>
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_return_rate_div">
<label>Return</label></label>
<input type="number" class="form-control" name="dz_return_rate" id="dz_return_rate" value='<?php echo $rate_data[0]['dz_return_rate']; ?>' placeholder="return" required="" tabindex=58>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_fuel_formula_div">
<label>F Formula</label></label>
<select class="form-control" name='dz_fuel_formula' id='dz_fuel_formula'  required tabindex=59>
<option value='<?php echo $rate_data[0]['dz_fuel_formula']; ?>'><?php echo $rate_data[0]['dz_fuel_formula']; ?></option>    
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_fuel_rate_div">
<label>Fuel Rate</label>
<input type="number" class="form-control" name="dz_fuel_rate" id="dz_fuel_rate" value='<?php echo $rate_data[0]['dz_fuel_rate']; ?>'  placeholder="Fuel" required="" tabindex=60>
</div>
</div>
</div>
</div>



<br>
<p>Zone D</p>
<div class="form-group-attached">
<div class="row clearfix">
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_wgt1_div">
<label>WGT1</label></label>
<input type="text" class="form-control" name="dz_wgt1" id="dz_wgt1" value="<?php echo $rate_data[0]['dz_wgt1']; ?>" placeholder="Weight 1" required="" tabindex=47>
</div>
</div>

<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_rate1_div">
<label>RATE1</label></label>
<input type="number" class="form-control" name="dz_rate1" id="dz_rate1" value="<?php echo $rate_data[0]['dz_rate1']; ?>" placeholder="Rate 1" required="" tabindex=48>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_wgt2_div">
<label>WGT2</label></label>
<input type="text" class="form-control" name="dz_wgt2" id="dz_wgt2" value="<?php echo $rate_data[0]['dz_wgt2']; ?>" placeholder="Weight 2" required="" tabindex=49>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_rate2_div">
<label>RATE2</label></label>
<input type="number" class="form-control" name="dz_rate2" id="dz_rate2" value="<?php echo $rate_data[0]['dz_rate2']; ?>" placeholder="Rate 2" required="" tabindex=50>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_awgt_div">
<label>AWGT</label></label>
<input type="text" class="form-control" name="dz_awgt" id="dz_awgt"  value="<?php echo $rate_data[0]['dz_add_wgt']; ?>" placeholder="Addition" required="" tabindex=51>
</div>
</div>
<div class="col-sm-2">
<div class="form-group form-group-default required" id="dz_arate_div">
<label>ARATE</label></label>
<input type="number" class="form-control" name="dz_arate" id="dz_arate" value="<?php echo $rate_data[0]['dz_add_rate']; ?>" placeholder="ADD Rate" required="" tabindex=52>
</div>
</div>
</div>



<div class="row clearfix">
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_gst_formula_div">
<label>Gst Formula</label>
<select class="form-control" name='dz_gst_formula' id='dz_gst_formula'  required tabindex=53>
<option value='PER'>PER</option>
</select>
</div>
</div>

<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_gst_rate_div">
<label>GST Rate</label>
<input type="number" class="form-control" name="dz_gst_rate" id="dz_gst_rate" value="<?php echo $rate_data[0]['dz_gst_rate']; ?>" placeholder="Rate 1" required="" tabindex=54>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="user_name_div">
<label>SPH Formula</label>
<select class="form-control" name='dz_sp_handling_formula' id='dz_sp_handling_formula'  required tabindex=55>
<option value='<?php echo $rate_data[0]['dz_sp_handling_formula']; ?>'><?php echo $rate_data[0]['dz_sp_handling_formula']; ?></option>
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_sp_handling_rate_div">
<label>SP Handing</label></label>
<input type="number" class="form-control" name="dz_sp_handling_rate" id="dz_sp_handling_rate" value="<?php echo $rate_data[0]['dz_sp_handling_rate']; ?>"   value="<?php echo $rate_data[0]['dz_sp_handling_rate']; ?>"  placeholder="Handling" required="" tabindex=56>
</div>
</div>
</div>

<div class="row clearfix">
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_return_formula_div">
<label>Re Formula</label></label>
<select class="form-control" name='dz_return_formula' id='dz_return_formula'  required tabindex=57>
<option value='<?php echo $rate_data[0]['dz_return_formula']; ?>'><?php echo $rate_data[0]['dz_return_formula']; ?></option>
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_return_rate_div">
<label>Return</label></label>
<input type="number" class="form-control" name="dz_return_rate" id="dz_return_rate" value='<?php echo $rate_data[0]['dz_return_rate']; ?>' placeholder="return" required="" tabindex=58>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_fuel_formula_div">
<label>F Formula</label></label>
<select class="form-control" name='dz_fuel_formula' id='dz_fuel_formula'  required tabindex=59>
<option value='<?php echo $rate_data[0]['dz_fuel_formula']; ?>'><?php echo $rate_data[0]['dz_fuel_formula']; ?></option>    
<option value='PER'>PER</option>
<option value='FIX'>Fixed</option>
</select>
</div>
</div>
<div class="col-sm-3">
<div class="form-group form-group-default required" id="dz_fuel_rate_div">
<label>Fuel Rate</label>
<input type="number" class="form-control" name="dz_fuel_rate" id="dz_fuel_rate" value='<?php echo $rate_data[0]['dz_fuel_rate']; ?>'  placeholder="Fuel" required="" tabindex=60>
</div>
</div>
</div>
</div>


<br>
<p>Flyar Rate</p>
<div class="form-group-attached">
<div class="row clearfix">
<div class="col-sm-12">
<div class="form-group form-group-default required" id="flyer_rate_div">
<label>Flyer Rate</label></label>
<input type="number" class="form-control" name="flyer_rate" id="flyer_rate" value='<?php echo $rate_data[0]['flyer_rate']; ?>'  placeholder="Flyer Rate" required="" tabindex=61>
</div>
</div>
</div>
<div class="row clearfix">
<div class="col-sm-6">
<div class="form-group form-group-default required" id="cash_handling_rate_div">
<label>Cash Handling Formula</label></label>
<select class="form-control" name="cash_handling_formula" id="cash_handling_formula" required="" tabindex=62>
<option value="<?php echo $rate_data[0]['cash_handling_formula']; ?>"><?php echo $rate_data[0]['cash_handling_formula']; ?></option>    
<option value="PER">PER</option>
<option value="FIX">FIXED</option>
</select>    
</div>
</div>
<div class="col-sm-6">
<div class="form-group form-group-default required" id="cash_handling_rate_div">
<label>Cash Handling Rate</label></label>
<input type="number" class="form-control" name="cash_handling_rate" value='<?php echo $rate_data[0]['cash_handling_rate']; ?>' id="cash_handling_rate" placeholder="Cash Handling Rate" required="" tabindex=62>
</div>
</div>
</div>

<div class="row clearfix">
<div class="col-sm-6">
<div class="form-group form-group-default required" id="reference_formula_div">
<label>Reference Formula</label></label>
<select class="form-control" name="reference_formula" id="reference_formula" required="" tabindex=63>
<option value="<?php echo $rate_data[0]['reference_formula']; ?>"><?php echo $rate_data[0]['reference_formula']; ?></option>    
<option value="PER">PER</option>
<option value="FIX">FIXED</option>
</select>    
</div>
</div>
<div class="col-sm-6">
<div class="form-group form-group-default required" id="reference_rate_div">
<label>Reference Rate</label></label>
<input type="number" class="form-control" name="reference_rate" id="reference_rate" value='<?php echo $rate_data[0]['reference_rate']; ?>' placeholder="Reference Rate" required="" tabindex=64>
</div>
</div>
</div>


</div>
<br>
</form>

</div>
</div>
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
        <!-- END PAGE CONTENT -->

<script>
 
function check_username(){
  
var username=$("#user_name").val();
var mydata={
username : username
};
$.ajax({
url: "<?php echo base_url(); ?>Customer/check_username",
type: "POST",
data: mydata,        
success: function(data) {
  //  alert(data);
if(data==0){    
$("#user_name_div").css("border-color", "green");
} else if(data!=0){
$("#user_name_div").css("border-color", "red");
$("#user_name").focus();
}
}
});

}

</script>




</div>
</div>
<?php
$this->load->view('inc/footer');
?>      