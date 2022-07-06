<?php
	error_reporting(0);
	$this->load->view('inc/header');
?>

<script type="text/javascript">
	$(document).ready(function(){ 		
		$('#data_panel').saimtech();
		$('#booking_range_1').focus();
		$('#customer').select2();
		$('#origin').select2();
		$('#destination').select2();
		$('#paymode').select2();
		$('#services').select2();
		
		var table =$('#data_panel').DataTable( {
			lengthMenu: [[ 25, 50, -1], [ 25, 50, "All"]],
			//order: [[ 10 "desc" ]],
			fixedHeader: true,
			searching: true,			
			paging:   true,
			ordering: true,
			bInfo: true,
			dom: 'Blfrtip',
			buttons: [
			'colvis', 
			
			{
				extend: 'excelHtml5',
				text:"<i class='fs-14 pg-form'></i> Excel",
				titleAttr: 'Excel',
				sheetName:'Pendings',
				className: 'btn-info',
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
				title:"Pendings",
				message:"TM Cargo <br> System Developer TM IT <br>  Zero Rated Report<br>"
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
						<li class="breadcrumb-item">Home</li>
						<li class="breadcrumb-item">Invoice</li>
						<li class="breadcrumb-item">Zero Rated</li>                  
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
					<div class="container-fluid container-fixed-lg bg-gray">
						<div class="row">							
							<div class="col-md-3" id="f_panel">							
								<div class="card m-t-10">									
									<div class="card-header  separator">
										<div class="card-title">Find CN</div>
									</div>
									<div class="card-body">
										<h5>Select CN</h5>
										<form role="form"  action="<?php echo base_url(); ?>Invoice/zero_cn" method="POST">
											<div class="form-group" id="invoice_date_div">
												<label>To Date</label>
												<span class="help">e.g. "<?php echo date('Y-m-d',strtotime("-7 day")); ?>"</span>
												<input type="date" id="booking_range_1" name="booking_range_1" value="<?php echo isset($order_booking_date1) ? $order_booking_date1 : date('Y-m-d',strtotime("-7 day")); ?>" class="form-control" tabindex="1" required>											
											</div>
											<div class="form-group" id="invoice_date_f_div">
												<label>From Date</label>
												<span class="help">e.g. "<?php echo date('Y-m-d'); ?>"</span>
												<input type="date" id="booking_range_2" name="booking_range_2" value="<?php echo isset($order_booking_date2) ? $order_booking_date2 : date('Y-m-d'); ?>" class="form-control" tabindex="2" required>											
											</div>
											<div class="form-group" id="customer_div">
												<label>Customer</label>
												<span class="help">(if any Optional)</span>												
												<select class="form-control" id="customer" name="customer" tabindex="3"> 
													<option value="">Select Customer</option>
													<?php foreach($customer_data as $types){
														if (isset($customer_id)){
															echo $customer_id == $types->customer_id ? "<option value='".$types->customer_id."' selected>[".$types->customer_account_no."] ".$types->customer_note."</option>" : "<option value='".$types->customer_id."'>[".$types->customer_account_no."] ".$types->customer_note."</option>" ;
														} else { echo "<option value='".$types->customer_id."'>[".$types->customer_account_no."] ".$types->customer_note."</option>"; }															
													} ?>
												</select>
											</div>
											<div class="form-group" id="mcn_div">
												<label>Manual CN</label>
												<span class="help">(if any Optional)</span>
												<input style="background:white" type="text" class="form-control" id="mcn" name="mcn" tabindex="4" <?php echo isset($manual_cn) ? "value='".$manual_cn."'" : "" ; ?>>
											</select>
										</div>
										<div class="form-group" id="origin_div">
											<label>Origin</label>
											<span class="help">(if any Optional)</span>
											<select class="form-control" id="origin" name="origin" tabindex="5"> 
												<option value="">Select City</option>
												<?php foreach($cities_data as $rows){
													if(isset($origin_city)){ echo $origin_city == $rows->city_id ? "<option value='".$rows->city_id."' selected>(".$rows->city_code.") (".$rows->city_short_code.") ".$rows->city_full_name."</option>" : "<option value='".$rows->city_id."'>(".$rows->city_code.") (".$rows->city_short_code.") ".$rows->city_full_name."</option>"; }
													else { echo("<option value='".$rows->city_id."'>(".$rows->city_code.") (".$rows->city_short_code.") ".$rows->city_full_name."</option>"); }   
												} ?>
											</select>
										</div>
										<div class="form-group" id="destination_div">
											<label>Destination</label>
											<span class="help">(if any Optional)</span>
											<select class="form-control" id="destination" name="destination" tabindex="6"> 
												<option value="">Select City</option>
												<?php foreach($cities_data as $rows){
													if(isset($destination_city)){ echo $destination_city == $rows->city_id ? "<option value='".$rows->city_id."' selected>(".$rows->city_code.") (".$rows->city_short_code.") ".$rows->city_full_name."</option>" : "<option value='".$rows->city_id."'>(".$rows->city_code.") (".$rows->city_short_code.") ".$rows->city_full_name."</option>"; }
													else { echo("<option value='".$rows->city_id."'>(".$rows->city_code.") (".$rows->city_short_code.") ".$rows->city_full_name."</option>"); }   
												} ?>
											</select>
										</div>											
										<div class="form-group" id="shipper_div">
											<label>Shipper</label>
											<span class="help">(if any Optional)</span>
											<input type="text" name="shipper"  id="shipper" class="form-control"  tabindex="7" <?php echo isset($shipper_name) ? "value='".$shipper_name."'" : "" ; ?>>
										</div>
										<div class="form-group" id="consignee_div">
											<label>Consignee</label>
											<span class="help">(if any Optional)</span>
											<input type="text" name="consignee" id="consignee" class="form-control" tabindex="8" <?php echo isset($consignee_name) ? "value='".$consignee_name."'" : "" ; ?>>
										</div>										
										<div class="form-group" id="pieces_div">
											<label>Pieces</label>
											<span class="help">(if any Optional)</span>
											<input type="number" name="pieces"  id="pieces" class="form-control" tabindex="9" <?php echo isset($pieces) ? "value='".$pieces."'" : "" ; ?>>
										</div>
										<div class="form-group" id="weight_div">
											<label>Weight</label>
											<span class="help">(if any Optional)</span>
											<input type="number" name="weight"  id="weight" class="form-control" <?php echo isset($weight) ? "value='".$weight."'" : "" ; ?> tabindex="10">
										</div>
										<div class="form-group" id="context_div">
											<label>Content</label>
											<span class="help">(if any Optional)</span>
											<input name="content" id="content" class="form-control"  tabindex="11" <?php echo isset($content) ? "value='".$content."'" : "" ; ?>>
										</div>
										<div class="form-group" id="paymode_div">
											<label>Pay Mode</label>
											<span class="help">(if any Optional)</span>
											<select class="form-control" id="paymode" name="paymode" tabindex="12"> 
												<option value="">Select Pay Mode</option>
												<option value="Account" <?php echo $payment_mode == "Account" ? "selected" : "" ; ?> >Account</option>
												<option value="Cash" <?php echo $payment_mode == "Cash" ? "selected" : "" ; ?> >Cash</option>
												<option value="FOC" <?php echo $payment_mode == "FOC" ? "selected" : "" ; ?> >FOC</option>
												<option value="COD" <?php echo $payment_mode == "COD" ? "selected" : "" ; ?> >FOD</option>													
											</select>
										</div>
										<div class="form-group" id="services_id">
											<label>Services</label>
											<span class="help">(if any Optional)</span>
											<select class="form-control" id="services" name="services" tabindex="13"> 
												<option value="">Select Service</option>
												<?php foreach($shipment_types as $types){
													if(isset($order_service_type)){ echo $order_service_type == $types->service_id ? "<option value='".$types->service_id."' selected >[".$types->service_code."] ".$types->service_name."</option>" : "<option value='".$types->service_id."'>[".$types->service_code."] ".$types->service_name."</option>" ; }
													else { echo("<option value='".$types->service_id."'>[".$types->service_code."] ".$types->service_name."</option>"); }
												} ?>
											</select>
										</div>
										<!-- <button class='pull-right btn btn-primary' onclick="fetch_bookings()" id="btn_fetch_bookings">Fetch Booking</button> -->
										<input type="submit" class='pull-right btn btn-primary' value="Fetch CN">
										<input type="reset" class='pull-right btn btn-secondry' >
									</form>
								</div>
							</div>
						</div>
						<div class="col-md-9" id="d_panel">
							<div class="card m-t-10">
								<div class="card-header  separator">
									<div class="card-title">Data Panel</div>									
									<div class="card-controls">
										<button class="btn btn-primary" type="button" onclick="filters()">Filters</button>
									</div>
								</div>
								<div class="card-body">									
									<div class="table-responsive">
										<table class="table table-bordered" id="data_panel">
											<thead>
												<tr>
													<th>No #</th>
													<th>Booking Date</th>
													<th>Customer</th>
													<th>CN</th>
													<th>Origin</th>
													<th>Destination</th>													
													<th>Shipper</th>
													<th>Consignee</th>													
													<th>Pieces</th>													
													<th>Weight</th>
													<th>Content</th>
													<th>Pay Mode</th>
													<th>Service</th>													
													<!--<th>Actions</th>-->
												</tr>
											</thead>
											<tbody>
												<?php if(!empty($selected_cns)){
													$i=0;  
													foreach($selected_cns as $rows){
														$i=$i+1;
														$style = $rows['is_hardchecked'] == 1 ? "style='color:var(--success)!important'" : "" ;
														$disabled = $rows['is_hardchecked'] == 1 ? $_SESSION['is_supervisor'] == 0 ? "disabled" : "" : "";
														echo("<tr id='tr_".$rows['order_id']."' >");
														echo("<td ".$style." >".$i."</td>");
														echo("<td ".$style." >".$rows['order_date']."</td>");
														echo("<td ".$style." >".$rows['customer_note']."</td>");													
														echo("<td ".$style." >".$rows['manual_cn']."</td>");
														echo("<td ".$style." >".$rows['origin_city_name']."</td>");
														echo("<td ".$style." >".$rows['destination_city_name']."</td>");													
														echo("<td ".$style." >".$rows['shipper_name']."</td>");
														echo("<td ".$style." >".$rows['consignee_name']."</td>");													
														echo("<td ".$style." >".$rows['pieces']."</td>");													
														echo("<td ".$style." >".number_format($rows['weight'],2)."</td>");
														echo("<td ".$style." >".$rows['product_detail']."</td>");
														echo("<td ".$style." >".$rows['order_pay_mode']."</td>");
														echo("<td ".$style." >".$rows['service_name']."</td>");													
														//echo("<td ".$style." ><button class='btn btn-info cn-edit' id='btn_edit_".$rows['order_id']."' name='btn_edit_".$rows['order_id']."' value='".$rows['order_id']."|".$rows['manual_cn']."' ".$disabled.">&#9998;</button>&nbsp;<button class='btn btn-info cn-okay' id='btn_okay_".$rows['order_id']."' name='btn_okay_".$rows['order_id']."' value='".$rows['order_id']."|".$rows['manual_cn']."' ".$disabled.">&#10003;</button></td>");
														echo("</tr>"); 
													}}?>	
											</tbody>
										</table>
									</div>										
								</div>
							</div>
						</div>
						
						<!--<div class="col-md-2">
							<div class="card m-t-10 bg-warning text-black">
							<div class="card-header  separator">
							<div class="card-title">Summary</div>
							</div>
							<div class="card-body">
							<center><div  id="summary_data"></div></center>     
							</div>
							</div>
						</div> -->
						
						
						<!-- END card -->
					</div>
					
				</div>
				<!-- END PLACE PAGE CONTENT HERE -->
			</div>
			<!-- END CONTAINER FLUID -->
		</div>
		<!-- END PAGE CONTENT -->
		
		<script>				
			function filters(){				
				var f_class = $('#f_panel').attr('class');
				var d_class = $('#d_panel').attr('class');
				
				if(f_class.indexOf('col-md-3') != -1){
					f_class = f_class.replace('col-md-3','col-md-0');
					d_class = d_class.replace('col-md-9','col-md-12');					
					$('#f_panel').hide();					
				} else {
					f_class = f_class.replace('col-md-0','col-md-3');
					d_class = d_class.replace('col-md-12','col-md-9');					
					$('#f_panel').show();					
				}
				
				$('#f_panel').attr('class',f_class);
				$('#d_panel').attr('class',d_class);				
			}
			
			$("#f_book").submit(function(e) {
				e.preventDefault();
				
				var data = {				
					booking_range_1: $('#booking_range_1').val().length > 0 ?  $('#booking_range_1').val() : "",
					booking_range_2: $('#booking_range_2').val().length > 0 ?  $('#booking_range_2').val() : "",
					customer: $('#customer').val().length > 0 ? $('#customer').val() : "",
					mcn: $('#mcn').val().length > 0 ? $('#mcn').val() : "",					
					origin: $('#origin').val().length > 0 ? $('#origin').val() : "",
					destination: $('#destination').val().length > 0 ? $('#destination').val() : "",
					shipper: $('#shipper').val().length > 0 ? $('#shipper').val() : "",
					consignee: $('#consignee').val().length > 0 ? $('#consignee').val() : "",
					pieces: $('#pieces').val().length > 0 ? $('#pieces').val() : "",
					weight: $('#weight').val().length > 0 ? $('#weight').val() : "",
					context: $('#content').val().length > 0 ? $('#content').val() : "",
					paymode: $('#paymode').val().length > 0 ? $('#paymode').val() : "",
					services: $('#services').val().length > 0 ? $('#services').val() : ""				
				};											
				
				$.ajax({
					url: "<?php echo base_url(); ?>Invoice/zero_cn",
					type: "POST",
					data: data,        
					success: function(data) {						
						if(!data.includes("Error")){
							$('#msg_div').html(data);
						}
					}
				});
				
			});
			
		</script>	
	</div>
</div>
<?php
	$this->load->view('inc/footer');
?>      													