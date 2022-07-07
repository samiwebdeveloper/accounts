<?php
error_reporting(0);

$this->load->view('inc/header');
?>


<style>
	.lds-ring {
		display: inline-block;
		position: relative;
		width: 9px;
		height: 14px;
		top: 0px;
		right: 6px;
	}

	.lds-ring div {
		box-sizing: border-box;
		display: block;
		position: absolute;
		width: 16px;
		height: 16px;
		margin: 3px;
		border: 3px solid #fff;
		border-radius: 50%;
		animation: lds-ring 1.2s cubic-bezier(0.5, 0, 0.5, 1) infinite;
		border-color: #fff transparent transparent transparent;
	}

	.lds-ring div:nth-child(1) {
		animation-delay: -0.45s;
	}

	.lds-ring div:nth-child(2) {
		animation-delay: -0.3s;
	}

	.lds-ring div:nth-child(3) {
		animation-delay: -0.15s;
	}

	@keyframes lds-ring {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}
</style>

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
						<li class="breadcrumb-item">Booking</li>
						<li class="breadcrumb-item">Select</li>
					</ol>
					<!-- END BREADCRUMB -->
				</div>
			</div>
		</div>

		<!-- END JUMBOTRON -->
		<!-- START CONTAINER FLUID -->
		<div class="container-fluid container-fixed-lg">
			<!-- BEGIN PlACE PAGE CONTENT HERE -->
			<div class="pgn-wrapper" data-position="top" style="top: 4px;" id="msg_div"></div>
			<div class="row">
				<div class="col-xl-12 col-lg-12">
					<!-- START card -->
					<div class="container-fluid container-fixed-lg bg-gray">
						<div class="row">
							<div class="col-md-3" id="f_panel">
								<div class="card m-t-10">
									<div class="card-header  separator">
										<div class="card-title">Find Booking</div>
									</div>
									<div class="card-body">
										<h5>Select Booking</h5>
										<form role="form" method="POST">
											<div class="form-group" id="invoice_date_div">
												<label>To Date</label>
												<span class="help">e.g. "<?php echo date('Y-m-d', strtotime("-5 day")); ?>"</span>
												<input type="date" id="booking_range_1" name="booking_range_1" value="<?php echo isset($order_booking_date1) ? $order_booking_date1 : date('Y-m-d', strtotime("-5 day")); ?>" class="form-control" tabindex="1" required>
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
													<option value="" id="cusotmer_op">Select Customer</option>

												</select>
											</div>
											<div class="form-group" id="mcn_div">
												<label>Manual CN</label>
												<span class="help">(if any Optional)</span>
												<input style="background:white" type="text" class="form-control" id="mcn" name="mcn" tabindex="4" <?php echo isset($manual_cn) ? "value='" . $manual_cn . "'" : ""; ?>>
												</select>
											</div>
											<div class="form-group" id="origin_div">
												<label>Origin</label>
												<span class="help">(if any Optional)</span>
												<select class="form-control" id="origin" name="origin" tabindex="5">
													<option value="" id="city_origin">Select City</option>

												</select>
											</div>
											<div class="form-group" id="destination_div">
												<label>Destination</label>
												<span class="help">(if any Optional)</span>
												<select class="form-control" id="destination" name="destination" tabindex="6">
													<option value="" id="city_des">Select City</option>

												</select>
											</div>
											<div class="form-group" id="shipper_div">
												<label>Shipper</label>
												<span class="help">(if any Optional)</span>
												<input type="text" name="shipper" id="shipper" class="form-control" tabindex="7" <?php echo isset($shipper_name) ? "value='" . $shipper_name . "'" : ""; ?>>
											</div>
											<div class="form-group" id="consignee_div">
												<label>Consignee</label>
												<span class="help">(if any Optional)</span>
												<input type="text" name="consignee" id="consignee" class="form-control" tabindex="8" <?php echo isset($consignee_name) ? "value='" . $consignee_name . "'" : ""; ?>>
											</div>
											<div class="form-group" id="pieces_div">
												<label>Pieces</label>
												<span class="help">(if any Optional)</span>
												<input type="number" name="pieces" id="pieces" class="form-control" tabindex="9" <?php echo isset($pieces) ? "value='" . $pieces . "'" : ""; ?>>
											</div>
											<div class="form-group" id="weight_div">
												<label>Weight</label>
												<span class="help">(if any Optional)</span>
												<input type="number" name="weight" id="weight" class="form-control" <?php echo isset($weight) ? "value='" . $weight . "'" : ""; ?> tabindex="10">
											</div>
											<div class="form-group" id="context_div">
												<label>Content</label>
												<span class="help">(if any Optional)</span>
												<input name="content" id="content" class="form-control" tabindex="11" <?php echo isset($content) ? "value='" . $content . "'" : ""; ?>>
											</div>
											<div class="form-group" id="paymode_div">
												<label>Pay Mode</label>
												<span class="help">(if any Optional)</span>
												<select class="form-control" id="paymode" name="paymode" tabindex="12">
													<option value="">Select Pay Mode</option>
													<option value="Account" <?php echo $payment_mode == "Account" ? "selected" : ""; ?>>Account</option>
													<option value="Cash" <?php echo $payment_mode == "Cash" ? "selected" : ""; ?>>Cash</option>
													<option value="FOC" <?php echo $payment_mode == "FOC" ? "selected" : ""; ?>>FOC</option>
													<option value="COD" <?php echo $payment_mode == "COD" ? "selected" : ""; ?>>FOD</option>
												</select>
											</div>
											<div class="form-group" id="services_id">
												<label>Services</label>
												<span class="help">(if any Optional)</span>
												<select class="form-control" id="services" name="services" tabindex="13">
													<option value="" id="service_op">Select Service</option>

												</select>
											</div>
											<!-- <button class='pull-right btn btn-primary' onclick="fetch_bookings()" id="btn_fetch_bookings">Fetch Booking</button> -->
											<input type="button" id="testing" class='pull-right btn btn-primary' value="Fetch Booking">
											<input type="reset" class='pull-right btn btn-secondry'>
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

										<div class="text-center d-flex">
											<input type="text" class="form-control" id="min" name="min" style="width:50% ;" placeholder="Enter Start Date">
											<input type="text" class="form-control" id="max" name="max" style="width:50% ;" placeholder="Enter End Date">
										</div>
										<div class="table-responsive">
											<table class="table table-bordered compact nowrap" id="data_panel" style="border-top:1px solid black ;">
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
														<th>Actions</th>
													</tr>
												</thead>
												<tbody>

												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>


					</div>
					<!-- END PLACE PAGE CONTENT HERE -->
				</div>
				<!-- END CONTAINER FLUID -->
			</div>
			<!-- END PAGE CONTENT -->
		</div>
	</div>
	<?php $this->load->view('inc/footer'); ?>
	<!-- <script src="cdn.datatables.net/plug-ins/1.12.1/filtering/row-based/range_dates.js"></script> -->
	<script>
		function filters() {
			var f_class = $('#f_panel').attr('class');
			var d_class = $('#d_panel').attr('class');

			if (f_class.indexOf('col-md-3') != -1) {
				f_class = f_class.replace('col-md-3', 'col-md-0');
				d_class = d_class.replace('col-md-9', 'col-md-12');
				$('#f_panel').hide();
			} else {
				f_class = f_class.replace('col-md-0', 'col-md-3');
				d_class = d_class.replace('col-md-12', 'col-md-9');
				$('#f_panel').show();
			}

			$('#f_panel').attr('class', f_class);
			$('#d_panel').attr('class', d_class);
		}

		function load_data() {
			var data = {
				booking_range_1: $('#booking_range_1').val().length > 0 ? $('#booking_range_1').val() : "",
				booking_range_2: $('#booking_range_2').val().length > 0 ? $('#booking_range_2').val() : "",
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
			$('#data_panel').DataTable().destroy();
			$.ajax({
				url: "testing",
				type: "POST",
				data: data,
				beforeSend: function() {
					$('tbody').html("<tr><td colspan='14'><img src='<?php echo base_url(); ?>assets/ajax-loader.gif'  width='130px'></td></tr>");
				},
				success: function(data) {
					$('tbody').html("");
					var js_obj = $.parseJSON(data)
					var selected_cns = js_obj.selected_cns;
					var cities_data = js_obj.cities_data;
					var customer_data = js_obj.customer_data;
					var shipment_types = js_obj.shipment_types;
					var is_supervisor = "<?php echo $_SESSION['is_supervisor']; ?>";

					// add origin_city & des_city
					for (let index = 0; index < cities_data.length; index++) {
						$("#city_origin").after("<option value='" + cities_data[index].city_id + "' >(" + cities_data[index].city_code + ") [ " + cities_data[index].city_name.toUpperCase() + " ] </option>");
						$("#city_des").after("<option value='" + cities_data[index].city_id + "' >(" + cities_data[index].city_code + ") [ " + cities_data[index].city_name.toUpperCase() + " ] </option>");
					}

					// add customer
					for (let customer = 0; customer < customer_data.length; customer++) {
						$("#cusotmer_op").after("<option value='" + customer_data[customer].customer_id + "' > [ " + customer_data[customer].customer_name + " ] </option>");
					}

					// add service
					for (let service = 0; service < shipment_types.length; service++) {
						$("#service_op").after("<option value='" + shipment_types[service].service_id + "' > [ " + shipment_types[service].service_name + " ] </option>");
					}

					// add table
					var data_arr = [];
					var btn = "";
					for (var count = 0; count < selected_cns.length; count++) {
						if (selected_cns[count].is_hardchecked == 1 && is_supervisor == 1) {
							var btn = '<button id="btn_edit_' + selected_cns[count].manual_cn + '" onclick="myfunction(' + selected_cns[count].manual_cn + ',' + selected_cns[count].order_id + ')" class="btn btn-info  btn-xs ">&#9998;</button>&nbsp;<button onclick="cn_okay(' + selected_cns[count].manual_cn + ',' + selected_cns[count].order_id + ')" id="btn_okay_' + selected_cns[count].manual_cn + '"  class="btn  btn-success btn-xs" >&#10003;</button>';
						} else if (selected_cns[count].is_hardchecked == 0 && is_supervisor == 1) {
							var btn = '<button id="btn_edit_' + selected_cns[count].manual_cn + '" onclick="myfunction(' + selected_cns[count].manual_cn + ',' + selected_cns[count].order_id + ')" class="btn btn-info  btn-xs ">&#9998;</button>&nbsp;<button onclick="cn_okay(' + selected_cns[count].manual_cn + ',' + selected_cns[count].order_id + ')" id="btn_okay_' + selected_cns[count].manual_cn + '"  class="btn  btn-info btn-xs" >&#10003;</button>';
						} else if (selected_cns[count].is_hardchecked == 0 && is_supervisor == 0) {
							var btn = '<button id="btn_edit_' + selected_cns[count].manual_cn + '" onclick="myfunction(' + selected_cns[count].manual_cn + ',' + selected_cns[count].order_id + ')" class="btn btn-info  btn-xs ">&#9998;</button>&nbsp;<button onclick="cn_okay(' + selected_cns[count].manual_cn + ',' + selected_cns[count].order_id + ')" id="btn_okay_' + selected_cns[count].manual_cn + '"  class="btn  btn-info btn-xs" >&#10003;</button>';
						} else if (selected_cns[count].is_hardchecked == 1 && is_supervisor == 0) {
							var btn = '<button disabled  style="cursor:not-allowed;" onclick="myfunction(' + selected_cns[count].manual_cn + ',' + selected_cns[count].order_id + ')" class="btn btn-info  btn-xs ">&#9998;</button>&nbsp;<button disabled style="cursor:not-allowed;" class="btn btn-success btn-xs ">&#10003;</button>';
						}
						var sub_array = {
							'sr': (count + 1),
							'Booking_Date': selected_cns[count].order_date,
							'Customer': selected_cns[count].customer_note,
							'CN': selected_cns[count].manual_cn,
							'Origin': selected_cns[count].origin_city_name,
							'Destination': selected_cns[count].destination_city_name,
							'Shipper': selected_cns[count].shipper_name,
							'Consignee': selected_cns[count].consignee_name,
							'Pieces': selected_cns[count].pieces,
							'Weight': selected_cns[count].weight,
							'Content': selected_cns[count].product_detail,
							'Pay_Mode': selected_cns[count].order_pay_mode,
							'Service': selected_cns[count].service_name,
							'action': btn
						};
						data_arr.push(sub_array);

					}
					var table = $('#data_panel').DataTable({
						lengthMenu: [
							[25, 50, -1],
							[25, 50, "All"]
						],
						dom: 'Blfrtip',
						buttons: ['colvis'],
						data: data_arr,
						order: [],
						columns: [{
								data: "sr"
							},
							{
								data: "Booking_Date"
							},
							{
								data: "Customer"
							},
							{
								data: "CN"
							},
							{
								data: "Origin"
							},
							{
								data: "Destination"
							},
							{
								data: "Shipper"
							},
							{
								data: "Consignee"
							},
							{
								data: "Pieces"
							},
							{
								data: "Weight"
							},
							{
								data: "Content"
							},
							{
								data: "Pay_Mode"
							},
							{
								data: "Service"
							},
							{
								data: "action"
							}
						]
					});
					$('#min, #max').keyup(function() {
						table.draw();
					});

				}
			});
		}

		function myfunction(a, b) {
			var cn = a;
			var mcn = b;
			window.open('edit_booking_view/' + cn);
		}

		$("#testing").click(function() {
			load_data();
		});


		function cn_okay(a, b) {
			var val = a;
			var mcn = b;
			$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Please Wait Manual CN <strong>" + a + "</strong> is getting processed.</div></div>");
			var mydata = {
				order_id: val,
				mcn: mcn
			};
			console.log("btn_okay_" + val);
			$.ajax({
				url: "<?php echo base_url(); ?>Booking/Booking/mark_cn_corrected",
				type: "POST",
				data: mydata,
				beforeSend: function() {
					$("#btn_okay_" + val).css("cursor", "not-allowed").html('<div class="lds-ring"><div></div><div></div><div></div><div>')
				},
				success: function(data) {
					$("#btn_okay_" + val).html('&#10003')
					if (data == 1) {
						$("#btn_okay_" + val).html("&#9998").addClass('btn-success').removeClass('btn-info');
						$("#btn_edit_" + val).attr("disabled", true).css("cursor", "not-allowed");
					} else {
						$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Manual CN " + a + " <strong>can't</strong> be marked as corrected now.</div></div>");
					}
				},
				error: function(data) {
					$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-danger'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Manual CN " + a + " <strong>can't</strong> be marked as corrected now." + data + "</div></div>");
				},
			});
		}
	</script>
	
	<script type="text/javascript">
		$(document).ready(function() {
			$.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
				var min = parseInt($('#min').val(), 10);
				var max = parseInt($('#max').val(), 10);

				var date_data = data[1]
				const myArray = date_data.split("-");
				var age = parseFloat(myArray[2]) || 0; // use data for the age column

				if (
					(isNaN(min) && isNaN(max)) ||
					(isNaN(min) && age <= max) ||
					(min <= age && isNaN(max)) ||
					(min <= age && age <= max)

				) {
					return true;
				}
				return false;
			});
			load_data()
			$('#data_panel').saimtech();
			$('#booking_range_1').focus();
			$('#customer').select2();
			$('#origin').select2();
			$('#destination').select2();
			$('#paymode').select2();
			$('#services').select2();
		});
	</script>