<?php
error_reporting(0);
$this->load->view('inc/header');
?>


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
						<li class="breadcrumb-item">Accounts</li>
						<li class="breadcrumb-item">Invoice</li>
						<li class="breadcrumb-item">Create Invoice</li>
						<li class="breadcrumb-item"><mark><?php echo date('Y-m-d h:i:s'); ?></mark></li>
						<li class="breadcrumb-item"><mark><?php echo $invoice_code; ?></mark></li>
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
				<div class="col-xl-12 col-lg-12">
					<!-- START card -->
					<div class=" container-fluid   container-fixed-lg bg-gray">
						<div class="row">
							<div class="col-md-3" id="f_panel">
								<div class="card m-t-10">
									<div class="card-header  separator">
										<div class="card-title">Create Invoice </div>
									</div>
									<div class="card-body">
										<h5>Invoice Module <mark><?php echo $invoice_code; ?></mark></h5>
										<form role="form">
											<div class="form-group" id="invoice_date_div">
												<label>To Date</label>
												<span class="help">e.g. "2019-08-23"</span>
												<input type="date" id="invoice_date" name="invoice_date" value="<?php echo date('Y-m-01', strtotime('last month')); ?>" class="form-control" tabindex="1">
											</div>
											<div class="form-group" id="invoice_date_f_div">
												<label>From Date</label>
												<span class="help">e.g. "2019-08-23"</span>
												<input type="date" id="invoice_date_f" name="invoice_date_f" value="<?php echo date('Y-m-t', strtotime('last month')); ?>" class="form-control" tabindex="2">
											</div>
											<div class="form-group" id="customer_div">
												<label>Customer</label>
												<span class="help">Eatbunny</span>
												<select class="form-control" id="customer" name="customer" tabindex="3">
													<!-- <option value="" id="customer_ops"> Select Customer</option> -->

												</select>
											</div>
											<div class="form-group" id="services_div">
												<label>Service</label>
												<span class="help">OverNight</span>
												<select class="form-control" id="service" name="service" tabindex="4" multiple="multiple">
													<!-- <option value="" id="service_ops">Select Service</option> -->

												</select>
											</div>
											<div class="form-group" id="customer_div">
												<label>Destination</label>
												<span class="help">Karachi</span>
												<select class="form-control" id="destination" name="destination" multiple="multiple" tabindex="5">
													<!-- <option value="" id="des_city_ops"> Select Destination</option> -->

												</select>
											</div>
											<div class="form-group" id="rider_div">
												<label>Permission</label>
												<span class="help">With GST</span>
												<input style="background:white" type="text" readonly="readonly" class="form-control" id="permission" name="permission" tabindex="6">
												</select>
											</div>
											<div class="form-group">
												<label>Other Type</label>
												<span class="help">if any (Optional)</span>
												<select type="text" name="other" id="other" class="form-control" tabindex="7">
													<option value="">Select Other Option</option>
													<option value="Lifter Charges">Lifter Charges</option>
													<option value="Loading / Unloading Charges">Loading/Unloading Charges</option>
													<option value="Pickup Charges">Pickup Charges</option>
													<option value="Sack Charges">Sack Charges</option>
													<option value="Delivery Challan">Delivery Challan</option>
												</select>
											</div>
											<div class="form-group">
												<label>Other Amount </label>
												<span class="help">if any (Optional)</span>
												<input type="text" name="other_amount" id="other_amount" class="form-control" tabindex="8">
											</div>
											<div class="form-group">
												<label>Discount Amount </label>
												<span class="help">if any (Optional)</span>
												<input type="text" name="discount_amount" id="discount_amount" class="form-control" tabindex="9">
											</div>
											<div class="form-group">
												<label>Remark</label>
												<span class="help">if any (Optional)</span>
												<textarea name="remark" id="remark" class="form-control" tabindex="10" rows="6"></textarea>
											</div>
											<div class="form-group">
												<button class="btn btn-primary" tabindex="11" onclick="rate_cus();">Fetch CNs</button>
											</div>
										</form>
									</div>
								</div>
							</div>
							<div class="col-md-7" id="d_panel">
								<div class="card m-t-10">
									<div class="card-header  separator">
										<div class="card-title">Data Panel</div>
										<div class="card-controls">
											<button class="btn btn-primary" type="button" onclick="filters()">Filters</button>
										</div>
									</div>
									<div class="card-body">
										<button class='pull-right btn btn-primary' type="submit" onclick="complete_invoice()" id="cp_inv">Complete Invoice</button>
										<input type="hidden" id="arrData" name="arrData" />
										<div class="table-responsive">
											
											<table width="100%" class="table table-bordered" id="data_list" name="data_panel">
												<thead>
													<tr>
														<th>Sr</th>
														<th>Date</th>
														<th>CN</th>
														<th>Origin</th>
														<th>Dest</th>
														<th>Consignee</th>
														<th>Service</th>
														<th>Rate</th>
														<th>Pcs</th>
														<th>Weigh</th>
														<th>Sc</th>
														<th>GST</th>
														<th>OSA|SD</th>
														<th>Fuel</th>
														<th>FAF</th>
														<th>Others</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody id="autoload">
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-2">
								<div class="card m-t-10 bg-warning text-black">
									<div class="card-header  separator">
										<div class="card-title">Summary</div>
									</div>
									<div class="card-body">
										<center>
											<div id="summary_data"></div>
										</center>
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
	<script>
		function filters() {
			var f_class = $('#f_panel').attr('class');
			var d_class = $('#d_panel').attr('class');

			if (f_class.indexOf('col-md-3') != -1) {
				f_class = f_class.replace('col-md-3', 'col-md-0');
				d_class = d_class.replace('col-md-7', 'col-md-10');
				$('#f_panel').hide();
			} else {
				f_class = f_class.replace('col-md-0', 'col-md-3');
				d_class = d_class.replace('col-md-10', 'col-md-7');
				$('#f_panel').show();
			}

			$('#f_panel').attr('class', f_class);
			$('#d_panel').attr('class', d_class);
		}
		var data_arr = [];
		var order_others = '';
		var js_obj = "";
		var table = "";

		function rate_cus() {
			//$('#customer').change(function(e){
			$('#data_panel').DataTable().destroy();
			$("#summary_data").html("");

			customer = $("#customer").val();
			$.ajax({
				url: "<?php echo base_url(); ?>Invoice/get_cutomer_gst",
				type: "POST",
				data: {
					customer: customer
				},
				dataType: "json",
				success: function(result) {
					$("#permission").val(result.result.is_gst);
				}
			});
			var check = "Pass";
			var customer = "";

			var invoice_code = '<?php echo $invoice_code; ?>';
			var invoice_date = "";
			var invoice_date_f = "";
			var selected_destination = "";
			var selected_service = "";
			//------------Customer
			if ($("#customer").val() != "") {
				customer = $("#customer").val();
				$("#customer_div").css("border-color", "rgba(0, 0, 0, 0.07)");
			} else {
				$("#customer_div").css("border-color", "red");
				$("#customer").focus();
				check = "Fail";
			}
			//------------Date
			if ($("#invoice_date").val() != "") {
				invoice_date = $("#invoice_date").val();
				$("#invoice_date_div").css("border-color", "rgba(0, 0, 0, 0.07)");
			} else {
				$("#invoice_date_div").css("border-color", "red");
				$("#invoice_date").focus();
				check = "Fail";
			}
			//------------FDate
			if ($("#invoice_date_f").val() != "") {
				invoice_date_f = $("#invoice_date_f").val();
				$("#invoice_date_f_div").css("border-color", "rgba(0, 0, 0, 0.07)");
			} else {
				$("#invoice_date_f_div").css("border-color", "red");
				$("#invoice_date_f").focus();
				check = "Fail";
			}

			selected_destination = $('#destination').val().join(",");
			selected_service = $('#service').val().join(",");

			$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Please Wait .</div></div>");
			var mydata = {
				customer: customer,
				invoice_code: invoice_code,
				invoice_date: invoice_date,
				invoice_date_f: invoice_date_f,
				invoice_destination: selected_destination,
				invoice_service: selected_service
			};
			$.ajax({
				url: "<?php echo base_url(); ?>Invoice/cn_data_list",
				type: "POST",
				data: mydata,
				beforeSend: function() {
					$('tbody').html("<tr><td colspan='14'><img src='<?php echo base_url(); ?>assets/ajax-loader.gif'  width='130px'></td></tr>");
				},
				success: function(data) {
					$('tbody').html("");
					var obj = $.parseJSON(data);
					for (var count = 0; count < obj.length; count++) {
						if (obj[count].order_others == null ) {
							order_others = "0.00";
						} else {
							order_others;
						}
						if (obj[count].order_osa_sd_total == null ) {
							order_osa_sd_total = "0.00";
						} else {
							order_osa_sd_total;
						}
						var sub_array = {
							'sr': (count + 1),
							'order_date': obj[count].order_date,
							'order_code': obj[count].order_code + ' | ' + obj[count].manual_cn,
							'Origin': obj[count].origin_city_name,
							'Destination': obj[count].destination_city_name,
							'Consignee': obj[count].consignee_name,
							'order_rate': obj[count].order_rate,
							'service_name': obj[count].service_name,
							'Pieces': obj[count].pieces,
							'Weight': obj[count].weight,
							'order_sc': obj[count].order_sc,
							'order_gst': obj[count].order_gst,
							'order_osa': obj[count].order_osa,
							'order_osa_sd':order_osa_sd_total,
							'order_fuel': obj[count].order_fuel,
							'order_faf': obj[count].order_faf,
							'order_others': order_others,
							'action': '<button  id="' + count + '" onclick="remove_from_invoice()" class="btn btn-danger  btn-xs ">Release</button>'
						};
						data_arr.push(sub_array);
					}
					data_array(data_arr);
				}
			});
			document.getElementById("cp_inv").focus();
			//--------------------------------End
		}
		//);			

		function data_array(get_array) {
			var total_sc = 0;
			var total_gst = 0;
			var total_osa_sd = 0;
			var osa_sd = 0;
			var total_fuel = 0;
			var total_faf = 0;
			var total_other = 0;
			var total_pieces = 0;
			var total_weight = 0;
			for (let index = 0; index < get_array.length; index++) {
				console.log(get_array[index].order_faf);
				total_pieces = parseInt(total_pieces) + parseInt(get_array[index].Pieces)
				total_weight = parseInt(total_weight) + parseInt(get_array[index].Weight)
				total_sc = parseInt(total_sc) + parseInt(get_array[index].order_sc)
				total_gst = parseInt(total_gst) + parseInt(get_array[index].order_gst)
				total_osa_sd = parseInt(total_osa_sd) + parseInt(get_array[index].order_osa)
				osa_sd = parseInt(total_osa_sd) + parseInt(get_array[index].order_osa_sd)
				total_fuel = parseInt(total_fuel) + parseInt(get_array[index].order_fuel)
				total_faf = parseInt(total_faf) + parseInt(get_array[index].order_faf)
				total_other = parseInt(total_other) + parseInt(get_array[index].order_others)
			}

			var net = total_sc + total_gst + total_osa_sd + total_fuel + total_faf + total_other  + osa_sd
			$("#summary_data").html("");
			$("#summary_data").html("<table class='table table_data'><tr><td >Total CNs</td><td class='total_cn'>" + get_array.length + "</td></tr><tr><td>Total Pieces </td><td class='total_pieces'>" + total_pieces + "</td></tr><tr><td>Total Weight </td><td class='total_weight'>" + total_weight + "</td></tr><tr><td>Total SC </td><td class='total_sc'>" + total_sc + "</td></tr><tr><td>Total Gst </td><td class='total_gst'>" + total_gst + "</td></tr><tr><td>Total OSA</td><td class='total_osa'>" + total_osa_sd + "</td></tr><tr><td>Total SD</td><td class='total_osa'>" + osa_sd + "</td></tr><tr><td>Total Fuel </td><td class='total_fuel'>" + total_fuel + "</td></tr><tr><td>Total FAF </td><td class='total_faf'>" + total_faf + "</td></tr><tr><td>Total Others </td><td class='total_other'>" + total_other + "</td></tr><tr><tr><td>NET</td><td class='total_net'>" + net + "</td></tr><tr></table>");

			$('#data_list').DataTable().destroy();
			table = $('#data_list').DataTable({

				lengthMenu: [
					[25, 50, -1],
					[25, 50, "All"]
				],
				dom: 'Blfrtip',
				buttons: [
                    'colvis',
                    {
                        extend: 'excelHtml5',
                        text: "<i class='fs-14 pg-form'></i> Excel",
                        titleAttr: 'Excel',
                        sheetName: 'Summary',
                        exportOptions: {
                            columns: ':visible'
                        },

                    },
                    {
                        extend: 'copyHtml5',
                        footer: 'true',
                        text: "<i class='fs-14 pg-note'></i> Copy",
                        titleAttr: 'Copy',
                        exportOptions: {
                            columns: ':visible'
                        },
                    },
                    {
                        extend: 'print',
                        text: "<i class='fs-14 pg-ui'></i> Print",
                        titleAttr: 'Print',
                        footer: 'true',
                        title: 'Summary',
                        exportOptions: {
                            columns: ':visible'
                        },

                    },
                ],
				data: data_arr,
				order: [],
				columns: [{
						data: "sr"
					},
					{
						data: "order_date"
					},
					{
						data: "order_code"
					},
					{
						data: "Origin"
					},
					{
						data: "Destination"
					},
					{
						data: "Consignee"
					},
					{
						data: "service_name"
					},
					{
						data: "order_rate"
					},

					{
						data: "Pieces"
					},
					{
						data: "Weight"
					},
					{
						data: "order_sc"
					},
					{
						data: "order_gst"
					},
					{
						data: "order_osa"
					},
					{
						data: "order_fuel"
					},
					{
						data: "order_faf"
					},
					{
						data: "order_others"
					},
					{
						data: "action"
					}
				]
			});


		}

		function remove_from_invoice() {
			index = $(this).closest('tr').index();
			data_arr.splice(index, 1)
			data_array(data_arr)
		}

		$("form").on("submit", function(event) {
			event.preventDefault();
		});

		function complete_invoice() {
			var form_array = $("form").serialize();
			var form_data_array = form_array.split("&");
			var TableData = new Array();
			$('.table_data tr').each(function(row, tr) {
				TableData[row] = {
					"0": $(tr).find('td:eq(0)').text(),
					"1": $(tr).find('td:eq(1)').text()
				}
			});
			TableData.splice(10, 1)
			TableData.pop()

			var mydata = {
				order_acc: data_arr,
				summary: TableData,
				form_data_array: form_data_array,
			};
			$("#msg_div").html("<div class='pgn push-on-sidebar-open pgn-bar'><div class='alert alert-warning'><button type='button' class='close' data-dismiss='alert'><span aria-hidden='true'>×</span><span class='sr-only'>Close</span></button>Please Wait .</div></div>");
			$.ajax({
				url: "<?php echo base_url(); ?>Invoice/complete_invoice",
				type: "POST",
				data: mydata,
				success: function(data) {
					console.log(data)
					// location.replace("<?php echo base_url(); ?>Invoice/create_invoice");
				}
			});
			$("#cn").val("");

		}
	</script>

	<script type="text/javascript">
		$(document).ready(function() {

			var mydata = {
				start_date: $('#invoice_date').val(),
				end_date: $('#invoice_date_f').val()
			};

			$.ajax({
				url: "<?php echo base_url(); ?>Invoice/create_invoice_data",
				type: "GET",
				data: mydata,
				beforeSend: function() {
					$('tbody').html("<tr><td colspan='14'><img src='<?php echo base_url(); ?>assets/ajax-loader.gif'  width='130px'></td></tr>");
				},
				success: function(data) {

					var obj = $.parseJSON(data)
					var invoice_code = obj.invoice_code;
					var customer_ops = obj.customer_data;
					var cities_data = obj.destinations;
					var services_ops = obj.services;
					$('tbody').html("");

					for (let index = 0; index < cities_data.length; index++) {
						$("#destination").append("<option value='" + cities_data[index].city_id + "' > " + cities_data[index].city_full_name + "</option>");
					}

					// add customer
					for (let customer = 0; customer < customer_ops.length; customer++) {
						$("#customer").append("<option value='" + customer_ops[customer].id + "' > " + customer_ops[customer].name + " </option>");
					}

					// add service
					for (let service = 0; service < services_ops.length; service++) {
						$("#service").append("<option value='" + services_ops[service].service_id + "' >  " + services_ops[service].service_name + "  </option>");
					}

				}
			});

			document.getElementById("customer").focus();
			$('#data_panel').saimtech();
			$('#pending_panel').saimtech();
			$('#customer').select2({
				placeholder: "Select Customer"
			});
			$('#destination').select2({
				placeholder: "Select Destinations"
			});
			$('#service').select2({
				placeholder: "Select Service"
			});
		});
	</script>